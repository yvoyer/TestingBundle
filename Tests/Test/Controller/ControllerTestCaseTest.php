<?php

namespace Ka\Bundle\TestingBundle\Tests\Test\Controller;

use Ka\Bundle\TestingBundle\Test\Controller\ControllerTestCase;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * @covers \Ka\Bundle\TestingBundle\Test\Controller\ControllerTestCase
 *
 * @author Kevin Archer <ka@kevinarcher.ca>
 */
class ControllerTestCaseTest extends WebTestCase
{
    /**
     * @var ControllerTestCase
     */
    private $testCase;

    public function setUp()
    {
        $this->testCase = new ControllerTestCase();
    }

    public function testAssertHtmlContainsWithMatch()
    {
        $this->testCase->assertHtmlContains('Index Content', '/fixture/index');
    }

    /**
     * @expectedException \PHPUnit_Framework_ExpectationFailedException
     * @expectedExceptionMessage Failed asserting that 'Other Content' is on the page.
     */
    public function testAssertHtmlContainsWithNonMatch()
    {
        $this->testCase->assertHtmlContains('Other Content', '/fixture/index');
    }

    public function testAssertHtmlNotContainsWithMatch()
    {
        $this->testCase->assertHtmlNotContains('Other Content', '/fixture/index');
    }

    /**
     * @expectedException \PHPUnit_Framework_ExpectationFailedException
     * @expectedExceptionMessage Failed asserting that 'Index Content' is not on the page.
     */
    public function testAssertHtmlNotContainsWithNonMatch()
    {
        $this->testCase->assertHtmlNotContains('Index Content', '/fixture/index');
    }
}
