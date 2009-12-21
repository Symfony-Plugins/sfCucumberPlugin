<?php

class sfCucumberGeneratorWhen extends sfCucumberGeneratorToken
{
  static protected $dataStack = array();

  public function render()
  {
    $content = $this->token->content;

    if (preg_match('/I follow the "(.*)" link/', $content, $matches))
    {
      return $this->doClick($matches[1]);
    }
    elseif (preg_match('/I fill "([^"]+)" with "([^"]+)"/', $content, $matches))
    {
      self::$dataStack[$matches[1]] = $matches[2];
      return '';
    }
    elseif (preg_match('/I press "(.*)"/', $content, $matches))
    {
      $data = self::$dataStack;
      self::$dataStack = array();

      return $this->doClick($matches[1], $data);
    }

    throw new RuntimeException(sprintf('Could not handle Then clause "%s"', $this->token->content));
  }

  protected function doClick($label, $data = array())
  {
    if (empty($data))
    {
      return <<<EOR


  click('$label')->
EOR;
    }
    else
    {
      $data = $this->export($data);
      return <<<EOR


  click('$label', $data)->
EOR;
    }
  }
}
