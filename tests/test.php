<?php

namespace PHPrivoxy\Matcher;

require_once __DIR__ . '/../vendor/autoload.php';

use League\Uri\Idna\Converter;

echo!Converter::isIdn('http://яндекс.рф');
echo PHP_EOL;

echo Converter::isIdn('bébé.be');
echo PHP_EOL;

echo Converter::isIdn('www.xn--85x722f.xn--55qx5d.cn');
echo PHP_EOL;

echo PHP_EOL;

echo (Converter::toUnicode('http://яндекс.рф'))->domain();
echo PHP_EOL;

echo (Converter::toUnicode('bébé.be'))->domain();
echo PHP_EOL;

echo (Converter::toUnicode('www.xn--85x722f.xn--55qx5d.cn'))->domain();
echo PHP_EOL;

echo PHP_EOL;

echo (Converter::toAscii('http://яндекс.рф'))->domain();
echo PHP_EOL;

echo (Converter::toAscii('яндекс.рф'))->domain();
echo PHP_EOL;

echo (Converter::toAscii('bébé.be'))->domain();
echo PHP_EOL;

echo (Converter::toAscii('www.xn--85x722f.xn--55qx5d.cn'))->domain();
echo PHP_EOL;
