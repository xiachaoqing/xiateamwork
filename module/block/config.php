<?php
/**
 * The config file of block module of ZenTaoPMS.
 *

 * @author      Yidong Wang <yidong@cnezsoft.com>
 * @package     block
 * @version     $Id$
*/
$config->block = new stdclass();
$config->block->version = 2;
$config->block->editor  = new stdclass();
$config->block->editor->set = array('id' => 'html', 'tools' => 'simple');

$config->block->longBlock = array();
$config->block->longBlock['']['flowchart']        = 'flowchart';
$config->block->longBlock['']['welcome']          = 'welcome';
$config->block->longBlock['product']['statistic'] = 'statistic';
$config->block->longBlock['project']['statistic'] = 'statistic';
$config->block->longBlock['qa']['statistic']      = 'statistic';

$config->block->shortBlock = array();
$config->block->shortBlock['product']['overview'] = 'overview';
$config->block->shortBlock['project']['overview'] = 'overview';

$config->statistic = new stdclass();
$config->statistic->storyStages = array('wait', 'planned', 'developing', 'testing', 'released');
