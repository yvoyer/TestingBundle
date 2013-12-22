<?php

/**
 * @author Kevin Archer <ka@kevinarcher.ca>
 */

/**
 * Asserts that the HTML Response from a Url contains a given text
 *
 * @param string $text
 * @param string $url
 * @param string $message
 */
function assertHtmlContains($text, $url, $message = '')
{
    return call_user_func_array(
        'Ka\Bundle\TestingBundle\Test\Controller\ControllerTestCase::assertHtmlContains',
        func_get_args()
    );
}

/**
 * Asserts that the HTML Response from a Url does not contain a given text
 *
 * @param string $text
 * @param string $url
 * @param string $message
 */
function assertHtmlNotContains($text, $url, $message = '')
{
    return call_user_func_array(
        'Ka\Bundle\TestingBundle\Test\Controller\ControllerTestCase::assertHtmlNotContains',
        func_get_args()
    );
}
