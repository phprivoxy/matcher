<?php

namespace PHPrivoxy\Matcher;

require_once __DIR__ . '/../vendor/autoload.php';

$data = [];

// 0
$data[0] = [
    '//site.ru' => ['site.ru', true],
    'site.ru' => ['site.ru', true],
    'site.ru/' => ['site.ru', true],
    'http://site.ru' => ['site.ru', true],
    'https://site.ru' => ['site.ru', true],
    'www.site.ru' => ['site.ru', false],
    'sub.site.ru' => ['site.ru', false],
];

// 1
$data[1] = [
    'site.ru' => ['http://site.ru', true],
    'http://site.ru' => ['http://site.ru', true],
    'https://site.ru' => ['http://site.ru', false],
    'www.site.ru' => ['http://site.ru', false],
    'sub.site.ru' => ['http://site.ru', false],
];

// 2
$data[2] = [
    'site.ru' => ['.site.ru', true],
    'http://site.ru' => ['.site.ru', true],
    'www.site.ru' => ['.site.ru', true],
    'sub.site.ru' => ['.site.ru', true],
];

// 3
$data[3] = [
    'http://site.ru' => ['*.site.ru', true],
    'site.ru' => ['*.site.ru', true],
    'www.site.ru' => ['*.site.ru', true],
    'sub.site.ru' => ['*.site.ru', true],
];

// 4
$data[4] = [
    'http://site.ru' => ['site.ru.', true],
    'site.ru' => ['site.ru.', true],
    'яндекс.рф' => ['яндекс.рф.', true],
    'яндекс.ru' => ['яндекс.ru.', true],
    'www.site.ru' => ['site.ru.', false],
    'sub.site.ru' => ['site.ru.', false],
];

// 5
$data[5] = [
    'http://site.ru' => ['site.ru.*', true],
    'site.ru' => ['site.ru.*', true],
    'яндекс.рф' => ['яндекс.рф.*', true],
    'яндекс.ru' => ['яндекс.ru.*', true],
    'www.site.ru' => ['site.ru.*', false],
    'sub.site.ru' => ['site.ru.*', false],
];

// 6
$data[6] = [
    'http://site.ru' => ['site.ru*', true],
    'site.ru' => ['site.ru*', true],
    'www.site.ru' => ['site.ru*', false],
    'sub.site.ru' => ['site.ru*', false],
];

// 7
$data[7] = [
    'http://site1.ru' => ['*site*', true],
    'site2.ru' => ['*site*', true],
    'www.site.ru' => ['*site*', true],
    'sub.site.ru' => ['*site*', true],
    'site.ru' => ['*site*', true],
    'domain.site' => ['*site*', true],
];

// 8
$data[8] = [
    'http://site.ru' => ['*.ru', true],
    'site1.ru' => ['*.ru', true],
    'domain.guru' => ['*.ru', false],
    'domain.site' => ['*.ru', false],
    'site2.ru' => ['*ru', true],
    'domain2.guru' => ['*ru', true],
];

// 9
$data[9] = [
    'site.ru' => ['*ite.ru', true],
    'http://site.ru' => ['*ite.ru', true],
    'www.site.ru' => ['*ite.ru', true],
    'sub.site.ru' => ['*ite.ru', true],
];

// 10
$data[10] = [
    'site.ru' => ['www.site.ru', false],
    'http://site.ru' => ['www.site.ru', false],
    'www.site.ru' => ['www.site.ru', true],
    'sub.site.ru' => ['www.site.ru', false],
];

// 11
$data[11] = [
    'site.ru' => ['/', true],
    'www.site.ru/' => ['/', true],
    'sub.site.ru' => ['/page.html', false],
    'ads.site.ru' => ['/adv/', false],
];

// 12
$data[12] = [
    'site.ru' => ['site.ru/page.html', false],
    'site.ru/' => ['site.ru/page.html', false],
    'www.site.ru' => ['site.ru/page.html', false],
];

// 13
$data[13] = [
    'site.ru' => ['*ite.ru/page.html', false],
    'www.site.ru' => ['*ite.ru/page.html', false],
];

