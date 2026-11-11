<?php

declare(strict_types=1);

namespace EdwinLove\MyTurn\Core\Tests\Unit\Infrastructure\Http;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use EdwinLove\MyTurn\Core\Domain\Seo\PageMetadata;
use EdwinLove\MyTurn\Core\Infrastructure\Http\GuzzleMyTurnPageClient;
use PHPUnit\Framework\TestCase;

final class GuzzleMyTurnPageClientTest extends TestCase
{
    public function testExtractsOpenGraphMetadataFromMyTurnHtml(): void
    {
        $html = <<<'HTML'
            <!doctype html>
            <html><head>
                <meta property="og:title" content="Cordless drill">
                <meta name="og:description" content="A useful drill">
                <meta property="og:image" content="https://images.example/drill.jpg">
            </head><body></body></html>
            HTML;
        $adapter = $this->clientWithResponses(new Response(200, [], $html));

        $metadata = $adapter->getMetadata('https://mysite.myturn.com/library/inventory/show/42?embed=true');

        self::assertEquals(
            new PageMetadata('Cordless drill', 'A useful drill', 'https://images.example/drill.jpg'),
            $metadata
        );
    }

    public function testReturnsNullWhenMyTurnDoesNotProvideMetadata(): void
    {
        $adapter = $this->clientWithResponses(new Response(503));

        self::assertNull($adapter->getMetadata('https://mysite.myturn.com/library/inventory/show/42?embed=true'));
    }

    private function clientWithResponses(Response ...$responses): GuzzleMyTurnPageClient
    {
        $handler = HandlerStack::create(new MockHandler($responses));

        return new GuzzleMyTurnPageClient(new Client(['handler' => $handler]));
    }
}
