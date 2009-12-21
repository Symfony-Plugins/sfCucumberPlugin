<?php

class sfCucumberGeneratorThen extends sfCucumberGeneratorToken
{
  public function render()
  {
    $content = $this->token->content;

    if (preg_match('/I should see "([^"]+)"/', $content, $matches))
    {
      return $this->doResponseContains($matches[1]);
    }
    elseif (preg_match('/I should see in the title "([^"]+)"/', $content, $matches))
    {
      return $this->doCheckElement('h2', $matches[1]);
    }
    elseif (preg_match('/I should not see "([^"]+)" in the list anymore/', $content, $matches))
    {
      return $this->doResponseContains('!'.$matches[1]);
    }

    throw new RuntimeException(sprintf('Could not handle Then clause "%s"', $content));
  }

  protected function doCheckElement($element, $string)
  {
    $string  = $this->export($string);
    $element = $this->export($element);

    return <<<EOR
  

  with('response')->begin()->
    checkElement($element, $string)->
  end()->
EOR;
  }

  protected function doResponseContains($string)
  {
    $string = $this->export($string);
    return <<<EOR


  with('response')->begin()->
    contains($string)->
  end()->
EOR;
  }
}
