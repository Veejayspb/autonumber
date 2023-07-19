<?php

use veejay\autonumber\Number;

final class NumberTest extends BaseTestCase
{
    public function testConstruct(): void
    {
        $object = new Number;
        $this->assertEquals(1, $object->getValue());

        $object = new Number(111);
        $this->assertEquals(111, $object->getValue());

        $this->assertException(function () {
            new Number(0);
        });

        $this->assertException(function () {
            new Number(-1);
        });

        $this->assertException(function () {
            new Number(1000);
        });
    }

    public function testToString(): void
    {
        $object = new Number(456);

        $this->assertSame('456', (string)$object);
    }

    public function testSetGetValue(): void
    {
        $object = new Number;
        $object->setValue(222);
        $this->assertEquals(222, $object->getValue());

        $this->assertException(function () {
            $object = new Number;
            $object->setValue(0);
        });

        $this->assertException(function () {
            $object = new Number;
            $object->setValue(-2);
        });

        $this->assertException(function () {
            $object = new Number;
            $object->setValue(2000);
        });
    }

    public function testIsFirst(): void
    {
        $object = new Number(1);
        $this->assertTrue($object->isFirst());

        $object = new Number(222);
        $this->assertFalse($object->isFirst());

        $object = new Number(999);
        $this->assertFalse($object->isFirst());
    }

    public function testIsLast(): void
    {
        $object = new Number(1);
        $this->assertFalse($object->isLast());

        $object = new Number(333);
        $this->assertFalse($object->isLast());

        $object = new Number(999);
        $this->assertTrue($object->isLast());
    }

    public function testPrev(): void
    {
        $object = new Number(2);

        $this->assertSame($object, $object->prev());
        $this->assertSame(1, $object->getValue());

        $this->assertSame($object, $object->prev());
        $this->assertSame(999, $object->getValue());
    }

    public function testNext(): void
    {
        $object = new Number(998);

        $this->assertSame($object, $object->next());
        $this->assertSame(999, $object->getValue());

        $this->assertSame($object, $object->next());
        $this->assertSame(1, $object->getValue());
    }

    public function testValidate(): void
    {
        // Valid values
        $true = [
            1,
            999,
        ];

        foreach ($true as $item) {
            $this->assertTrue(Number::validate($item));
        }

        // Invalid values
        $false = [
            -1,
            0,
            1000,
            2.2,
            '0',
            null,
            [],
            true,
            false,
            $this,
            function () {},
            new class {},
        ];

        foreach ($false as $item) {
            $this->assertFalse(Number::validate($item));
        }
    }
}
