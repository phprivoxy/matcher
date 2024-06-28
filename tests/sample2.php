<?php

namespace PHPrivoxy\Matcher;

require_once __DIR__ . '/../vendor/autoload.php';

$uri = 'www.site.ru/cat/page.html';
$matcher = new UriMatcher($uri);

$patterns = [
    'microsoft.com/office',
    '*.microsoft.com/windows',
    '.windows.com',
    'github.com',
    '*linux*'
];

$matcher = new PatternsMatcher($patterns);

echo $matcher->match('https://www.linuxmint.com/') ? 'TRUE' : 'FALSE'; // TRUE
echo PHP_EOL;

echo $matcher->match('https://www.microsoft.com/other/linux-vs-windows/') ? 'TRUE' : 'FALSE'; // FALSE
echo PHP_EOL;

echo $matcher->match('https://www.github.com/windows') ? 'TRUE' : 'FALSE'; // FALSE
echo PHP_EOL;

echo $matcher->match('https://github.com/os2') ? 'TRUE' : 'FALSE'; // TRUE
echo PHP_EOL;

echo $matcher->match('https://linux.github.com/') ? 'TRUE' : 'FALSE'; // TRUE
echo PHP_EOL;

echo $matcher->match('https://www.microsoft.com/office') ? 'TRUE' : 'FALSE'; // FALSE
echo PHP_EOL;

echo $matcher->match('https://microsoft.com/office2024') ? 'TRUE' : 'FALSE'; // TRUE
echo PHP_EOL;

echo $matcher->match('http://left.site/not-exist.html') ? 'TRUE' : 'FALSE'; // FALSE
echo PHP_EOL;
