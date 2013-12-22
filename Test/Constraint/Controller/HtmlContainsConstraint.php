<?php

namespace Ka\Bundle\TestingBundle\Test\Constraint\Controller;

use Ka\Bundle\TestingBundle\Test\TextUI\CrawlerPrinter;
use Symfony\Component\DomCrawler\Crawler;

/**
 * @author Kevin Archer <ka@kevinarcher.ca>
 */
class HtmlContainsConstraint extends \PHPUnit_Framework_Constraint
{
    /**
     * @var Crawler
     */
    private $crawler;

    /**
     * @param Crawler $crawler
     */
    public function __construct(Crawler $crawler)
    {
        $this->crawler = $crawler;
    }

    /**
     * @param string $other
     *
     * @return bool
     */
    public function matches($other)
    {
        return (bool) $this->crawler->filter('html:contains("'.$other.'")')->count();
    }

    /**
     * @return string
     */
    public function toString()
    {
        return 'is on the page';
    }

    /**
     * @param mixed $other
     *
     * @return string
     */
    protected function additionalFailureDescription($other)
    {
        $printer = new CrawlerPrinter($this->crawler);

        return $printer->html();
    }
}
