<?php

declare(strict_types=1);

namespace EdwinLove\MyTurn\Core\Tests\Unit\Application;

use EdwinLove\MyTurn\Core\Application\UseCase\BuildThingPage;
use EdwinLove\MyTurn\Core\Domain\Seo\PageMetadata;
use EdwinLove\MyTurn\Core\Tests\Support\MyTurnPageClientSpy;
use PHPUnit\Framework\TestCase;

final class BuildThingPageTest extends TestCase
{
    public function testBuildsThingPageAndReturnsFetchedMetadata(): void
    {
        $metadata = new PageMetadata('Drill', 'Cordless drill', 'https://images.example/drill.jpg');
        $client = new MyTurnPageClientSpy($metadata);
        $useCase = new BuildThingPage($client, 'https://mysite.myturn.com/', 'https://mysite.com/');

        $page = $useCase->execute(42);

        self::assertSame('https://mysite.myturn.com/library/inventory/show/42?embed=true', $page->embedUrl);
        self::assertSame('https://mysite.com/thing/42', $page->canonicalUrl);
        self::assertSame($metadata, $page->metadata);
        self::assertSame([$page->embedUrl], $client->requestedUrls);
    }

    public function testAllowsTheWordPressAdapterToProvideItsCanonicalPath(): void
    {
        $client = new MyTurnPageClientSpy(null);
        $useCase = new BuildThingPage($client, 'https://mysite.myturn.com/', 'https://mysite.com/');

        $page = $useCase->execute(42, 'tools/42/');

        self::assertSame('https://mysite.com/tools/42/', $page->canonicalUrl);
        self::assertNull($page->metadata);
    }
}
