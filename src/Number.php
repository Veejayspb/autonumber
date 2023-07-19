<?php

namespace veejay\autonumber;

use Exception;

class Number extends AbstractPart
{
    const MIN = 1;
    const MAX = 999;

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
        return str_pad($this->value, 3, '0', STR_PAD_LEFT);
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
    public function prev(): AbstractPart
    {
        if ($this->isFirst()) {
            $this->value = self::MAX;
        } else {
            $this->value--;
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
            $this->value++;
        }

        return $this;
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
}
