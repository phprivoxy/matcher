<?php

declare(strict_types=1);

namespace PHPrivoxy\Matcher;

interface MatcherInterface
{
    public function match(string $pattern): bool;
}
