<?php

namespace App\Services\Schema;

use App\Models\Member;
use Illuminate\Support\Collection;
use Spatie\ContentApi\Data\Author;
use Spatie\ContentApi\Data\Post;
use Spatie\SchemaOrg\BlogPosting;
use Spatie\SchemaOrg\Organization;
use Spatie\SchemaOrg\Person;
use Spatie\SchemaOrg\PostalAddress;
use Spatie\SchemaOrg\ProfilePage;
use Spatie\SchemaOrg\Schema as Builder;

class Schema
{
    public function organization(): Organization
    {
        return Builder::organization()
            ->identifier('https://spatie.be/#organization')
            ->name('Spatie')
            ->email('info@spatie.be')
            ->telephone('+32 3 292 56 79')
            ->vatID('BE0809.387.596')
            ->url('https://spatie.be')
            ->sameAs([
                'https://www.wikidata.org/wiki/Q141360524',
                'https://www.linkedin.com/company/spatie',
                'https://x.com/spatie_be',
                'https://github.com/spatie',
                'https://bsky.app/profile/spatie.be',
                'https://www.instagram.com/spatie_be',
            ])
            ->logo('https://spatie.be/images/spatie.png')
            ->image('https://spatie.be/images/og-image.jpg')
            ->address($this->address())
            ->founders($this->founders())
            ->employees($this->employees());
    }

    public function authorPage(Member $member): ProfilePage
    {
        return Builder::profilePage()
            ->mainEntity($this->author($member));
    }

    /** @param Collection<string, Member> $authorMembers */
    public function blogPost(Post $post, Collection $authorMembers): BlogPosting
    {
        $authors = $post->authors
            ->map(function (Author $author) use ($authorMembers) {
                $member = $authorMembers->get($author->gravatar_url);

                return $member
                    ? $this->author($member)
                    : Builder::person()->name($author->name);
            })
            ->values()
            ->all();

        return Builder::blogPosting()
            ->headline($post->title)
            ->url(route('blog.show', $post->slug))
            ->datePublished($post->date)
            ->dateModified($post->updated_at)
            ->if($post->header_image, function (BlogPosting $blogPosting) use ($post): void {
                $blogPosting->image($post->header_image);
            })
            ->author($authors)
            ->publisher($this->organizationReference());
    }

    protected function author(Member $member): Person
    {
        $sameAs = array_values(array_filter([
            $member->website,
            $member->twitter ? "https://x.com/{$member->twitter}" : null,
            $member->github ? "https://github.com/{$member->github}" : null,
        ]));

        return $member->schema()
            ->url(route('blog.author', $member->author_slug))
            ->image(gravatar_url($member->email))
            ->sameAs($sameAs)
            ->worksFor($this->organizationReference());
    }

    protected function organizationReference(): Organization
    {
        return Builder::organization()->identifier('https://spatie.be/#organization');
    }

    protected function address(): PostalAddress
    {
        return Builder::postalAddress()
            ->addressLocality('Antwerp')
            ->addressRegion('Antwerp')
            ->postalCode('2060')
            ->streetAddress('Kruikstraat 22 bus 12')
            ->addressCountry('Belgium');
    }

    protected function founders(): array
    {
        return Member::founder()
            ->get()
            ->map(fn (Member $member) => $member->schema())
            ->toArray();
    }

    protected function employees(): array
    {
        return Member::employee()
            ->get()
            ->map(fn (Member $member) => $member->schema())
            ->toArray();
    }
}
