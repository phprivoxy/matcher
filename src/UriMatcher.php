<?php

declare(strict_types=1);

namespace PHPrivoxy\Matcher;

use Psr\Http\Message\UriInterface;
use League\Uri\Uri;
use League\Uri\Idna\Converter;

// TODO: results caching.

class UriMatcher implements MatcherInterface
{
    private ?string $scheme;
    private ?array $hosts;
    private ?string $host;
    private ?string $fullPath;

    public function __construct(UriInterface|string $uri)
    {
        $uri = Uri::new($uri);

        $this->scheme = $uri->getScheme();
        if (empty($this->scheme)) {
            $this->scheme = '*';
        }

        $this->hosts = [];
        $host = $uri->getHost();
        if (empty($host)) {
            $uri = Uri::new('//' . $uri);
            $host = $uri->getHost();
        }

        if (false !== strpos($host, '%')) {
            $host = rawurldecode($host);
        }
        $this->hosts[] = $host;
        if (Converter::isIdn($host)) {
            $new = (Converter::toUnicode($host))->domain();
            if ($new !== $host) {
                $this->hosts[] = $new;
            }
            $new = (Converter::toAscii($host))->domain();
            if ($new !== $host) {
                $this->hosts[] = $new;
            }
        }

        $this->fullPath = $uri->getPath() . $uri->getQuery();
    }

    public function match(?string $pattern): bool
    {
        $pattern = $this->sanitizePattern($pattern);
        if (empty($pattern)) {
            return false;
        }

        $pattern = Uri::new($pattern);

        $scheme = $pattern->getScheme();
        if (empty($scheme)) {
            $scheme = '*';
            $pattern = Uri::new('//' . $pattern);
        }

        $host = $pattern->getHost();
        $path = $pattern->getPath();

        $fullPath = $path . $pattern->getQuery();
        if (empty($host)) {
            return $this->matchScheme($scheme) && $this->matchFullPath($fullPath);
        }

        $matchHost = false;
        foreach ($this->hosts as $uriHost) {
            $this->host = $uriHost;
            $matchHost = $matchHost || $this->matchHost($host);
        }

        return $this->matchScheme($scheme) && $matchHost && $this->matchFullPath($fullPath);
    }

    private function sanitizePattern(?string $pattern): ?string
    {
        $patternSrc = $pattern;
        $pattern = trim($pattern);
        if (empty($pattern)) {
            return null;
        }

        while (false !== strpos($pattern, '**')) {
            $pattern = str_replace('**', '*', $pattern);
        }

        if (!$this->checkPattern($pattern)) {
            throw new MatcherException('Incorrect pattern: "' . $patternSrc . '"');
        }

        $first = '';
        if (false !== ($pos = strpos($pattern, '://'))) {
            $pos = $pos + 3;
            $first = substr($pattern, 0, $pos);
            $pattern = substr($pattern, $pos);
        }
        while (false !== strpos($pattern, '//')) {
            $pattern = str_replace('//', '/', $pattern);
        }

        if (false !== (strpos($pattern, '/'))) {
            $result = explode('/', $pattern);
            $host = $result[0];
        } else {
            $result = [];
            $host = $pattern;
        }

        if (false !== (strpos($host, '*'))) {
            $res = explode('*', $host);
        } else {
            $res = [];
            $res[] = $host;
        }
        foreach ($res as $num => $part) {
            if (empty($part)) {
                continue;
            }
            $asciiPart = (Converter::toAscii($part))->domain();
            $res[$num] = ($part !== $asciiPart) ? $asciiPart : $part;
        }
        $host = implode('*', $res);

        $result[0] = $host;
        $pattern = implode('/', $result);

        $pattern = $first . $pattern;

        return $pattern;
    }

    private function checkPattern(?string $pattern): bool
    {
        if ('/' === substr($pattern, 0, 1)) { // WEB-page.
            $pattern = substr($pattern, 1);
        }

        $count = substr_count($pattern, '*');
        if (0 === $count) {
            return true;
        }
        if (2 < $count) {
            return false;
        }

        $first = strpos($pattern, '*');
        $last = strrpos($pattern, '*');
        $len = strlen($pattern) - 1;

        if ($first !== $last) {
            if (0 < $first) {
                return false;
            }
            if ($last < $len) {
                return false;
            }
            return true;
        }

        if (0 === $first || $last === $len) {
            return true;
        }

        return false;
    }

    private function matchScheme(?string $scheme): bool
    {
        if (empty($scheme) || '*' === $scheme || '*' === $this->scheme || $this->scheme === $scheme) {
            return true;
        }

        return false;
    }

