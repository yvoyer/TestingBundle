<?php

namespace Ka\Bundle\TestingBundle\Tests\Test\Constraint\Extension;

use Ka\Bundle\TestingBundle\Test\Constraint\Extension\ServiceHasTagConstraint;

/**
 * @covers \Ka\Bundle\TestingBundle\Test\Constraint\Extension\ServiceHasTagConstraint
 *
 * @author Kevin Archer <ka@kevinarcher.ca>
 */
class ServiceHasTagConstraintTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @group unit
     *
     * @dataProvider serviceTagProvider
     *
     * @param bool $expected
     * @param string $id
     * @param string $tag
     * @param bool $returnValue
     */
    public function testServiceHasTag($expected, $id, $tag, $returnValue)
    {
        $container = $this->getMock('Symfony\Component\DependencyInjection\ContainerBuilder');
        $reference = $this->getMock('Symfony\Component\DependencyInjection\Reference');

        $container
            ->expects($this->once())
            ->method('getReference')
            ->with($id)
            ->will($this->returnValue($reference))
        ;

        $reference
            ->expects($this->once())
            ->method('hasTag')
            ->with($tag)
            ->will($this->returnValue($returnValue));

        $constraint = new ServiceHasTagConstraint($container, $id);

        $this->assertEquals($expected, $constraint->matches($tag));
    }

    public function serviceTagProvider()
    {
        return array(
            array(true, 'bar.service', 'some.tag', true),
            array(false, 'baz.service', 'some.missing.tag', false),
        );
    }
}
