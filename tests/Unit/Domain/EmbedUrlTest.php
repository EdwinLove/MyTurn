<?php

declare(strict_types=1);

namespace EdwinLove\MyTurn\Core\Tests\Unit\Domain;

use EdwinLove\MyTurn\Core\Domain\Embed\EmbedUrl;
use PHPUnit\Framework\TestCase;

final class EmbedUrlTest extends TestCase
{
    public function testBuildsEmbedUrlWithoutQueryParameters(): void
    {
        self::assertSame(
            'https://kloth.myturn.com/library/inventory/show/42?embed=true',
            EmbedUrl::fromPath('https://kloth.myturn.com/', 'inventory/show/42')
        );
    }

    public function testAppendsEmbedParameterToExistingQuery(): void
    {
        self::assertSame(
            'https://kloth.myturn.com/library/inventory/browse?q=tent&embed=true',
            EmbedUrl::fromPath('https://kloth.myturn.com/', 'inventory/browse?q=tent')
        );
    }

    public function testBuildsCanonicalPageUrlAndNormalizesSlashes(): void
    {
        self::assertSame(
            'https://kloth.org.uk/thing/42',
            EmbedUrl::pageUrl('https://kloth.org.uk///', '/thing/42')
        );
    }
}
