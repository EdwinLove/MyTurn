<?php

declare(strict_types=1);

namespace EdwinLove\MyTurn\Core\Application\UseCase;

use EdwinLove\MyTurn\Core\Application\Port\MyTurnPageClient;
use EdwinLove\MyTurn\Core\Domain\Embed\EmbedUrl;
use EdwinLove\MyTurn\Core\Domain\Page\EmbeddedPage;
use EdwinLove\MyTurn\Core\Domain\Page\SearchPage;

final class BuildSearchPage
{
    public function __construct(
        private readonly MyTurnPageClient $client,
        private readonly string $myTurnBaseUrl,
        private readonly string $siteBaseUrl,
    ) {
    }

    public function execute(string $searchQuery, ?string $canonicalPath = null): EmbeddedPage
    {
        $page = new SearchPage($searchQuery);
        $myTurnUrl = EmbedUrl::fromPath($this->myTurnBaseUrl, $page->myTurnPath());

        return new EmbeddedPage(
            $myTurnUrl,
            EmbedUrl::pageUrl($this->siteBaseUrl, $canonicalPath ?? $page->pagePath()),
            $this->client->getMetadata($myTurnUrl),
        );
    }
}
