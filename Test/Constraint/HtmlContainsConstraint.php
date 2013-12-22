<?php

namespace Ka\Bundle\TestingBundle\Test\Constraint;

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

    public function toString()
    {
        return 'is on the page';
    }

    protected function additionalFailureDescription($other)
    {
        // TODO: move to a DomNodeList display class
        // TODO: Display could be cleaner, initial implementation
        $displayNodeList = function (\DOMNodeList $nodeList, \DOMElement $parent) use (&$displayNodeList)
        {
            $page = '';
            /**
             * @var \DomElement $element
             */
            foreach ($nodeList as $element) {
                if ($element->hasChildNodes()) {
                    $page .= $displayNodeList($element->childNodes, $element);
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
                            break;
                        default:
                            $page .= $element->nodeName;
                    }
                }
            }

            return $page;
        };

        $line = str_repeat('=', 69).PHP_EOL;
        $page = $line.$displayNodeList($this->crawler->getNode(0)->childNodes, $this->crawler->getNode(0)).PHP_EOL.$line;

        return str_replace(array('  ', "\n\n\n"), array('', ''), $page);
    }
}
