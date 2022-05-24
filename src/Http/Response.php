<?php

namespace Src\Http;

use Src\Core\Http;

/**
 * Http Response class
 */
class Response
{
  /**
   * Http Redirect
   * 
   * @param string|null $to
   * @param array $params
   * 
   * @return Http
   */
  public static function redirect(string $to, array $params = []): Http
  {
    return new Http($to, $params);
  }

  /**
   * Http redirect to route
   * 
   * @param string|null $route
   * @param array $params
   * 
   * @return http
   */
  public static function toRoute(string $route, array $params = []): http
  {
    $params['route'] = $route;

    return new Http('/', $params);
  }
}
