<?php

declare(strict_types=1);

namespace PHPrivoxy\Matcher;

// TODO: results caching.

class PatternsMatcher implements MatcherInterface
{
    private array $patterns;

    public function __construct(array $patterns = [])
    {
        $this->patterns = $patterns;
    }

    public function match(UriInterface|string $uri): bool
    {
        $matcher = new UriMatcher($uri);
        foreach ($this->patterns as $pattern) {
            if ($matcher->match($pattern)) {
                return true;
            }
        }

        return false;
    }
}
