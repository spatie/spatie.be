<?php

namespace App\Support\CommonMark;

use Illuminate\Support\Str;
use League\CommonMark\Extension\CommonMark\Node\Inline\Image;
use League\CommonMark\Node\Node;
use League\CommonMark\Renderer\ChildNodeRendererInterface;
use League\CommonMark\Renderer\NodeRendererInterface;
use League\CommonMark\Util\HtmlElement;
use League\CommonMark\Util\RegexHelper;
use League\Config\ConfigurationAwareInterface;
use League\Config\ConfigurationInterface;

class ImageRenderer implements NodeRendererInterface, ConfigurationAwareInterface
{
    protected ConfigurationInterface $config;

    public function render(Node $node, ChildNodeRendererInterface $childRenderer)
    {
        if (! ($node instanceof Image)) {
            throw new \InvalidArgumentException('Incompatible inline type: ' . \get_class($node));
        }

        $attrs = $node->data->get('attributes', []);

        $forbidUnsafeLinks = ! $this->config->get('allow_unsafe_links');
        if ($forbidUnsafeLinks && RegexHelper::isLinkPotentiallyUnsafe($node->getUrl())) {
            $attrs['src'] = '';
        } else {
            $url = $node->getUrl();

            $relativePath = preg_match('$^../$', $url);

            $attrs['src'] = $relativePath ? Str::after($url, '../') : $url;
        }

        $alt = $childRenderer->renderNodes($node->children());
        $alt = \preg_replace('/\<[^>]*alt="([^"]*)"[^>]*\>/', '$1', $alt);
        $attrs['alt'] = \preg_replace('/\<[^>]*\>/', '', $alt);

        if (isset($node->data['title'])) {
            $attrs['title'] = $node->data['title'];
        }

        return new HtmlElement('img', $attrs, '', true);
    }

    public function setConfiguration(ConfigurationInterface $configuration): void
    {
        $this->config = $configuration;
    }
}
