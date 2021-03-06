<?php

require_once __DIR__ . '/../vendor/autoload.php';

/**
 * Created by PhpStorm.
 * User: salman
 * Date: 08/11/2015
 */
class UserTest extends PHPUnit_Framework_TestCase
{
    protected $db;
    protected $user;

    /**
     * Setup database Mock
     */
    public function setUp()
    {
        $this->db = $this->getMockBuilder('DB')
            ->setMethods(['insert', 'get', 'update', 'delete'])
            ->getMock();

        // Instantiate User
        $this->user = new User($this->db);

    }

    /**
     * Test creating user
     */
    public function testCreateUser()
    {
        $username = 'john';
        $password = 'pass123';

        // User::newUser should call DB::insert() method once with $username and
        // md5 hashed password.
        $this->db->expects($this->once())
            ->method('insert')
            ->with($username, md5($password));

        $this->user->newUser($username, $password);
    }

    /**
     * Test Creating user with password less than 6 characters
     */
    public function testCreateUserWithShortPassword()
    {
        // If password is shorter than 6 chars, the user should not be created

        $username = 'john';
        $password = 'abc12';

        // DB::insert should never get executed
        $this->db->expects($this->never())
            ->method('insert');

        $this->user->newUser($username, $password);

    }

    /**
     * Test changing password
     */
    public function testChangePassword()
    {
        $username = 'john';
        $newPassword = 'N3wpass!9';

        // Mock that the user (john) exists
        $this->db->expects($this->once())
            ->method('get')
            ->with($username)
            ->willReturn("something");

        $this->db->expects($this->once())
            ->method('update')
            ->with($username, $newPassword);

        $this->user->changePassword($username, $newPassword);
    }

    /**
     * Test changing password with new password less than 6 characters.
     */
    public function testChangePasswordWithShortPassword()
    {
        // If the new password is shorter than 6 chars, it shouldn't be updated

        $username = 'john';
        $newPassword = 'N3w!9';

        $this->db->expects($this->never())->method('update');

        $this->user->changePassword($username, $newPassword);
    }

    /**
     * Test changing password of the user which does not exist.
     */
    public function testChangePasswordOfNonExistingUser()
    {
        // If user doesn't exist, the password should not be changed
        $username = 'john';
        $newPassword = 'N3wpass!9';

        $this->db->expects($this->once())
            ->method('get')
            ->with($username)
            ->willReturn(null);

        // DB::update should never get executed
        $this->db->expects($this->never())
            ->method('update');

        $this->user->changePassword($username, $newPassword);
    }

    /**
     * Test deleting user
     */
    public function testDeleteUser()
    {
        $username = 'john';

        $this->db->expects($this->once())
            ->method('get')
            ->with($username)
            ->willReturn("something");

        $this->db->expects($this->once())
            ->method('delete')
            ->with($username);

        $this->user->deleteUser($username);
    }

    /**
     * Test deleting user which does not exist.
     */
    public function testDeleteNonExistingUser()
    {
        // If user doesn't exist, we shouldn't try to delete it
        $username = 'james';

        $this->db->expects($this->once())
            ->method('get')
            ->with($username)
            ->willReturn(null);

        $this->db->expects($this->never())
            ->method('delete');

        $this->user->deleteUser($username);
    }

    /**
     * Test user does not exist.
     */
    public function testUserDoesntExists()
    {
        // If we get no data about the user, assume it doesn't exist
        $username = 'johnny';

        $this->db->expects($this->once())
            ->method('get')
            ->with($username)
            ->willReturn(null);

        $this->assertFalse($this->user->userExists($username));
    }

}