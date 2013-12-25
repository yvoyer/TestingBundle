<?php

namespace Ka\Bundle\TestingBundle\Tests\Test;

use Ka\Bundle\TestingBundle\Tests\Test\Fixtures\ExtensionTestCase\FixtureExtensionTestCase;
use Ka\Bundle\TestingBundle\Tests\Test\Fixtures\ExtensionTestCase\NoDefaultConfigurationExtensionTestCase;

/**
 * @covers \Ka\Bundle\TestingBundle\Test\ExtensionTestCase
 *
 * @covers \Ka\Bundle\TestingBundle\Test\Constraint\Extension\ServiceExistsConstraint
 * @covers \Ka\Bundle\TestingBundle\Test\Constraint\Extension\ServiceHasTagConstraint
 * @covers \Ka\Bundle\TestingBundle\Test\Constraint\Extension\TagAttributeEqualsConstraint
 *
 * @author Kevin Archer <ka@kevinarcher.ca>
 */
class ExtensionTestCaseTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var FixtureExtensionTestCase
     */
    private $testCase;

    public function setUp()
    {
        $this->testCase = new FixtureExtensionTestCase();
    }

    /**
     * @group integration
     */
    public function testAssertServiceExistsWithMatch()
    {
        $this->testCase->assertServiceExists('fixture.bar');
    }

    /**
     * @group integration
     */
    public function testAssertServiceExistsWithMatchAndCustomConfig()
    {
        $this->testCase->assertServiceExists('fixture.custom', array(
            'bar' => array(
                'custom' => true,
            ),
        ));
    }

    /**
     * @group integration
     */
    public function testAssertServiceExistsWithMatchFromDefaultConfig()
    {
        $this->testCase->assertServiceExists('fixture.default');
    }

    /**
     * @group integration
     *
     * @expectedException \PHPUnit_Framework_ExpectationFailedException
     * @expectedExceptionMessage Failed asserting that 'fixture.baz' service is defined.
     */
    public function testAssertServiceExistsWithNonMatch()
    {
        $this->testCase->assertServiceExists('fixture.baz');
    }

    /**
     * @group integration
     *
     * @expectedException \PHPUnit_Framework_ExpectationFailedException
     * @expectedExceptionMessage Failed asserting that 'fixture.default' service is defined.
     */
    public function testAssertServiceIsLoadedWithNoDefaultConfigDoesNotMatch()
    {
        $testcase = new NoDefaultConfigurationExtensionTestCase();

        $testcase->assertServiceExists('fixture.default');
    }

    /**
     * @group integration
     *
     * @expectedException \PHPUnit_Framework_ExpectationFailedException
     * @expectedExceptionMessage Service should be defined
     */
    public function testAssertServiceExistsWithMessage()
    {
        $this->testCase->assertServiceExists('fixture.baz', null, 'Service should be defined');
    }

    /**
     * @group integration
     */
    public function testAssertServiceNotExistsWithMatch()
    {
        $this->testCase->assertServiceNotExists('fixture.non.existing');
    }

    /**
     * @group integration
     *
     * @expectedException \PHPUnit_Framework_ExpectationFailedException
     * @expectedExceptionMessage Failed asserting that 'fixture.bar' service is not defined.
     */
    public function testAssertServiceNotExistsWithNonMatch()
    {
        $this->testCase->assertServiceNotExists('fixture.bar');
    }

    /**
     * @group integration
     *
     * @expectedException \PHPUnit_Framework_ExpectationFailedException
     * @expectedExceptionMessage Service should not be defined
     */
    public function testAssertServiceNotExistsWithMessage()
    {
        $this->testCase->assertServiceNotExists('fixture.bar', null, 'Service should not be defined');
    }

    /**
     * @group integration
     *
     * @expectedException \PHPUnit_Framework_ExpectationFailedException
     * @expectedExceptionMessage Failed asserting that 'fixture.custom' service is not defined.
     */
    public function testAssertServiceNotExistsWithCustomConfiguration()
    {
        $this->testCase->assertServiceNotExists('fixture.custom', array(
            'bar' => array(
                'custom' => true,
            ),
        ));
    }

    /**
     * @group integration
     */
    public function testAssertServiceHasTagWithMatch()
    {
        $this->testCase->assertServiceHasTag('fixture.bar', 'bar.tag');
    }

    /**
     * @group integration
     *
     * @expectedException \PHPUnit_Framework_ExpectationFailedException
     * @expectedExceptionMessage Failed asserting that 'fixture.bar' service has tag 'baz.tag'.
     */
    public function testAssertServiceHasTagWithNonMatch()
    {
        $this->testCase->assertServiceHasTag('fixture.bar', 'baz.tag');
    }

    /**
     * @group integration
     *
     * @expectedException \PHPUnit_Framework_ExpectationFailedException
     * @expectedExceptionMessage Service should have baz.tag tag
     */
    public function testAssertServiceHasTagWithMessage()
    {
        $this->testCase->assertServiceHasTag('fixture.bar', 'baz.tag', null, ' Service should have baz.tag tag');
    }

    /**
     * @group integration
     */
    public function testAssertServiceNotHasTagWithMatch()
    {
       $this->testCase->assertServiceNotHasTag('fixture.bar', 'baz.tag');
    }

    /**
     * @group integration
     *
     * @expectedException \PHPUnit_Framework_ExpectationFailedException
     * @expectedExceptionMessage Failed asserting that 'fixture.bar' service does not have tag 'bar.tag'.
     */
    public function testAssertServiceNotHasTagWithNonMatch()
    {
        $this->testCase->assertServiceNotHasTag('fixture.bar', 'bar.tag');
    }

    /**
     * @group integration
     *
     * @expectedException \PHPUnit_Framework_ExpectationFailedException
     * @expectedExceptionMessage Service should not have bar.tag
     */
    public function testAssertServiceNotHasTagWithMessage()
    {
        $this->testCase->assertServiceNotHasTag('fixture.bar', 'bar.tag', null, 'Service should not have bar.tag');
    }

    /**
     * @group integration
     */
    public function testAssertTagAttributeEqualsWithMatch()
    {
        $this->testCase->assertTagAttributeEquals('fixture.bar', 'bar.tag', 'flag', true);
    }

    /**
     * @group integration
     *
     * @expectedException \PHPUnit_Framework_ExpectationFailedException
     * @expectedExceptionMessage Failed asserting that test attribute is equal to 'abc'.
     */
    public function testAssertTagAttributeEqualsWithNonMatch()
    {
        $this->testCase->assertTagAttributeEquals('fixture.bar', 'bar.tag', 'test', 'abc');
    }

    /**
     * @group integration
     *
     * @expectedException \PHPUnit_Framework_ExpectationFailedException
     * @expectedExceptionMessage Custom message
     */
    public function testAssertTagAttributeEqualsWithMessage()
    {
        $this->testCase->assertTagAttributeEquals('fixture.bar', 'bar.tag', 'test', 'abc', null, 'Custom message');
    }

    /**
     * @group integration
     */
    public function testAssertTagAttributeNotEqualsWithMatch()
    {
        $this->testCase->assertTagAttributeNotEquals('fixture.bar', 'bar.tag', 'test', 'abc');
    }

    /**
     * @group integration
     *
     * @expectedException \PHPUnit_Framework_ExpectationFailedException
     * @expectedExceptionMessage Failed asserting that test attribute is not equal to 'check'.
     */
    public function testAssertTagAttributeNotEqualsWithNonMatch()
    {
        $this->testCase->assertTagAttributeNotEquals('fixture.bar', 'bar.tag', 'test', 'check');
    }

    /**
     * @group integration
     *
     * @expectedException \PHPUnit_Framework_ExpectationFailedException
     * @expectedExceptionMessage Attribute should not equal x
     */
    public function testAssertTagAttributeNotEqualsWithMessage()
    {
        $this->testCase->assertTagAttributeNotEquals('fixture.bar', 'bar.tag', 'test', 'check', null, 'Attribute should not equal x');
    }
}
