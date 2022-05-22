<?php

namespace Src\Views;

/**
 * Views header class
 */
class Header
{
  /**
   * Render view html
   * 
   * @param array $data
   * 
   * @return mixed
   */
  public static function render(array $data = []): mixed
  {
    return view('components/header', $data);
  }
}
