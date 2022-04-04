<?php
/**
 * The group module zh-tw file of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2015 青島易軟天創網絡科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL (http://zpl.pub/page/zplv12.html)
 * @author      XCQ
 * @package     group
 * @version     $Id: zh-tw.php 4719 2013-05-03 02:20:28Z 631753810@qq.com $
*/
$lang->group->common             = '權限分組';
$lang->group->browse             = '瀏覽分組';
$lang->group->create             = '新增分組';
$lang->group->edit               = '編輯分組';
$lang->group->copy               = '複製分組';
$lang->group->delete             = '刪除分組';
$lang->group->manageView         = '視圖維護';
$lang->group->managePriv         = '權限維護';
$lang->group->managePrivByGroup  = '權限維護';
$lang->group->managePrivByModule = '按模組分配權限';
$lang->group->byModuleTips       = '<span class="tips">（可以按住Shift或者Ctrl鍵進行多選）</span>';
$lang->group->manageMember       = '成員維護';
$lang->group->confirmDelete      = '您確定刪除該用戶分組嗎？';
$lang->group->successSaved       = '成功保存';
$lang->group->errorNotSaved      = '沒有保存，請確認選擇了權限數據。';
$lang->group->viewList           = '允許訪問視圖';
$lang->group->productList        = '允許訪問' . $lang->productCommon;
$lang->group->projectList        = '允許訪問' . $lang->projectCommon;
$lang->group->noticeVisit        = '空代表訪問沒有訪問限制';

$lang->group->id       = '編號';
$lang->group->name     = '分組名稱';
$lang->group->desc     = '分組描述';
$lang->group->role     = '角色';
$lang->group->acl      = '權限';
$lang->group->users    = '用戶列表';
$lang->group->module   = '模組';
$lang->group->method   = '方法';
$lang->group->priv     = '權限';
$lang->group->option   = '選項';
$lang->group->inside   = '組內用戶';
$lang->group->outside  = '組外用戶';
$lang->group->other    = '其他模組';
$lang->group->all      = '所有權限';

$lang->group->copyOptions['copyPriv'] = '複製權限';
$lang->group->copyOptions['copyUser'] = '複製用戶';

$lang->group->versions['']          = '修改歷史';

include (dirname(__FILE__) . '/resource.php');
