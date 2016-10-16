<?php

namespace Gamma\Pushpin\PushpinBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

class GammaPushpinExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $container->setParameter('gamma.pushpin.control_uri', $config['proxy']['control_uri']);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');
        $loader->load('handlers.yml');
        $loader->load('json.yml');

        $this->configJsonEventFactory($config, $container);
    }

    /**
     * @param array            $config
     * @param ContainerBuilder $container
     */
    private function configJsonEventFactory(array $config, ContainerBuilder $container)
    {
        $baseNameSpace = $config['web_socket']['json_events']['base_namespace'];
        $mappings = $config['web_socket']['json_events']['mappings'];

        $jsonEventFactory = $container->getDefinition('gamma.pushpin.json_event_factory');

        $jsonEventFactory->addMethodCall(
            'configure',
            [
                $baseNameSpace,
                $mappings,
            ]
        );
    }
}
