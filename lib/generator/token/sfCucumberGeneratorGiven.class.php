<?php

class sfCucumberGeneratorGiven extends sfCucumberGeneratorToken
{
  public function render()
  {
    $content = $this->token->content;

    if (preg_match('/I am on the (.*) page/', $this->token->content, $matches))
    {
      return $this->doGet($matches[1]);
    }

    throw new RuntimeException(sprintf('Could not handle Given clause "%s"', $this->token->content));
  }

  protected function doGet($route)
  {
    $url        = $this->routing->generate($route);
    $routes     = $this->routing->getRoutes();
    $defaults   = $routes[$route]->getDefaults();

    $string = <<<EOR


  get(%url%)->

  with('request')->begin()->
    checkParameter('module', %module%)->
    checkParameter('action', %action%)->
  end()->

  with('response')->begin()->
    isStatusCode(200)->
  end()->
EOR;
  
    return strtr($string, $this->exportArray(array(
      '%url%'    => $url,
      '%module%' => $defaults['module'],
      '%action%' => $defaults['action'],
    )));
  }
}


