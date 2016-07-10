<?php

namespace Wookieb\RelativeTimeBundle;


use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Wookieb\RelativeTimeBundle\DependencyInjection\CalculatorsCompiler;

class RelativeTimeBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new CalculatorsCompiler());
    }

}