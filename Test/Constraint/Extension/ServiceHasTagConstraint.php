<?php

namespace Ka\Bundle\TestingBundle\Test\Constraint\Extension;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

/**
 * @author Kevin Archer <ka@kevinarcher.ca>
 */
class ServiceHasTagConstraint extends \PHPUnit_Framework_Constraint
{
    /**
     * @var ContainerBuilder
     */
    private $container;

    /**
     * @var Definition
     */
    private $definition;

    /**
     * @var string
     */
    private $id;

    /**
     * @param ContainerBuilder $container
     * @param string $id
     */
    public function __construct(ContainerBuilder $container, $id)
    {
        $this->container = $container;
        $this->definition = $container->getDefinition($id);
        $this->id = $id;
    }

    /**
     * @param string $other
     *
     * @return bool
     */
    public function matches($other)
    {
        return $this->definition->hasTag($other);
    }

    /**
     * @return string
     */
    public function toString()
    {
        return 'has tag';
    }

    /**
     * @param string $other
     *
     * @return string
     */
    protected function failureDescription($other)
    {
        return \PHPUnit_Util_Type::export($this->id) . ' service '. $this->toString() . ' ' . \PHPUnit_Util_Type::export($other);
    }
}
