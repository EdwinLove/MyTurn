<?php

declare(strict_types=1);

namespace EdwinLove\MyTurn\Core\Domain\Page;

final class SearchPage
{
    public function __construct(private readonly string $searchQuery)
    {
    }

    public function myTurnPath(): string
    {
        return 'inventory/browse?q=' . rawurlencode($this->searchQuery);
    }

    public function pagePath(): string
    {
        return 'thing/search/' . rawurlencode($this->searchQuery);
    }
}
