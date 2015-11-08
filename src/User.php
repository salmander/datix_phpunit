<?php

/**
 * Created by PhpStorm.
 * User: salman
 * Date: 08/11/2015
 * Time: 13:07
 */
class User
{
    private $db;

    /**
     * User constructor.
     * @param DB $db
     */
    public function __construct(DB $db)
    {
        $this->db = $db;
    }

    /**
     * Create new user in the database
     * @param $username
     * @param $password
     */
    public function newUser($username, $password)
    {
        // Validate password length
        if (!$this->validatePasswordLength($password)) {
            return false;
        }

        $this->db->insert($username, md5($password));
    }

    /**
     * Delete user from the database
     * @param $username
     */
    public function deleteUser($username)
    {
        if ($this->userExists($username))
        {
            $this->db->delete($username);
        }
    }

    /**
     * Change user's password
     * @param $username
     * @param $password
     */
    public function changePassword($username, $password)
    {

        // Validate password length
        if (!$this->validatePasswordLength($password)) {
            return false;
        }

        // Check if the user exists first
        if ($this->userExists($username))
        {
            // Update user's password
            $this->db->update($username, $password);
        }
    }

    /**
     * Check if the user exists in the database
     * @param $username
     * @return bool
     */
    public function userExists($username)
    {
        $user = $this->db->get($username);
        return !empty($user); // Check and return $user is not empty
    }

    /**
     * Check if the password is greater than 6 characters
     * @param $password
     * @return bool
     */
    function validatePasswordLength($password)
    {
        if (strlen($password) < 6) {
            return false;
        }

        return true;
    }

}