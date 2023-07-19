<?php

use PHPUnit\Framework\TestCase;

abstract class BaseTestCase extends TestCase
{
    /**
     * @param callable $callback
     * @param string $message
     * @return void
     */
    public function assertException(callable $callback, string $message = ''): void
    {
        $thrown = false;

        try {
            call_user_func($callback);
        } catch (Throwable $e) {
            $thrown = true;
        }

        $this->assertTrue($thrown, $message);
    }
}
