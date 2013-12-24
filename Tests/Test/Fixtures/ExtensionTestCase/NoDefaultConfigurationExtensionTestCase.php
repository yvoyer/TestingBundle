<?php

namespace Ka\Bundle\TestingBundle\Tests\Test\Fixtures\ExtensionTestCase;

use Ka\Bundle\TestingBundle\Test\ExtensionTestCase;

/**
 * @author Kevin Archer <ka@kevinarcher.ca>
 */
class NoDefaultConfigurationExtensionTestCase extends ExtensionTestCase
{
    protected function getExtension()
    {
        return new FooExtension();
    }
}
