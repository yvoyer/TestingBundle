<?php

namespace Ka\Bundle\TestingBundle\Test\Constraint\Extension;

use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * @author Kevin Archer <ka@kevinarcher.ca>
 */
class ServiceIsSynchronizedConstraint extends \PHPUnit_Framework_Constraint
{
    /**
     * @var ContainerBuilder
     */
    private $container;

    /**
     * @param ContainerBuilder $container
     */
    public function __construct(ContainerBuilder $container)
    {
        $this->container = $container;
    }

    /**
     * @param string $id
     *
     * @return bool
     */
    public function matches($id)
    {
        return $this->container->getDefinition($id)->isSynchronized();
    }

    /**
     * @return string
     */
    public function toString()
    {
        return 'service is synchronized';
    }
}
