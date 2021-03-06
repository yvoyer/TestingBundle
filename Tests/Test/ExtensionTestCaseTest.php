<?php

namespace Ka\Bundle\TestingBundle\Tests\Test;

use Ka\Bundle\TestingBundle\Tests\Test\Fixtures\ExtensionTestCase\FixtureExtensionTestCase;
use Ka\Bundle\TestingBundle\Tests\Test\Fixtures\ExtensionTestCase\NoDefaultConfigurationExtensionTestCase;

/**
 * @covers \Ka\Bundle\TestingBundle\Test\ExtensionTestCase
 *
 * @covers \Ka\Bundle\TestingBundle\Test\Constraint\Extension\ServiceClassEqualsConstraint
 * @covers \Ka\Bundle\TestingBundle\Test\Constraint\Extension\ServiceExistsConstraint
 * @covers \Ka\Bundle\TestingBundle\Test\Constraint\Extension\ServiceHasTagConstraint
 * @covers \Ka\Bundle\TestingBundle\Test\Constraint\Extension\ServiceIsAbstractConstraint
 * @covers \Ka\Bundle\TestingBundle\Test\Constraint\Extension\ServiceIsLazyConstraint
 * @covers \Ka\Bundle\TestingBundle\Test\Constraint\Extension\ServiceIsPublicConstraint
 * @covers \Ka\Bundle\TestingBundle\Test\Constraint\Extension\ServiceIsSynchronizedConstraint
 * @covers \Ka\Bundle\TestingBundle\Test\Constraint\Extension\ServiceIsSyntheticConstraint
 * @covers \Ka\Bundle\TestingBundle\Test\Constraint\Extension\ServiceTagAttributeEqualsConstraint
 * @covers \Ka\Bundle\TestingBundle\Test\Constraint\Extension\ServiceScopeConstraint
 *
 * @author Kevin Archer <ka@kevinarcher.ca>
 */
class ExtensionTestCaseTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var FixtureExtensionTestCase
     */
    private $testCase;

    public function setUp()
    {
        $this->testCase = new FixtureExtensionTestCase();
    }

    /**
     * @group integration
     */
    public function testAssertServiceExistsWithMatch()
    {
        $this->testCase->assertServiceExists('fixture.bar');
    }

    /**
     * @group integration
     */
    public function testAssertServiceExistsWithMatchAndCustomConfig()
    {
        $this->testCase->assertServiceExists('fixture.custom', $this->getCustomConfig());
    }

    /**
     * @group integration
     */
    public function testAssertServiceExistsWithMatchFromDefaultConfig()
    {
        $this->testCase->assertServiceExists('fixture.default');
    }

    /**
     * @group integration
     *
     * @expectedException \PHPUnit_Framework_ExpectationFailedException
     * @expectedExceptionMessage Failed asserting that 'fixture.baz' service is defined.
     */
    public function testAssertServiceExistsWithNonMatch()
    {
        $this->testCase->assertServiceExists('fixture.baz');
    }

    /**
     * @group integration
     *
     * @expectedException \PHPUnit_Framework_ExpectationFailedException
     * @expectedExceptionMessage Failed asserting that 'fixture.default' service is defined.
     */
    public function testAssertServiceIsLoadedWithNoDefaultConfigDoesNotMatch()
    {
        $testcase = new NoDefaultConfigurationExtensionTestCase();

        $testcase->assertServiceExists('fixture.default');
    }

    /**
     * @group integration
     *
     * @expectedException \PHPUnit_Framework_ExpectationFailedException
     * @expectedExceptionMessage Service should be defined
     */
    public function testAssertServiceExistsWithMessage()
    {
        $this->testCase->assertServiceExists('fixture.baz', null, 'Service should be defined');
    }

    /**
     * @group integration
     */
    public function testAssertServiceNotExistsWithMatch()
    {
        $this->testCase->assertServiceNotExists('fixture.non.existing');
    }

    /**
     * @group integration
     *
     * @expectedException \PHPUnit_Framework_ExpectationFailedException
     * @expectedExceptionMessage Failed asserting that 'fixture.bar' service is not defined.
     */
    public function testAssertServiceNotExistsWithNonMatch()
    {
        $this->testCase->assertServiceNotExists('fixture.bar');
    }

    /**
     * @group integration
     *
     * @expectedException \PHPUnit_Framework_ExpectationFailedException
     * @expectedExceptionMessage Service should not be defined
     */
    public function testAssertServiceNotExistsWithMessage()
    {
        $this->testCase->assertServiceNotExists('fixture.bar', null, 'Service should not be defined');
    }

    /**
     * @group integration
     *
     * @expectedException \PHPUnit_Framework_ExpectationFailedException
     * @expectedExceptionMessage Failed asserting that 'fixture.custom' service is not defined.
     */
    public function testAssertServiceNotExistsWithCustomConfiguration()
    {
        $this->testCase->assertServiceNotExists('fixture.custom', $this->getCustomConfig());
    }

    /**
     * @group integration
     */
    public function testAssertServiceHasTagWithMatch()
    {
        $this->testCase->assertServiceHasTag('fixture.bar', 'bar.tag');
    }

    /**
     * @group integration
     *
     * @expectedException \PHPUnit_Framework_ExpectationFailedException
     * @expectedExceptionMessage Failed asserting that 'fixture.bar' service has tag 'baz.tag'.
     */
    public function testAssertServiceHasTagWithNonMatch()
    {
        $this->testCase->assertServiceHasTag('fixture.bar', 'baz.tag');
    }

    /**
     * @group integration
     *
     * @expectedException \PHPUnit_Framework_ExpectationFailedException
     * @expectedExceptionMessage Service should have baz.tag tag
     */
    public function testAssertServiceHasTagWithMessage()
    {
        $this->testCase->assertServiceHasTag('fixture.bar', 'baz.tag', null, ' Service should have baz.tag tag');
    }

    /**
     * @group integration
     */
    public function testAssertServiceHasTagWithConfig()
    {
        $this->testCase->assertServiceHasTag('fixture.custom', 'custom.tag', $this->getCustomConfig());
    }

    /**
     * @group integration
     */
    public function testAssertServiceNotHasTagWithMatch()
    {
       $this->testCase->assertServiceNotHasTag('fixture.bar', 'baz.tag');
    }

    /**
     * @group integration
     *
     * @expectedException \PHPUnit_Framework_ExpectationFailedException
     * @expectedExceptionMessage Failed asserting that 'fixture.bar' service does not have tag 'bar.tag'.
     */
    public function testAssertServiceNotHasTagWithNonMatch()
    {
        $this->testCase->assertServiceNotHasTag('fixture.bar', 'bar.tag');
    }

    /**
     * @group integration
     *
     * @expectedException \PHPUnit_Framework_ExpectationFailedException
     * @expectedExceptionMessage Service should not have bar.tag
     */
    public function testAssertServiceNotHasTagWithMessage()
    {
        $this->testCase->assertServiceNotHasTag('fixture.bar', 'bar.tag', null, 'Service should not have bar.tag');
    }

    /**
     * @group integration
     */
    public function testAssertServiceNotHasTagWithConfig()
    {
        $this->testCase->assertServiceNotHasTag('fixture.custom', 'foo.tag', $this->getCustomConfig());
    }

    /**
     * @group integration
     */
    public function testAssertServiceTagAttributeEqualsWithMatch()
    {
        $this->testCase->assertServiceTagAttributeEquals('fixture.bar', 'bar.tag', 'flag', true);
    }

    /**
     * @group integration
     *
     * @expectedException \PHPUnit_Framework_ExpectationFailedException
     * @expectedExceptionMessage Failed asserting that test attribute is equal to 'abc'.
     */
    public function testAssertServiceTagAttributeEqualsWithNonMatch()
    {
        $this->testCase->assertServiceTagAttributeEquals('fixture.bar', 'bar.tag', 'test', 'abc');
    }

    /**
     * @group integration
     *
     * @expectedException \PHPUnit_Framework_ExpectationFailedException
     * @expectedExceptionMessage Custom message
     */
    public function testAssertServiceTagAttributeEqualsWithMessage()
    {
        $this->testCase->assertServiceTagAttributeEquals('fixture.bar', 'bar.tag', 'test', 'abc', null, 'Custom message');
    }

    /**
     * @group integration
     */
    public function testAssertServiceTagAttributeEqualsWithConfig()
    {
        $this->testCase->assertServiceTagAttributeEquals('fixture.custom', 'custom.tag', 'custom', true, $this->getCustomConfig());
    }

    /**
     * @group integration
     */
    public function testAssertServiceTagAttributeNotEqualsWithMatch()
    {
        $this->testCase->assertServiceTagAttributeNotEquals('fixture.bar', 'bar.tag', 'test', 'abc');
    }

    /**
     * @group integration
     *
     * @expectedException \PHPUnit_Framework_ExpectationFailedException
     * @expectedExceptionMessage Failed asserting that test attribute is not equal to 'check'.
     */
    public function testAssertServiceTagAttributeNotEqualsWithNonMatch()
    {
        $this->testCase->assertServiceTagAttributeNotEquals('fixture.bar', 'bar.tag', 'test', 'check');
    }

    /**
     * @group integration
     *
     * @expectedException \PHPUnit_Framework_ExpectationFailedException
     * @expectedExceptionMessage Attribute should not equal x
     */
    public function testAssertServiceTagAttributeNotEqualsWithMessage()
    {
        $this->testCase->assertServiceTagAttributeNotEquals('fixture.bar', 'bar.tag', 'test', 'check', null, 'Attribute should not equal x');
    }

    /**
     * @group integration
     */
    public function testAssertServiceTagAttributeNotEqualsWithConfig()
    {
        $this->testCase->assertServiceTagAttributeNotEquals('fixture.custom', 'custom.tag', 'custom', false, $this->getCustomConfig());
    }

    /**
     * @group integration
     */
    public function testAssertServiceIsSyntheticWithMatch()
    {
        $this->testCase->assertServiceIsSynthetic('fixture.synthetic');
    }

    /**
     * @group integration
     *
     * @expectedException \PHPUnit_Framework_ExpectationFailedException
     * @expectedExceptionMessage Failed asserting that 'fixture.bar' service is synthetic.
     */
    public function testAssertServiceIsSyntheticWithNonMatch()
    {
        $this->testCase->assertServiceIsSynthetic('fixture.bar');
    }

    /**
     * @group integration
     *
     * @expectedException \PHPUnit_Framework_ExpectationFailedException
     * @expectedExceptionMessage Failed asserting that 'fixture.custom' service is synthetic.
     */
    public function testAssertServiceIsSyntheticWithConfig()
    {
        $this->testCase->assertServiceIsSynthetic('fixture.custom', $this->getCustomConfig());
    }

    /**
     * @group integration
     *
     * @expectedException \PHPUnit_Framework_ExpectationFailedException
     * @expectedExceptionMessage The service should be synthetic
     */
    public function testAssertServiceIsSyntheticWithMessage()
    {
        $this->testCase->assertServiceIsSynthetic('fixture.bar', null, 'The service should be synthetic');
    }

    /**
     * @group integration
     */
    public function testAssertServiceIsNotSyntheticWithMatch()
    {
        $this->testCase->assertServiceIsNotSynthetic('fixture.bar');
    }

    /**
     * @group integration
     *
     * @expectedException \PHPUnit_Framework_ExpectationFailedException
     * @expectedExceptionMessage Failed asserting that 'fixture.synthetic' service is not synthetic.
     */
    public function testAssertServiceIsNotSyntheticWithNonMatch()
    {
        $this->testCase->assertServiceIsNotSynthetic('fixture.synthetic');
    }

    /**
     * @group integration
     */
    public function testAssertServiceIsNotSyntheticWithConfig()
    {
        $this->testCase->assertServiceIsNotSynthetic('fixture.custom', $this->getCustomConfig());
    }

    /**
     * @group integration
     *
     * @expectedException \PHPUnit_Framework_ExpectationFailedException
     * @expectedExceptionMessage The service should not be synthetic
     */
    public function testAssertServiceIsNotSyntheticWithMessage()
    {
        $this->testCase->assertServiceIsNotSynthetic('fixture.synthetic', null, 'The service should not be synthetic');
    }

    /**
     * @group integration
     */
    public function testAssertServiceIsAbstractWithMatch()
    {
        $this->testCase->assertServiceIsAbstract('fixture.abstract');
    }

    /**
     * @group integration
     *
     * @expectedException \PHPUnit_Framework_ExpectationFailedException
     * @expectedExceptionMessage Failed asserting that 'fixture.bar' service is abstract.
     */
    public function testAssertServiceIsAbstractWithNonMatch()
    {
        $this->testCase->assertServiceIsAbstract('fixture.bar');
    }

    /**
     * @group integration
     *
     * @expectedException \PHPUnit_Framework_ExpectationFailedException
     * @expectedExceptionMessage Failed asserting that 'fixture.custom' service is abstract.
     */
    public function testAssertServiceIsAbstractWithConfig()
    {
        $this->testCase->assertServiceIsAbstract('fixture.custom', $this->getCustomConfig());
    }

    /**
     * @group integration
     *
     * @expectedException \PHPUnit_Framework_ExpectationFailedException
     * @expectedExceptionMessage The service should be abstract
     */
    public function testAssertServiceIsAbstractWithMessage()
    {
        $this->testCase->assertServiceIsAbstract('fixture.bar', null, 'The service should be abstract');
    }

    /**
     * @group integration
     */
    public function testAssertServiceIsNotAbstractWithMatch()
    {
        $this->testCase->assertServiceIsNotAbstract('fixture.bar');
    }

    /**
     * @group integration
     *
     * @expectedException \PHPUnit_Framework_ExpectationFailedException
     * @expectedExceptionMessage Failed asserting that 'fixture.abstract' service is not abstract.
     */
    public function testAssertServiceIsNotAbstractWithNonMatch()
    {
        $this->testCase->assertServiceIsNotAbstract('fixture.abstract');
    }

    /**
     * @group integration
     */
    public function testAssertServiceIsNotAbstractWithConfig()
    {
        $this->testCase->assertServiceIsNotAbstract('fixture.custom', $this->getCustomConfig());
    }

    /**
     * @group integration
     *
     * @expectedException \PHPUnit_Framework_ExpectationFailedException
     * @expectedExceptionMessage The service should not be abstract
     */
    public function testAssertServiceIsNotAbstractWithMessage()
    {
        $this->testCase->assertServiceIsNotAbstract('fixture.abstract', null, 'The service should not be abstract');
    }

    /**
     * @group integration
     */
    public function testAssertServiceIsLazyWithMatch()
    {
        $this->testCase->assertServiceIsLazy('fixture.lazy');
    }

    /**
     * @group integration
     *
     * @expectedException \PHPUnit_Framework_ExpectationFailedException
     * @expectedExceptionMessage Failed asserting that 'fixture.bar' service is lazy.
     */
    public function testAssertServiceIsLazyWithNonMatch()
    {
        $this->testCase->assertServiceIsLazy('fixture.bar');
    }

    /**
     * @group integration
     *
     * @expectedException \PHPUnit_Framework_ExpectationFailedException
     * @expectedExceptionMessage Failed asserting that 'fixture.custom' service is lazy.
     */
    public function testAssertServiceIsLazyWithConfig()
    {
        $this->testCase->assertServiceIsLazy('fixture.custom', $this->getCustomConfig());
    }

    /**
     * @group integration
     *
     * @expectedException \PHPUnit_Framework_ExpectationFailedException
     * @expectedExceptionMessage The service should be lazy
     */
    public function testAssertServiceIsLazyWithMessage()
    {
        $this->testCase->assertServiceIsLazy('fixture.bar', null, 'The service should be lazy');
    }

    /**
     * @group integration
     */
    public function testAssertServiceIsNotLazyWithMatch()
    {
        $this->testCase->assertServiceIsNotLazy('fixture.bar');
    }

    /**
     * @group integration
     *
     * @expectedException \PHPUnit_Framework_ExpectationFailedException
     * @expectedExceptionMessage Failed asserting that 'fixture.lazy' service is not lazy.
     */
    public function testAssertServiceIsNotLazyWithNonMatch()
    {
        $this->testCase->assertServiceIsNotLazy('fixture.lazy');
    }

    /**
     * @group integration
     */
    public function testAssertServiceIsNotLazyWithConfig()
    {
        $this->testCase->assertServiceIsNotLazy('fixture.custom', $this->getCustomConfig());
    }

    /**
     * @group integration
     *
     * @expectedException \PHPUnit_Framework_ExpectationFailedException
     * @expectedExceptionMessage The service should not be lazy
     */
    public function testAssertServiceIsNotLazyWithMessage()
    {
        $this->testCase->assertServiceIsNotLazy('fixture.lazy', null, 'The service should not be lazy');
    }

    /**
     * @group integration
     */
    public function testAssertServiceIsPublicWithMatch()
    {
        $this->testCase->assertServiceIsPublic('fixture.bar');
    }

    /**
     * @group integration
     *
     * @expectedException \PHPUnit_Framework_ExpectationFailedException
     * @expectedExceptionMessage Failed asserting that 'fixture.notpublic' service is public.
     */
    public function testAssertServiceIsPublicWithNonMatch()
    {
        $this->testCase->assertServiceIsPublic('fixture.notpublic');
    }

    /**
     * @group integration
     *
     * @expectedException \PHPUnit_Framework_ExpectationFailedException
     * @expectedExceptionMessage Failed asserting that 'fixture.custom' service is public.
     */
    public function testAssertServiceIsPublicWithConfig()
    {
        $config = $this->getCustomConfig();
        $config['bar']['custom'] = array('public' => false);

        $this->testCase->assertServiceIsPublic('fixture.custom', $config);
    }

    /**
     * @group integration
     *
     * @expectedException \PHPUnit_Framework_ExpectationFailedException
     * @expectedExceptionMessage The service should be public
     */
    public function testAssertServiceIsPublicWithMessage()
    {
        $this->testCase->assertServiceIsPublic('fixture.notpublic', null, 'The service should be public');
    }

    /**
     * @group integration
     */
    public function testAssertServiceIsNotPublicWithMatch()
    {
        $this->testCase->assertServiceIsNotPublic('fixture.notpublic');
    }

    /**
     * @group integration
     *
     * @expectedException \PHPUnit_Framework_ExpectationFailedException
     * @expectedExceptionMessage Failed asserting that 'fixture.bar' service is not public.
     */
    public function testAssertServiceIsNotPublicWithNonMatch()
    {
        $this->testCase->assertServiceIsNotPublic('fixture.bar');
    }

    /**
     * @group integration
     */
    public function testAssertServiceIsNotPublicWithConfig()
    {
        $config = $this->getCustomConfig();
        $config['bar']['custom'] = array('public' => false);

        $this->testCase->assertServiceIsNotPublic('fixture.custom', $config);
    }

    /**
     * @group integration
     *
     * @expectedException \PHPUnit_Framework_ExpectationFailedException
     * @expectedExceptionMessage The service should not be public
     */
    public function testAssertServiceIsNotPublicWithMessage()
    {
        $this->testCase->assertServiceIsNotPublic('fixture.bar', null, 'The service should not be public');
    }

    /**
     * @group integration
     */
    public function testAssertServiceIsSynchronizedWithMatch()
    {
        $this->testCase->assertServiceIsSynchronized('fixture.synchronized');
    }

    /**
     * @group integration
     *
     * @expectedException \PHPUnit_Framework_ExpectationFailedException
     * @expectedExceptionMessage Failed asserting that 'fixture.bar' service is synchronized.
     */
    public function testAssertServiceIsSynchronizedWithNonMatch()
    {
        $this->testCase->assertServiceIsSynchronized('fixture.bar');
    }

    /**
     * @group integration
     *
     * @expectedException \PHPUnit_Framework_ExpectationFailedException
     * @expectedExceptionMessage Failed asserting that 'fixture.custom' service is synchronized.
     */
    public function testAssertServiceIsSynchronizedWithConfig()
    {
        $this->testCase->assertServiceIsSynchronized('fixture.custom', $this->getCustomConfig());
    }

    /**
     * @group integration
     *
     * @expectedException \PHPUnit_Framework_ExpectationFailedException
     * @expectedExceptionMessage The service should be synchronized
     */
    public function testAssertServiceIsSynchronizedWithMessage()
    {
        $this->testCase->assertServiceIsSynchronized('fixture.bar', null, 'The service should be synchronized');
    }

    /**
     * @group integration
     */
    public function testAssertServiceIsNotSynchronizedWithMatch()
    {
        $this->testCase->assertServiceIsNotSynchronized('fixture.bar');
    }

    /**
     * @group integration
     *
     * @expectedException \PHPUnit_Framework_ExpectationFailedException
     * @expectedExceptionMessage Failed asserting that 'fixture.synchronized' service is not synchronized.
     */
    public function testAssertServiceIsNotSynchronizedWithNonMatch()
    {
        $this->testCase->assertServiceIsNotSynchronized('fixture.synchronized');
    }

    /**
     * @group integration
     */
    public function testAssertServiceIsNotSynchronizedWithConfig()
    {
        $this->testCase->assertServiceIsNotSynchronized('fixture.custom', $this->getCustomConfig());
    }

    /**
     * @group integration
     *
     * @expectedException \PHPUnit_Framework_ExpectationFailedException
     * @expectedExceptionMessage The service should not be synchronized
     */
    public function testAssertServiceIsNotSynchronizedWithMessage()
    {
        $this->testCase->assertServiceIsNotSynchronized('fixture.synchronized', null, 'The service should not be synchronized');
    }

    /**
     * @group integration
     */
    public function testAssertServiceClassEqualsWithMatch()
    {
        $this->testCase->assertServiceClassEquals('fixture.bar', 'BarClass');
    }

    /**
     * @group integration
     *
     * @expectedException \PHPUnit_Framework_ExpectationFailedException
     * @expectedExceptionMessage Failed asserting that 'BarClass' service class is equal to 'BazClass'.
     */
    public function testAssertServiceClassEqualsWithNonMatch()
    {
        $this->testCase->assertServiceClassEquals('fixture.bar', 'BazClass');
    }

    /**
     * @group integration
     */
    public function testAssertServiceClassEqualsWithConfig()
    {
        $this->testCase->assertServiceClassEquals('fixture.custom', 'CustomClass', $this->getCustomConfig());
    }

    /**
     * @group integration
     *
     * @expectedException \PHPUnit_Framework_ExpectationFailedException
     * @expectedExceptionMessage Should be BarClass
     */
    public function testAssertServiceClassEqualsWithMessage()
    {
        $this->testCase->assertServiceClassEquals('fixture.bar', 'BazClass', null, 'Should be BarClass');
    }

    /**
     * @group integration
     */
    public function testAssertServiceClassEqualsWithParameter()
    {
        $this->testCase->assertServiceClassEquals('zed', '%zed.class%');
    }

    /**
     * @group integration
     *
     * @expectedException \PHPUnit_Framework_ExpectationFailedException
     * @expectedExceptionMessage Failed asserting that '%zed.class%' service class is equal to 'ZedClass'.
     */
    public function testAssertServiceClassEqualsWithParameterToClass()
    {
        $this->testCase->assertServiceClassEquals('zed', 'ZedClass');
    }

    /**
     * @group integration
     */
    public function testAssertServiceClassNotEqualsWithMatch()
    {
        $this->testCase->assertServiceClassNotEquals('fixture.bar', 'BazClass');
    }

    /**
     * @group integration
     *
     * @expectedException \PHPUnit_Framework_ExpectationFailedException
     * @expectedExceptionMessage Failed asserting that 'BarClass' service class is not equal to 'BarClass'.
     */
    public function testAssertServiceClassNotEqualsWithNonMatch()
    {
        $this->testCase->assertServiceClassNotEquals('fixture.bar', 'BarClass');
    }

    /**
     * @group integration
     */
    public function testAssertServiceClassNotEqualsWithConfig()
    {
        $this->testCase->assertServiceClassNotEquals('fixture.custom', 'SomeClass', $this->getCustomConfig());
    }

    /**
     * @group integration
     *
     * @expectedException \PHPUnit_Framework_ExpectationFailedException
     * @expectedExceptionMessage Should not be BarClass
     */
    public function testAssertServiceClassNotEqualsWithMessage()
    {
        $this->testCase->assertServiceClassNotEquals('fixture.bar', 'BarClass', null, 'Should not be BarClass');
    }

    /**
     * @group integration
     */
    public function testAssertServiceClassNotEqualsWithParameterValue()
    {
        $this->testCase->assertServiceClassNotEquals('zed', 'ZedClass');
    }

    /**
     * @group integration
     */
    public function testAssertServiceClassIsParameterWithMatch()
    {
        $this->testCase->assertServiceClassIsParameter('zed');
    }

    /**
     * @group integration
     *
     * @expectedException \PHPUnit_Framework_ExpectationFailedException
     * @expectedExceptionMessage Failed asserting that 'BarClass' service class is equal to '%fixture.bar.class%'.
     */
    public function testAssertServiceClassIsParameterWithNonMatch()
    {
        $this->testCase->assertServiceClassIsParameter('fixture.bar');
    }

    /**
     * @group integration
     *
     * @expectedException \PHPUnit_Framework_ExpectationFailedException
     * @expectedExceptionMessage Should be configurable
     */
    public function testAssertServiceClassIsParameterWithMessage()
    {
        $this->testCase->assertServiceClassIsParameter('fixture.bar', null, 'Should be configurable');
    }

    /**
     * @group integration
     *
     * @expectedException \PHPUnit_Framework_ExpectationFailedException
     * @expectedExceptionMessage Failed asserting that 'CustomClass' service class is equal to '%fixture.custom.class%'.
     */
    public function testAssertServiceClassIsParameterWithConfig()
    {
        $this->testCase->assertServiceClassIsParameter('fixture.custom', $this->getCustomConfig());
    }

    /**
     * @group integration
     */
    public function testAssertServiceScopeIsRequestWithMatch()
    {
        $this->testCase->assertServiceScopeIsRequest('request.scoped');
    }

    /**
     * @group integration
     *
     * @expectedException \PHPUnit_Framework_ExpectationFailedException
     * @expectedExceptionMessage Failed asserting that 'container' scope is 'request'.
     */
    public function testAssertServiceScopeIsRequestWithNonMatch(){
        $this->testCase->assertServiceScopeIsRequest('container.scoped');
    }

    /**
     * @group integration
     *
     * @expectedException \PHPUnit_Framework_ExpectationFailedException
     * @expectedExceptionMessage Should be request scoped
     */
    public function testAssertServiceScopeIsRequestWithMessage()
    {
        $this->testCase->assertServiceScopeIsRequest('container.scoped', null, 'Should be request scoped');
    }

    /**
     * @group integration
     *
     * @expectedException \PHPUnit_Framework_ExpectationFailedException
     * @expectedExceptionMessage Failed asserting that 'container' scope is 'request'.
     */
    public function testAssertServiceScopeIsRequestWithConfig()
    {
        $this->testCase->assertServiceScopeIsRequest('fixture.custom', $this->getCustomConfig());
    }

    /**
     * @group integration
     */
    public function testAssertServiceScopeIsNotRequestWithMatch()
    {
        $this->testCase->assertServiceScopeIsNotRequest('prototype.scoped');
    }

    /**
     * @group integration
     *
     * @expectedException \PHPUnit_Framework_ExpectationFailedException
     * @expectedExceptionMessage Failed asserting that 'request' scope is not 'request'.
     */
    public function testAssertServiceScopeIsNotRequestWithNonMatch(){
        $this->testCase->assertServiceScopeIsNotRequest('request.scoped');
    }

    /**
     * @group integration
     *
     * @expectedException \PHPUnit_Framework_ExpectationFailedException
     * @expectedExceptionMessage Should not be request scoped
     */
    public function testAssertServiceScopeIsNotRequestWithMessage()
    {
        $this->testCase->assertServiceScopeIsNotRequest('request.scoped', null, 'Should not be request scoped');
    }

    /**
     * @group integration
     */
    public function testAssertServiceScopeIsNotRequestWithConfig()
    {
        $this->testCase->assertServiceScopeIsNotRequest('fixture.custom', $this->getCustomConfig());
    }

    /**
     * @group integration
     */
    public function testAssertServiceScopeIsPrototypeWithMatch()
    {
        $this->testCase->assertServiceScopeIsPrototype('prototype.scoped');
    }

    /**
     * @group integration
     *
     * @expectedException \PHPUnit_Framework_ExpectationFailedException
     * @expectedExceptionMessage Failed asserting that 'container' scope is 'prototype'.
     */
    public function testAssertServiceScopeIsPrototypeWithNonMatch(){
        $this->testCase->assertServiceScopeIsPrototype('container.scoped');
    }

    /**
     * @group integration
     *
     * @expectedException \PHPUnit_Framework_ExpectationFailedException
     * @expectedExceptionMessage Should be prototype scoped
     */
    public function testAssertServiceScopeIsPrototypeWithMessage()
    {
        $this->testCase->assertServiceScopeIsPrototype('container.scoped', null, 'Should be prototype scoped');
    }

    /**
     * @group integration
     *
     * @expectedException \PHPUnit_Framework_ExpectationFailedException
     * @expectedExceptionMessage Failed asserting that 'container' scope is 'prototype'.
     */
    public function testAssertServiceScopeIsPrototypeWithConfig()
    {
        $this->testCase->assertServiceScopeIsPrototype('fixture.custom', $this->getCustomConfig());
    }

    /**
     * @group integration
     */
    public function testAssertServiceScopeIsNotPrototypeWithMatch()
    {
        $this->testCase->assertServiceScopeIsNotPrototype('container.scoped');
    }

    /**
     * @group integration
     *
     * @expectedException \PHPUnit_Framework_ExpectationFailedException
     * @expectedExceptionMessage Failed asserting that 'prototype' scope is not 'prototype'.
     */
    public function testAssertServiceScopeIsNotPrototypeWithNonMatch(){
        $this->testCase->assertServiceScopeIsNotPrototype('prototype.scoped');
    }

    /**
     * @group integration
     *
     * @expectedException \PHPUnit_Framework_ExpectationFailedException
     * @expectedExceptionMessage Should not be prototype scoped
     */
    public function testAssertServiceScopeIsNotPrototypeWithMessage()
    {
        $this->testCase->assertServiceScopeIsNotPrototype('prototype.scoped', null, 'Should not be prototype scoped');
    }

    /**
     * @group integration
     */
    public function testAssertServiceScopeIsNotPrototypeWithConfig()
    {
        $this->testCase->assertServiceScopeIsNotPrototype('fixture.custom', $this->getCustomConfig());
    }

    /**
     * @group integration
     */
    public function testAssertServiceScopeIsContainerWithMatch()
    {
        $this->testCase->assertServiceScopeIsContainer('container.scoped');
    }

    /**
     * @group integration
     *
     * @expectedException \PHPUnit_Framework_ExpectationFailedException
     * @expectedExceptionMessage Failed asserting that 'request' scope is 'container'.
     */
    public function testAssertServiceScopeIsContainerWithNonMatch(){
        $this->testCase->assertServiceScopeIsContainer('request.scoped');
    }

    /**
     * @group integration
     *
     * @expectedException \PHPUnit_Framework_ExpectationFailedException
     * @expectedExceptionMessage Should be container scoped
     */
    public function testAssertServiceScopeIsContainerWithMessage()
    {
        $this->testCase->assertServiceScopeIsContainer('prototype.scoped', null, 'Should be container scoped');
    }

    /**
     * @group integration
     */
    public function testAssertServiceScopeIsContainerWithConfig()
    {
        $this->testCase->assertServiceScopeIsContainer('fixture.custom', $this->getCustomConfig());
    }

    /**
     * @group integration
     */
    public function testAssertServiceScopeIsNotContainerWithMatch()
    {
        $this->testCase->assertServiceScopeIsNotContainer('request.scoped');
    }

    /**
     * @group integration
     *
     * @expectedException \PHPUnit_Framework_ExpectationFailedException
     * @expectedExceptionMessage Failed asserting that 'container' scope is not 'container'.
     */
    public function testAssertServiceScopeIsNotContainerWithNonMatch(){
        $this->testCase->assertServiceScopeIsNotContainer('container.scoped');
    }

    /**
     * @group integration
     *
     * @expectedException \PHPUnit_Framework_ExpectationFailedException
     * @expectedExceptionMessage Should not be container scoped
     */
    public function testAssertServiceScopeIsNotContainerWithMessage()
    {
        $this->testCase->assertServiceScopeIsNotContainer('container.scoped', null, 'Should not be container scoped');
    }

    /**
     * @group integration
     *
     * @expectedException \PHPUnit_Framework_ExpectationFailedException
     * @expectedExceptionMessage Failed asserting that 'container' scope is not 'container'.
     */
    public function testAssertServiceScopeIsNotContainerWithConfig()
    {
        $this->testCase->assertServiceScopeIsNotContainer('fixture.custom', $this->getCustomConfig());
    }
    
    /**
     * @return array
     */
    private function getCustomConfig()
    {
        return array(
            'bar' => array(
                'custom' => true,
            ),
        );
    }

}
