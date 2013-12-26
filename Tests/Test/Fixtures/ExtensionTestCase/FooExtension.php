<?php

namespace Ka\Bundle\TestingBundle\Tests\Test\Fixtures\ExtensionTestCase;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\Config\FileLocator;

/**
 * @author Kevin Archer <ka@kevinarcher.ca>
 */
class FooExtension implements ExtensionInterface
{
    public function load(array $config, ContainerBuilder $container)
    {
        $loader = new XmlFileLoader(
            $container,
            new FileLocator(__DIR__.'/config')
        );

        $loader->load('services.xml');

        if (isset($config['bar']['custom'])) {
            $definition = new Definition();
            $definition->addTag('custom.tag', array('custom' => true));

            if (isset($config['bar']['custom']['public'])) {
                $definition->setPublic($config['bar']['custom']['public']);
            }

            $container->setDefinition('fixture.custom', $definition);
        }

        if (isset($config['bar']['default'])) {
            $container->setDefinition('fixture.default', new Definition());
        }
    }

    public function getXsdValidationBasePath()
    {
        return false;
    }

    public function getNamespace()
    {
        return 'http://testingbundle/fixture/schema';
    }

    public function getAlias()
    {
        return 'foo';
    }
} 
