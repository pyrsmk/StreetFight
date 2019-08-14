```php
$match = new DescSortedReport(
    new PercentageReport(
        new Report(
            new AutoTimedMatch(
                new Round(
                    new ChallengerList(
                        new Challenger('player1', function () {}),
                        new Challenger('player2', function () {})
                    ),
                    new Hook(function () {}),
                    new Hook(function () {})
                )
            )
        )
    )
);
var_dump($match()->fight());
```
