<?php

namespace PHPrivoxy\Matcher;

require_once __DIR__ . '/../vendor/autoload.php';

$uri = 'www.яндекс.рф/cat/page.html';
$matcher = new UriMatcher($uri);

$patterns = [
    '.яндекс.рф',
    'яндекс.рф',
    '*ндек*',
    '*ww*',
    '*екс.рф.',
    '.екс.рф.',
    '*екс.рф.*',
    '*екс.рф*',
    '*екс.рф',
    'екс.рф.',
    'екс.рф.*',
    'www.яндекс.рф',
    'w.яндекс.рф.*',
    '.w.яндекс.рф',
    '*w.яндекс.рф',
    'www.яндекс.рф.',
    'www.яндекс.рф*',
    'www.яндекс.рф.*',
    '*ww.яндекс.рф.*',
    '.яндекс.рф*',
    '*.яндекс.рф*',
    '.ндекс.рф.',
    '*ндекс.рф.',
    '*ндекс.рф*',
    '*ндекс.рф.*',
    'xn--d1acpjx3f.xn--p1ai',
    '.xn--d1acpjx3f.xn--p1ai',
    '*xn--d1acpjx3f.xn--p1ai',
    '*.xn--d1acpjx3f.xn--p1ai',
    'www.xn--d1acpjx3f.xn--p1ai',
    '*'
];

foreach ($patterns as $pattern) {
    echo $uri . ' IS ' . $pattern . ' ';
    echo $matcher->match($pattern) ? 'TRUE' : 'FALSE';
    echo PHP_EOL;
}
