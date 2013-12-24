<?php

namespace Ka\Bundle\TestingBundle\Tests\Test\Constraint\Extension;

use Ka\Bundle\TestingBundle\Test\Constraint\Extension\ServiceExistsConstraint;

/**
 * @covers \Ka\Bundle\TestingBundle\Test\Constraint\Extension\ServiceExistsConstraint
 *
 * @author Kevin Archer <ka@kevinarcher.ca>
 */
class ServiceExistsConstraintTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @group unit
     *
     * @dataProvider serviceMatchingProvider
     *
     * @param bool $expected
     * @param string $id
     * @param bool $returnValue
     */
    public function testServiceExistsMatching($expected, $id, $returnValue)
    {
        $container = $this->getMock('Symfony\Component\DependencyInjection\ContainerBuilder');

        $container
            ->expects($this->once())
            ->method('has')
            ->with($id)
            ->will($this->returnValue($returnValue))
        ;

        $constraint = new ServiceExistsConstraint($container);

        $this->assertEquals($expected, $constraint->matches($id));
    }

    public function serviceMatchingProvider()
    {
        return array(
            array(true, 'some.existing.service', true),
            array(false, 'some.missing.service', false),
        );
    }
}
