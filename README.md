StreetFight 1.0.3
=================

StreetFight is a tiny benchmarking tool aiming to quickly know what code is better in performance from another one. It is not intended to be an exhaustive profiling library and probably won't grow any further.

Install
-------

StreetFight requires PHP 7.1.

```
composer require pyrsmk/streetfight
```

Example/Use
-----------

```php
$match = new StreetFight\Match();

$match->add('!isset()', new StreetFight\Challenger(function() {
    !isset($undefined_var);
}));

$match->add('isset() === false', new StreetFight\Challenger(function() {
    isset($undefined_var) === false;
}));

$match->fight();

/*
    Will return, in percent (the less the better) :

    [
        'isset() === false' => 100,
        '!isset()' => 97.19
    ]
*/
```

Glossary
--------

- the `Match` object is the benchmarking tool
- the `Challenger` object is a chunk of code to test

Notes
-----

By default, the tool will run for at least `2000ms`. You can tweak it by passing another value to the constructor :

```php
// For 750ms
$match = new StreetFight\Match(750);
```

A `Challenger` object accepts any callable argument in its constructor :

```php
// This will call $an_object::a_method()
$challenger = new StreetFight\Challenger([$an_object, 'a_method']);
```

Depending on what code you're benchmarking, execution time can exceed the `max_execution_time` directive. Just use `set_time_limit(0)` in that case.

License
-------

[MIT](http://dreamysource.mit-license.org).
