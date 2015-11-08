<?php

function NewUser ($db, $username, $password)
{
	$db->insert ($username, md5($password));
}

function DeleteUser ($db, $username)
{
	if (UserExists($db, $username))
	{
		$db->delete ($username);
	}
}

function ChangePassword ($db, $username, $password)
{
	$db->update ($username, $password);
}

function UserExists ($db, $username)
{
	$user = $db->get($username);
	return !empty($user);
}
