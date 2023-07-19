<?php

namespace veejay\autonumber;

use Exception;

/**
 * Class Generator
 *
 * @property-read Number $number
 * @property-read Letter $letter
 * @property-read Region $region
 */
class Generator
{
    /**
     * Number handler.
     * @var Number
     */
    protected $number;

    /**
     * Letter handler.
     * @var Letter
     */
    protected $letter;

    /**
     * Region handler.
     * @var Region
     */
    protected $region;

    /**
     * @param string|null $value
     * @throws Exception
     */
    public function __construct(string $value = null)
    {
        $this->number = new Number;
        $this->letter = new Letter;
        $this->region = new Region;

        if ($value !== null) {
            $this->setValue($value);
        }
    }

    /**
     * @param string $name
     * @return mixed
     */
    public function __get($name)
    {
        return $this->$name;
    }

    /**
     * Set autonumber.
     * @param string $value
     * @return void
     * @throws Exception
     */
    public function setValue(string $value): void
    {
        $ll = implode('|', Letter::SYMBOLS); // ll - letters list
        $pattern = "/^([$ll])([0-9]{3})([$ll]{2})([0-9]{2,3})$/ui";
        $result = preg_match($pattern, $value, $matches);

        if ($result === false) {
            throw new Exception("Wrong autonumber format: $value", 500);
        }

        $this->number->setValue($matches[2]);
        $this->letter->setValue($matches[1] . $matches[3]);
        $this->region->setValue($matches[4]);
    }

    /**
     * Get autonumber.
     * @return string
     */
    public function getValue(): string
    {
        $parts = [
            mb_substr($this->letter, 0, 1),
            $this->number,
            mb_substr($this->letter, 1, 2),
            $this->region,
        ];

        return implode('', $parts);
    }
}
