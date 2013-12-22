<?php

namespace Ka\Bundle\TestingBundle\Tests\Fixtures\FixtureBundle\Controller;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * @author Kevin Archer <ka@kevinarcher.ca>
 */
class FixtureController
{
    public function indexAction()
    {
        return new Response('<html><body>Index Content</body></html>');
    }

    public function redirectAction()
    {
        return new RedirectResponse('/fixture/index');
    }
}
