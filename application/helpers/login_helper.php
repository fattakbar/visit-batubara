<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('get_hash')) {

	function get_hash($plain_password)
	{
		$option = ['cost' => 5,];

		return password_hash($plain_password, PASSWORD_DEFAULT, $option);
	}
}

if (!function_exists('hash_verified')) {

	function hash_verified($plain_password, $hash_password)
	{
		return password_verify($plain_password, $hash_password) ? true : false;
	}
}
