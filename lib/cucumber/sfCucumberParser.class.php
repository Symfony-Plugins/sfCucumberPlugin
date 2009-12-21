<?php

class sfCucumberParser implements Iterator
{
  const
    T_FEATURE     = 'T_FEATURE',
    T_IN_ORDER_TO = 'T_IN_ORDER_TO',
    T_AS_A        = 'T_AS_A',
    T_I_WANT_TO   = 'T_I_WANT_TO',
    T_SCENARIO    = 'T_SCENARIO',
    T_GIVEN       = 'T_GIVEN',
    T_WHEN        = 'T_WHEN',
    T_THEN        = 'T_THEN',
    T_AND         = 'T_AND'
  ;

  static protected
    $masks  = array(
      self::T_FEATURE     => '/^Feature ?: ?(.*)$/',
      self::T_IN_ORDER_TO => '/^In order to (.*)$/',
      self::T_AS_A        => '/^As a (.*)$/',
      self::T_I_WANT_TO   => '/^I want to (.*)$/',
      self::T_SCENARIO    => '/^Scenario ?: ?(.*)$/',
      self::T_GIVEN       => '/^Given (.*)$/',
      self::T_WHEN        => '/^When (.*)$/',
      self::T_THEN        => '/^Then (.*)$/',
      self::T_AND         => '/^And (.*)$/',
    )
  ;

  static public function parse($source)
  {
    $tokens = array();

    foreach(explode(PHP_EOL, $source) as $line)
    {
      // indentation is not meaningful
      $line = trim($line);

      foreach(self::$masks as $token => $mask)
      {
        if (preg_match($mask, $line, $matches))
        {
          if ($token == self::T_AND)
          {
            $token = $tokens[count($tokens) - 1]->token;
          }

          $tokens[] = new sfCucumberToken($token, $matches[1]);
          break;
        }
      }
    }

    return $tokens;
  }

  public function current()
  {
    return current($this->tokens);
  }

  public function next()
  {
    return next($this->tokens);
  }

  public function key()
  {
    return key($this->tokens);
  }

  public function valid()
  {
    return key($this->tokens) < count($this->tokens);
  }

  public function rewind()
  {
    rewind($this->tokens);
  }
}
