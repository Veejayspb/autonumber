<?php

use veejay\autonumber\Generator;
use veejay\autonumber\Letter;
use veejay\autonumber\Number;
use veejay\autonumber\Region;

final class GeneratorTest extends BaseTestCase
{
    public function testConstruct(): void
    {
        $object = new Generator;
        $this->assertSame('а001аа01', $object->getValue());

        $object = new Generator('а123ве60');
        $this->assertSame('а123ве60', $object->getValue());

        $this->assertException(function () {
            new Generator('а12ве60');
        });
    }

    public function testGet(): void
    {
        $object = new Generator;

        $this->assertTrue(is_a($object->number, Number::class));
        $this->assertTrue(is_a($object->letter, Letter::class));
        $this->assertTrue(is_a($object->region, Region::class));
    }

    public function testSetValue(): void
    {
        $object = new Generator;
        $object->setValue('к456мн70');

        $this->assertEquals($object->number, new Number(456));
        $this->assertEquals($object->letter, new Letter('кмн'));
        $this->assertEquals($object->region, new Region(70));

        $this->assertException(function () use ($object) {
            $object->setValue('к456мн');
        });
    }

    public function testGetValue(): void
    {
        $object = new Generator;
        $object->number->setValue(789);
        $object->letter->setValue('орс');
        $object->region->setValue(150);

        $this->assertSame('о789рс150', $object->getValue());
    }
}
