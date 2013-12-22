<?php

namespace Ka\Bundle\TestingBundle\Tests\Test\Controller;

use Ka\Bundle\TestingBundle\Test\Controller\ControllerTestCase;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * TODO: Probably could simply these tests by using data providers by assertion type
 *
 * @covers \Ka\Bundle\TestingBundle\Test\Controller\ControllerTestCase
 *
 * @covers \Ka\Bundle\TestingBundle\Test\Constraint\HtmlContainsConstraint
 * @covers \Ka\Bundle\TestingBundle\Test\Constraint\RedirectConstraint
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

    public function testAssertRedirectWithMatch()
    {
        $this->testCase->assertRedirect('/fixture/redirect');
    }

    /**
     * @expectedException \PHPUnit_Framework_ExpectationFailedException
     * @expectedExceptionMessage Failed asserting that '/fixture/index' is a redirect.
     */
    public function testAssertRedirectWithNonMatch()
    {
        $this->testCase->assertRedirect('/fixture/index');
    }

    public function testAssertRedirectToWithMatch()
    {
        $this->testCase->assertRedirectTo('/fixture/redirect', '/fixture/index');
    }

    /**
     * @expectedException \PHPUnit_Framework_ExpectationFailedException
     * @expectedExceptionMessage Failed asserting that '/fixture/redirect' is redirecting to '/fixture/test'.
     */
    public function testAssertRedirectToWithNonMatch()
    {
        $this->testCase->assertRedirectTo('/fixture/redirect', '/fixture/test');
    }

    /**
     * @expectedException \PHPUnit_Framework_ExpectationFailedException
     * @expectedExceptionMessage Failed asserting that '/fixture/index' is redirecting to '/fixture/index'.
     */
    public function testAssertRedirectToWithNonRedirectingMatch()
    {
        $this->testCase->assertRedirectTo('/fixture/index', '/fixture/index');
    }

    public function testAssertNotRedirectWithMatch()
    {
        $this->testCase->assertNotRedirect('/fixture/index');
    }

    /**
     * @expectedException \PHPUnit_Framework_ExpectationFailedException
     * @expectedExceptionMessage Failed asserting that '/fixture/redirect' is not a redirect.
     */
    public function testAssertNotRedirectWithNonMatch()
    {
        $this->testCase->assertNotRedirect('/fixture/redirect');
    }

    public function testAssertNotRedirectToWithMatch()
    {
        $this->testCase->assertNotRedirectTo('/fixture/redirect', '/fixture/test');
    }

    /**
     * @expectedException \PHPUnit_Framework_ExpectationFailedException
     * @expectedExceptionMessage Failed asserting that '/fixture/redirect' is not redirecting to '/fixture/index'.
     */
    public function testAssertNotRedirectToWithNonMatch()
    {
        $this->testCase->assertNotRedirectTo('/fixture/redirect', '/fixture/index');
    }

    /**
     * @expectedException \PHPUnit_Framework_ExpectationFailedException
     * @expectedExceptionMessage Failed asserting that '/fixture/redirect' is not redirecting to '/fixture/index'.
     */
    public function testAssertNotRedirectToWithRedirectingMatch()
    {
        $this->testCase->assertNotRedirectTo('/fixture/redirect', '/fixture/index');
    }
}
