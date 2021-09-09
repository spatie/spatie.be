<?php

namespace App\Models;

use App\Domain\Experience\Commands\RegisterVideoCompletion;
use App\Domain\Experience\Models\Achievement;
use App\Domain\Experience\Projections\UserAchievementProjection;
use App\Domain\Experience\Projections\UserExperienceProjection;
use App\Domain\Shop\Enums\PurchasableType;
use App\Domain\Shop\Models\Bundle;
use App\Domain\Shop\Models\License;
use App\Domain\Shop\Models\Purchasable;
use App\Domain\Shop\Models\Purchase;
use App\Domain\Shop\Models\PurchaseAssignment;
use App\Domain\Shop\Models\Referrer;
use App\Observers\UserObserver;
use App\Support\Uuid\Uuid;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;
use Laravel\Paddle\Billable;
use Spatie\Mailcoach\Domain\Audience\Models\EmailList;

class User extends Authenticatable
{
    use HasFactory;
    use Billable;
    use Notifiable;

    protected $hidden = [
        'password', 'remember_token',
    ];

    public $casts = [
        'is_admin' => 'bool',
        'next_purchase_discount_period_ends_at' => 'datetime',
        'sponsor_gift_given_at' => 'datetime',
        'has_access_to_unreleased_products' => 'boolean',
        'uuid' => Uuid::class,
    ];

    protected static function booted()
    {
        self::observe(UserObserver::class);

        self::saving(function (User $user) {
            if ($user->uuid === null) {
                $user->uuid = (string) Uuid::new();
            }
        });
    }

    public function resolveUuid(): string
    {
        if (! $this->uuid) {
            $this->uuid = (string) Uuid::new();
            $this->save();
        }

        return $this->uuid;
    }

    public function getPayLinkForProductId(string $paddleProductId, License $license = null)
    {
        $purchasable = Purchasable::findForPaddleProductId($paddleProductId);

        $displayablePrice = $purchasable->getPriceForIp(request()->ip());
        $prices[] = $displayablePrice->toPaddleFormat();
        if ($displayablePrice->currencyCode !== 'USD') {
            $dollarDisplayablePrice = $purchasable->getPriceForCountryCode('US');
            $prices[] = $dollarDisplayablePrice->toPaddleFormat();
        }

        $passthrough = [];

        if ($referrer = Referrer::findActive()) {
            $passthrough['referrer_uuid'] = $referrer->uuid;
        }

        if ($license) {
            $passthrough['license_id'] = $license->id;
        }

        return $this->chargeProduct($paddleProductId, [
            'quantity_variable' => ! $purchasable->isRenewal(),
            'customer_email' => auth()->user()->email,
            'marketing_consent' => true,
            'prices' => $prices,
            'passthrough' => $passthrough,
        ]);
    }

    public function getPayLinkForBundle(Bundle $bundle)
    {
        $displayablePrice = $bundle->getPriceForIp(request()->ip());
        $prices[] = $displayablePrice->toPaddleFormat();
        if ($displayablePrice->currencyCode !== 'USD') {
            $dollarDisplayablePrice = $bundle->getPriceForCountryCode('US');
            $prices[] = $dollarDisplayablePrice->toPaddleFormat();
        }

        $passthrough = [];

        $passthrough['bundle_id'] = $bundle->id;

        if ($referrer = Referrer::findActive()) {
            $passthrough['referrer_uuid'] = $referrer->uuid;
        }

        return $this->chargeProduct($bundle->paddle_product_id, [
            'quantity_variable' => false,
            'customer_email' => auth()->user()->email,
            'marketing_consent' => true,
            'prices' => $prices,
            'passthrough' => $passthrough,
        ]);
    }

    public function isSponsoring(): bool
    {
        if ($this->isSpatieMember()) {
            return true;
        }

        return (bool) $this->is_sponsor;
    }

    public function isSubscribedToNewsletter(): bool
    {
        if (! $this->email) {
            return false;
        }

        /** @var EmailList $emailList */
        $emailList = EmailList::firstWhere('name', 'Spatie');

        if (! $emailList) {
            return false;
        }

        return $emailList->isSubscribed($this->email);
    }

    public function hasAccessToUnReleasedProducts(): bool
    {
        if ($this->has_access_to_unreleased_products) {
            return true;
        }

        if ($this->isSpatieMember()) {
            return true;
        }

        return false;
    }

    public function isSpatieMember(): bool
    {
        if (! $this->is_admin) {
            return false;
        }

        return Member::where('github', $this->github_username)->exists();
    }

    public function owns(Purchasable $purchasable): bool
    {
        return $this->assignments()->where('purchasable_id', $purchasable->id)->exists();
    }

    public function ownsAny(Collection $purchasables): bool
    {
        return $this->assignments()->whereIn('purchasable_id', $purchasables->pluck('id'))->exists();
    }

    public function licenses(): HasManyThrough
    {
        return $this->hasManyThrough(License::class, PurchaseAssignment::class);
    }

    public function purchases(): HasMany
    {
        return $this->hasMany(Purchase::class)->with(['purchasable.product', 'bundle']);
    }

    public function assignments(): HasMany
    {
        return $this->hasMany(PurchaseAssignment::class);
    }

    public function purchasesWithoutRenewals(): HasMany
    {
        return $this->hasMany(Purchase::class)->where(function (Builder $query) {
            $query->whereHas('purchasable', function (Builder $query): void {
                $query->whereNotIn('type', [
                    PurchasableType::TYPE_STANDARD_RENEWAL,
                    PurchasableType::TYPE_UNLIMITED_DOMAINS_RENEWAL,
                ]);
            })->orWhereHas('bundle');
        });
    }

    public function assignmentsWithoutRenewals(): HasMany
    {
        return $this->assignments()->whereHas('purchasable', function (Builder $query): void {
            $query->whereNotIn('type', [
                PurchasableType::TYPE_STANDARD_RENEWAL,
                PurchasableType::TYPE_UNLIMITED_DOMAINS_RENEWAL,
            ]);
        });
    }

    public function completedVideos(): BelongsToMany
    {
        return $this->belongsToMany(Video::class, 'video_completions')->withTimestamps();
    }

    public function enjoysExtraDiscountOnNextPurchase(): bool
    {
        if (! $this->next_purchase_discount_period_ends_at) {
            return false;
        }

        return $this->next_purchase_discount_period_ends_at->isFuture();
    }

    public function nextPurchaseDiscountPercentage(): int
    {
        return 10;
    }

    public function canImpersonate(): bool
    {
        return $this->isSpatieMember();
    }

    public function hasCompleted(Series $series): bool
    {
        return Video::query()
            ->where('series_id', $series->id)
            ->whereDoesntHave('completions', function (Builder|VideoCompletion $builder) {
                return $builder->where('user_id', $this->id);
            })
            ->doesntExist();
    }

    public function completeVideo(Video $video): self
    {
        VideoCompletion::create([
            'user_id' => $this->id,
            'video_id' => $video->id,
        ]);

        command(RegisterVideoCompletion::forUser(
            user: $this,
            videoId: $video->id
        ));

        return $this;
    }

    public function hasAchievement(Achievement $achievement): bool
    {
        return UserAchievementProjection::forUser($this->id)
            ->andSlug($achievement->slug)
            ->exists();
    }

    public function experience(): HasOne
    {
        return $this->hasOne(UserExperienceProjection::class);
    }

    public function achievements(): HasMany
    {
        return $this->hasMany(UserAchievementProjection::class);
    }
}
