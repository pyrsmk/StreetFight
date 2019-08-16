# StreetFight

StreetFight is a benchmarking tool aiming to quickly know what code have better performance against another one. It is not intended to be an exhaustive profiling library and probably won't grow any further.

Note that StreetFight is following the [Elegant Objects](https://www.elegantobjects.org/) principle, and uses some functional programming internally with the help of [Funktions](https://github.com/pyrsmk/Funktions).

## Install

StreetFight requires PHP 7.2.

```
composer require pyrsmk/streetfight
```

## Example

Here's the common way to execute a benchmark and retrieve a report directly from it. This example compares the performance of pre-increment and post-increment instructions.

```php
use StreetFight\Challenger\Challenger;
use StreetFight\Challenger\ChallengerList;
use StreetFight\Round\Round;
use StreetFight\Match\AutoTimedMatch;
use StreetFight\Report\Report;
use StreetFight\Report\PercentageReport;
use StreetFight\Report\DescSortedReport;

$report =
    // Sort the report in descending direction
    new DescSortedReport(
        // Convert the seconds report to percentage
        new PercentageReport(
            // Create a report to process match results
            new Report(
                // Create a match to process the benchmark for a certain time
                // (here, AutoTimedMatch will compute automatically the time of the match)
                // (see below for types of match)
                new AutoTimedMatch(
                    // A typical round...
                    new Round(
                        // ...with a challenger list
                        new ChallengerList(
                            new Challenger('Pre-increment', function () {
                                $i = 0;
                                ++$i;
                            }),
                            new Challenger('Post-increment', function () {
                                $i = 0;
                                $i++;
                            })
                        )
                    )
                )
            )
        )
    );

var_dump($report->asPercentages());
/*
    [
        'Post-increment' => 100,
        'Pre-increment' => 98.84
    ]
*/
```

## Match objects

There are 3 types of matches:

- `StreetFight\Match\Match(int $rounds, RoundInterface $round)`: it will take a number of rounds to run, and a `StreetFight\Round\Round` object
- `StreetFight\Match\TimedMatch(int $time, RoundInterface $round)`: it will take a minimum time in milliseconds while the benchmark will run, and a `StreetFight\Round\Round` object
- `StreetFight\Match\AutoTimedMatch(RoundInterface $round)`: contrary to `TimedMatch`, it will automatically compute the maximum time for the benchmark to run, and only accepts a `StreetFight\Round\Round` object as parameter

```php
new Match(
    100, // Will iterate 100 times
    new Round(
        new ChallengerList(
            new Challenger('Pre-increment', function () {
                $i = 0;
                ++$i;
            }),
            new Challenger('Post-increment', function () {
                $i = 0;
                $i++;
            })
        )
    )
)
```

```php
new TimedMatch(
    5000, // Will run for 5 seconds at least
    new Round(
        new ChallengerList(
            new Challenger('Pre-increment', function () {
                $i = 0;
                ++$i;
            }),
            new Challenger('Post-increment', function () {
                $i = 0;
                $i++;
            })
        )
    )
)
```

```php
// The recommended and simplest way to run the benchmark
new AutoTimedMatch(
    new Round(
        new ChallengerList(
            new Challenger('Pre-increment', function () {
                $i = 0;
                ++$i;
            }),
            new Challenger('Post-increment', function () {
                $i = 0;
                $i++;
            })
        )
    )
)
```

## Report objects

There are several types of `Report` objects:

- `StreetFight\Report\Report(MatchInterface $match)`: the main `Report` object, can only take a `Match` object as parameter; the results are returned as raw seconds
- `StreetFight\Report\RoundedSecondsReport`: a decorator for the main `Report` object; the results are returned as seconds rounded to 2 decimal digits
- `StreetFight\Report\MillisecondsReport`: a decorator for the main `Report` object; the results are returned as milliseconds
- `StreetFight\Report\MicrosecondsReport`: a decorator for the main `Report` object; the results are returned as microseconds
- `StreetFight\Report\PercentageReport`: a decorator for the main `Report` object; the results are returned in percentage
- `StreetFight\Report\AscSortedReport`: a decorator that sorts a report in ascending direction
- `StreetFight\Report\DescSortedReport`: a decorator that sorts a report in descending direction

```php
// Sort the report
new AscSortedReport(
    // Format the report results in microseconds
    new MicrosecondsReport(
        // The main Report object
        new Report(
            new AutoTimedMatch(
                new Round(
                    new ChallengerList(
                        new Challenger('Pre-increment', function () {
                            $i = 0;
                            ++$i;
                        }),
                        new Challenger('Post-increment', function () {
                            $i = 0;
                            $i++;
                        })
                    )
                )
            )
        )
    )
)
```

## Set BEFORE and AFTER hooks

If you need to run some specific routines, you can set them in the `Round` object:

```php
new Round(
    new ChallengerList(
        new Challenger('file_put_contents (overwrite)', function () {
            file_put_contents('foo.txt', 'bar');
        }),
        new Challenger('fwrite (overwrite)', function () {
            $f = fopen('foo.txt', 'w');
            fwrite($f, 'bar');
            fclose($f);
        }),
        new Challenger('file_put_contents (append)', function () {
            file_put_contents('foo.txt', 'bar', FILE_APPEND);
        }),
        new Challenger('fwrite (append)', function () {
            $f = fopen('foo.txt', 'a');
            fwrite($f, 'bar');
            fclose($f);
        }),
    ),
    // Set a hook that will be run BEFORE each task of each iteration
    new Hook(function () {
        touch('foo.txt');
    }),
    // Set a hook that will be run AFTER each task of each iteration
    new Hook(function () {
        unlink('foo.txt');
    })
)
```

## Passing some data to tasks

As you can see from the above example, the same data is used across all tasks. Furthermore, we could need to generate random data at each iteration. But since mutability makes it really difficult for StreetFight to keep track on the data (and passing it into objects complicates the API), it has been decided to define it outside of StreetFight itself in a procedural way. So, here's how you would use arbitrary data, based on the previous example:

```php
$data = [
    'filename' => 'foo.txt',
    'content' => 'bar'
];

new Round(
    new ChallengerList(
        new Challenger('file_put_contents (overwrite)', function () use ($data) {
            file_put_contents($data['filename'], $data['content']);
        }),
        new Challenger('fwrite (overwrite)', function () use ($data) {
            $f = fopen($data['filename'], 'w');
            fwrite($f, $data['content']);
            fclose($f);
        }),
        new Challenger('file_put_contents (append)', function () use ($data) {
            file_put_contents($data['filename'], $data['content'], FILE_APPEND);
        }),
        new Challenger('fwrite (append)', function () use ($data) {
            $f = fopen($data['filename'], 'a');
            fwrite($f, $data['content']);
            fclose($f);
        }),
    ),
    new Hook(function () {
        touch($data['filename']);
    }),
    new Hook(function () {
        unlink($data['filename']);
    })
)
```

## Side note

Depending on what code you're benchmarking, the execution time can exceed the `max_execution_time` directive of PHP. Just set `set_time_limit(0)` and you'll be all good.

## License

[MIT](http://dreamysource.mit-license.org).
