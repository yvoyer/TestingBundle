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

Optionally you can implement the `getDefaultConfig` method which will provide the default configuration parameters
to be used when loading the extension. This method will be called when no config argument is provided to the assertions.
This is useful when you are using a custom Configuration class that requires certain parameters to be always set.

  ```php
  protected function getDefaultConfig()
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
<!-- TODO: add index and permalinks -->

assertServiceExists
-------------------

`assertServiceExists(string $id[, array $config = null, string $message = ''])`

Reports an error identified by `$message` if `$id` service is not defined in the container.

  ```php
  public function testServiceExists()
  {
      $this->assertServiceExists('bar.service');
  }
  ```

assertServiceNotExists
----------------------

`assertServiceNotExists(string $id[, array $config = null, string $message = ''])`

Reports an error identified by `$message` if `$id` service is defined in the container.

  ```php
  public function testServiceNotExists()
  {
      $this->assertServiceNotExists('bar.service');
  }
  ```

assertServiceHasTag
-------------------

`assertServiceHasTag(string $id, string $tag[, array $config = null, string $message = ''])`

Reports an error identified by `$message` if `$id` service does not have `$tag` tag.

  ```php
  public function testServiceHasTag()
  {
      $this->assertServiceHasTag('bar.service', 'bar.tag');
  }
  ```

assertServiceNotHasTag
----------------------

`assertServiceNotHasTag(string $id, string $tag[, array $config = null, string $message = ''])`

Reports an error identified by `$message` if `$id` service has `$tag` tag.

  ```php
  public function testServiceNotHasTag()
  {
      $this->assertServiceNotHasTag('bar.service', 'baz.tag');
  }
  ```

assertTagAttributeEquals
========================

`assertTagAttributeEquals(string $id, string $tag, string $attribute, mixed $value[, $message = ''])`

Reports an error identified by `$message` if a `$service` `$tag` `$attribute` is not equal to `$value`.

  ```php
  public function testTagAttributeEquals()
  {
      $this->assertTagAttributeEquals('bar.service', 'baz.tag', 'zen', 'myvalue');
  }
  ```

assertTagAttributeNotEquals
===========================

`assertTagAttributeNotEquals(string $id, string $tag, string $attribute, mixed $value[, $message = ''])`

Reports an error identified by `$message` if a `$service` `$tag` `$attribute` is equal to `$value`.

  ```php
  public function testTagAttributeNotEquals()
  {
      $this->assertTagAttributeNotEquals('bar.service', 'baz.tag', 'zen', 'othervalue');
  }
  ```
