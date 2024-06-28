<?php

namespace PHPrivoxy\Matcher;

require_once __DIR__ . '/../vendor/autoload.php';

$blackList = [
    '*ficbook.net',
    'idiotizmu.net',
    'www.idiotizmu.net',
    'microsoft.com/office',
    '*.microsoft.com/windows',
    '.windows.com',
    '*.youtube.com',
    '*kaka.local'
];

$whiteList = [
    '*linux*',
    '/*linux*',
    '.яндекс.рф',
    'гугль.рф/search.'
];

$totalBan = [
    '*',
    '.'
];

$uris = [
    'https://ficbook.net/fanfiction',
    'https://subdomain.ficbook.net/authors.html',
    'https://ficbook.net/',
    'http://idiotizmu.net',
    'http://www.idiotizmu.net',
    'https://mustdie.org',
    'https://ms.com/windows',
    'https://www.microsoft.com/office',
    'https://microsoft.com/office2024',
    'https://windows.com.org',
    'https://windows.com',
    'https://2024.windows.com',
    'https://www.youtube.com/channels/',
    'https://www.youtu.be/channels/',
    'http://sobaka-kaka.local',
    'http://subsubdomain.subdomain.kaka.local',
    'http://kaka.local.local',
    'http://linux.local',
    'http://linux',
    'http://total-linux-os.org',
    'https://www.microsoft.com/2024-linux.html',
    'https://яндекс.рф',
    'https://www.яндекс.рф',
    'https://subsub.sub.яндекс.рф/search.html',
    'https://поддомен.яндекс.рф/search.html',
    'https://яндекс.рф/search.',
    'https://гугль.рф/',
    'https://гугль.рф/search.',
    'https://гугль.рф/search.html',
    'https://гугль.рф/search',
];

$black = new PatternsMatcher($blackList);
$white = new PatternsMatcher($whiteList);
$total = new PatternsMatcher($totalBan);

foreach ($uris as $uri) {
    echo $uri;
    if ($total->match($uri)) {
        echo ' BANNED';
    }
    echo PHP_EOL;
}
echo PHP_EOL;

foreach ($uris as $uri) {
    echo $uri;
    if (!$white->match($uri)) {
        echo ' NOT IN WHITELIST';
    }
    echo PHP_EOL;
}
echo PHP_EOL;

foreach ($uris as $uri) {
    echo $uri;
    if ($black->match($uri)) {
        echo ' IN BLACKLIST';
    }
    echo PHP_EOL;
}
echo PHP_EOL;

foreach ($uris as $uri) {
    echo $uri;
    if ($white->match($uri)) {
        echo ' IN WHITELIST';
    }
    echo PHP_EOL;
}

