<?php

declare(strict_types=1);

namespace EdwinLove\MyTurn\Core\Tests\Unit\Application;

use EdwinLove\MyTurn\Core\Application\UseCase\BuildSearchPage;
use EdwinLove\MyTurn\Core\Domain\Seo\PageMetadata;
use EdwinLove\MyTurn\Core\Tests\Support\MyTurnPageClientSpy;
use PHPUnit\Framework\TestCase;

final class BuildSearchPageTest extends TestCase
{
    public function testBuildsSearchPageWithAnEncodedQueryAndMetadata(): void
    {
        $metadata = new PageMetadata('Search results', 'Tools matching tent');
        $client = new MyTurnPageClientSpy($metadata);
        $useCase = new BuildSearchPage($client, 'https://mysite.myturn.com/', 'https://mysite.com/');

        $page = $useCase->execute('tent & tools');

        self::assertSame(
            'https://mysite.myturn.com/library/inventory/browse?q=tent%20%26%20tools&embed=true',
            $page->embedUrl
        );
        self::assertSame('https://mysite.com/thing/search/tent%20%26%20tools', $page->canonicalUrl);
        self::assertSame($metadata, $page->metadata);
        self::assertSame([$page->embedUrl], $client->requestedUrls);
    }

    public function testAllowsTheWordPressAdapterToProvideItsCanonicalPath(): void
    {
        $client = new MyTurnPageClientSpy(null);
        $useCase = new BuildSearchPage($client, 'https://mysite.myturn.com/', 'https://mysite.com/');

        $page = $useCase->execute('tent', 'find/tent/');

        self::assertSame('https://mysite.com/find/tent/', $page->canonicalUrl);
        self::assertNull($page->metadata);
    }
}
