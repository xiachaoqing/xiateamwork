<?php
global $app;
helper::cd($app->getBasePath());
helper::import('module/chat/model.php');
helper::cd();
class extchatModel extends chatModel 
{
public function getExtensionList($userID)
{
    return $this->loadExtension('xuanxuan')->getExtensionList($userID);
}

public function editUser($user = null)
{
    return $this->loadExtension('xuanxuan')->editUser($user);
}

public function getServer($backend = 'xxb')
{
    return $this->loadExtension('xuanxuan')->getServer($backend);
}
//**//
}