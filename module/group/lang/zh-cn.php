<?php
/**
 * The group module zh-cn file of ZenTaoPMS.
 *
 * @author      XCQ
 * @package     group
 * @version     $Id: zh-cn.php 4719 2013-05-03 02:20:28Z 631753810@qq.com $
*/
$lang->group->common             = '权限分组';
$lang->group->browse             = '浏览分组';
$lang->group->create             = '新增分组';
$lang->group->edit               = '编辑分组';
$lang->group->copy               = '复制分组';
$lang->group->delete             = '删除分组';
$lang->group->manageView         = '视图维护';
$lang->group->managePriv         = '权限维护';
$lang->group->managePrivByGroup  = '权限维护';
$lang->group->managePrivByModule = '按模块分配权限';
$lang->group->byModuleTips       = '<span class="tips">（可以按住Shift或者Ctrl键进行多选）</span>';
$lang->group->manageMember       = '成员维护';
$lang->group->confirmDelete      = '您确定删除该用户分组吗？';
$lang->group->successSaved       = '成功保存';
$lang->group->errorNotSaved      = '没有保存，请确认选择了权限数据。';
$lang->group->viewList           = '允许访问视图';
$lang->group->productList        = '允许访问' . $lang->productCommon;
$lang->group->projectList        = '允许访问' . $lang->projectCommon;
$lang->group->noticeVisit        = '空代表访问没有访问限制';

$lang->group->id       = '编号';
$lang->group->name     = '分组名称';
$lang->group->desc     = '分组描述';
$lang->group->role     = '角色';
$lang->group->acl      = '权限';
$lang->group->users    = '用户列表';
$lang->group->module   = '模块';
$lang->group->method   = '方法';
$lang->group->priv     = '权限';
$lang->group->option   = '选项';
$lang->group->inside   = '组内用户';
$lang->group->outside  = '组外用户';
$lang->group->other    = '其他模块';
$lang->group->all      = '所有权限';

$lang->group->copyOptions['copyPriv'] = '复制权限';
$lang->group->copyOptions['copyUser'] = '复制用户';

$lang->group->versions['']          = '修改历史';

include (dirname(__FILE__) . '/resource.php');
