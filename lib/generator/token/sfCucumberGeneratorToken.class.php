<?php

abstract class sfCucumberGeneratorToken
{
  protected
    $token   = null,
    $routing = null;

  public function __construct($token, sfPatternRouting $routing)
  {
    $this->token   = $token;
    $this->routing = $routing;
  }

  abstract public function render();


  protected function exportArray($data)
  {
    foreach($data as $k => $v)
    {
      $data[$k] = $this->export($v);
    }

    return $data;
  }

  protected function export($data)
  {
    if (is_array($data))
    {
      $tmp = array();
      foreach($data as $k => $v)
      {
        $k = strtr(strtolower($k), array(' ' => '_'));
        $tmp[$k] = $v;
      }
      $data = $tmp;
    }
    $data = var_export($data, true);
    return $data;
  }
}
