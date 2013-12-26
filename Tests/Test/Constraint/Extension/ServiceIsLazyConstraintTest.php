<?php

namespace Ka\Bundle\TestingBundle\Tests\Test\Constraint\Extension;

use Ka\Bundle\TestingBundle\Test\Constraint\Extension\ServiceIsLazyConstraint;

/**
 * @covers \Ka\Bundle\TestingBundle\Test\Constraint\Extension\ServiceIsLazyConstraint
 *
 * @author Kevin Archer <ka@kevinarcher.ca>
 */
class ServiceIsLazyConstraintTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @group unit
     *
     * @dataProvider serviceProvider
     *
     * @param bool $expected
     * @param string $id
     * @param bool $returnValue
     */
    public function testServiceIsAbstract($expected, $id, $returnValue)
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
            ->method('isLazy')
            ->will($this->returnValue($returnValue))
        ;


        $constraint = new ServiceIsLazyConstraint($container);

        $this->assertEquals($expected, $constraint->matches($id));
    }

    public function serviceProvider()
    {
        return array(
            array(true, 'some.lazy.service', true),
            array(false, 'some.regular.service', false),
        );
    }
}
