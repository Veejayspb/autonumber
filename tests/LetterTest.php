<?php

use veejay\autonumber\Letter;

final class LetterTest extends BaseTestCase
{
    public function testConstruct(): void
    {
        $object = new Letter;
        $this->assertEquals('ааа', $object->getValue());

        $object = new Letter('ввв');
        $this->assertEquals('ввв', $object->getValue());

        $object = new Letter('ЕЕЕ');
        $this->assertEquals('еее', $object->getValue());

        $this->assertException(function () {
            new Letter('ббб');
        });

        $this->assertException(function () {
            new Letter('ее');
        });

        $this->assertException(function () {
            new Letter('оооо');
        });

        $this->assertException(function () {
            new Letter('100');
        });
    }

    public function testToString(): void
    {
        $object = new Letter('аве');

        $this->assertSame('аве', (string)$object);
    }

    public function testSetGetValue(): void
    {
        $object = new Letter;
        $object->setValue('ккк');
        $this->assertEquals('ккк', $object->getValue());

        $object = new Letter;
        $object->setValue('МММ');
        $this->assertEquals('ммм', $object->getValue());

        $this->assertException(function () {
            $object = new Letter;
            $object->setValue('ггг');
        });

        $this->assertException(function () {
            $object = new Letter;
            $object->setValue('нн');
        });

        $this->assertException(function () {
            $object = new Letter;
            $object->setValue('рррр');
        });

        $this->assertException(function () {
            $object = new Letter;
            $object->setValue('200');
        });
    }

    public function testIsFirst(): void
    {
        $object = new Letter('ааа');
        $this->assertTrue($object->isFirst());

        $object = new Letter('ооо');
        $this->assertFalse($object->isFirst());

        $object = new Letter('ххх');
        $this->assertFalse($object->isFirst());
    }

    public function testIsLast(): void
    {
        $object = new Letter('ааа');
        $this->assertFalse($object->isLast());

        $object = new Letter('ттт');
        $this->assertFalse($object->isLast());

        $object = new Letter('ххх');
        $this->assertTrue($object->isLast());
    }

    public function testPrev(): void
    {
        $object = new Letter('аав');

        $this->assertSame($object, $object->prev());
        $this->assertSame('ааа', $object->getValue());

        $this->assertSame($object, $object->prev());
        $this->assertSame('ххх', $object->getValue());
    }

    public function testNext(): void
    {
        $object = new Letter('хху');

        $this->assertSame($object, $object->next());
        $this->assertSame('ххх', $object->getValue());

        $this->assertSame($object, $object->next());
        $this->assertSame('ааа', $object->getValue());
    }

    public function testValidate(): void
    {
        // Valid values
        $true = [
            'век',
            'ВОР',
            'РоМ',
            'хЕр',
        ];

        foreach ($true as $item) {
            $this->assertTrue(Letter::validate($item));
        }

        // Invalid values
        $false = [
            'ббб',
            'ooo', // Latin
            'аааа',
            'в вв',
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
            $this->assertFalse(Letter::validate($item));
        }
    }
}
