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

$match = new StreetFight\Match([
    'container' => new Chernozem\Container(),
    'board' => function(array $results) {
        return new StreetFight\Board($results);
    },
    'challengerList' => new StreetFight\ChallengerList([
        new StreetFight\Challenger('name', function($container) {}),
        new StreetFight\Challenger('name', function($container) {}),
        new StreetFight\Challenger('name', function($container) {}),
    ]),
    'rounds' => 100,
    'round' => function($challengerList) {
        return new StreetFight\Round([
            'id' => new StreetFight\Round\Id(),
            'board' => function(array $results) {
                return new StreetFight\Board($results);
            },
            'challengerList' => $challengerList,
            'chrono' => new StreetFight\Chrono(),
            'beginRoutine' => new StreetFight\Routine(function($container) {}),
            'endRoutine' => new StreetFight\Routine(function($container) {})
        ]);
    },
    'beginRoutine' => new StreetFight\Routine(function($container) {}),
    'endRoutine' => new StreetFight\Routine(function($container) {})
]);

$match = StreetFight\createMatch(
    'challengers' => [
        'name' => function($container) {},
        'name' => function($container) {},
        'name' => function($container) {},
    ],
    'rounds' => 100,
    'beginMatch' => function($container) {},
    'endMatch' => function($container) {},
    'beginRound' => function($container) {},
    'endRound' => function($container) {}
);

var_dump(
    (
        new PercentageReport($match->fight())
    )
    ->compute()
);

/*
    Projet annexe : Jeerz
    But : proposer des objets de base pour un écosystème en pur objet

    Premier module : Jeerz\Options
    But : gérer simplement des options passées en tableau associatif à un objet

    Faut il gérer des objets pour les types? (string, boolean, int, ...)
*/
```
