<?php

namespace Ka\Bundle\TestingBundle\Test;

use Ka\Bundle\TestingBundle\Test\Constraint\Extension\ServiceExistsConstraint;
use Ka\Bundle\TestingBundle\Test\Constraint\Extension\ServiceHasTagConstraint;
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
     * TODO: Allow yml file or string to be provided as default config?
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
     * Assert that a service has a given tag
     *
     * TODO: to prevent building the container excessively and allow for multiple assertions, the assertions should
     * accept a built container instead of a config
     *
     * @param string $id
     * @param string $tag
     * @param array $config
     * @param string $message
     */
    public function assertServiceHasTag($id, $tag, array $config = null, $message = '')
    {
        $container = $this->getContainer($config);

        self::assertServiceExists($id, $config);
        self::assertThat($tag, new ServiceHasTagConstraint($container, $id), $message);
    }

    /**
     * Assert that a service does not have a given tag
     *
     * @param string $id
     * @param string $tag
     * @param array $config
     * @param string $message
     */
    public function assertServiceNotHasTag($id, $tag, array $config = null, $message = '')
    {
        $container = $this->getContainer($config);

        self::assertServiceExists($id, $config);
        self::assertThat($tag,
            self::logicalNot(
                new ServiceHasTagConstraint($container, $id)
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
