<?php

declare(strict_types=1);

namespace EdwinLove\MyTurn\Core\Tests\Unit\Domain;

use InvalidArgumentException;
use EdwinLove\MyTurn\Core\Domain\Page\ThingPage;
use PHPUnit\Framework\TestCase;

final class ThingPageTest extends TestCase
{
    public function testBuildsMyTurnAndCanonicalPaths(): void
    {
        $page = new ThingPage(42);

        self::assertSame('inventory/show/42', $page->myTurnPath());
        self::assertSame('thing/42', $page->pagePath());
    }

    public function testRejectsNonPositiveThingIds(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new ThingPage(0);
    }
}
