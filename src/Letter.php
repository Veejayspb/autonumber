<?php

namespace veejay\autonumber;

use Exception;

class Letter extends AbstractPart
{
    const MIN = 'ааа';
    const MAX = 'ххх';

    /**
     * Available symbols.
     */
    const SYMBOLS = [
        'а', 'в', 'е', 'к',
        'м', 'н', 'о', 'р',
        'с', 'т', 'у', 'х',
    ];

    /**
     * @var string
     */
    protected $value;

    /**
     * @param string $value
     * @throws Exception
     */
    public function __construct(string $value = self::MIN)
    {
        $this->setValue($value);
    }

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        return $this->value;
    }

    /**
     * Set current value.
     * @param string $value
     * @return void
     * @throws Exception
     */
    public function setValue(string $value): void
    {
        if (!static::validate($value)) {
            throw new Exception('Wrong value type', 500);
        }

        $this->value = mb_strtolower($value);
    }

    /**
     * Get current value.
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * {@inheritdoc}
     */
    public function prev(): AbstractPart
    {
        if ($this->isFirst()) {
            $this->value = self::MAX;
        } else {
            $index = $this->getValueIndex();
            $this->setValueIndex($index - 1);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function next(): AbstractPart
    {
        if ($this->isLast()) {
            $this->value = self::MIN;
        } else {
            $index = $this->getValueIndex();
            $this->setValueIndex($index + 1);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public static function validate($value): bool
    {
        $symbols = implode('', static::SYMBOLS);
        $pattern = "/^[$symbols]{3}$/ui";

        return
            is_string($value) &&
            preg_match($pattern, $value);
    }

    /**
     * Set current value using integer representation.
     * @param int $index
     * @return void
     */
    private function setValueIndex(int $index): void
    {
        $maxIndex = $this->lettersToIndex(static::MAX) + 1;
        $index = $index % $maxIndex;

        $countSigns = count(static::SYMBOLS);
        $baseConverted = base_convert($index, 10, $countSigns);
        $letters = '';

        for ($i = 0; isset($baseConverted[$i]); $i++) {
            $index = base_convert($baseConverted[$i], $countSigns, 10);
            $letters .= static::SYMBOLS[$index];
        }

        $this->value = str_pad($letters, strlen(static::MIN), static::SYMBOLS[0], STR_PAD_LEFT);
    }

    /**
     * Get integer representation of current value.
     * @return int
     */
    private function getValueIndex(): int
    {
        return $this->lettersToIndex($this->value);
    }

    /**
     * Get integer representation of specific letters.
     * @param string $letters
     * @return int
     */
    private function lettersToIndex(string $letters): int
    {
        $countRanks = mb_strlen($letters);
        $countSigns = count(static::SYMBOLS);
        $baseConverted = '';

        for ($i = 0; $i < $countRanks; $i++) {
            $letter = mb_substr($letters, $i, 1);
            $index = array_search($letter, static::SYMBOLS);

            if ($index === false) {
                continue;
            }

            $baseConverted .= base_convert($index, 10, $countSigns);
        }

        return base_convert($baseConverted, $countSigns, 10);
    }
}
