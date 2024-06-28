# phprivoxy/matcher
## Simple URI matcher.

### Requirements 
- **PHP >= 8.1**

### Installation
#### Using composer (recommended)
```bash
composer create phprivoxy/matcher
```

### Does pattern match the URI 

```php
$uri = 'www.site.ru/cat/page.html';
$matcher = new PHPrivoxy\Matcher\UriMatcher($uri);

$matcher->match('*');               // TRUE
$matcher->match('.');               // TRUE
$matcher->match(''); // FALSE
$matcher->match('site.ru'); // FALSE
$matcher->match('.site.ru');        // TRUE
$matcher->match('*.site.ru');       // TRUE
$matcher->match('*site*');          // TRUE
$matcher->match('.ite.ru'); // FALSE
$matcher->match('*ite.ru');         // TRUE
$matcher->match('/page.html'); // FALSE
$matcher->match('/*page.html');     // TRUE
$matcher->match('/ca');             // TRUE
$matcher->match('/ca*');            // TRUE
$matcher->match('/ca$'); // FALSE
$matcher->match('/cat/page.html$'); // TRUE
$matcher->match('/cat/page.html');  // TRUE
$matcher->match('/cat/page.htm');   // TRUE
$matcher->match('/cat/page.htm');   // TRUE
$matcher->match('*ite.ru/cat/pag'); // TRUE
$matcher->match('*/cat/page.*');    // TRUE
```

Any samples you also may find at "tests" directory.


### ### Does URI match the patterns 

```php
$patterns = [
    '.яндекс.рф/search',
    'microsoft.com/office',
    '*.microsoft.com/windows',
    '.windows.com',
    'github.com',
    '*linux*'
];

$matcher = new PHPrivoxy\Matcher\PatternsMatcher($patterns);
$matcher->match('https://www.яндекс.рф/'); // FALSE
$matcher->match('https://www.яндекс.рф/search.html'); // TRUE
$matcher->match('https://www.linuxmint.com/'); // TRUE
$matcher->match('https://www.microsoft.com/other/linux-vs-windows/'); // FALSE
$matcher->match('https://www.github.com/windows'); // FALSE
$matcher->match('https://github.com/os2'); // TRUE
$matcher->match('https://linux.github.com/'); // TRUE
$matcher->match('https://www.microsoft.com/office'); // FALSE
$matcher->match('https://microsoft.com/office2024'); // TRUE
$matcher->match('http://left.site/not-exist.html'); // FALSE
```

### License
MIT License See [LICENSE](LICENSE)
