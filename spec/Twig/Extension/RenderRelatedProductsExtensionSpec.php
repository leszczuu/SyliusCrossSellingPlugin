<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace spec\BitBag\SyliusUpsellingPlugin\Twig\Extension;

use BitBag\SyliusUpsellingPlugin\Finder\RelatedProductsFinderInterface;
use BitBag\SyliusUpsellingPlugin\Twig\Extension\RenderRelatedProductsExtension;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\Templating\EngineInterface;
use Twig\Extension\ExtensionInterface;

final class RenderRelatedProductsExtensionSpec extends ObjectBehavior
{
    function let(
        RelatedProductsFinderInterface $relatedProductsFinder,
        EngineInterface $templatingEngine
    ): void {
        $this->beConstructedWith(
            $relatedProductsFinder,
            $templatingEngine,
            '@defaultTemplate.html.twig'
        );
    }

    function it_is_initializable(): void
    {
        $this->shouldHaveType(RenderRelatedProductsExtension::class);
    }

    function it_implements_extension_interface(): void
    {
        $this->shouldHaveType(ExtensionInterface::class);
    }

    function it_renders_related_products(
        RelatedProductsFinderInterface $relatedProductsFinder,
        EngineInterface $templatingEngine
    ): void {
        $relatedProducts = [];

        $relatedProductsFinder->findRelatedInCurrentChannelBySlug(Argument::cetera())
            ->willReturn($relatedProducts);

        /** @noinspection PhpTemplateMissingInspection */
        $templatingEngine->render('@customTemplate.html.twig', [
            'products' => $relatedProducts,
        ])->willReturn('rendered template');

        $this->renderRelatedProducts('test-123', 8, '@customTemplate.html.twig');
    }
}