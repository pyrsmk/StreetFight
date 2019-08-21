<?php

error_reporting(E_ALL);

require __DIR__ . '/vendor/autoload.php';

########################################################### Prepare

$suite = new MiniSuite\Suite('StreetFight');

################################################## StreetFight\Result\Result

$result = new StreetFight\Result\Result('foo', 0.5);
$array1 = [];
$array2 = ['foo' => 0.5];
$array3 = ['foo' => 1];

$suite->expects('Result#addTo(): add with non existing result')
    ->that($result->addTo($array1))
    ->equals($array2);

$suite->expects('Result#addTo(): add when the result already exists')
    ->that($result->addTo($array2))
    ->equals($array3);

################################################## StreetFight\Result\ResultList

$resultList = new StreetFight\Result\ResultList(
    $result,
    $result,
    $result
);

$suite->expects('ResultList#items(): return 3 items')
    ->that(count(iterator_to_array($resultList->items())))
    ->equals(3);

################################################## StreetFight\Challenger\Challenger

$challenger = new StreetFight\Challenger\Challenger('foo', function () {
    echo 'foo';
    usleep(1000);
});

$suite->expects('Challenger#kick(): run >= 1ms')
    ->that(function () use ($challenger) {
        $result = $challenger->kick()->addTo([]);
        return $result['foo'];
    })
    ->isGreaterThanOrEqual(0.001);

ob_start();
$challenger->kick();

$suite->expects('Challenger#kick(): muted output')
    ->that(ob_get_clean())
    ->equals('');

################################################## StreetFight\Challenger\ChallengerList

$challengerList = new StreetFight\Challenger\ChallengerList(
    $challenger,
    new StreetFight\Challenger\Challenger('bar', function () {
        usleep(1000);
    }),
    new StreetFight\Challenger\Challenger('foobar', function () {
        usleep(1000);
    })
);

$suite->expects('ChallengerList#items(): return 3 items')
    ->that(count(iterator_to_array($challengerList->items())))
    ->equals(3);

################################################## StreetFight\Hook\Hook

$hook = new StreetFight\Hook\Hook(function () {
    echo 'bar';
});

ob_start();
$hook->run();

$suite->expects('Hook#run(): has run')
    ->that(ob_get_clean())
    ->equals('bar');

################################################## StreetFight\Hook\NullHook

$nullHook = new StreetFight\Hook\NullHook();
$nullHook->run();

################################################## StreetFight\Round\Round

$round = new StreetFight\Round\Round($challengerList, $hook, $hook);
ob_start();
$round->fight();

$suite->expects('Round#fight(): the hooks have been called')
    ->that(ob_get_clean())
    ->equals('barbarbarbarbarbar');

$round = new StreetFight\Round\Round($challengerList);

$suite->expects('Round#fight(): the returned ResultList has 3 items')
    ->that(count(iterator_to_array($round->fight()->items())))
    ->equals(3);

################################################## StreetFight\Match\Match

$match = new StreetFight\Match\Match(10, $round);

$suite->expects('Match#fight(): 10 results in the array')
    ->that(count($match->fight()))
    ->equals(10);

################################################## StreetFight\Match\TimedMatch

$match = new StreetFight\Match\TimedMatch(15, $round);

$suite->expects('TimedMatch#fight(): at least 3 results in the array')
    ->that(count($match->fight()))
    ->isGreaterThanOrEqual(3);

$time1 = microtime(true);
$match->fight();
$time2 = microtime(true);

$suite->expects('TimedMatch#fight(): run >= 15ms')
    ->that($time2 - $time1)
    ->isGreaterThanOrEqual(0.015);

$match = new StreetFight\Match\TimedMatch(-1000, $round);
$time1 = microtime(true);
$match->fight();
$time2 = microtime(true);

$suite->expects('TimedMatch#fight(): run > 0ms and < 4ms')
    ->that($time2 - $time1)
    ->isBetween(0, 0.004);

################################################## StreetFight\Match\AutoTimedMatch

$match = new StreetFight\Match\AutoTimedMatch(
    new StreetFight\Round\Round(
        new StreetFight\Challenger\ChallengerList(
            new StreetFight\Challenger\Challenger('foo', function () {
            }),
            new StreetFight\Challenger\Challenger('bar', function () {
            }),
            new StreetFight\Challenger\Challenger('foobar', function () {
            })
        )
    )
);

$suite->expects('AutoTimedMatch#fight(): 10000 results in the array')
    ->that(count($match->fight()))
    ->equals(10000);

################################################## StreetFight\Report\Report

$report = new StreetFight\Report\Report(
    new StreetFight\Match\Match(
        1,
        new StreetFight\Round\Round(
            new StreetFight\Challenger\ChallengerList(
                new StreetFight\Challenger\Challenger('foo', function () {
                }),
                new StreetFight\Challenger\Challenger('bar', function () {
                }),
                new StreetFight\Challenger\Challenger('foobar', function () {
                })
            )
        )
    )
);
$results = $report->compute();

$suite->expects('Report#compute(): computed result 1')
    ->that($results['foo'])
    ->isFloat();

$suite->expects('Report#compute(): computed result 2')
    ->that($results['bar'])
    ->isFloat();

$suite->expects('Report#compute(): computed result 3')
    ->that($results['foobar'])
    ->isFloat();

################################################## StreetFight\Report\RoundedSecondsReport

$report = new StreetFight\Report\RoundedSecondsReport(
    new StreetFight\Report\Report(
        new StreetFight\Match\Match(
            1000,
            new StreetFight\Round\Round(
                new StreetFight\Challenger\ChallengerList(
                    new StreetFight\Challenger\Challenger('foo', function () {
                        usleep(30000);
                    }),
                    new StreetFight\Challenger\Challenger('bar', function () {
                        usleep(30000);
                    }),
                    new StreetFight\Challenger\Challenger('foobar', function () {
                        usleep(30000);
                    })
                )
            )
        )
    )
);
$results = $report->compute();

