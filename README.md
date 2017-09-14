StreetFight 6.5.0
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



/*
    - hooks?
    - ChallengerList : ajout?

    $match = new Match(
        new Rounds(
            100,
            new Round(
                new Chrono(),
                new ChallengerList([
                    new Challenger('name', function() {}),
                    new Challenger('name', function() {}),
                    new Challenger('name', function() {})
                ])
            )
        )
    );
    $report = new PercentageReport($match->fight());
    var_dump($report->compute());
*/



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

// Start the fight and return the complete results board
$board = $match->fight();

$report = new StreetFight\Report($board);
$report->getPerformance();
/*
    Will return, in percent (the less the better) :

    [
        'isset() === false' => 100,
        '!isset()' => 97.19
    ]
*/
```

Callbacks
---------

If you need to run some specific routines before and after each iteration, you can do :

```php
$match->begin(function ($container) {
    // some tasks
});

$match->end(function ($container) {
    // some other tasks
});
```

For ease of use, a [container](https://github.com/pyrsmk/Chernozem) is passed to each callback so you can register values/services that you'll pass to your benchmarks. Per example :

```php
$container = $match->getContainer();
$container['filename'] = __DIR__ . '/test.txt';

$streetFight->begin(function ($container) {
    touch($container['filename']);
});

$streetFight->end(function ($container) {
    unlink($container['filename']);
});

$streetFight->add('file_put_contents (overwrite)', function ($container) {
    file_put_contents($container['filename'], 'contents');
});

$streetFight->add('fwrite (overwrite)', function ($container) {
    $f = fopen($container['filename'], 'w');
    fwrite($f, 'contents');
    fclose($f);
});
```

Notes
-----

By default, the match will run for a total of `1000ms` for each test. If needed, when an test iteration is taking much more than `1000ms` You can force a match time with :

```php
// Run for 750ms
$match = new StreetFight\Match(750);
```

If needed, you can retrieve the results report in different units than percentages with :

```php
$report = new StreetFight\Report($board);
$report->getPerformance(StreetFight\Report::MS);

/*
    Available constants :

    - StreetFight\Report::PERCENTAGE
    - StreetFight\Report::SECONDS
    - StreetFight\Report::MILLISECONDS
    - StreetFight\Report::MICROSECONDS
*/
```

Depending on what code you're benchmarking, execution time can exceed the `max_execution_time` directive. Just use `set_time_limit(0)` in that case.

License
-------

[MIT](http://dreamysource.mit-license.org).
