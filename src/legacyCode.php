<?php

/**
 * Create new user in the database
 * @param $db
 * @param $username
 * @param $password
 * @return bool
 */
function NewUser ($db, $username, $password)
{
	// Validate password length
	if (!validatePasswordLength($password)) {
		return false;
	}

	$db->insert ($username, md5($password));
}

/**
 * Delete user from the database
 * @param $db
 * @param $username
 */
function DeleteUser ($db, $username)
{
	if (UserExists($db, $username))
	{
		$db->delete ($username);
	}
}

/**
 * Change user password
 * @param $db
 * @param $username
 * @param $password
 * @return bool
 */
function ChangePassword ($db, $username, $password)
{
	// Validate password length
	if (!validatePasswordLength($password)) {
		return false;
	}

	// Check if the user exists first
    $user = UserExists($db, $username);

	if ($user)
	{
		$db->update($username, $password);
	}

}

/**
 * Check if the user exists in the database
 * @param $db
 * @param $username
 * @return bool
 */
function UserExists ($db, $username)
{
	$user = $db->get($username);
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
