<?php

/**
 * Containter for unit tests for Immutable ArrayObject
 *
 * PHP Version 7
 *
 * @category  Library
 * @package   ApplicationArchitecture
 * @author    Matthew "Juniper" Barlett <emeraldinspirations@gmail.com>
 * @copyright 2017 Matthew "Juniper" Barlett <emeraldinspirations@gmail.com>
 * @license   MIT ../LICENSE
 * @link      http://github.com/emeraldinspirations/lib-applicationArchitecture
 */
namespace emeraldinspirations\library\applicationArchitecture;

/**
 * Unit tests for Immutable ArrayObject
 *
 * @category Library
 * @package  ApplicationArchitecture
 * @author   Matthew "Juniper" Barlett <emeraldinspirations@gmail.com>
 * @license  MIT ../LICENSE
 * @version  GIT: $Id$ In Development.
 * @link     https://github.com/emeraldinspirations/lib-applicationArchitecture
 */
class ImmutableArrayObjectTest extends \PHPUnit_Framework_TestCase
{
    protected $Object;
    const KEY_MAINTAINED = 'KeyMaintained';
    const KEY_CHANGED    = 'KeyChanged';

    /**
     * Set up before each test is run
     *
     * @return void
     */
    public function setUp()
    {
        $this->Object = new ImmutableArrayObject(
            [
                self::KEY_MAINTAINED => 'ValueMaintained',
                self::KEY_CHANGED    => 'OriginalValue',
            ]
        );
    }

    /**
     * Verify new object is constructable and extends \ArrayObject
     *
     * @return void
     */
    public function testConstruct()
    {

        $this->assertInstanceOf(
            ImmutableArrayObject::class,
            $this->Object,
            'Fails if class missing or not created'
        );

        $this->assertInstanceOf(
            \ArrayObject::class,
            $this->Object,
            'Fails if class does not extend ArrayObject'
        );

    }

    /**
     * Verify offset is settable through WITH function (immutable pattern)
     *
     * @return void
     */
    public function testWithOffsetSet()
    {
        $ValueUpdated  = 'NewValue';

        $ObjectClone = $this->Object->withOffsetSet(
            self::KEY_CHANGED, $ValueUpdated
        );
        // Fails if function not defined

        $this->assertInstanceOf(
            ImmutableArrayObject::class,
            $ObjectClone,
            'Fails if non ImmutableArrayObject returned'
        );

        $this->assertTrue(
            $ObjectClone->offsetExists(self::KEY_MAINTAINED),
            'Fails if data not maintained'
        );

        $this->assertNotSame(
            $this->Object,
            $ObjectClone,
            'Fails if object not cloned'
        );

        $this->assertEquals(
            $ValueUpdated,
            $ObjectClone->offsetGet(self::KEY_CHANGED),
            'Fails if offset not updated'
        );

    }


    /**
     * Verify offset is unsettable through WITH function (immutable pattern)
     *
     * @return void
     */
    public function testWithOffsetUnset()
    {
        $ObjectClone = $this->Object->withOffsetUnset(self::KEY_CHANGED);
        // Fails if function not defined

        $this->assertInstanceOf(
            ImmutableArrayObject::class,
            $ObjectClone,
            'Fails if non ImmutableArrayObject returned'
        );

        $this->assertTrue(
            $ObjectClone->offsetExists(self::KEY_MAINTAINED),
            'Fails if data not maintained'
        );

        $this->assertNotSame(
            $this->Object,
            $ObjectClone,
            'Fails if object not cloned'
        );

        $this->assertFalse(
            $ObjectClone->offsetExists(self::KEY_CHANGED),
            'Fails if offset not removed'
        );

    }

    /**
     * Verify offsetSet throws exception
     *
     * @expectedException     \LogicException
     * @expectedExceptionCode 1487415175
     *
     * @return void
     */
    public function testIsReadOnly1()
    {
        $this->Object[self::KEY_CHANGED] = 'NewValue';

    }

    /**
     * Verify offsetUnset throws exception
     *
     * @expectedException     \LogicException
     * @expectedExceptionCode 1487415510
     *
     * @return void
     */
    public function testIsReadOnly2()
    {

        unset($this->Object[self::KEY_CHANGED]);

    }

}