    private function matchHost(?string $host): bool
    {
        if (empty($host) || $this->host === $host) {
            return true;
        }

        if ('*.' === $this->getFirstTwo($host) && substr($host, 2) === $this->host) {
            return true;
        }
        if ('.*' === $this->getLastTwo($host)) {
            $newHost = substr($host, 0, -2);
            if ($newHost === $this->host) {
                return true;
            }
            $host = $newHost . '*';
        }

        $first = $this->getFirst($host);
        $last = $this->getLast($host);

        if ('.' === $first) {
            $newHost = mb_substr($host, 1);
            $part = function ($hostLenght) {
                return $this->host;
            };
            if ($this->compare($newHost, $part)) {
                return true;
            }
            $first = '*';
            $host = $first . $host;
        }

        if ('.' === $last) {
            $newHost = mb_substr($host, 0, -1);
            $part = function ($hostLenght) {
                return $this->host;
            };
            if ($this->compare($newHost, $part)) {
                return true;
            }
            $last = '*';
            $host = $newHost . $last;
        }

        if ('*' === $first && '*' !== $last) {
            $host = mb_substr($host, 1);
            $part = function ($hostLenght) {
                return mb_substr($this->host, -$hostLenght);
            };
            return $this->compare($host, $part);
        }

        if ('*' !== $first && '*' === $last) {
            $host = mb_substr($host, 0, -1);
            $part = function ($hostLenght) {
                return mb_substr($this->host, 0, $hostLenght);
            };
            return $this->compare($host, $part);
        }

        if ('*' === $first && '*' === $last) {
            $host = mb_substr($host, 1, -1);
            return $this->consist($host, $this->host);
        }

        return false;
    }

    private function compare(string $host, $part): bool
    {
        $hosts = [];
        $hosts[] = $host;
        if (Converter::isIdn($host)) {
            $new = (Converter::toUnicode($host))->domain();
            if ($new !== $host) {
                $hosts[] = $new;
            }
        }

        foreach ($hosts as $host) {
            $hostLenght = mb_strlen($host);
            if ($part($hostLenght) === $host) {
                return true;
            }
        }

        return false;
    }

    private function consist(string $host, string $main): bool
    {
        $hosts = [];
        $hosts[] = $host;
        if (Converter::isIdn($host)) {
            $new = (Converter::toUnicode($host))->domain();
            if ($new !== $host) {
                $hosts[] = $new;
            }
        }

        foreach ($hosts as $host) {
            if (false !== mb_strpos($main, $host)) {
                return true;
            }
        }

        return false;
    }

    private function matchFullPath(?string $fullPath): bool
    {
        if (empty($fullPath) || $this->fullPath === $fullPath) {
            return true;
        }

        if ('/*' === $this->getFirstTwo($fullPath)) {
            $fullPath = substr($fullPath, 0, -1);
        }

        $first = $this->getFirst($fullPath);
        $last = $this->getLast($fullPath);

        if ('/' === $first) {
            if ('$' === $last) {
                return $this->fullPath === substr($fullPath, 0, -1);
            }
            $fullPath = substr($fullPath, 1);
            $first = $this->getFirst($fullPath);
        }

        if ('*' === $last) {
            $fullPath = substr($fullPath, 0, -1);
        }

        // $ - end of string
        if ('*' !== $first && '$' === $last) {
            $fullPath = substr($fullPath, 0, -1);
            return $this->fullPath === $fullPath;
        }

        if ('*' === $first && '$' === $last) {
            $fullPath = substr($fullPath, 1, -1);
            $fullPathLenght = strlen($fullPath);
            return substr($this->fullPath, -$fullPathLenght) === $fullPath;
        }

        if ('*' !== $first && '$' !== $last) {
            $fullPathLenght = strlen($fullPath);
            return substr($this->fullPath, 1, $fullPathLenght) === $fullPath;
        }

        // "*" === $first && "$" !== $last
        $fullPath = substr($fullPath, 1);
        return false !== strpos($this->fullPath, $fullPath);
    }

    private function getFirst(string $str): string
    {
        return 0 < strlen($str) ? substr($str, 0, 1) : '';
    }

    private function getFirstTwo(string $str): string
    {
        return 1 < strlen($str) ? substr($str, 0, 2) : '';
    }

    private function getLast(string $str): string
    {
        return 0 < strlen($str) ? substr($str, -1) : '';
    }

    private function getLastTwo(string $str): string
    {
        return 1 < strlen($str) ? substr($str, -2) : '';
    }
}
