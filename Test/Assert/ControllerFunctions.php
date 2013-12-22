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

/**
 * Asserts that the Requested Url redirects
 *
 * @param string $url
 * @param string $message
 */
function assertRedirect($url, $message = '')
{
    return call_user_func_array(
        'Ka\Bundle\TestingBundle\Test\Controller\ControllerTestCase::assertRedirect',
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
        'Ka\Bundle\TestingBundle\Test\Controller\ControllerTestCase::assertNotRedirect',
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
        'Ka\Bundle\TestingBundle\Test\Controller\ControllerTestCase::assertRedirectTo',
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
        'Ka\Bundle\TestingBundle\Test\Controller\ControllerTestCase::assertNotRedirectTo',
        func_get_args()
    );
}

