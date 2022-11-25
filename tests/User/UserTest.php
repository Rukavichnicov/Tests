<?php
namespace User;

use App\Models\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    private User $user;

    protected function setUp(): void
    {
        $this->user = $this->getMockBuilder(User::class)
            ->disableOriginalConstructor()
            ->disableOriginalClone()
            ->disableArgumentCloning()
            ->disallowMockingUnknownTypes()
            ->getMock();

        $user = new User();
        $user->setName("name");
        $user->setEmail("email@email.com");
        $user->setPassword(password_hash("password",PASSWORD_BCRYPT));
        $user->setIsActive("0");

        $this->user->method('register')->willReturn($user);
    }

    protected function tearDown(): void
    {

    }

    public function additionProvider()
    {
        return [
            [
                'name',
                'email@email.com',
                'password'
            ]
        ];
    }


    /**
     * @dataProvider additionProvider
     * @param $name
     * @param $email
     * @param $password
     * @return void
     */
    public function testRegister($name, $email, $password)
    {
        $this->user = $this->user->register($name, $email, $password);

        $this->assertNotEmpty($this->user);
        $this->assertEquals($name, $this->user->getName());
        $this->assertEquals($email, $this->user->getEmail());
        $this->assertTrue(password_verify($password, $this->user->getPassword()));
        $this->assertEquals("0", $this->user->getIsActive());
    }
}
