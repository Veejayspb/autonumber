Аutomobile number generator
============================

[![License: WTFPL](https://img.shields.io/badge/License-WTFPL-brightgreen.svg)](http://www.wtfpl.net/about/)

Generator for russian automobile registration numbers.

Features:
- validation;
- ability to set/get number, letters, region number separately;
- regions list;
- built-in iterators (prev, next);

Example
--------
```php
use veejay\autonumber\Generator;

$generator = new Generator('а123ве178');

$generator->letter->next(); // аве -> авк
$generator->region->prev(); // 178 -> 98
$generator->number->setValue(22); // 123 -> 022

$result = $generator->getValue(); // а022вк98
```