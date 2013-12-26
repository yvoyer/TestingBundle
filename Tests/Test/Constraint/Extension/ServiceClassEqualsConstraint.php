<?php

namespace Ka\Bundle\TestingBundle\Tests\Test\Constraint\Extension;

use Ka\Bundle\TestingBundle\Test\Constraint\Extension\ServiceClassEqualsConstraint;

/**
 * @covers \Ka\Bundle\TestingBundle\Test\Constraint\Extension\ServiceClassEqualsConstraint
 *
 * @author Kevin Archer <ka@kevinarcher.ca>
 */
class ServiceClassEqualsConstraintTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @group unit
     *
     * @dataProvider serviceClassProvider
     *
     * @param bool $expected
     * @param string $id
     * @param string $class
     * @param bool $returnValue
     */
    public function testServiceHasTag($expected, $id, $class, $returnValue)
    {
        $container = $this->getMock('Symfony\Component\DependencyInjection\ContainerBuilder');
        $definition = $this->getMock('Symfony\Component\DependencyInjection\Definition');

        $container
            ->expects($this->once())
            ->method('getDefinition')
            ->with($id)
            ->will($this->returnValue($definition))
        ;

        $definition
            ->expects($this->once())
            ->method('getClass')
            ->will($this->returnValue($returnValue))
        ;

        $constraint = new ServiceClassEqualsConstraint($container, $id);

        $this->assertEquals($expected, $constraint->matches($class));
    }

    public function serviceClassProvider()
    {
        return array(
            array(true, 'bar.service', '%bar.service.class%', true),
            array(true, 'bar.service', 'Foo\\Bar\\FooBar', true),
            array(false, 'baz.service', 'Unknown\\Class', false),
        );
    }
}
