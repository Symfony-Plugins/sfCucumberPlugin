<?php

class sfCucumberGenerateTask extends sfBaseTask
{
  public function configure()
  {
    $this->addOption('application', null, sfCommandOption::PARAMETER_REQUIRED, 'The application', 'frontend');

    $this->namespace = 'cucumber';
    $this->name = 'generate';
  }

  public function execute($arguments = array(), $options = array())
  {
    $this->application = $options['application'];

    $features = glob(sfConfig::get('sf_root_dir').'/features/*.feature');

    foreach($features as $feature)
    {
      $this->doGenerate($feature);
    }
  }

  protected function doGenerate($file)
  {
    $this->logSection('cucumber', 'processing '.$file);

    $tokens = sfCucumberParser::parse(file_get_contents($file));

    $code = '';

    foreach($tokens as $token)
    {
      $generator = sfCucumberGenerator::getGenerator($token, $this->getRouting());

      $code .= $generator->render();
    }

    $dest_file = sfConfig::get('sf_test_dir').'/functional/'.$this->application.'/'.basename($file).'.php';
    file_put_contents($dest_file, $code);
  }
}
