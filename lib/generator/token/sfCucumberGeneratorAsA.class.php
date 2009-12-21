<?php

class sfCucumberGeneratorAsA extends sfCucumberGeneratorToken
{
  public function render()
  {
    $info = addslashes($this->token->content);
    return <<<EOR

  info('As a $info')->
EOR;
  }
}
