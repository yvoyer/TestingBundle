<?php

namespace Ka\Bundle\TestingBundle\Tests\Test\Constraint\Extension;

use Ka\Bundle\TestingBundle\Test\Constraint\Extension\ServiceIsSyntheticConstraint;

/**
 * @covers \Ka\Bundle\TestingBundle\Test\Constraint\Extension\ServiceIsSyntheticConstraint
 *
 * @author Kevin Archer <ka@kevinarcher.ca>
 */
class ServiceIsSyntheticConstraintTest extends \PHPUnit_Framework_TestCase
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
    public function testServiceIsSynthetic($expected, $id, $returnValue)
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
            ->method('isSynthetic')
            ->will($this->returnValue($returnValue))
        ;


        $constraint = new ServiceIsSyntheticConstraint($container);

        $this->assertEquals($expected, $constraint->matches($id));
    }

    public function serviceProvider()
    {
        return array(
            array(true, 'some.synthetic.service', true),
            array(false, 'some.regular.service', false),
        );
    }
}
