<?php

namespace Ka\Bundle\TestingBundle\Test\TextUI;

use Symfony\Component\DomCrawler\Crawler;

/**
 * TODO: Refactor
 *
 * @author Kevin Archer <ka@kevinarcher.ca>
 */
class CrawlerPrinter
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

    public function html()
    {
        $line = str_repeat('=', 69).PHP_EOL;

        $page = $line.$this->displayNodeList($this->crawler->getNode(0)->childNodes, $this->crawler->getNode(0));

        return str_replace(array('  ', "\n\n\n"), array('', ''), $page).PHP_EOL.$line;
    }

    private function displayNodeList(\DOMNodeList $nodeList, \DOMElement $parent)
    {
        $page = '';

        /**
         * @var \DomElement $element
         */
        foreach ($nodeList as $element) {
            if ($element->hasChildNodes()) {
                $page .= $this->displayNodeList($element->childNodes, $element);
            } else {
                switch ($element->nodeName) {
                    case 'br':
                        $page .= PHP_EOL;
                        break;
                    case '#text':
                        if ('title' === $parent->nodeName) {
                            $page .= $element->textContent.PHP_EOL;
                            $page .= str_repeat('=', 69);
                            break;
                        }

                        $page .= $element->textContent;
                        break;
                    case 'img':
                        $page .= '['.$element->getAttribute('alt').']';
                        break;
                    case 'input':
                        $page .= '['.$element->getAttribute('type').' input] ';
                        break;
                    case 'meta':
                    case 'link':
                        break;
                    case 'div':
                    case 'head':
                        break;
                    default:
                        $page .= $element->nodeName;
                }
            }
        }

        return $page;
    }
}
