<?php

use Src\Session\Flash;

if (!function_exists('arrayToObject')) {

  /**
   * Merubah array menjadi object
   * 
   * @param mixed $array
   * 
   * @return mixed
   */
  function arrayToObject(mixed $array): mixed
  {
    if (is_array($array)) {
      return (object) array_map(__FUNCTION__, $array);
    }

    return trim($array);
  }
}

if (!function_exists('config')) {

  /**
   * Mengambil nilai pada konfigurasi
   * 
   * @param string $key [Gunakan tanda . atau / sebagai pemisah antara file dan key]
   * @param mixed|null $default
   * 
   * @return mixed
   */
  function config(string $key, mixed $default = null): mixed
  {
    $keys = trim($key, '/');
    $keys = str_replace('.', '/', $keys);
    $keys = explode('/', $keys);

    $config = require __DIR__ . "/../config/{$keys[0]}.php";
    unset($keys[0]);

    if ($config[$keys[1]]) return $config[$keys[1]];

    return $default;
  }
}

if (!function_exists('view')) {

  /**
   * Mengambil view
   * Lokasi file relatif terhadap folder /views
   * 
   * @param string $view
   * @param array $data
   * 
   * @return void
   */
  function view(string $view, array $data = []): mixed
  {
    $viewPath = str_replace('.', '/', $view);

    extract($data);

    return require __DIR__ . "/../views/{$viewPath}.php";
  }
}

if (!function_exists('layout')) {

  /**
   * Mengambil view layout
   * Lokasi file layouts relatif terhadap folder /views/layouts/*
   * 
   * @param string $layout
   * @param string $content
   * @param array $data
   * 
   * @return void
   */
  function layout(string $view, string $content, array $data = []): mixed
  {
    $data['content'] = str_replace('.', '/', $content);

    return view($view, $data);
  }
}

if (!function_exists('route')) {

  /**
   * Membuat full route url
   * 
   * @param string $path
   * @param array $params
   * 
   * @return string
   */
  function route(string $path, array $params = []): string
  {
    $baseUrl = config('app.url');
    $baseUrl = trim($baseUrl, '/');
    $baseUrl .= '/?route=' . trim($path, '/');

    if (count($params) > 0) {
      foreach ($params as $key => $value) {
        $baseUrl .= "&{$key}={$value}";
      }
    }

    return $baseUrl;
  }
}

if (!function_exists('isRoute')) {

  /**
   * Cek apakah route sesuai dengan yang di request atau tidak
   * 
   * @param string $path
   * @param string|null $default
   * 
   * @return bool
   */
  function isRoute(string $path, ?string $default = null): bool
  {
    $route = $_GET['route'] ?? '/';
    $path = trim($path, '/');

    if ($route != $path && !empty($default)) {
      return $route === $default;
    }

    return $route === $path;
  }
}

if (!function_exists('toRoute')) {

  /**
   * Helper redirect to route.
   * 
   * @param  string $route
   * @param  array  $params
   * 
   * @return void
   */
  function toRoute(string $route, array $params = []): void
  {
    header('Location: ' . route($route, $params));
    exit();
  }
}

if (!function_exists('url')) {

  /**
   * Membuat full url
   * 
   * @param string $path
   * 
   * @return string
   */
  function url(string $path, array $params = []): string
  {
    $configUrl = trim(config('app.url'), '/');
    $path = trim(trim($path), '/');
    $url = $configUrl . '/' . $path;

    // Cek params
    if (count($params) > 0) {
      $url .= '?';

      // Set query string
      foreach ($params as $key => $value) {
        $url .= "{$key}={$value}";

        if (array_key_last($params) !== $key) {
          $url .= "&";
        }
      }
    }

    return trim($url);
  }
}

if (!function_exists('e')) {

  /**
   * Clear print
   * 
   * @param mixed $value
   * @param string|null $character
   * 
   * @return string|int
   */
  function e(mixed $value, ?string $character = null): string|int
  {
    if (!is_null($character)) {
      $value = trim($value, $character);
    } else {
      $value = trim($value);
    }

    return htmlspecialchars($value);
  }
}

if (!function_exists('old')) {

  /**
   * Mengampil value lama | old value
   * 
   * @param string $name
   * @param string|null $default
   * 
   * @return string|null
   */
  function old(string $name, ?string $default = null): ?string
  {
    if (!Flash::get('old')) {
      return $default;
    }

    $old = $default;

    foreach (Flash::get('old') as $key => $value) {
      if ($key == $name) {
        $old = $value;
      }
    }

    return $old;
  }
}

if (!function_exists('error')) {

  /**
   * Mengampil data error pada session flash
   * 
   * @param string|null $name
   * 
   * @return mixed
   */
  function errors(?string $name = null): mixed
  {
    if (!Flash::get('errors')) {
      return null;
    }

    if (empty($name)) {
      return Flash::get('errors');
    }

    $error = null;
    foreach (Flash::get('errors') as $key => $value) {
      if ($key == $name) {
        $error = $value;
      }
    }

    return $error;
  }
}

if(!function_exists('dd')) {

  /**
   * var_dump & die
   * 
   * @param  mixed $data
   * @return void
   */
  function dd(mixed $data): void
  {
    var_dump($data);
    die();
  }
}
