<?php

class sfCucumberGeneratorScenario extends sfCucumberGeneratorToken
{
  public function render()
  {
    $info = addslashes($this->token->content);
    return <<<EOR

  info('Scenario: $info')->
EOR;
  }
}

