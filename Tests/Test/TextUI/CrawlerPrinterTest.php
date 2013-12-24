<?php

namespace Ka\Bundle\TestingBundle\Tests\Test\TextUI;

use Ka\Bundle\TestingBundle\Test\TextUI\CrawlerPrinter;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DomCrawler\Crawler;

/**
 * @covers \Ka\Bundle\TestingBundle\Test\TextUI\CrawlerPrinter
 *
 * @author Kevin Archer <ka@kevinarcher.ca>
 */
class CrawlerPrinterTest extends WebTestCase
{
    /**
     * @group integration
     *
     * @dataProvider tagTemplateProvider
     *
     * TODO: these tests won't pass on windows because of line endings?
     *
     * @param string $templateName
     */
    public function testDisplayOfHtml($templateName)
    {
        $crawler = new Crawler();
        $printer = new CrawlerPrinter($crawler);

        $crawler->addHtmlContent(file_get_contents(__DIR__.'/Fixtures/'.$templateName.'.html'));

        $this->assertStringEqualsFile(__DIR__.'/Fixtures/'.$templateName.'.txt', $printer->html());
    }

    public function tagTemplateProvider()
    {
        return array(
            'Double BRs collapsed' => array('br'),
            'img alt attirbute' => array('img'),
            'text nodes' => array('text'),
            'title tag' => array('title'),
            'inputs' => array('input'),
            'meta ignored' => array('meta'),
            'link ignored' => array('link'),
            'head ignored' => array('head'),
            'empty div ignored' => array('div'),
            'unknownTagsAreDisplayed' => array('unknown'),
        );
    }
}
