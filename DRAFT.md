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
    'board' => 'StreetFight\Board',
    'challengerList' => new StreetFight\ChallengerList([
        new StreetFight\Challenger('name', function($container) {}),
        new StreetFight\Challenger('name', function($container) {}),
        new StreetFight\Challenger('name', function($container) {}),
    ]),
    'rounds' => 100,
    'round' => function($challengerList) {
        return new StreetFight\Round([
            'id' => new StreetFight\Round\Id(),
            'board' => 'StreetFight\Board',
            'challengerList' => $challengerList,
            'chrono' => new StreetFight\Chrono(),
            'beginRoutine' => new StreetFight\Routine(function($container) {}),
            'endRoutine' => new StreetFight\Routine(function($container) {})
        ]);
    },
    'beginRoutine' => new StreetFight\Routine(function($container) {}),
    'endRoutine' => new StreetFight\Routine(function($container) {}),
]);

/*$arguments = (new Jeerz\Arguments([
    'container' => [
        'type' => 'Psr\Container\ContainerInterface',
        'default' => function() {
            return new Chernozem\Container();
        },
    ],
    'board' => [
        'type' => 'StreetFight\BoardInterface',
        'default' => 'StreetFight\Board',
    ],
    'challengerList' => [
        'type' => 'StreetFight\ChallengerList',
        'required' => true,
    ],
    'rounds' => [
        'type' => 'integer',
        'default' => 100,
    ],
    'round' => [
        'type' => 'Closure',
        'default' => function() {
            return function($challengerList) {
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
            };
        },
    ],
    'beginRoutine' => [
        'type' => 'Closure',
        'default' => function() {
            return function(){};
        },
    ],
    'endRoutine' => [
        'type' => 'Closure',
        'default' => function() {
            return function(){};
        },
    ],
    ],
]))->extract($args);*/

$match = new StreetFight\Match([
    'challengerList' => new StreetFight\ChallengerList([
        new StreetFight\Challenger('name', function($container) {}),
        new StreetFight\Challenger('name', function($container) {}),
        new StreetFight\Challenger('name', function($container) {}),
    ]),
]);

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
