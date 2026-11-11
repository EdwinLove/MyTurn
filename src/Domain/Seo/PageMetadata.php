<?php

declare(strict_types=1);

namespace EdwinLove\MyTurn\Core\Domain\Seo;

final class PageMetadata
{
    public function __construct(
        public readonly ?string $title = null,
        public readonly ?string $description = null,
        public readonly ?string $image = null,
    ) {
    }
}
