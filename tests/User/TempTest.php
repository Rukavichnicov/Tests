<?php

namespace User;

use PHPUnit\Framework\TestCase;
use Throwable;

class TempTest extends TestCase
{
    public static function setUpBeforeClass(): void
    {
        fwrite(STDOUT, __METHOD__ . "\n");
    }

    public function setUp(): void
    {
        fwrite(STDOUT, __METHOD__ . "\n");
    }

    public function assertPreConditions(): void
    {
        fwrite(STDOUT, __METHOD__ . "\n");
    }

    public function testOne()
    {
        fwrite(STDOUT, __METHOD__ . "\n");
        $this->assertTrue(true);
    }

    public function testTwo()
    {
        fwrite(STDOUT, __METHOD__ . "\n");
        $this->assertFalse(false);
    }

    public function assertPostConditions(): void
    {
        fwrite(STDOUT, __METHOD__ . "\n");
    }

    public function tearDown(): void
    {
        fwrite(STDOUT, __METHOD__ . "\n");
    }

    protected  function  onNotSuccessfulTest(Throwable $t): void
    {
        fwrite(STDOUT, __METHOD__ . "\n");
        throw $t;
    }

    public static function tearDownAfterClass(): void
    {
        fwrite(STDOUT, __METHOD__ . "\n");
    }
}