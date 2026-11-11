<?php

declare(strict_types=1);

namespace EdwinLove\MyTurn\Core\Domain\Page;

final class ThingPage
{
    public function __construct(private readonly int $thingId)
    {
        if ($thingId < 1) {
            throw new \InvalidArgumentException('Thing ID must be a positive integer.');
        }
    }

    public function myTurnPath(): string
    {
        return 'inventory/show/' . $this->thingId;
    }

    public function pagePath(): string
    {
        return 'thing/' . $this->thingId;
    }
}
