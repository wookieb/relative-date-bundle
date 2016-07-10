<?php

namespace Wookieb\RelativeTimeBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class
CalculatorsCompiler implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $services = $container->findTaggedServiceIds('relative_date.calculator');

        $twigService = $container->getDefinition('relative_time_bundle.twig');

        foreach ($services as $serviceId => $tags) {
            foreach ($tags as $tagName => $tagAttributes) {
                $twigService->addMethodCall('registerCalculator', [
                    $tagAttributes['alias'], new Reference($serviceId)
                ]);
            }
        }
    }
}