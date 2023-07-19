<?php

namespace veejay\autonumber;

abstract class AbstractPart
{
    /**
     * Current value.
     * @var mixed
     */
    protected $value;

    /**
     * @return string
     */
    abstract public function __toString();

    /**
     * Is current value first.
     * @return bool
     */
    public function isFirst(): bool
    {
        return $this->value === static::MIN;
    }

    /**
     * Is current value last.
     * @return bool
     */
    public function isLast(): bool
    {
        return $this->value === static::MAX;
    }

    /**
     * Set value to previous.
     * @return static
     */
    abstract public function prev(): self;

    /**
     * Set value to next.
     * @return static
     */
    abstract public function next(): self;

    /**
     * Validate specific value.
     * @param mixed $value
     * @return bool
     */
    abstract public static function validate($value): bool;
}
