<?php

namespace PHPrivoxy\Matcher;

require_once __DIR__ . '/../vendor/autoload.php';

$uri = 'www.site.ru/cat/page.html';
$matcher = new UriMatcher($uri);

echo $matcher->match('*') ? 'TRUE' : 'FALSE';               // TRUE
echo PHP_EOL;

echo $matcher->match('.') ? 'TRUE' : 'FALSE';               // TRUE
echo PHP_EOL;

echo $matcher->match('') ? 'TRUE' : 'FALSE'; // FALSE
echo PHP_EOL;

echo $matcher->match('site.ru') ? 'TRUE' : 'FALSE'; // FALSE
echo PHP_EOL;

echo $matcher->match('.site.ru') ? 'TRUE' : 'FALSE';        // TRUE
echo PHP_EOL;

echo $matcher->match('*.site.ru') ? 'TRUE' : 'FALSE';       // TRUE
echo PHP_EOL;

echo $matcher->match('*site*') ? 'TRUE' : 'FALSE';          // TRUE
echo PHP_EOL;

echo $matcher->match('.ite.ru') ? 'TRUE' : 'FALSE'; // FALSE
echo PHP_EOL;

echo $matcher->match('*ite.ru') ? 'TRUE' : 'FALSE';         // TRUE
echo PHP_EOL;

echo $matcher->match('/page.html') ? 'TRUE' : 'FALSE'; // FALSE
echo PHP_EOL;

echo $matcher->match('/*page.html') ? 'TRUE' : 'FALSE';     // TRUE
echo PHP_EOL;

echo $matcher->match('/ca') ? 'TRUE' : 'FALSE';             // TRUE
echo PHP_EOL;

echo $matcher->match('/ca*') ? 'TRUE' : 'FALSE';            // TRUE
echo PHP_EOL;

echo $matcher->match('/ca$') ? 'TRUE' : 'FALSE'; // FALSE
echo PHP_EOL;

echo $matcher->match('/cat/page.html$') ? 'TRUE' : 'FALSE'; // TRUE
echo PHP_EOL;

echo $matcher->match('/cat/page.html') ? 'TRUE' : 'FALSE';  // TRUE
echo PHP_EOL;

echo $matcher->match('/cat/page.htm') ? 'TRUE' : 'FALSE';   // TRUE
echo PHP_EOL;

echo $matcher->match('/cat/page.htm') ? 'TRUE' : 'FALSE';   // TRUE
echo PHP_EOL;

echo $matcher->match('*ite.ru/cat/pag') ? 'TRUE' : 'FALSE'; // TRUE
echo PHP_EOL;

echo $matcher->match('*/cat/page.*') ? 'TRUE' : 'FALSE';    // TRUE
echo PHP_EOL;

