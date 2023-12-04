<?php

namespace App\Services\Mailcoach;

use Illuminate\Support\Facades\Http;

class MailcoachApi
{
    public function getSubscriber(string $email, string $listUuid = null): ?Subscriber
    {
        $listUuid ??= '4af46b59-3784-41a5-9272-6da31afa3a02';

        $response = Http::timeout(10)->withToken(config('services.mailcoach.token'))
            ->get("https://spatie.mailcoach.app/api/email-lists/{$listUuid}/subscribers", [
                'filter' => [
                    'email' => $email,
                ],
            ]);

        if (! $response->successful()) {
            return null;
        }

        $subscribers = $response->json('data');

        if (! isset($subscribers[0])) {
            return null;
        }

        return Subscriber::fromResponse($subscribers[0]);
    }

    public function subscribe(string $email, string $listUuid = null, bool $skipConfirmation = false, bool $skipWelcomeMail = false): ?Subscriber
    {
        $listUuid ??= '4af46b59-3784-41a5-9272-6da31afa3a02';

        $response = Http::timeout(10)->withToken(config('services.mailcoach.token'))
            ->post("https://spatie.mailcoach.app/api/email-lists/{$listUuid}/subscribers", [
                'email' => $email,
                'skip_confirmation' => $skipConfirmation,
            ]);

        if (! $response->successful() || ! $response->json('data') || ! $response->json('data.uuid')) {
            return null;
        }

        return Subscriber::fromResponse($response->json('data'));
    }

    public function unsubscribe(Subscriber $subscriber): void
    {
        Http::timeout(10)->withToken(config('services.mailcoach.token'))
            ->post("https://spatie.mailcoach.app/api/subscribers/{$subscriber->uuid}/unsubscribe");
    }

    public function addTags(Subscriber $subscriber, array $tags): void
    {
        Http::timeout(10)->withToken(config('services.mailcoach.token'))
            ->patch("https://spatie.mailcoach.app/api/subscribers/{$subscriber->uuid}", [
                'tags' => $tags,
                'append_tags' => true,
            ])
            ->throw();
    }

    public function removeTag(Subscriber $subscriber, string $tag): void
    {
        $tags = array_filter($subscriber->tags, fn (string $existingTag) => $existingTag !== $tag);

        Http::timeout(10)->withToken(config('services.mailcoach.token'))
            ->patch("https://spatie.mailcoach.app/api/subscribers/{$subscriber->uuid}", [
                'tags' => $tags,
                'append_tags' => false,
            ])
            ->throw();
    }
}
