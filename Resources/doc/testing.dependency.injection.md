Dependency Injection Testing
============================

Extension Testing
==================

When testing Extensions you should extend from `ExtensionTestCase`.

  ```php
  namespace MyCompany\Bundle\BarBundle\Tests\DependencyInjection;

  use Ka\Bundle\TestingBundle\Test\ExtensionTestCase;
  use MyCompany\Bundle\BarBundle\DependencyInjection\BarExtension;

  class BarExtensionTest extends ExtensionTestCase
  {
      protected function getExtension()
      {
          return new BarExtension();
      }
  }
  ```

You are required to implement the `getExtension` method which must return a new instance of the extension under test.

Optionally you can also implement the `getDefaultConfig` method which will provide the default configuration parameters
to be used when building the container. This method will be called when no config argument is provided to the assertions.
This is useful for when you are using a custom Configuration class that requires certain parameters to be set.

  ```php
  protected function getExtension()
  {
      return array(
          'bar' => array(
              'parameter' => 'value',
          ),
      );
  }
  ```

Assertions
==========

This section lists the various assertion methods that are available.

<!-- TODO: continue to expand the documentation and clarify anything ambiguous. -->

assertServiceExists
------------------

`assertServiceExists(string $id[, array $config = null, string $message = ''])`

Reports an error identified by `$message` if `$id` service is not defined in the container.

  ```php
  public function testServiceExists()
  {
      $this->assertServiceExists('bar.service');
  }
  ```

assertServiceNotExists
------------------

`assertServiceNotExists(string $id[, array $config = null, string $message = ''])`

Reports an error identified by `$message` if `$id` service is defined in the container.

  ```php
  public function testServiceNotExists()
  {
      $this->assertServiceNotExists('bar.service');
  }
  ```
