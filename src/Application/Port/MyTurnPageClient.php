<?php

declare(strict_types=1);

namespace EdwinLove\MyTurn\Core\Application\Port;

use EdwinLove\MyTurn\Core\Domain\Seo\PageMetadata;

interface MyTurnPageClient
{
    /** Returns null when MyTurn is unavailable or its response has no usable metadata. */
    public function getMetadata(string $myTurnUrl): ?PageMetadata;
}
