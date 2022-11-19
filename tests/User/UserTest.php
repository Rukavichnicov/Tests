<?php

namespace User;

use App\Models\Db;
use App\Models\User;
use App\Models\UserObserver;
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

    public function testEmpty()
    {
        $this->markTestIncomplete('Incomlete');
    }

    public function testSkipped()
    {
        if (true) {
            $this->markTestSkipped('Skipped test');
        }
    }

    /**
     * @requires PHP 8.1
     * @medium
     */
    public function testRequireDoc()
    {
        for ($i = 0; $i <= 100000000; $i++) {
        }
        $this->assertEquals(5, 5);
    }

    public function testModel()
    {
        $db = $this->createMock(Db::class);
        $db->expects($this->any())->method('connect')->willReturn(true);
        //$db->method('query')->willReturn(true);
        $db->method('query')->will(
//            $this->returnArgument(0)
//            $this->returnValue(true)
//            $this->returnCallback(function () {
//                return true;
//            })
            $this->onConsecutiveCalls(true, true)
        );
        $db->query('SELCET');
        $this->assertTrue($this->user->save($db));
    }

    public function testModelTwo()
    {
        $db = $this->getMockBuilder(Db::class)
            ->disableOriginalConstructor()
            ->disableOriginalClone()
            ->setMockClassName('Db')
            ->getMock();
        $db->expects($this->any())->method('connect')->willReturn(true);
        $db->method('query')->willReturn(true);
        $db->query('SELCET');
        $this->assertTrue($this->user->save($db));
    }

    public function testObserver()
    {
        $observer = $this->getMockBuilder(UserObserver::class)
            ->getMock();

        $observer->expects($this->exactly(2))
            ->method('update')
//            ->with($this->equalTo('update'))
//            ->with($this->anything())
//            ->with($this->stringContains('update'))
//            ->withConsecutive(
//                [$this->anything()],
//                [$this->stringContains('upd')]
//            )
            ->with(
                $this->callback(function ($param) {
                    return $param == 'update';
                })
            );
        $this->user->attach($observer);
        $this->user->attach($observer);
        $this->user->update();
    }
}
