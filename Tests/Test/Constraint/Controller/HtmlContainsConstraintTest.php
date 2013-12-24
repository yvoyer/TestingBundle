<?php

namespace Ka\Bundle\TestingBundle\Tests\Test\Constraint\Controller;

use Ka\Bundle\TestingBundle\Test\Constraint\Controller\HtmlContainsConstraint;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * @covers \Ka\Bundle\TestingBundle\Test\Constraint\Controller\HtmlContainsConstraint
 *
 * @author Kevin Archer <ka@kevinarcher.ca>
 */
class HtmlContainsConstraintTest extends WebTestCase
{
    /**
     * @group integration
     */
    public function testWithMatchingNeedleShouldReturnTrue()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/fixture/index');

        $constraint = new HtmlContainsConstraint($crawler);

        $this->assertTrue($constraint->matches('Index Content'));
    }

    /**
     * @group integration
     */
    public function testWithNonMatchShouldReturnFalse()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/fixture/index');

        $constraint = new HtmlContainsConstraint($crawler);

        $this->assertFalse($constraint->matches('Other Content'));
    }
}
