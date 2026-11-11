<?php

declare(strict_types=1);

namespace EdwinLove\MyTurn\Core\Domain\Embed;

final class EmbedUrl
{
    public static function fromPath(string $myTurnBaseUrl, string $path): string
    {
        $separator = str_contains($path, '?') ? '&' : '?';

        return rtrim($myTurnBaseUrl, '/') . '/library/' . ltrim($path, '/') . $separator . 'embed=true';
    }

    public static function pageUrl(string $siteBaseUrl, string $path): string
    {
        return rtrim($siteBaseUrl, '/') . '/' . ltrim($path, '/');
    }
}
