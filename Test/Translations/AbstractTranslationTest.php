<?php

namespace Translations;


use Symfony\Component\Translation\Loader\YamlFileLoader;
use Symfony\Component\Translation\Translator;
use Symfony\Component\Translation\TranslatorInterface;

abstract class AbstractTranslationTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var TranslatorInterface
     */
    protected $translator;

    protected function setupTranslator($locale)
    {
        $translator = new Translator($locale);
        $translator->addLoader('yml', new YamlFileLoader());
        return $translator;
    }

}