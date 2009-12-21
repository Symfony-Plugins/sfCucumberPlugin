<?php

class sfCucumberGeneratorInOrderTo extends sfCucumberGeneratorToken
{
  public function render()
  {
    $info = addslashes($this->token->content);
    return <<<EOR

  info('In order to $info')->
EOR;
  }
}
