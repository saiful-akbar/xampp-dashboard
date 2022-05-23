<?php

namespace Src\Http;

/**
 * Http session class
 */
class Session
{

	/**
	 * Value untuk flash session
	 * 
	 * @var array
	 */
	protected static array $flashValues = [];

	/**
	 * Membuat session flash
	 * 
	 * @param  string $name
	 * @param  mixed $data
	 * 
	 * @return void
	 */
	public static function flash(string $name, array $value = null): void
	{
		$_SESSION[$name] = $value;
	}

	/**
	 * Mengambil flash session
	 * 
	 * @param  string $name
	 * @return mixed
	 */
	public static function getFlash(string $name): mixed
	{
		if (isset($_SESSION[$name])) {
			self::$flashValues[$name] = $_SESSION[$name];

			if (is_array($_SESSION[$name])) {
				self::$flashValues[$name] = arrayToObject($_SESSION[$name]);
			}

			unset($_SESSION[$name]);
		}

		if (array_key_exists($name, self::$flashValues)) {
			return self::$flashValues[$name];
		}

		return null;
	}
}
