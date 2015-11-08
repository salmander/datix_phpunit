<?php

require __DIR__.'/../vendor/autoload.php';
require __DIR__ . '/../src/legacyCode.php';

class TechnicalTest extends PHPUnit_Framework_TestCase
{
	protected $db;

	public function setUp ()
	{
		$this->db = $this->getMockBuilder('DB')
				         ->setMethods(['insert','delete','update','get'])
				         ->getMock();
	}

	public function testCreateUser ()
	{
		$username = 'john';
		$password = 'pass123';

		$this->db->expects($this->once())
				->method('insert')
				->with($username, md5($password));

		NewUser($this->db, $username, $password);
	}

	public function testCreateUserWithShortPassword ()
	{
		// If password is shorter than 6 chars, the user should not be created

		$username = 'john';
		$password = 'abc12';

		$this->db->expects($this->never())
				->method('insert');

		NewUser($this->db, $username, $password);

	}

	public function testChangePassword ()
	{
		$username = 'john';
		$newPassword = 'N3wpass!9';

        // Mock that the user exists
        $this->db->expects($this->once())
            ->method('get')
            ->with($username)
            ->willReturn("something");

		$this->db->expects($this->once())
            ->method('update')
            ->with($username, $newPassword);

		ChangePassword($this->db, $username, $newPassword);
	}

	public function testChangePasswordWithShortPassword ()
	{
		// If the new password is shorter than 6 chars, it shouldn't be updated

		$username = 'john';
		$newPassword = 'N3w!9';

		$this->db->expects($this->never())->method('update');

		ChangePassword($this->db, $username, $newPassword);
	}

	public function testChangePasswordOfNonExistingUser()
	{
		// If user doesn't exist, the password should not be changed

		$username = 'john';
		$newPassword = 'N3wpass!9';

		$this->db->expects($this->once())
            ->method('get')
            ->with($username)
            ->willReturn(null);

		$this->db->expects($this->never())
            ->method('update');

		ChangePassword($this->db, $username, $newPassword);
	}

	public function testDeleteUser ()
	{
		$username = 'john';

		$this->db->expects($this->once())
            ->method('get')
            ->with($username)
            ->willReturn("something");

		$this->db->expects($this->once())
            ->method('delete')
            ->with($username);

		DeleteUser ($this->db, $username);
	}

	public function testDeleteNonExistingUser ()
	{
		// If user doesn't exist, we shouldn't try to delete it

		$username = 'james';

		$this->db->expects($this->once())->method('get')->with($username)->willReturn(null);

		$this->db->expects($this->never())->method('delete');

		DeleteUser ($this->db, $username);
	}

	public function testUserDoesntExists ()
	{
		// If we get no data about the user, assume it doesn't exist

		$username = 'johnny';

		$this->db->expects($this->once())->method('get')->with($username)->willReturn(null);

		$this->assertFalse (UserExists ($this->db, $username));
	}
}
