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
        for ($i = 0; $i <= 1000000; $i++) {
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
    public function testMockery()
    {
//        $db = \Mockery::mock(Db::class);
//        $db->shouldReceive('connect')
//            ->once()
//            ->andReturn(true);
//
//        $db->shouldReceive('query')
//            ->once()
//            ->andReturn(true);
//
//        $this->assertTrue($this->user->save($db));
        $observer = \Mockery::mock(UserObserver::class);

        $observer->shouldReceive('update')
//            ->with('update')
            ->withArgs(function ($param) {
                $this->assertEquals('update', $param);
                return true;
            })
            ->once();

        $this->user->attach($observer);
        $this->user->update();
    }

    public function testAssertMethods() {
        $array = ['key1' => 1, 'key2' => 2];
        $this->assertArrayHasKey('key1', $array);
        $this->assertArrayNotHasKey('key', $array);

        $this->assertClassHasAttribute('age', User::class);
        $this->assertClassNotHasAttribute('login', User::class);

        $this->assertClassNotHasStaticAttribute('age', User::class);

        $this->assertContains(33, [1, 2, 33, 35]);
        $this->assertStringContainsString('abc', 'abcde');
        $this->assertContainsOnly('integer', [1, 2, 33, 35]);
        $this->assertContainsOnlyInstancesOf(User::class, [$this->user, $this->user]);

        $this->assertCount(2, [1, 2]);

        $this->assertDirectoryExists('/home/sergey/PhpstormProjects/Tests/tests');
        $this->assertDirectoryIsReadable('/home/sergey/PhpstormProjects/Tests/tests');
        $this->assertDirectoryIsWritable('/home/sergey/PhpstormProjects/Tests/tests');

        $this->assertEmpty('');

        // ==
        $this->assertEquals('33', $this->user->getAge());

        // ===
        $this->assertNotSame('33', $this->user->getAge());

        $this->assertFalse(false);

        $this->assertFileEquals('/home/sergey/PhpstormProjects/Tests/test1.txt',
            '/home/sergey/PhpstormProjects/Tests/test2.txt');
        $this->assertFileIsReadable('/home/sergey/PhpstormProjects/Tests/test1.txt');
        $this->assertIsReadable('/home/sergey/PhpstormProjects/Tests/test1.txt');
        $this->assertIsReadable('/home/sergey/PhpstormProjects/Tests');

        $this->assertGreaterThan(1, 3);
        $this->assertGreaterThanOrEqual(3, 3);
        $this->assertLessThan(3, 1);
        $this->assertLessThanOrEqual(3, 3);


        $this->assertInfinite(log(0));
        $this->assertInstanceOf(User::class, $this->user);
        $this->assertIsIterable($array);
        $this->assertIsObject($this->user);
        $this->assertNan(acos(2));

        $this->assertMatchesRegularExpression('/str/', '123str1');
        $this->assertStringStartsWith('prefix', 'prefixxxxx');
        $this->assertStringEndsWith('suffix', 'ssssuffix');
    }
}
