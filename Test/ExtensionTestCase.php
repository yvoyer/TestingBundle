<?php

namespace Ka\Bundle\TestingBundle\Test;

use Ka\Bundle\TestingBundle\Test\Constraint\Extension\ServiceClassEqualsConstraint;
use Ka\Bundle\TestingBundle\Test\Constraint\Extension\ServiceExistsConstraint;
use Ka\Bundle\TestingBundle\Test\Constraint\Extension\ServiceHasTagConstraint;
use Ka\Bundle\TestingBundle\Test\Constraint\Extension\ServiceIsAbstractConstraint;
use Ka\Bundle\TestingBundle\Test\Constraint\Extension\ServiceIsLazyConstraint;
use Ka\Bundle\TestingBundle\Test\Constraint\Extension\ServiceIsPublicConstraint;
use Ka\Bundle\TestingBundle\Test\Constraint\Extension\ServiceIsSynchronizedConstraint;
use Ka\Bundle\TestingBundle\Test\Constraint\Extension\ServiceIsSyntheticConstraint;
use Ka\Bundle\TestingBundle\Test\Constraint\Extension\ServiceScopeConstraint;
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
     * Asserts that a service with the specified id exists
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
     * Asserts that a service with the specified id does not exist
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
     * Asserts that a service has a given tag
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
     * Asserts that a service does not have a given tag
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
     * Asserts that a service tag attribute is equal to a value
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
     * Asserts that a service tag attribute is not equal to a value
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
     * Asserts service is synthetic
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
     * Asserts service is not synthetic
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
            self::logicalNot(
                new ServiceIsSyntheticConstraint($container)
            ),
            $message
        );
    }

    /**
     * Asserts service is abstract
     *
     * @param string $id
     * @param array $config
     * @param string $message
     */
    public function assertServiceIsAbstract($id, array $config = null, $message = '')
    {
        $container = $this->getContainer($config);

        self::assertThat($id, new ServiceIsAbstractConstraint($container), $message);
    }

    /**
     * Asserts service is not abstract
     *
     * @param $id
     * @param array $config
     * @param string $message
     */
    public function assertServiceIsNotAbstract($id, array $config = null, $message = '')
    {
        $container = $this->getContainer($config);

        self::assertThat(
            $id,
            self::logicalNot(
                new ServiceIsAbstractConstraint($container)
            ),
            $message
        );
    }

    /**
     * Asserts service is lazy
     *
     * @param string $id
     * @param array $config
     * @param string $message
     */
    public function assertServiceIsLazy($id, array $config = null, $message = '')
    {
        $container = $this->getContainer($config);

        self::assertThat($id, new ServiceIsLazyConstraint($container), $message);
    }

    /**
     * Asserts service is not lazy
     *
     * @param $id
     * @param array $config
     * @param string $message
     */
    public function assertServiceIsNotLazy($id, array $config = null, $message = '')
    {
        $container = $this->getContainer($config);

        self::assertThat(
            $id,
            self::logicalNot(
                new ServiceIsLazyConstraint($container)
            ),
            $message
        );
    }

    /**
     * Asserts service is public
     *
     * @param string $id
     * @param array $config
     * @param string $message
     */
    public function assertServiceIsPublic($id, array $config = null, $message = '')
    {
        $container = $this->getContainer($config);

        self::assertThat($id, new ServiceIsPublicConstraint($container), $message);
    }

    /**
     * Asserts service is not public
     *
     * @param $id
     * @param array $config
     * @param string $message
     */
    public function assertServiceIsNotPublic($id, array $config = null, $message = '')
    {
        $container = $this->getContainer($config);

        self::assertThat(
            $id,
            self::logicalNot(
                new ServiceIsPublicConstraint($container)
            ),
            $message
        );
    }

    /**
     * Asserts service is synchronized
     *
     * @param string $id
     * @param array $config
     * @param string $message
     */
    public function assertServiceIsSynchronized($id, array $config = null, $message = '')
    {
        $container = $this->getContainer($config);

        self::assertThat($id, new ServiceIsSynchronizedConstraint($container), $message);
    }

    /**
     * Asserts service is not synchronized
     *
     * @param $id
     * @param array $config
     * @param string $message
     */
    public function assertServiceIsNotSynchronized($id, array $config = null, $message = '')
    {
        $container = $this->getContainer($config);

        self::assertThat(
            $id,
            self::logicalNot(
                new ServiceIsSynchronizedConstraint($container)
            ),
            $message
        );
    }

    /**
     * Asserts that a service class is equal to a value
     * 
     * @param string $id
     * @param string $value
     * @param array $config
     * @param string $message
     */
    public function assertServiceClassEquals($id, $value, array $config = null, $message = '')
    {
        $container = $this->getContainer($config);

        self::assertThat($value, new ServiceClassEqualsConstraint($container, $id), $message);
    }

    /**
     * Asserts that a service class does not equal a value
     *
     * @param string $id
     * @param string $value
     * @param array $config
     * @param string $message
     */
    public function assertServiceClassNotEquals($id, $value, array $config = null, $message = '')
    {
        $container = $this->getContainer($config);

        self::assertThat(
            $value,
            self::logicalNot(
                new ServiceClassEqualsConstraint($container, $id)
            ),
            $message
        );
    }

    /**
     * Asserts that a service class can be configured by a parameter.
     *
     * @param string $id
     * @param array $config
     * @param string $message
     */
    public function assertServiceClassIsParameter($id, array $config = null, $message = '')
    {
        $container = $this->getContainer($config);

        self::assertThat("%{$id}.class%", new ServiceClassEqualsConstraint($container, $id), $message);
    }

    /**
     * Asserts that a service is request scoped
     *
     * @param string $id
     * @param array $config
     * @param string $message
     */
    public function assertServiceScopeIsRequest($id, array $config = null, $message = '')
    {
        $container = $this->getContainer($config);

        self::assertThat('request', new ServiceScopeConstraint($container, $id), $message);
    }

    /**
     * Asserts that a service is not request scoped
     *
     * @param string $id
     * @param array $config
     * @param string $message
     */
    public function assertServiceScopeIsNotRequest($id, array $config = null, $message = '')
    {
        $container = $this->getContainer($config);

        self::assertThat(
            'request',
            self::logicalNot(
                new ServiceScopeConstraint($container, $id)
            ),
            $message
        );
    }

    /**
     * Asserts that a service is prototype scoped
     *
     * @param string $id
     * @param array $config
     * @param string $message
     */
    public function assertServiceScopeIsPrototype($id, array $config = null, $message = '')
    {
        $container = $this->getContainer($config);

        self::assertThat('prototype', new ServiceScopeConstraint($container, $id), $message);
    }

    /**
     * Asserts that a service is not prototype scoped
     *
     * @param string $id
     * @param array $config
     * @param string $message
     */
    public function assertServiceScopeIsNotPrototype($id, array $config = null, $message = '')
    {
        $container = $this->getContainer($config);

        self::assertThat(
            'prototype',
            self::logicalNot(
                new ServiceScopeConstraint($container, $id)
            ),
            $message
        );
    }

    /**
     * Asserts that a service is container scoped
     *
     * @param string $id
     * @param array $config
     * @param string $message
     */
    public function assertServiceScopeIsContainer($id, array $config = null, $message = '')
    {
        $container = $this->getContainer($config);

        self::assertThat('container', new ServiceScopeConstraint($container, $id), $message);
    }

    /**
     * Asserts that a service is not prototype scoped
     *
     * @param string $id
     * @param array $config
     * @param string $message
     */
    public function assertServiceScopeIsNotContainer($id, array $config = null, $message = '')
    {
        $container = $this->getContainer($config);

        self::assertThat(
            'container',
            self::logicalNot(
                new ServiceScopeConstraint($container, $id)
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
