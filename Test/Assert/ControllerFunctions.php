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
        'Ka\Bundle\TestingBundle\Test\ControllerTestCase::assertHtmlContains',
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
        'Ka\Bundle\TestingBundle\Test\ControllerTestCase::assertHtmlNotContains',
        func_get_args()
    );
}

/**
 * Asserts that the Requested Url redirects
 *
 * @param string $url
 * @param string $message
 */
function assertRedirect($url, $message = '')
{
    return call_user_func_array(
        'Ka\Bundle\TestingBundle\Test\ControllerTestCase::assertRedirect',
        func_get_args()
    );
}

/**
 * Asserts that the Requested Url does not redirect
 *
 * @param string $url
 * @param string $message
 */
function assertNotRedirect($url, $message = '')
{
    return call_user_func_array(
        'Ka\Bundle\TestingBundle\Test\ControllerTestCase::assertNotRedirect',
        func_get_args()
    );
}

/**
 * Asserts that the Requested Url redirects to another Url
 *
 * @param string $url
 * @param string $redirectUrl
 * @param string $message
 */
function assertRedirectTo($url, $redirectUrl, $message = '')
{
    return call_user_func_array(
        'Ka\Bundle\TestingBundle\Test\ControllerTestCase::assertRedirectTo',
        func_get_args()
    );
}

/**
 * Asserts that the Requested Url does not redirect to another Url
 *
 * @param string $url
 * @param string $redirectUrl
 * @param string $message
 */
function assertNotRedirectTo($url, $redirectUrl, $message = '')
{
    return call_user_func_array(
        'Ka\Bundle\TestingBundle\Test\ControllerTestCase::assertNotRedirectTo',
        func_get_args()
    );
}

/**
 * Assert that the Request Url redirects to a login page
 *
 * @param string $url
 * @param string $loginUrl
 * @param string $message
 */
function assertAuthenticationIsRequired($url, $redirectUrl, $message = '')
{
    return call_user_func_array(
        'Ka\Bundle\TestingBundle\Test\ControllerTestCase::assertAuthenticationIsRequired',
        func_get_args()
    );
}
