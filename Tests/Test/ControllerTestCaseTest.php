<?php

namespace Ka\Bundle\TestingBundle\Tests\Test;

use Ka\Bundle\TestingBundle\Test\ControllerTestCase;

/**
 * TODO: Probably could simply these tests by using data providers by assertion type
 *
 * @covers \Ka\Bundle\TestingBundle\Test\ControllerTestCase
 *
 * @covers \Ka\Bundle\TestingBundle\Test\Constraint\Controller\HtmlContainsConstraint
 * @covers \Ka\Bundle\TestingBundle\Test\Constraint\Controller\RedirectConstraint
 *
 * @author Kevin Archer <ka@kevinarcher.ca>
 */
class ControllerTestCaseTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ControllerTestCase
     */
    private $testCase;

    public function setUp()
    {
        $this->testCase = new ControllerTestCase();
    }

    /**
     * @group functional
     */
    public function testAssertHtmlContainsWithMatch()
    {
        $this->testCase->assertHtmlContains('Index Content', '/fixture/index');
    }

    /**
     * @group functional
     *
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
     * @group functional
     *
     * @expectedException \PHPUnit_Framework_ExpectationFailedException
     * @expectedExceptionMessage Failed asserting that 'Index Content' is not on the page.
     */
    public function testAssertHtmlNotContainsWithNonMatch()
    {
        $this->testCase->assertHtmlNotContains('Index Content', '/fixture/index');
    }

    /**
     * @group functional
     */
    public function testAssertRedirectWithMatch()
    {
        $this->testCase->assertRedirect('/fixture/redirect');
    }

    /**
     * @group functional
     *
     * @expectedException \PHPUnit_Framework_ExpectationFailedException
     * @expectedExceptionMessage Failed asserting that '/fixture/index' is a redirect.
     */
    public function testAssertRedirectWithNonMatch()
    {
        $this->testCase->assertRedirect('/fixture/index');
    }

    /**
     * @group functional
     */
    public function testAssertRedirectToWithMatch()
    {
        $this->testCase->assertRedirectTo('/fixture/redirect', '/fixture/index');
    }

    /**
     * @group functional
     *
     * @expectedException \PHPUnit_Framework_ExpectationFailedException
     * @expectedExceptionMessage Failed asserting that '/fixture/redirect' is redirecting to '/fixture/test'.
     */
    public function testAssertRedirectToWithNonMatch()
    {
        $this->testCase->assertRedirectTo('/fixture/redirect', '/fixture/test');
    }

    /**
     * @group functional
     *
     * @expectedException \PHPUnit_Framework_ExpectationFailedException
     * @expectedExceptionMessage Failed asserting that '/fixture/index' is redirecting to '/fixture/index'.
     */
    public function testAssertRedirectToWithNonRedirectingMatch()
    {
        $this->testCase->assertRedirectTo('/fixture/index', '/fixture/index');
    }

    /**
     * @group functional
     */
    public function testAssertNotRedirectWithMatch()
    {
        $this->testCase->assertNotRedirect('/fixture/index');
    }

    /**
     * @group functional
     *
     * @expectedException \PHPUnit_Framework_ExpectationFailedException
     * @expectedExceptionMessage Failed asserting that '/fixture/redirect' is not a redirect.
     */
    public function testAssertNotRedirectWithNonMatch()
    {
        $this->testCase->assertNotRedirect('/fixture/redirect');
    }

    /**
     * @group functional
     */
    public function testAssertNotRedirectToWithMatch()
    {
        $this->testCase->assertNotRedirectTo('/fixture/redirect', '/fixture/test');
    }

    /**
     * @group functional
     *
     * @expectedException \PHPUnit_Framework_ExpectationFailedException
     * @expectedExceptionMessage Failed asserting that '/fixture/redirect' is not redirecting to '/fixture/index'.
     */
    public function testAssertNotRedirectToWithNonMatch()
    {
        $this->testCase->assertNotRedirectTo('/fixture/redirect', '/fixture/index');
    }

    /**
     * @group functional
     *
     * @expectedException \PHPUnit_Framework_ExpectationFailedException
     * @expectedExceptionMessage Failed asserting that '/fixture/redirect' is not redirecting to '/fixture/index'.
     */
    public function testAssertNotRedirectToWithRedirectingMatch()
    {
        $this->testCase->assertNotRedirectTo('/fixture/redirect', '/fixture/index');
    }

    public function testAssertAuthenticationIsRequiredWithMatch()
    {
        $this->testCase->assertAuthenticationIsRequired('/fixture/secured', '/fixture/login');
    }

    /**
     * @group functional
     *
     * @expectedException \PHPUnit_Framework_ExpectationFailedException
     * @expectedExceptionMessage Failed asserting that '/fixture/index' is redirecting to '/fixture/login'.
     */
    public function testAssertAuthenticationIsRequiredWithNonMatch()
    {
        $this->testCase->assertAuthenticationIsRequired('/fixture/index', '/fixture/login');
    }

    /**
     * @group functional
     *
     * @expectedException \PHPUnit_Framework_ExpectationFailedException
     * @expectedExceptionMessage Failed asserting that '/fixture/secured' is redirecting to '/fixture/not-the-login'.
     */
    public function testAssertAuthenticationIsRequiredWithNonMatchLoginUrl()
    {
        $this->testCase->assertAuthenticationIsRequired('/fixture/secured', '/fixture/not-the-login');
    }

    /**
     * @group functional
     */
    public function testAuthenticateWithSuccessfulLogin()
    {
        $this->testCase->authenticate('/fixture/login', 'admin', 'adminpass');

        $this->testCase->assertHtmlContains('Logged in', '/fixture/secured');
    }

    /**
     * @group functional
     */
    public function testAuthenticateWithSuccessfulLoginWithFormValues()
    {
        $this->testCase->authenticate('/fixture/login', array(
            '_username' => 'admin',
            '_password' => 'adminpass',
        ));

        $this->testCase->assertHtmlContains('Logged in', '/fixture/secured');
    }

    /**
     * @group functional
     */
    public function testAuthenticateWithUnsuccessfulLogin()
    {
        $this->testCase->authenticate('/fixture/login', 'admin', 'wrongpass');

        $this->testCase->assertAuthenticationIsRequired('/fixture/secured', '/fixture/login');
    }

    /**
     * @group functional
     */
    public function testAuthenticateWithInsufficientPermsLogin()
    {
        $this->testCase->authenticate('/fixture/login', 'user', 'userpasss');

        $this->testCase->assertAuthenticationIsRequired('/fixture/secured/adminonly', '/fixture/login');
    }
}
