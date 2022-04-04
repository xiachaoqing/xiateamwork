<?php
/**
 * The main view file of block module of ZentaoPMS.
 *

 * @author      Yidong Wang <yidong@cnezsoft.com>
 * @package     block
 * @version     $Id$
 * @link        http://www.zentao.pms*/
$viewDir      = dirname(__FILE__);
$file2Include = file_exists(dirname($viewDir) . "/ext/view/{$code}block.html.php") ? dirname($viewDir) . "/ext/view/{$code}block.html.php" : "{$viewDir}/{$code}block.html.php";
include $file2Include;
?>
