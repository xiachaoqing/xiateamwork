<?php
/**
 * The upgrade module English file of ZenTaoPMS.
 *
 * @author      XCQ
 * @package     upgrade
 * @version     $Id: en.php 5119 2019-03-11 08:06:42Z wyd621@gmail.com $
*/
$lang->upgrade->common  = 'Update';
$lang->upgrade->result  = 'Result';
$lang->upgrade->fail    = 'Failed';
$lang->upgrade->success = 'Updated';
$lang->upgrade->tohome  = 'Visit ZenTao';
$lang->upgrade->license = 'ZenTao is under Z PUBLIC LICENSE(ZPL) 1.2.';
$lang->upgrade->warnning= 'Warning!';
$lang->upgrade->checkExtension  = 'Check Extension';
$lang->upgrade->consistency     = 'Check Consistency';
$lang->upgrade->warnningContent = <<<EOT
<p>Please backup your database before updating ZenTao!</p>
<pre>
1. Use phpMyAdmin to backup.
2. Use mysqlCommand to backup.
   $> mysqldump -u <span class='text-danger'>username</span> -p <span class='text-danger'>dbname</span> > <span class='text-danger'>filename</span> 
   Change the red text into corresponding Username and Database name.
   e.g. mysqldump -u root -p zentao >zentao.bak
</pre>
EOT;
$lang->upgrade->createFileWinCMD   = 'Open command line and execute <strong style="color:#ed980f">echo > %s</strong>';
$lang->upgrade->createFileLinuxCMD = 'Execute command line: <strong style="color:#ed980f">touch %s</strong>';
$lang->upgrade->setStatusFile      = '<h4>Please finish the following actions</h4>
                                      <ul style="line-height:1.5;font-size:13px;">
                                      <li>%s</li>
                                      <li>Or delete "<strong style="color:#ed980f">%s</strong>" and create <strong style="color:#ed980f">ok.txt</strong> and leave it blank.</li>
                                      </ul>
                                      <p><strong style="color:red">I have read and done as instructed above. <a href="upgrade.php">Continue upgrading.</a></strong></p>';
$lang->upgrade->selectVersion = 'Version';
$lang->upgrade->continue      = 'Continue';
$lang->upgrade->noteVersion   = "Select the compatible version, or it might cause data loss.";
$lang->upgrade->fromVersion   = 'From';
$lang->upgrade->toVersion     = 'To';
$lang->upgrade->confirm       = 'Confirm SQL';
$lang->upgrade->sureExecute   = 'Execute';
$lang->upgrade->forbiddenExt  = 'Extension is not compatible with the version. It has been deactivated:';
$lang->upgrade->updateFile    = 'File information has to be updated.';
$lang->upgrade->noticeSQL     = 'Check that your database is inconsistent with the standard and try to fix failure. Please perform the following SQL and refresh.';
$lang->upgrade->afterDeleted  = 'File is not deleted. Please refresh after you delete it.';

include dirname(__FILE__) . '/version.php';
