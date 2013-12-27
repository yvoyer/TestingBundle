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
<!-- TODO: add sample fail tests -->
<!-- TODO: remove inverse case and add note that it exists -->

assertServiceExists
-------------------

`assertServiceExists(string $id[, array $config = null, string $message = ''])`

Reports an error identified by `$message` if `$id` service is not defined in the container.

`assertServiceNotExists()` is the inverse of this assertion and takes the same arguments.

  ```php
  public function testServiceExists()
  {
      $this->assertServiceExists('bar.service');
  }
  ```

assertServiceClassEquals
------------------------

`assertServiceClassEquals(string $id, string $class[, array $config = null, string $message = ''])`

Reports an error identified by `$message` if `$id` service class does not equal `$class`.

`assertServiceClassNotEquals()` is the inverse of this assertion and takes the same arguments.

  ```php
  public function testServiceClassEquals()
  {
      $this->assertServiceClassEquals('bar.service', 'Bar\Class');
  }
  ```

assertServiceClassIsParameter
-----------------------------

`assertServiceClassIsParameter(string $id[, array $config = null, string $message = ''])`

Reports an error identified by `$message` if `$id` service class does not equal `%$id.class%`.

  ```php
  public function testServiceClassIsParameter()
  {
      $this->assertServiceClassIsParameter('bar.service');
  }
  ```

assertServiceHasTag
-------------------

`assertServiceHasTag(string $id, string $tag[, array $config = null, string $message = ''])`

Reports an error identified by `$message` if `$id` service does not have `$tag` tag.

`assertServiceNotHasTag()` is the inverse of this assertion and takes the same arguments.

  ```php
  public function testServiceHasTag()
  {
      $this->assertServiceHasTag('bar.service', 'bar.tag');
  }
  ```

assertServiceTagAttributeEquals
-------------------------------

`assertServiceTagAttributeEquals(string $id, string $tag, string $attribute, mixed $value[, array $config = null, $message = ''])`

Reports an error identified by `$message` if a `$service` `$tag` `$attribute` is not equal to `$value`.

`assertServiceTagAttributeNotEquals()` is the inverse of this assertion and takes the same arguments.

  ```php
  public function testTagAttributeEquals()
  {
      $this->assertServiceTagAttributeEquals('bar.service', 'baz.tag', 'zen', 'myvalue');
  }
  ```

assertServiceIsAbstract
-----------------------

`assertServiceIsAbstract(string $id[, array $config = null, $message = ''])`

Reports an error identified by `$message` if `$service` is not abstract.

`assertServiceIsNotAbstract()` is the inverse of this assertion and takes the same arguments.

  ```php
  public function testServiceIsAbstract()
  {
      $this->assertServiceIsAbstract('bar.service');
  }
  ```

assertServiceIsLazy
-------------------

`assertServiceIsLazy(string $id[, array $config = null, $message = ''])`

Reports an error identified by `$message` if `$service` is not lazy.

`assertServiceIsNotLazy()` is the inverse of this assertion and takes the same arguments.

  ```php
  public function testServiceIsLazy()
  {
      $this->assertServiceIsLazy('bar.service');
  }
  ```

assertServiceIsPublic
---------------------

`assertServiceIsPublic(string $id[, array $config = null, $message = ''])`

Reports an error identified by `$message` if `$service` is not public.

`assertServiceIsNotPublic()` is the inverse of this assertion and takes the same arguments.

  ```php
  public function testServiceIsPublic()
  {
      $this->assertServiceIsPublic('bar.service');
  }
  ```

assertServiceIsSynchronized
---------------------------

`assertServiceIsSynchronized(string $id[, array $config = null, $message = ''])`

Reports an error identified by `$message` if `$service` is not synchronized.

`assertServiceIsNotSynchronized()` is the inverse of this assertion and takes the same arguments.

  ```php
  public function testServiceIsSynchronized()
  {
      $this->assertServiceIsSynchronized('bar.service');
  }
  ```

assertServiceIsSynthetic
------------------------

`assertServiceIsSynthetic(string $id[, array $config = null, $message = ''])`

Reports an error identified by `$message` if `$service` is not synthetic.

`assertServiceIsNotSynthetic()` is the inverse of this assertion and takes the same arguments.

  ```php
  public function testServiceIsSynthetic()
  {
      $this->assertServiceIsSynthetic('bar.service');
  }
  ```

Helper Methods
==============

getContainer
------------

`ContainerBuilder getContainer([array $config = null])`

Returns that container after loading the extension using `$config` or `getDefaultConfig` if omitted.

  ```php
  public function testContainer()
  {
      $container = $this->getContainer();

      $definition = $container->getDefinition('service.id');

      // ... perform assertions directly on the service definition
  }
  ```

**Caution**: Currently the container will only be loaded once per config so modifying the `$container` may cause unwanted
behaviour.
