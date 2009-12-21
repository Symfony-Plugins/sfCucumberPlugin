<?php

class sfCucumberGeneratorFeature extends sfCucumberGeneratorToken
{
  public function render()
  {
    return <<<EOR
<?php

include(dirname(__FILE__).'/../../bootstrap/functional.php');

\$browser = new sfTestFunctional(new sfBrowser());

\$browser->
EOR;
  }
}
