<?php

use veejay\autonumber\Region;

final class RegionTest extends BaseTestCase
{
    public function testConstruct(): void
    {
        $object = new Region;
        $this->assertEquals(1, $object->getValue());

        $object = new Region(78);
        $this->assertEquals(78, $object->getValue());

        $object = new Region(178);
        $this->assertEquals(178, $object->getValue());

        $this->assertException(function () {
            new Region(0);
        });

        $this->assertException(function () {
            new Region(-1);
        });

        $this->assertException(function () {
            new Region(1000);
        });
    }

    public function testToString(): void
    {
        $object = new Region(111);

        $this->assertSame('111', (string)$object);
    }

    public function testSetGetValue(): void
    {
        $object = new Region;
        $object->setValue(147);
        $this->assertEquals(147, $object->getValue());

        $this->assertException(function () {
            $object = new Region;
            $object->setValue(0);
        });

        $this->assertException(function () {
            $object = new Region;
            $object->setValue(-2);
        });

        $this->assertException(function () {
            $object = new Region;
            $object->setValue(2000);
        });
    }

    public function testIsFirst(): void
    {
        $spbIndexes = $this->getSpbIndexes();

        foreach ($spbIndexes as $i => $index) {
            $object = new Region($index);

            if ($i == 0) {
                $this->assertTrue($object->isFirst());
            } else {
                $this->assertFalse($object->isFirst());
            }
        }

        $object = new Region(20);
        $this->assertTrue($object->isFirst());

        $object = new Region(120);
        $this->assertTrue($object->isFirst());
    }

    public function testIsLast(): void
    {
        $spbIndexes = $this->getSpbIndexes();
        $spbIndexes = array_reverse($spbIndexes);

        foreach ($spbIndexes as $i => $index) {
            $object = new Region($index);

            if ($i == 0) {
                $this->assertTrue($object->isLast());
            } else {
                $this->assertFalse($object->isLast());
            }
        }

        $object = new Region(20);
        $this->assertTrue($object->isLast());

        $object = new Region(120);
        $this->assertTrue($object->isLast());
    }

    public function testPrev(): void
    {
        $spbIndexes = $this->getSpbIndexes();
        $object = new Region(next($spbIndexes));

        $this->assertSame($object, $object->prev());
        $this->assertSame(prev($spbIndexes), $object->getValue());

        $this->assertSame($object, $object->prev());
        $this->assertSame(end($spbIndexes), $object->getValue());
    }

    public function testNext(): void
    {
        $spbIndexes = $this->getSpbIndexes();
        end($spbIndexes);
        $object = new Region(prev($spbIndexes));

        $this->assertSame($object, $object->next());
        $this->assertSame(end($spbIndexes), $object->getValue());

        $this->assertSame($object, $object->next());
        $this->assertSame(reset($spbIndexes), $object->getValue());
    }

    public function testGetName(): void
    {
        $object = new Region(77);
        $this->assertSame(Region::BASIC_LIST[77], $object->getName());

        $object = new Region(178);
        $this->assertSame(Region::BASIC_LIST[78], $object->getName());

        $object = new Region(878);
        $this->assertSame(Region::BASIC_LIST[78], $object->getName());

        $object = new Region(20);
        $this->assertNull($object->getName());
    }

    public function testGetIndexes(): void
    {
        $object = new Region(178);
        $this->assertSame($this->getSpbIndexes([178]), $object->getIndexes());

        $object = new Region(98);
        $this->assertSame($this->getSpbIndexes([98]), $object->getIndexes());

        $object = new Region(678);
        $this->assertSame($this->getSpbIndexes([678]), $object->getIndexes());

        $object = new Region(120);
        $this->assertSame([120], $object->getIndexes());
    }

    public function testValidate(): void
    {
        // Valid values
        $true = [
            1,
            999,
        ];

        foreach ($true as $item) {
            $this->assertTrue(Region::validate($item));
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
            $this->assertFalse(Region::validate($item));
        }
    }

    /**
     * Return all region indexes of Saint-Petersburg.
     * @param array $addIndexes - additional indexes
     * @return array
     */
    private function getSpbIndexes(array $addIndexes = []): array
    {
        $indexes = [
            78, 178, 278, 378, 478, 578, 678, 778, 878, 978,
            98, 198, 298, 398, 498, 598, 698, 798, 898, 998,
        ];

        $indexes = array_intersect(
            array_merge([78, 98], Region::EXISTS),
            $indexes
        );

        $indexes = array_merge($indexes, $addIndexes);
        $indexes = array_unique($indexes);
        sort($indexes);

        return $indexes;
    }
}
