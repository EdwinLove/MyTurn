<?php

declare(strict_types=1);

namespace EdwinLove\MyTurn\Core\Infrastructure\Http;

use DOMDocument;
use DOMXPath;
use GuzzleHttp\ClientInterface;
use EdwinLove\MyTurn\Core\Application\Port\MyTurnPageClient;
use EdwinLove\MyTurn\Core\Domain\Seo\PageMetadata;
use Throwable;

final class GuzzleMyTurnPageClient implements MyTurnPageClient
{
    public function __construct(private readonly ClientInterface $client)
    {
    }

    public function getMetadata(string $myTurnUrl): ?PageMetadata
    {
        try {
            $response = $this->client->request('GET', $myTurnUrl, ['http_errors' => false]);
            if ($response->getStatusCode() < 200 || $response->getStatusCode() >= 300) {
                return null;
            }

            $html = (string) $response->getBody();
            $previous = libxml_use_internal_errors(true);
            try {
                $document = new DOMDocument();
                $document->loadHTML($html, LIBXML_NONET | LIBXML_NOERROR | LIBXML_NOWARNING);
            } finally {
                libxml_clear_errors();
                libxml_use_internal_errors($previous);
            }

            $xpath = new DOMXPath($document);
            $values = [];
            foreach (['title', 'description', 'image'] as $field) {
                $property = 'og:' . $field;
                $nodes = $xpath->query(sprintf(
                    '//meta[@property="%s" or @name="%s"]/@content',
                    $property,
                    $property
                ));
                $value = $nodes !== false && $nodes->length > 0 ? trim($nodes->item(0)->nodeValue ?? '') : '';
                $values[$field] = $value !== '' ? $value : null;
            }

            if ($values['title'] === null && $values['description'] === null && $values['image'] === null) {
                return null;
            }

            return new PageMetadata($values['title'], $values['description'], $values['image']);
        } catch (Throwable) {
            // Metadata is optional; the WordPress route can still render its iframe.
            return null;
        }
    }
}
