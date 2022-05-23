<?php

namespace Src\Http;

/**
 * Http session class
 */
class Session
{
	protected static $values;

	/**
	 * Membuat session flash
	 * 
	 * @param  string $name]
	 * @param  mixed $data
	 * 
	 * @return void
	 */
	public static function flash(string $name, array $data = null): void
	{
		$_SESSION[$name] = $data;
	}

	/**
	 * Cek apakan ada session flash atau tidak.
	 * 
	 * @param  string $name
	 * 
	 * @return boolean
	 */
	public static function isFlash(string $name): bool
	{
		if (isset($_SESSION[$name]) && !empty($_SESSION[$name])) {
			return true;
		}

		return false;
	}

	/**
	 * Mengambil flash session
	 * 
	 * @param  string $name
	 * @return void
	 */
	public static function getFlash(string $name): mixed
	{
		if (isset($_SESSION[$name])) {
			self::$values = $_SESSION[$name];
			
			if(is_array($_SESSION[$name])) {
				self::$values = arrayToObject($_SESSION[$name]);
			}

			unset($_SESSION[$name]);
		}

		return self::$values;
	}
}