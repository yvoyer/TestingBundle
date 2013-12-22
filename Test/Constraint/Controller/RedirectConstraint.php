<?php

namespace Ka\Bundle\TestingBundle\Test\Constraint\Controller;

use Ka\Bundle\TestingBundle\Test\TextUI\CrawlerPrinter;
use Symfony\Bundle\FrameworkBundle\Client;

/**
 * TODO: Currently only internal Redirects can be validated
 *
 * @author Kevin Archer <ka@kevinarcher.ca>
 */
class RedirectConstraint extends \PHPUnit_Framework_Constraint
{
    /**
     * @var Client
     */
    private $client;

    /**
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @param string $other
     *
     * @return bool
     */
    public function matches($other)
    {
        if (null !== $other) {
            $schemeAndHost = $this->client->getRequest()->getSchemeAndHttpHost();
            $response = $this->client->getResponse();

            return ($response->isRedirect($other) || $response->isRedirect($schemeAndHost.$other));
        }

        return $this->client->getResponse()->isRedirection();
    }

    /**
     * @return string
     */
    public function toString()
    {
        return 'is redirecting to';
    }

    /**
     * @param mixed $other
     *
     * @return string
     */
    protected function additionalFailureDescription($other)
    {
        return (new CrawlerPrinter($this->client->getCrawler()))->html();
    }

    /**
     * @param mixed $other
     *
     * @return string
     */
    protected function failureDescription($other)
    {
        $requestUri = $this->client->getRequest()->getRequestUri();

        if (null !== $other) {
            return \PHPUnit_Util_Type::export($requestUri) . ' ' . $this->toString() . ' ' .\PHPUnit_Util_Type::export($other);
        }

        return \PHPUnit_Util_Type::export($requestUri) . ' is a redirect';
    }
}
