<?php

namespace Ka\Bundle\TestingBundle\Tests\Test;

use Ka\Bundle\TestingBundle\Tests\Test\Fixtures\FixtureExtensionTestCase;
use Ka\Bundle\TestingBundle\Tests\Test\Fixtures\NoDefaultConfigurationExtensionTestCase;

/**
 * @covers \Ka\Bundle\TestingBundle\Test\ExtensionTestCase
 *
 * @covers \Ka\Bundle\TestingBundle\Test\Constraint\Extension\ServiceExistsConstraint
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
     * @expcetedExceptionMessage Failed asserting that 'fixture.baz' service is defined.
     */
    public function testAssertServiceExistsWithNonMatch()
    {
        $this->testCase->assertServiceExists('fixture.baz');
    }

    /**
     * @group integration
     *
     * @expectedException \PHPUnit_Framework_ExpectationFailedException
     * @expcetedExceptionMessage Failed asserting that 'fixture.default' service is defined.
     */
    public function testAssertServiceIsLoadedWithNoDefaultConfigDoesNotMatch()
    {
        $testcase = new NoDefaultConfigurationExtensionTestCase();

        $testcase->assertServiceExists('fixture.default');
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
     * @expcetedExceptionMessage Failed asserting that 'fixture.bar' service is not defined.
     */
    public function testAssertServiceNotExistsWithNonMatch()
    {
        $this->testCase->assertServiceNotExists('fixture.bar');
    }

    /**
     * @group integration
     *
     * @expectedException \PHPUnit_Framework_ExpectationFailedException
     * @expcetedExceptionMessage Failed asserting that 'fixture.custom' service is not defined.
     */
    public function testAssertServiceNotExistsWithCustomConfiguration()
    {
        $this->testCase->assertServiceNotExists('fixture.custom', array(
            'bar' => array(
                'custom' => true,
            ),
        ));
    }
}
