<?php
global $app;
helper::cd($app->getBasePath());
helper::import('module/my/model.php');
helper::cd();
class extmyModel extends myModel 
{
public function setMenu()
{
$this->loadExtension('effort')->setMenu();
    return $this->loadExtension('web')->setMenu();
}
//**//
}