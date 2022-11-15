<?php

namespace User;

use App\Models\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    private User $user;

    protected function setUp(): void
    {
        $this->user = new User();
        $this->user->setAge(33);
    }

    protected function tearDown(): void
    {

    }

    /**
     * @dataProvider userProvider
     */
    public function testAge($age, $agePass)
    {
        $this->assertEquals($age, $agePass);
    }

    public function userProvider(): array
    {
        return [
            'one' => [1, 1],
            'two' => [2, 2],
            'correct' => [33, 33],
        ];
    }

    /**
     *
     */
    public function testAge1()
    {
        $this->assertEquals(33, $this->user->getAge());
        return 33;
    }

    /**
     * @depends testAge1
     */
    public function testAge2($age)
    {
        $this->assertEquals($age, $this->user->getAge());
    }

    public function testEmailException()
    {
        $this->expectException(\InvalidArgumentException::class);
        //$this->expectExceptionCode(403);
        $this->user->getEmail();
    }

    public function testEcho()
    {
        echo "success ";
        $this->setOutputCallback(function ($str) {
            return trim($str);
        });
        $this->expectOutputString('success');
    }

    public function testArray()
    {
        $this->assertEquals(
            [1, 2, 3, 4, 5],
            [1, 2, '3', 4, 5]
        );
    }
}
