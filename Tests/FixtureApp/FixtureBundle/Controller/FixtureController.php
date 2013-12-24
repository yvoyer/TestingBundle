<?php

namespace Ka\Bundle\TestingBundle\Tests\FixtureApp\FixtureBundle\Controller;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\SecurityContextInterface;

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

    public function loginAction(Request $request)
    {
        $session = $request->getSession();

        // TODO: not quite sure why I have to manually start the session for authentication to work..
        $session->start();

        return new Response('<html><body>
        <form action="/fixture/secured/login_check" method="post">
            Username: <input type="text" name="_username" />
            Password: <input type="password" name="_password" />
            <input type="submit" value="Login" />
        </form>
        </body></html>');
    }

    public function securedAction()
    {
        return new Response('<html><body>Logged in</body></html>');
    }

    public function adminAction()
    {
        return new Response('<html><body>Admins only!</body></html>');
    }
}
