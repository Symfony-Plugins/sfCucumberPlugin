<?php

class sfCucumberToken
{
  public $token, $content;

  public function __construct($token, $content)
  {
    $this->token   = $token;
    $this->content = $content;
  }
}
