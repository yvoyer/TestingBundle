<?php

namespace Ka\Bundle\TestingBundle\Tests\Test\Constraint\Controller;

use Ka\Bundle\TestingBundle\Test\Constraint\Controller\RedirectConstraint;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * @covers \Ka\Bundle\TestingBundle\Test\Constraint\Controller\RedirectConstraint
 *
 * @author Kevin Archer <ka@kevinarcher.ca>
 */
class RedirectConstraintTest extends WebTestCase
{
    /**
     * @group functional
     *
     * @dataProvider urlProvider
     *
     * @param bool $expected
     * @param mixed $url
     * @param mixed $redirectUrl
     */
    public function testRedirectMatching($expected, $url, $redirectUrl)
    {
        $client = static::createClient();
        $crawler = $client->request('GET', $url);

        $constraint = new RedirectConstraint($client);

        $this->assertEquals($expected, $constraint->matches($redirectUrl));
    }

    public function urlProvider()
    {
        return array(
            'RedirectUrl' => array(true, '/fixture/redirect', null),
            'RedirectUrlWithToUrl' => array(true, '/fixture/redirect', '/fixture/index'),
            'NonRedirectUrl' => array(false, '/fixture/index', null),
            'NonRedirectUrlWithToUrl' => array(false, '/fixture/index', '/fixture/test'),
            'RedirectUrlWithNonMatchingToUrl' => array(false, '/fixture/redirect', '/fixture/test')
        );
    }
}
