<?php

namespace Ka\Bundle\TestingBundle\Tests\Test\Constraint\Extension;

use Ka\Bundle\TestingBundle\Test\Constraint\Extension\ServiceTagAttributeEqualsConstraint;

/**
 * @covers \Ka\Bundle\TestingBundle\Test\Constraint\Extension\ServiceTagAttributeEqualsConstraint
 *
 * @author Kevin Archer <ka@kevinarcher.ca>
 */
class ServiceServiceTagAttributeEqualsConstraintTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @group unit
     *
     * @dataProvider tagAttributesProvider
     *
     * @param bool $expected
     * @param mixed $value
     * @param string $attribute
     * @param array $attributes
     */
    public function testAttributeEquals($expected, $value, $attribute, $attributes)
    {
        $constraint = new ServiceTagAttributeEqualsConstraint($attributes, $attribute);

        $this->assertEquals($expected, $constraint->matches($value));
    }

    public function tagAttributesProvider()
    {
        return array(
            'StringMatch' => array(true, 'value', 'flag', array(array('flag' => 'value'))),
            'BoolMatch' => array(true, false, 'attribute', array(array('flag' => 'baz', 'attribute' => false))),
            'TypeMismatch' => array(false, 1, 'number', array(array('number' => true))),
        );
    }
}
