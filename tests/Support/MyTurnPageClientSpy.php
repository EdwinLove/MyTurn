<?php

declare(strict_types=1);

namespace EdwinLove\MyTurn\Core\Tests\Support;

use EdwinLove\MyTurn\Core\Application\Port\MyTurnPageClient;
use EdwinLove\MyTurn\Core\Domain\Seo\PageMetadata;

final class MyTurnPageClientSpy implements MyTurnPageClient
{
    /** @var list<string> */
    public array $requestedUrls = [];

    public function __construct(private readonly ?PageMetadata $metadata)
    {
    }

    public function getMetadata(string $myTurnUrl): ?PageMetadata
    {
        $this->requestedUrls[] = $myTurnUrl;

        return $this->metadata;
    }
}
