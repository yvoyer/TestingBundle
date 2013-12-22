<?php

namespace Ka\Bundle\TestingBundle\Tests\Test\Assert;

require_once __DIR__ . '/../../../Test/Assert/ControllerFunctions.php';

/**
 * TODO: There is a lot of overlap between these tests and the ControllerTestCase tests. See if there's a better way to
 * test the functions behave as expected.
 *
 * @author Kevin Archer <ka@kevinarcher.ca>
 */
class ControllerFunctionsTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers ::assertHtmlContains
     */
    public function testAssertHtmlContainsPasses()
    {
        assertHtmlContains('Index Content', '/fixture/index');
    }

    /**
     * @covers ::assertHtmlContains
     *
     * @expectedException \PHPUnit_Framework_AssertionFailedError
     * @expectedExceptionMessage Failed asserting that 'Other Content' is on the page.
     */
    public function testAssertHtmlContainsFails()
    {
        assertHtmlContains('Other Content', '/fixture/index');
    }

    /**
     * @covers ::assertHtmlNotContains
     */
    public function testAssertHtmlNotContainsPasses()
    {
        assertHtmlNotContains('Other Content', '/fixture/index');
    }

    /**
     * @covers ::assertHtmlNotContains
     *
     * @expectedException \PHPUnit_Framework_AssertionFailedError
     * @expectedExceptionMessage Failed asserting that 'Index Content' is not on the page.
     */
    public function testAssertHtmlNotContainsFails()
    {
        assertHtmlNotContains('Index Content', '/fixture/index');
    }

    /**
     * @covers ::assertRedirect
     */
    public function testAssertRedirectPasses()
    {
        assertRedirect('/fixture/redirect');
    }

    /**
     * @covers ::assertRedirect
     *
     * @expectedException \PHPUnit_Framework_AssertionFailedError
     * @expectedExceptionMessage Failed asserting that '/fixture/index' is a redirect.
     */
    public function testAssertRedirectFails()
    {
        assertRedirect('/fixture/index');
    }

    /**
     * @covers ::assertNotRedirect
     */
    public function testAssertNotRedirectPasses()
    {
        assertNotRedirect('/fixture/index');
    }

    /**
     * @covers ::assertNotRedirect
     *
     * @expectedException \PHPUnit_Framework_AssertionFailedError
     * @expectedExceptionMessage Failed asserting that '/fixture/redirect' is not a redirect.
     */
    public function testAssertNotRedirectFails()
    {
        assertNotRedirect('/fixture/redirect');
    }

    /**
     * @covers ::assertRedirectTo
     */
    public function testAssertRedirectToPasses()
    {
        assertRedirectTo('/fixture/redirect', '/fixture/index');
    }

    /**
     * @covers ::assertRedirectTo
     *
     * @expectedException \PHPUnit_Framework_AssertionFailedError
     * @expectedExceptionMessage Failed asserting that '/fixture/redirect' is redirecting to '/fixture/test'.
     */
    public function testAssertRedirectToFails()
    {
        assertRedirectTo('/fixture/redirect', '/fixture/test');
    }

    /**
     * @covers ::assertNotRedirectTo
     */
    public function testAssertNotRedirectToPasses()
    {
        assertNotRedirectTo('/fixture/redirect', '/fixture/test');
    }

    /**
     * @covers ::assertRedirectTo
     *
     * @expectedException \PHPUnit_Framework_AssertionFailedError
     * @expectedExceptionMessage Failed asserting that '/fixture/redirect' is not redirecting to '/fixture/index'.
     */
    public function testAssertNotRedirectToFails()
    {
        assertNotRedirectTo('/fixture/redirect', '/fixture/index');
    }
}
