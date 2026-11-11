<?php

declare(strict_types=1);

namespace EdwinLove\MyTurn\Core\Domain\Page;

use EdwinLove\MyTurn\Core\Domain\Seo\PageMetadata;

final class EmbeddedPage
{
    public function __construct(
        public readonly string $embedUrl,
        public readonly string $canonicalUrl,
        public readonly ?PageMetadata $metadata,
    ) {
    }
}
