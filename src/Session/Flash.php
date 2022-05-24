<?php

namespace Src\Session;

/**
 * Http session class
 */
class Flash
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
	public static function set(string $name, array $value = null): void
	{
		$_SESSION[$name] = $value;
	}

	/**
	 * Mengambil flash session
	 * 
	 * @param  string $name
	 * @return mixed
	 */
	public static function get(string $name): mixed
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
