<?php

namespace App\Services\Mailcoach;

use Exception;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use Throwable;

class MailcoachApi
{
    public function getSubscriber(string $email, ?string $listUuid = null): ?Subscriber
    {
        try {
            return $this->findSubscriber($email, $listUuid);
        } catch (Exception) {
            return null;
        }
    }

    /** @throws RequestException|ConnectionException */
    public function findSubscriber(string $email, ?string $listUuid = null): ?Subscriber
    {
        $listUuid ??= '4af46b59-3784-41a5-9272-6da31afa3a02';

        $response = $this->request()
            ->get("https://spatie.mailcoach.app/api/email-lists/{$listUuid}/subscribers", [
                'filter' => [
                    'email' => $email,
                ],
            ])
            ->throw();

        $subscribers = $response->json('data');

        if (! isset($subscribers[0])) {
            return null;
        }

        return Subscriber::fromResponse($subscribers[0]);
    }

    public function subscribe(string $email, ?string $listUuid = null, bool $skipConfirmation = false, bool $skipWelcomeMail = false): ?Subscriber
    {
        try {
            return $this->createSubscriber($email, $listUuid, $skipConfirmation);
        } catch (RequestException) {
            return null;
        }
    }

    /** @throws RequestException */
    public function createSubscriber(string $email, ?string $listUuid = null, bool $skipConfirmation = false): ?Subscriber
    {
        $listUuid ??= '4af46b59-3784-41a5-9272-6da31afa3a02';

        $response = $this->request()
            ->post("https://spatie.mailcoach.app/api/email-lists/{$listUuid}/subscribers", [
                'email' => $email,
                'skip_confirmation' => $skipConfirmation,
            ])
            ->throw();

        if (! $response->json('data.uuid')) {
            return null;
        }

        return Subscriber::fromResponse($response->json('data'));
    }

    public function unsubscribe(Subscriber $subscriber): void
    {
        $this->request()
            ->post("https://spatie.mailcoach.app/api/subscribers/{$subscriber->uuid}/unsubscribe");
    }

    public function addTags(Subscriber $subscriber, array $tags): void
    {
        $this->request()
            ->patch("https://spatie.mailcoach.app/api/subscribers/{$subscriber->uuid}", [
                'tags' => $tags,
                'append_tags' => true,
            ])
            ->throw();
    }

    public function removeTag(Subscriber $subscriber, string $tag): void
    {
        $tags = array_filter($subscriber->tags, fn (string $existingTag) => $existingTag !== $tag);

        $this->request()
            ->patch("https://spatie.mailcoach.app/api/subscribers/{$subscriber->uuid}", [
                'tags' => $tags,
                'append_tags' => false,
            ])
            ->throw();
    }

    protected function request(): PendingRequest
    {
        return Http::timeout(10)
            ->withToken(config('services.mailcoach.token'))
            ->acceptJson()
            ->retry(
                times: 3,
                sleepMilliseconds: $this->retryDelayInMilliseconds(...),
                when: $this->isRateLimited(...),
                throw: false,
            );
    }

    protected function isRateLimited(Throwable $exception): bool
    {
        if (! $exception instanceof RequestException) {
            return false;
        }

        return $exception->response->tooManyRequests();
    }

    protected function retryDelayInMilliseconds(int $attempt, RequestException $exception): int
    {
        $retryAfterSeconds = (int) $exception->response->header('Retry-After');

        return max($retryAfterSeconds, $attempt * 5) * 1000;
    }
}
