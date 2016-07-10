<?php

namespace Wookieb\RelativeTimeBundle;


use Symfony\Component\OptionsResolver\OptionsResolver;
use Wookieb\DateDiffCalculator;
use Wookieb\Formatters\TranslatorFormatter;

class TwigExtension extends \Twig_Extension
{
    /**
     * @var OptionsResolver
     */
    private $optionsResolver;

    /**
     * @var DateDiffCalculator[]
     */
    private $calculators = [];
    /**
     * @var TranslatorFormatter
     */
    private $formatter;

    public function __construct(TranslatorFormatter $formatter)
    {
        $this->optionsResolver = new OptionsResolver();
        $this->optionsResolver->setDefaults([
            'calculator' => 'upTo2Weeks',
            'date_format' => 'Y-m-d H:i:s'
        ]);
        $this->formatter = $formatter;
    }


    public function registerCalculator($name, DateDiffCalculator $dateDiffCalculator)
    {
        $this->calculators[$name] = $dateDiffCalculator;
    }

    public function setDefaultOptions($defaultOptions)
    {
        $this->optionsResolver->setDefaults($defaultOptions);
    }

    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('relative_date', [$this, 'relativeDate'])
        ];
    }

    public function relativeDate(\DateTimeInterface $date, \DateTimeInterface $baseDate = null, array $options = [])
    {
        $options = $this->optionsResolver->resolve($options);
        if (!isset($this->calculators[$options['calculator']])) {
            throw new \InvalidArgumentException(sprintf('Undefined date diff calculator "%s"', $options['calculator']));
        }
        $calculator = $this->calculators[$options['calculator']];
        $this->formatter->setDateFormat($options['date_format']);
        return $this->formatter->format($calculator->compute($date, $baseDate));
    }

    public function getName()
    {
        return 'relative-date';
    }
}