<?php

namespace Ka\Bundle\TestingBundle\Tests\Test\Fixtures\ExtensionTestCase;

use Ka\Bundle\TestingBundle\Test\ExtensionTestCase;

/**
 * @author Kevin Archer <ka@kevinarcher.ca>
 */
class FixtureExtensionTestCase extends ExtensionTestCase
{
    protected function getExtension()
    {
        return new FooExtension();
    }

    protected function getDefaultConfig()
    {
        return array(
            'bar' => array(
                'default' => true,
            ),
        );
    }
}
