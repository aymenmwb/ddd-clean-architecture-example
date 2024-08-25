<?php

namespace Symfony5;

use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;
use Symfony5\DependencyInjection\Compiler\AutowireFdmPass;

class Kernel extends BaseKernel
{
    use MicroKernelTrait;

    public function registerBundles(): iterable
    {
        $contents = require $this->getProjectDir().'/config/bundles.php';
        foreach ($contents as $class => $envs) {
            if ($envs[$this->environment] ?? $envs['all'] ?? false) {
                yield new $class();
            }
        }
    }

    protected function configureContainer(ContainerConfigurator $container, LoaderInterface $loader, ContainerBuilder $builder): void
    {
        $configDir = $this->getConfigDir();

        $container->import($configDir.'/{packages}/*.yaml');
        $container->import($configDir.'/{packages}/'.$this->environment.'/*.yaml');

        $container->import($configDir.'/services.yaml');
        $container->import($configDir.'/parameters.yaml');

        $container->extension('twig', [
            'paths' => [
                '%kernel.project_dir%/resources/templates/',
            ],
        ]);
    }

    protected function configureRoutes(RoutingConfigurator $routes)
    {
        $confDir = $this->getProjectDir().'/config';
        $routes->import($confDir.'/{routes}/*.yaml' );
        $routes->import($confDir.'/routes.yaml');
    }

    protected function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new AutowireFdmPass());
    }

}
