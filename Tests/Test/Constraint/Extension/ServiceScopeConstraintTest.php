<?php

namespace Ka\Bundle\TestingBundle\Tests\Test\Constraint\Extension;

use Ka\Bundle\TestingBundle\Test\Constraint\Extension\ServiceScopeConstraint;

/**
 * @covers \Ka\Bundle\TestingBundle\Test\Constraint\Extension\ServiceScopeConstraint
 *
 * @author Kevin Archer <ka@kevinarcher.ca>
 */
class ServiceScopeConstraintTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @group unit
     *
     * @dataProvider serviceScopeProvider
     *
     * @param bool $expected
     * @param string $id
     * @param string $scope
     * @param bool $actualScope
     */
    public function testServiceScope($expected, $id, $scope, $actualScope)
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
            ->method('getScope')
            ->will($this->returnValue($actualScope))
        ;

        $constraint = new ServiceScopeConstraint($container, $id);

        $this->assertEquals($expected, $constraint->matches($scope));
    }

    public function serviceScopeProvider()
    {
        return array(
            'ServiceIsRequestScoped' => array(true, 'bar.service', 'request', 'request'),
            'ServiceIsNotContainerScoped' => array(false, 'baz.service', 'container', 'request'),
            'ServiceIsPrototypeScoped' => array(true, 'carl.service', 'prototype', 'prototype'),
        );
    }
}
