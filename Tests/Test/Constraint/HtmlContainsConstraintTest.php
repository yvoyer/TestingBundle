<?php

namespace Ka\Bundle\TestingBundle\Tests\Test\Constraint;

use Ka\Bundle\TestingBundle\Test\Constraint\HtmlContainsConstraint;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * @covers \Ka\Bundle\TestingBundle\Test\Constraint\HtmlContainsConstraint
 *
 * @author Kevin Archer <ka@kevinarcher.ca>
 */
class HtmlContainsConstraintTest extends WebTestCase
{
    public function testWithMatchingNeedleShouldReturnTrue()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/fixture/index');

        $constraint = new HtmlContainsConstraint($crawler);

        $this->assertTrue($constraint->matches('Index Content'));
    }

    public function testWithNonMatchShouldReturnFalse()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/fixture/index');

        $constraint = new HtmlContainsConstraint($crawler);

        $this->assertFalse($constraint->matches('Other Content'));
    }
    
    public function testToStringDescribeItself()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/fixture/index');

        $constraint = new HtmlContainsConstraint($crawler);

        $this->assertEquals('is on the page', $constraint->toString());
    }
}
