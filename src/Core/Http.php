<?php

namespace Src\Core;

use Src\Session\Flash;

/**
 * Core Http class
 */
class Http
{
  private ?string $redirect = null;

  /**
   * @param string|null $to
   * @param array $params
   */
  public function __construct(?string $to = null, array $params = [])
  {
    if (!is_null($to)) {
      $this->redirect = url($to, $params);
    }
  }

  /**
   * Redirect to route
   * 
   * @param string|null $to
   * @param array $params
   * 
   * @return Http
   */
  public function route(string $to = null, array $params = []): Http
  {
    if (!is_null($to)) {
      return toRoute($to, $params);
    }

    return $this;
  }

  /**
   * Redirect dengan flash session
   * 
   * @param string $name
   * @param array|null $value
   * 
   * @return Http
   */
  public function withFlash(string $name, array $value = null): Http
  {
    Flash::set($name, $value);
    return $this;
  }

  /**
   * Redirect with old flash session
   * 
   * @param array $values
   * 
   * @return Http
   */
  public function withOldInput(array $values): Http
  {
    Flash::set('old', $values);
    return $this;
  }

  /**
   * Redirect halaman jika properti $redirect tidak null
   */
  public function __destruct()
  {
    if (!is_null($this->redirect)) {
      header('Location: ' . $this->redirect);
      exit;
    }
  }
}
