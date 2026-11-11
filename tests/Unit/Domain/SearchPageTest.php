<?php

declare(strict_types=1);

namespace EdwinLove\MyTurn\Core\Tests\Unit\Domain;

use EdwinLove\MyTurn\Core\Domain\Page\SearchPage;
use PHPUnit\Framework\TestCase;

final class SearchPageTest extends TestCase
{
    public function testBuildsMyTurnAndCanonicalPathsWithAnEncodedQuery(): void
    {
        $page = new SearchPage('tent & tools');

        self::assertSame('inventory/browse?q=tent%20%26%20tools', $page->myTurnPath());
        self::assertSame('thing/search/tent%20%26%20tools', $page->pagePath());
    }
}
