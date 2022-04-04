<?php
global $app;
helper::cd($app->getBasePath());
helper::import('module/story/model.php');
helper::cd();
class extstoryModel extends storyModel 
{
/**
 * The model file of calendar module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2012 青岛易软天创网络科技有限公司 (QingDao Nature Easy Soft Network Technology Co,LTD www.cnezsoft.com)
 * @license     business(商业软件) 
 * @author      Memory <lvtao@cnezsoft.com>
 * @package     calendar 
 * @version     $Id$
*/
public function getUserStoryPairs($account = '', $limit = 0)
{
    return $this->loadExtension('calendar')->getUserStoryPairs($account, $limit);
}public function setListValue($productID, $branch = 0)
{
    return $this->loadExtension('excel')->setListValue($productID, $branch);
}

public function createFromImport($productID, $branch = 0)
{
    return $this->loadExtension('excel')->createFromImport($productID, $branch);
}
//**//
}