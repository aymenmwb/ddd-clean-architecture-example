<?php declare(strict_types=1);

namespace Symfony\DependencyInjection\Compiler;

use ReflectionClass;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class AutowireFdmPass implements CompilerPassInterface
{
    public function __construct()
    {
    }

    /**
     * You can modify the container here before it is dumped to PHP code.
     */
    public function process(ContainerBuilder $container)
    {
        $ids = $container->findTaggedServiceIds('fdm.autowire');

        foreach (array_keys($ids) as $className) {
            $rf = new ReflectionClass($className);
            foreach ($rf->getInterfaces() as $interface) {
                if (strpos($interface->getName(), 'Fdm') === 0) {
                    $container->autowire($interface->getName(), $className);
                }
            }
        }
    }

}
