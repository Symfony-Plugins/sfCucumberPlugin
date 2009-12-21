<?php

class sfCucumberGenerator
{
  static public function getGenerator(sfCucumberToken $token, sfPatternRouting $routing)
  {
    $className = substr($token->token, 2);
    $className = strtolower($className);
    $className = preg_replace_callback('/([a-z])_([a-z])/', function($m) { return $m[1].strtoupper($m[2]); }, $className);
    $className = ucfirst($className);
    $className = 'sfCucumberGenerator'.$className;

    if (!class_exists($className))
    {
      throw new RuntimeException(sprintf('Generator class "%s" not found', $className));
    }

    return new $className($token, $routing);
  }
}
