<?php

namespace App\Support\CommonMark;

use Illuminate\Support\Str;
use League\CommonMark\Environment\EnvironmentBuilderInterface;
use League\CommonMark\Event\DocumentParsedEvent;
use League\CommonMark\Extension\CommonMark\Node\Inline\Link;
use League\CommonMark\Extension\ExtensionInterface;

class DocsLinkPrefixExtension implements ExtensionInterface
{
    public function register(EnvironmentBuilderInterface $environment): void
    {
        $environment->addEventListener(DocumentParsedEvent::class, function (DocumentParsedEvent $event): void {
            foreach ($event->getDocument()->iterator() as $node) {
                if (! $node instanceof Link) {
                    continue;
                }

                if (! Str::startsWith($node->getUrl(), '/')) {
                    continue;
                }

                $node->setUrl(Str::start($node->getUrl(), '/docs'));
            }
        });
    }
}
