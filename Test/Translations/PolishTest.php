<?php

namespace Translations;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Translation\TranslatorInterface;
use Wookieb\Conditions\Results;
use Wookieb\DateDiffRequest;
use Wookieb\DateDiffResult;
use Wookieb\Formatters\TranslatorFormatter;

class PolishTest extends AbstractTranslationTest
{

    /**
     * @var TranslatorFormatter
     */
    private $formatter;


    protected function setUp()
    {
        $this->translator = $this->setupTranslator('pl');
        $this->translator->addResource('yml', __DIR__.'/../../Resources/translations/relative-date.pl.yml', 'pl', 'relative-date');
        $this->formatter = new TranslatorFormatter($this->translator);
    }

    public function translationCases()
    {
        $request = new DateDiffRequest(new \DateTimeImmutable(), new \DateTimeImmutable());
        return [
            [new DateDiffResult($request, Results::SECONDS_AGO, '1'), 'parę sekund temu'],
            [new DateDiffResult($request, Results::SECONDS_AGO, '10'), 'parę sekund temu'],
            [new DateDiffResult($request, Results::SECONDS_AGO, '30'), '30 sekund temu'],
            [new DateDiffResult($request, Results::SECONDS_AGO, '32'), '32 sekundy temu'],
            [new DateDiffResult($request, Results::SECONDS_AGO, '60'), '60 sekund temu'],
            [new DateDiffResult($request, Results::MINUTES_AGO, '1'), 'minutę temu'],
            [new DateDiffResult($request, Results::MINUTES_AGO, '2'), '2 minuty temu'],
            [new DateDiffResult($request, Results::MINUTES_AGO, '5'), '5 minut temu'],
            [new DateDiffResult($request, Results::MINUTES_AGO, '60'), '60 minut temu'],
            [new DateDiffResult($request, Results::HOURS_AGO, '1'), 'godzinę temu'],
            [new DateDiffResult($request, Results::HOURS_AGO, '2'), '2 godziny temu'],
            [new DateDiffResult($request, Results::HOURS_AGO, '5'), '5 godzin temu'],
            [new DateDiffResult($request, Results::HOURS_AGO, '10'), '10 godzin temu'],
            [new DateDiffResult($request, Results::HOURS_AGO, '60'), '60 godzin temu'],
            [new DateDiffResult($request, Results::DAYS_AGO, '1'), 'wczoraj'],
            [new DateDiffResult($request, Results::DAYS_AGO, '2'), 'przedwczoraj'],
            [new DateDiffResult($request, Results::DAYS_AGO, '3'), '3 dni temu'],
            [new DateDiffResult($request, Results::DAYS_AGO, '5'), '5 dni temu'],
            [new DateDiffResult($request, Results::DAYS_AGO, '20'), '20 dni temu'],
            [new DateDiffResult($request, Results::WEEKS_AGO, '1'), 'tydzień temu'],
            [new DateDiffResult($request, Results::WEEKS_AGO, '2'), '2 tygodnie temu'],
            [new DateDiffResult($request, Results::WEEKS_AGO, '3'), '3 tygodnie temu'],
            [new DateDiffResult($request, Results::WEEKS_AGO, '10'), '10 tygodni temu'],
            [new DateDiffResult($request, Results::WEEKS_AGO, '10'), '10 tygodni temu'],
            [new DateDiffResult($request, Results::MONTHS_AGO, '1'), 'miesiąc temu'],
            [new DateDiffResult($request, Results::MONTHS_AGO, '2'), '2 miesiące temu'],
            [new DateDiffResult($request, Results::MONTHS_AGO, '5'), '5 miesięcy temu'],
            [new DateDiffResult($request, 'yesterday'), 'wczoraj'],
            [new DateDiffResult($request, Results::YEARS_AGO, '1'), 'rok temu'],
            [new DateDiffResult($request, Results::YEARS_AGO, '2'), '2 lata temu'],
            [new DateDiffResult($request, Results::YEARS_AGO, '5'), '5 lat temu'],
        ];
    }

    /**
     * @dataProvider translationCases
     */
    public function testTranslation(DateDiffResult $dateDiffResult, $expected)
    {
        $this->assertSame($expected, $this->formatter->format($dateDiffResult));
    }
}