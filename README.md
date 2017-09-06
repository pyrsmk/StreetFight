StreetFight 5.1.0
=================

StreetFight is a tiny benchmarking tool aiming to quickly know what code is better in performance from another one. It is not intended to be an exhaustive profiling library and probably won't grow any further.

Install
-------

StreetFight requires PHP 7.1.

```
composer require pyrsmk/streetfight
```

How does it work?
-----------------

StreetFight, contrary to many benchmarks we can found on the net, has been designed to have stable results at each run. Instead of iterate `n` times on each benchmark one after the other, it iterates `n` times on all benchmarks. It avoids caching mecanism side effects.

Example/Use
-----------

```php
$match = new StreetFight\Match();

$match->add('!isset()', function () {
    !isset($undefined_var);
});

$match->add('isset() === false', function () {
    isset($undefined_var) === false;
});

$match->fight();

/*
    Will return, in percent (the less the better) :

    [
        'isset() === false' => 100,
        '!isset()' => 97.19
    ]
*/
```

`StreetFight\Match#add()` can accept any callable.

Begin/End
---------

If you need to run some specific routines before and after each iteration, you can do :

```php
$match->begin(function () {
    // some tasks
});

$match->end(function () {
    // some other tasks
});
```

Notes
-----

By default, the match will run for a total of `1000ms` for each test. If needed, when an test iteration is taking much more than `1000ms` You can force a match time with :

```php
// Run for 750ms
$match = new StreetFight\Match(750);
```

Depending on what code you're benchmarking, execution time can exceed the `max_execution_time` directive. Just use `set_time_limit(0)` in that case.

License
-------

[MIT](http://dreamysource.mit-license.org).
