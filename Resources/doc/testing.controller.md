Controller Testing
==================

When testing Controllers you should extend from `ControllerTestCase`.

  ```php
  namespace MyCompany\Bundle\FooBundle\Tests\Controller;

  use Ka\Bundle\TestingBundle\Test\ControllerTestCase;

  class FooControllerTest extends ControllerTestCase
  {
  }
  ```

Assertions
==========

This section lists the various assertion methods that are available.

<!-- TODO: Add method signatures and short explanations -->
<!-- TODO: add index and permalinks -->

assertHtmlContains
------------------

`assertHtmlContains(string $text, string $url[, string $message = ''])`

Reports an error identified by `$message` if `$text` is not found in the HTML response from `$url`.

  ```php
  public function testHtmlContains()
  {
      $this->assertHtmlContains('Hello, World!', '/path/to/page');
  }
  ```

assertHtmlNotContains
---------------------

`assertHtmlNotContains(string $text, string $url[, string $message = ''])`

Reports an error identified by `$message` if `$text` is found in the HTML response from `$url`.

  ```php
  public function testHtmlNotContains()
  {
      $this->assertHtmlNotContains('Hello, World!', '/path/to/page');
  }
  ```

assertRedirect
--------------

`assertRedirect(string $url[, string $message = ''])`

Reports an error identified by `$message` if `$url` does not redirect.

  ```php
  public function testAssertRedirect()
  {
      $this->assertRedirect('/path/to/page');
  }
  ```

assertNotRedirect
-----------------

`assertNotRedirect(string $url[, string $message = ''])`

Reports an error identified by `$message` if `$url` redirects.

  ```php
  public function testAssertNotRedirect()
  {
      $this->assertNotRedirect('/path/to/page');
  }
  ```

assertRedirectTo
----------------

`assertRedirectTo(string $url, string $destination[, string $message = ''])`

Reports an error identified by `$message` if `$url` does not redirect to `$destination`.

  ```php
  public function testAssertRedirectTo()
  {
      $this->assertRedirectTo('/path/to/page', '/redirecting/to');
  }
  ```

assertNotRedirectTo
-------------------

`assertNotRedirectTo(string $url, string $destination[, string $message = ''])`

Reports an error identified by `$message` if `$url` redirects to `$destination`.

  ```php
  public function testAssertNotRedirectTo()
  {
      $this->assertNotRedirectTo('/path/to/page', '/not/redirect/to');
  }
  ```

**Caution**: The assertion will still pass when `$url` returns a redirect that does not match `$destination`.

assertAuthenticationIsRequired
------------------------------

`assertAuthenticationIsRequired(string $url, string $loginUrl[, string $message = ''])`

Reports an error identified by `$message` if `$url` does not redirect to `$loginUrl`.

  ```php
  public function testAuthenticationIsRequired()
  {
      $this->assertAuthenticationIsRequired('/path/to/page', '/login');
  }
  ```

Helper Methods
==============

get
---

`Crawler get(string $url)`

Makes a `GET` request on the `$url` and returns an instance of `Crawler`.

  ```php
  public function testPageResponse()
  {
      $crawler = $this->get('/path/to/page');

      // ... perform assertions on the page content
  }
  ```

authenticate
------------

`authenticate(string $loginUrl, string|array $username[, $password = null])`

Authenticates the test `Client` on `$loginUrl` with `$username` and `$password`.

  ```php
  public function testWithAuthentication()
  {
      $this->authenticate('/login', 'user', 'userpass');

      $crawler = $this->get('/secured/page');

      // ... perform assertions on the page content
  }
  ```

By default `$username` and `$password` will be submitted to the `_username` and `_password` form fields. Optionally `$username`
can be an `array` of form values.

  ```php
  public function testWithAuthentication()
  {
      $this->authenticate('/login', array(
          'custom_username_field' => 'user',
          'custom_password_field' => 'userpass',
          'mandatory_field' => 'someValue',
      ));

      $crawler = $this->get('/secured/page');

      // ... perform assertions on the page content
  }
  ```
