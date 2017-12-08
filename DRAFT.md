Streetfight draft
=================

```php
/*
    - BoardInterface#readResults() : array
    - MatchBoard#__construct(array $roundBoards)
    - RoundBoard#__construct(array $resultLines)

    - ResultLineInterface#which() : ChallengerInterface
    - ResultLineInterface#time() : float
    - ResultLine#__construct(ChallengerInterface $challenger, float $time)

    - ChallengerListInterface#readList() : array
*/

$match = StreetFight\ring(
    'challengers' => [
        'name' => function($container) {},
        'name' => function($container) {},
        'name' => function($container) {},
    ],
    'beginMatch' => function($container) {},
    'endMatch' => function($container) {},
    'beginRound' => function($container) {},
    'endRound' => function($container) {}
);

$match = new StreetFight\Match([
    'container' => new Chernozem\Container(),
    'board' => new StreetFight\Board(),
    'challengerList' => new StreetFight\ChallengerList([
        new StreetFight\Challenger('name', function($container) {}),
        new StreetFight\Challenger('name', function($container) {}),
        new StreetFight\Challenger('name', function($container) {}),
    ]),
    'rounds' => 100,
    'round' => new StreetFight\Round\WarmUp(function($challengerList) {
        return new StreetFight\Round(
            'id' => new StreetFight\Round\Id(),
            'board' => new StreetFight\Board(),
            'challengerList' => $challengerList,
            'chrono' => new StreetFight\Chrono(),
            'beginRoutine' => new StreetFight\Routine(function($container) {}),
            'endRoutine' => new StreetFight\Routine(function($container) {})
        );
    }),
    'beginRoutine' => new StreetFight\Routine(function($container) {}),
    'endRoutine' => new StreetFight\Routine(function($container) {})
]);

$report = new PercentageReport($match->fight());
var_dump($report->compute());
```
