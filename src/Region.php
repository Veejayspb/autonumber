<?php

namespace veejay\autonumber;

use Exception;

class Region extends AbstractPart
{
    const MIN = 1;
    const MAX = 999;

    /**
     * Full list of regions.
     */
    const BASIC_LIST = [
        1 => 'Республика Адыгея',
        2 => 'Республика Башкортостан',
        3 => 'Республика Бурятия',
        4 => 'Республика Алтай',
        5 => 'Республика Дагестан',
        6 => 'Республика Ингушетия',
        7 => 'Кабардино-Балкарская Республика',
        8 => 'Республика Калмыкия',
        9 => 'Карачаево-Черкесская Республика',
        10 => 'Республика Карелия',
        11 => 'Республика Коми',
        12 => 'Республика Марий-Эл',
        13 => 'Республика Мордовия',
        14 => 'Республика Саха-Якутия',
        15 => 'Республика Северная Осетия-Алания',
        16 => 'Республика Татарстан',
        17 => 'Республика Тува',
        18 => 'Удмуртская Республика',
        19 => 'Республика Хакасия',
        21 => 'Чувашская Республика',
        22 => 'Алтайский край',
        23 => 'Краснодарский край',
        24 => 'Красноярский край',
        25 => 'Приморский край',
        26 => 'Ставропольский край',
        27 => 'Хабаровский край',
        28 => 'Амурская область',
        29 => 'Архангельская область',
        30 => 'Астраханская область',
        31 => 'Белгородская область',
        32 => 'Брянская область',
        33 => 'Владимирская область',
        34 => 'Волгоградская область',
        35 => 'Вологодская область',
        36 => 'Воронежская область',
        37 => 'Ивановская область',
        38 => 'Иркутская область',
        39 => 'Калининградская область',
        40 => 'Калужская область',
        41 => 'Камчатский край',
        42 => 'Кемеровская область',
        43 => 'Кировская область',
        44 => 'Костромская область',
        45 => 'Курганская область',
        46 => 'Курская область',
        47 => 'Ленинградская область',
        48 => 'Липецкая область',
        49 => 'Магаданская область',
        50 => 'Московская область',
        51 => 'Мурманская область',
        52 => 'Нижегородская область',
        53 => 'Новгородская область',
        54 => 'Новосибирская область',
        55 => 'Омская область',
        56 => 'Оренбургская область',
        57 => 'Орловская область',
        58 => 'Пензенская область',
        59 => 'Пермский край',
        60 => 'Псковская область',
        61 => 'Ростовская область',
        62 => 'Рязанская область',
        63 => 'Самарская область',
        64 => 'Саратовская область',
        65 => 'Сахалинская область',
        66 => 'Свердловская область',
        67 => 'Смоленская область',
        68 => 'Тамбовская область',
        69 => 'Тверская область',
        70 => 'Томская область',
        71 => 'Тульская область',
        72 => 'Тюменская область',
        73 => 'Ульяновская область',
        74 => 'Челябинская область',
        75 => 'Забайкальский край',
        76 => 'Ярославская область',
        77 => 'Москва',
        78 => 'Санкт-Петербург',
        79 => 'Еврейская автономная область',
        83 => 'Ненецкий автономный округ',
        86 => 'Ханты-Мансийский автономный округ',
        87 => 'Чукотский автономный округ',
        89 => 'Ямало-Ненецкий автономный округ',
        90 => 'Московская область',
        91 => 'Калининградская область',
        93 => 'Краснодарский край',
        94 => 'Байконур',
        95 => 'Чеченская республика',
        96 => 'Свердловская область',
        97 => 'Москва',
        98 => 'Санкт-Петербург',
        99 => 'Москва',
    ];

