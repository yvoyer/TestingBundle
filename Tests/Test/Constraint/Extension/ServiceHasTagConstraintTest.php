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
     * @param bool $hasTag
     */
    public function testServiceHasTag($expected, $id, $tag, $hasTag)
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
            ->method('hasTag')
            ->with($tag)
            ->will($this->returnValue($hasTag))
        ;

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
