<?php

namespace Ka\Bundle\TestingBundle\Test;

use Ka\Bundle\TestingBundle\Test\Constraint\Extension\ServiceExistsConstraint;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;

/**
 * TODO: support functional use of these assertions?
 * TODO: since these assertions apply more to the container and less to the extension maybe they can be made more generic
 *
 * @author Kevin Archer <ka@kevinarcher.ca>
 */
abstract class ExtensionTestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * Get an instance of the Extension under test
     *
     * @return ExtensionInterface
     */
    abstract protected function getExtension();

    /**
     * Get a default config for the extension. This config will be used when none / null is passed as the config param
     * to the assertions.
     *
     * @return array
     */
    protected function getDefaultConfig()
    {
        return array();
    }

    /**
     * Assert that a service with the specified id exists
     *
     * @param string $id
     * @param array $config
     * @param string $message
     */
    public function assertServiceExists($id, array $config = null, $message = '')
    {
        $container = $this->getContainer($config);

        self::assertThat($id, new ServiceExistsConstraint($container), $message);
    }

    /**
     * Assert that a service with the specified id does not exist
     *
     * @param string $id
     * @param array $config
     * @param string $message
     */
    public function assertServiceNotExists($id, array $config = null, $message = '')
    {
        $container = $this->getContainer($config);

        self::assertThat($id,
            self::logicalNot(
                new ServiceExistsConstraint($container)
            ),
            $message
        );
    }

    /**
     * @param array $config
     *
     * @return ContainerBuilder
     */
    private function getContainer(array $config = null)
    {
        $container = new ContainerBuilder();
        $extension = $this->getExtension();
        $config = $config ?: $this->getDefaultConfig();

        $extension->load($config, $container);

        return $container;
    }
}