    /**
     * List of existing region numbers.
     */
    const EXISTS = [
        102,
        113, 116,
        121, 122, 123, 124, 125, 126,
        134, 136, 138,
        142, 147,
        150, 152, 154, 156, 159,
        161, 163, 164,
        173, 174, 177, 178,
        186,
        190, 193, 196, 197, 198, 199,
        702,
        716,
        750,
        761, 763,
        774, 777,
        790, 797, 799,
    ];

    /**
     * @var int
     */
    protected $value;

    /**
     * @param int $value
     * @throws Exception
     */
    public function __construct(int $value = self::MIN)
    {
        $this->setValue($value);
    }

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        return str_pad($this->value, 2, '0', STR_PAD_LEFT);
    }

    /**
     * Set current value.
     * @param int $value
     * @return void
     * @throws Exception
     */
    public function setValue(int $value): void
    {
        if (!static::validate($value)) {
            throw new Exception('Wrong value type', 500);
        }

        $this->value = $value;
    }

    /**
     * Get current value.
     * @return int
     */
    public function getValue(): int
    {
        return $this->value;
    }

    /**
     * {@inheritdoc}
     */
    public function isFirst(): bool
    {
        $indexes = $this->getIndexes();

        if (!array_key_exists(0, $indexes)) {
            return true;
        }

        return $indexes[0] == $this->value;
    }

    /**
     * {@inheritdoc}
     */
    public function isLast(): bool
    {
        $indexes = $this->getIndexes();
        $indexes = array_reverse($indexes);

        if (!array_key_exists(0, $indexes)) {
            return true;
        }

        return $indexes[0] == $this->value;
    }

    /**
     * Previous number of the same region.
     * {@inheritdoc}
     */
    public function prev(): AbstractPart
    {
        $indexes = $this->getIndexes();

        if ($this->isFirst()) {
            $this->value = end($indexes);
            return $this;
        }

        $indexes = array_reverse($indexes);

        foreach ($indexes as $index) {
            if ($index < $this->value) {
                $this->value = $index;
                break;
            }
        }

        return $this;
    }

    /**
     * Next number of the same region.
     * {@inheritdoc}
     */
    public function next(): AbstractPart
    {
        $indexes = $this->getIndexes();

        if ($this->isLast()) {
            $this->value = reset($indexes);
            return $this;
        }

        foreach ($indexes as $index) {
            if ($this->value < $index) {
                $this->value = $index;
                break;
            }
        }

        return $this;
    }

    /**
     * Current region name.
     * @return string|null
     */
    public function getName(): ?string
    {
        $index = $this->getBasicIndex($this->value);

        return self::BASIC_LIST[$index] ?? null;
    }

    /**
     * Get all indexes of current region.
     * @return array
     */
    public function getIndexes(): array
    {
        $name = $this->getName();
        $indexes = array_keys(self::BASIC_LIST, $name);

        foreach ($indexes as $index) {
            $indexes = array_merge($indexes, $this->getAllIndexesOfRegion($index));
        }

        $indexes[] = $this->value;

        $indexes = array_unique($indexes);
        sort($indexes);

        return $indexes;
    }

    /**
     * {@inheritdoc}
     */
    public static function validate($value): bool
    {
        return
            is_int($value) &&
            self::MIN <= $value &&
            $value <= self::MAX;
    }

    /**
     * Return basic index of specified region.
     * @return int - 1-99
     */
    private function getBasicIndex(int $index): int
    {
        return $index % 100;
    }

    /**
     * Get all indexes of specified region.
     * @param int $index
     * @return array
     */
    private function getAllIndexesOfRegion(int $index): array
    {
        $basicIndex = $this->getBasicIndex($index);
        $result = [];

        for ($i = 0; $i <= 9; $i++) {
            $newIndex = $i * 100 + $basicIndex;

            if (
                !in_array($newIndex, self::EXISTS) &&
                !array_key_exists($newIndex, self::BASIC_LIST)
            ) {
                continue;
            }

            $result[] = $newIndex;
        }

        return $result;
    }
}