// 14
$data[14] = [
    'site1.ru/page.html' => ['/page.html', true],
    'site2.ru/page.html' => ['/*page.html', true],
    'site3.ru/page.html' => ['/page.html$', true],
    'site4.ru/page.html' => ['/*page.html$', true],
    'site5.ru/cat/page.html' => ['/page.html$', false],
    'site6.ru/cat/page.html' => ['page.html$', false], // Path must begin from "/".
    'site7.ru/cat/page.html' => ['*page.html$', false], // Path must begin from "/".
    'site8.ru/cat/page.html' => ['/*page.html$', true],
    'site9.ru/cat/page.html' => ['*page.html', false], // Path must begin from "/".
    'site10.ru/cat/page.html' => ['page.html', false], // Path must begin from "/".
    'site11.ru/cat/pag' => ['/page', false],
    'site12.ru/cat/page' => ['/page', false],
    'site13.ru/cat/page/' => ['/page', false],
    'site14.ru/cat/page/' => ['/*page', true],
    'site15.ru/pag' => ['/page', false],
    'site16.ru/page' => ['/page', true],
    'site17.ru/page/' => ['/page', true],
    'site18.ru/page/abc.html' => ['/page', true],
    'site19.ru/page/abc.html' => ['/page/', true],
    'site20.ru/page/abc.html' => ['/page/a', true],
    'site21.ru/page/' => ['/page*', true],
    'site22.ru/page/abc.html' => ['/page*', true],
    'site23.ru/page/abc.html' => ['/page/a*', true],
    'site24.ru/page/' => ['/*page', true],
    'www.site.ru/page.html' => ['/page', true],
    'sub.site.ru/page.html' => ['/page$', false],
    'ads.site.ru/page.html' => ['/*page*', true],
];

// 15
$data[15] = [
    'localhost1' => ['localhost1', true],
    'localhost2' => ['.localhost2', true],
    'localhost3' => ['localhost3.', true],
    'localhost4' => ['*localhost4', true],
    'localhost5' => ['localhost5*', true],
    'localhost6' => ['*localhost6*', true],
];

// 16
$data[16] = [
    'site.ru' => ['', false],
    'www.site.ru/' => ['', false],
    'sub.site.ru' => ['', false],
    'ads.site.ru' => ['', false],
    'site.ru/page.html' => ['', false],
    'www.site.ru/page.html' => ['', false],
    'sub.site.ru/cat/page.html' => ['', false],
    'ads.site.ru/?abc=xyz' => ['', false],
];

// 17
$data[17] = [
    'site.ru' => ['.', true],
    'www.site.ru/' => ['.', true],
    'sub.site.ru' => ['.', true],
    'ads.site.ru' => ['.', true],
    'site.ru/page.html' => ['.', true],
    'www.site.ru/page.html' => ['.', true],
    'sub.site.ru/cat/page.html' => ['.', true],
    'ads.site.ru/?abc=xyz' => ['.', true],
];

// 18
$data[18] = [
    'site.ru' => ['*', true],
    'www.site.ru/' => ['*', true],
    'sub.site.ru' => ['*', true],
    'ads.site.ru' => ['*', true],
    'site.ru/page.html' => ['*', true],
    'www.site.ru/page.html' => ['*', true],
    'sub.site.ru/cat/page.html' => ['*', true],
    'ads.site.ru/?abc=xyz' => ['*', true],
];

// 19
$data[19] = [
    'site.ru/search' => ['site.ru/search.*', false],
    'site.ru/search.' => ['site.ru/search.*', true],
    'www.site.ru/search.' => ['www.site.ru/search.$', true],
    'site.ru/search.html' => ['site.ru/search.*', true],
    'www.site.ru/search.html' => ['www.site.ru/search.$', false],
    'site.ru/search/' => ['site.ru/search.*', false],
    'site.ru/searchxyz' => ['site.ru/search.*', false],
    'яндекс.рф/search' => ['яндекс.рф/search.', false],
    'яндекс.рф/search.' => ['яндекс.рф/search.', true],
    'www.яндекс.рф/search.' => ['www.яндекс.рф/search.$', true],
    'яндекс.рф/search.html' => ['яндекс.рф/search.', true],
    'www.яндекс.рф/search.html' => ['www.яндекс.рф/search.$', false],
    'яндекс.рф/search/' => ['яндекс.рф/search.', false],
    'яндекс.рф/searchxyz' => ['яндекс.рф/search.', false],
];

foreach ($data as $number => $subData) {
    echo 'TEST NUMBER ' . $number . PHP_EOL;
    foreach ($subData as $uri => $uriData) {
        $matcher = new UriMatcher($uri);
        list($pattern, $assertion) = $uriData;
        $condition = $assertion ? 'IS' : 'NOT';
        $result = ($assertion === $matcher->match($pattern)) ? 'OK' : 'FAILED';
        //$result = $matcher->match($pattern);
        echo $uri . ' ' . $condition . ' ' . $pattern . ' --- ' . $result . PHP_EOL;
    }
    echo PHP_EOL;
}

//$matcher = new UriMatcher($uri);
