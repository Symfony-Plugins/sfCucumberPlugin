<?php

class sfCucumberGeneratorIWantTo extends sfCucumberGeneratorToken
{
  public function render()
  {
    $info = addslashes($this->token->content);
    return <<<EOR

  info('I want to $info')->
EOR;
  }
}
