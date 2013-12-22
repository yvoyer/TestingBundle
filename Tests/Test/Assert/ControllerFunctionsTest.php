<?php

namespace Ka\Bundle\TestingBundle\Tests\Test\Assert;

require_once __DIR__ . '/../../../Test/Assert/ControllerFunctions.php';

/**
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
    public function testAssertHtmlNotContains()
    {
        assertHtmlNotContains('Other Content', '/fixture/index');
    }

    /**
     * @covers ::assertHtmlNotContains
     *
     * @expectedException \PHPUnit_Framework_AssertionFailedError
     * @expectedExceptionMessage Failed asserting that 'Index Content' is not on the page.
     */
    public function testAssertHtmlContains()
    {
        assertHtmlNotContains('Index Content', '/fixture/index');
    }
}
