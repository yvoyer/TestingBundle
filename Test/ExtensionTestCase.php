<?php

namespace Ka\Bundle\TestingBundle\Test;

use Ka\Bundle\TestingBundle\Test\Constraint\Extension\ServiceExistsConstraint;
use Ka\Bundle\TestingBundle\Test\Constraint\Extension\ServiceHasTagConstraint;
use Ka\Bundle\TestingBundle\Test\Constraint\Extension\ServiceIsSyntheticConstraint;
use Ka\Bundle\TestingBundle\Test\Constraint\Extension\ServiceTagAttributeEqualsConstraint;
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
     * @var array
     */
    private $containers = array();

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
     * @param string $id
     * @param string $tag
     * @param array $config
     * @param string $message
     */
    public function assertServiceHasTag($id, $tag, array $config = null, $message = '')
    {
        $container = $this->getContainer($config);

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

        self::assertThat($tag,
            self::logicalNot(
                new ServiceHasTagConstraint($container, $id)
            ),
            $message
        );
    }

    /**
     * Assert that a service tag attribute is equal to a value
     *
     * @param string $id
     * @param string $tag
     * @param string $attribute
     * @param mixed $value
     * @param array $config
     * @param string $message
     */
    public function assertServiceTagAttributeEquals($id, $tag, $attribute, $value, array $config = null, $message = '')
    {
        $container = $this->getContainer($config);
        $attributes = $container->getDefinition($id)->getTag($tag);

        self::assertThat($value, new ServiceTagAttributeEqualsConstraint($attributes, $attribute), $message);
    }

    /**
     * Assert that a service tag attribute is not equal to a value
     *
     * @param string $id
     * @param string $tag
     * @param string $attribute
     * @param mixed $value
     * @param array $config
     * @param string $message
     */
    public function assertServiceTagAttributeNotEquals($id, $tag, $attribute, $value, array $config = null, $message = '')
    {
        $container = $this->getContainer($config);
        $attributes = $container->getDefinition($id)->getTag($tag);

        self::assertThat(
            $value,
            self::logicalNot(
                new ServiceTagAttributeEqualsConstraint($attributes, $attribute)
            ),
            $message
        );
    }

    /**
     * Assert service is synthetic
     *
     * @param string $id
     * @param array $config
     * @param string $message
     */
    public function assertServiceIsSynthetic($id, array $config = null, $message = '')
    {
        $container = $this->getContainer($config);

        self::assertThat($id, new ServiceIsSyntheticConstraint($container), $message);
    }

    /**
     * Assert service is not synthetic
     *
     * @param $id
     * @param array $config
     * @param string $message
     */
    public function assertServiceIsNotSynthetic($id, array $config = null, $message = '')
    {
        $container = $this->getContainer($config);

        self::assertThat(
            $id,
            $this->logicalNot(
                new ServiceIsSyntheticConstraint($container)
            ),
            $message
        );
    }

    /**
     * @param array $config
     *
     * @return ContainerBuilder
     */
    protected function getContainer(array $config = null)
    {
        $config = $config ?: $this->getDefaultConfig();

        $configId = md5(serialize($config));

        if (!isset($this->containers[$configId])) {
            $container = new ContainerBuilder();
            $extension = $this->getExtension();
            $extension->load($config, $container);

            $this->containers[$configId] = $container;
        }

        return $this->containers[$configId];
    }
}
