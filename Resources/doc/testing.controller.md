Controller Testing
==================

When testing Controllers you should extend from `ControllerTestCase`.

  ```php
  namespace MyCompany\Bundle\FooBundle;

  use Ka\Bundle\TestingBundle\Test\ControllerTestCase;

  class FooControllerTest extends ControllerTestCase
  {
  }
  ```

Assertions
==========

This section lists the various assertion methods that are available.

<!-- TODO: Add method signatures and short explanations -->

assertHtmlContains
------------------

  ```php
  public function testHtmlContains()
  {
      $this->assertHtmlContains('Hello, World!', '/path/to/page');
  }
  ```

assertHtmlNotContains
---------------------

  ```php
  public function testHtmlNotContains()
  {
      $this->assertHtmlNotContains('Hello, World!', '/path/to/page');
  }
  ```

assertRedirect
--------------

  ```php
  public function testAssertRedirect()
  {
      $this->assertRedirect('/path/to/page');
  }
  ```

assertNotRedirect
-----------------

  ```php
  public function testAssertNotRedirect()
  {
      $this->assertNotRedirect('/path/to/page');
  }
  ```

assertRedirectTo
----------------

  ```php
  public function testAssertRedirectTo()
  {
      $this->assertNotRedirect('/path/to/page', '/redirecting/to');
  }
  ```

assertNotRedirectTo
-------------------

  ```php
  public function testAssertRedirectTo()
  {
      $this->assertNotRedirect('/path/to/page', '/not/redirect/to');
  }
  ```