$suite->expects('RoundedSecondsReport#compute(): computed result 1')
    ->that($results['foo'])
    ->isGreaterThanOrEqual(0.03);

$suite->expects('RoundedSecondsReport#compute(): computed result 2')
    ->that($results['bar'])
    ->isGreaterThanOrEqual(0.03);

$suite->expects('RoundedSecondsReport#compute(): computed result 3')
    ->that($results['foobar'])
    ->isGreaterThanOrEqual(0.03);

################################################## StreetFight\Report\MillisecondsReport

$report = new StreetFight\Report\MillisecondsReport(
    new StreetFight\Report\Report(
        new StreetFight\Match\Match(
            1000,
            new StreetFight\Round\Round(
                new StreetFight\Challenger\ChallengerList(
                    new StreetFight\Challenger\Challenger('foo', function () {
                        usleep(1000);
                    }),
                    new StreetFight\Challenger\Challenger('bar', function () {
                        usleep(1000);
                    }),
                    new StreetFight\Challenger\Challenger('foobar', function () {
                        usleep(1000);
                    })
                )
            )
        )
    )
);
$results = $report->compute();

$suite->expects('MillisecondsReport#compute(): computed result 1')
    ->that($results['foo'])
    ->isGreaterThanOrEqual(1000);

$suite->expects('MillisecondsReport#compute(): computed result 2')
    ->that($results['bar'])
    ->isGreaterThanOrEqual(1000);

$suite->expects('MillisecondsReport#compute(): computed result 3')
    ->that($results['foobar'])
    ->isGreaterThanOrEqual(1000);

################################################## StreetFight\Report\MicrosecondsReport

$report = new StreetFight\Report\MicrosecondsReport(
    new StreetFight\Report\Report(
        new StreetFight\Match\Match(
            1000,
            new StreetFight\Round\Round(
                new StreetFight\Challenger\ChallengerList(
                    new StreetFight\Challenger\Challenger('foo', function () {
                        usleep(1);
                    }),
                    new StreetFight\Challenger\Challenger('bar', function () {
                        usleep(1);
                    }),
                    new StreetFight\Challenger\Challenger('foobar', function () {
                        usleep(1);
                    })
                )
            )
        )
    )
);
$results = $report->compute();

$suite->expects('MicrosecondsReport#compute(): computed result 1')
    ->that($results['foo'])
    ->isFloat()
    ->isGreaterThanOrEqual(1000);

$suite->expects('MicrosecondsReport#compute(): computed result 2')
    ->that($results['bar'])
    ->isFloat()
    ->isGreaterThanOrEqual(1000);

$suite->expects('MicrosecondsReport#compute(): computed result 3')
    ->that($results['foobar'])
    ->isFloat()
    ->isGreaterThanOrEqual(1000);

################################################## StreetFight\Report\PercentageReport

$report = new StreetFight\Report\PercentageReport(
    new StreetFight\Report\Report(
        new StreetFight\Match\Match(
            1000,
            new StreetFight\Round\Round(
                new StreetFight\Challenger\ChallengerList(
                    new StreetFight\Challenger\Challenger('foo', function () {
                    }),
                    new StreetFight\Challenger\Challenger('bar', function () {
                    }),
                    new StreetFight\Challenger\Challenger('foobar', function () {
                    })
                )
            )
        )
    )
);
$results = $report->compute();

$suite->expects('PercentageReport#compute(): computed result 1')
    ->that($results['foo'])
    ->isFloat()
    ->isGreaterThanOrEqual(0)
    ->isLessThanOrEqual(100);

$suite->expects('PercentageReport#compute(): computed result 2')
    ->that($results['bar'])
    ->isFloat()
    ->isGreaterThanOrEqual(0)
    ->isLessThanOrEqual(100);

$suite->expects('PercentageReport#compute(): computed result 3')
    ->that($results['foobar'])
    ->isFloat()
    ->isGreaterThanOrEqual(0)
    ->isLessThanOrEqual(100);

################################################## StreetFight\Report\AscSortedReport

$report = new StreetFight\Report\AscSortedReport(
    new StreetFight\Report\Report(
        new StreetFight\Match\Match(
            1,
            new StreetFight\Round\Round(
                new StreetFight\Challenger\ChallengerList(
                    new StreetFight\Challenger\Challenger('foo', function () {
                        usleep(2000);
                    }),
                    new StreetFight\Challenger\Challenger('bar', function () {
                        usleep(4000);
                    }),
                    new StreetFight\Challenger\Challenger('foobar', function () {
                        usleep(1000);
                    })
                )
            )
        )
    )
);
$results = $report->compute();

$suite->expects('AscSortedReport#compute(): positions')
    ->that(array_keys($results))
    ->equals(['foobar', 'foo', 'bar']);

################################################## StreetFight\Report\DescSortedReport

$report = new StreetFight\Report\DescSortedReport(
    new StreetFight\Report\Report(
        new StreetFight\Match\Match(
            1,
            new StreetFight\Round\Round(
                new StreetFight\Challenger\ChallengerList(
                    new StreetFight\Challenger\Challenger('foo', function () {
                        usleep(2000);
                    }),
                    new StreetFight\Challenger\Challenger('bar', function () {
                        usleep(4000);
                    }),
                    new StreetFight\Challenger\Challenger('foobar', function () {
                        usleep(1000);
                    })
                )
            )
        )
    )
);
$results = $report->compute();

$suite->expects('DescSortedReport#compute(): positions')
    ->that(array_keys($results))
    ->equals(['bar', 'foo', 'foobar']);
