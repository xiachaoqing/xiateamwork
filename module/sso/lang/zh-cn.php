<?php
/**
 * The sso module zh-cn file of ZenTaoPMS.
 *

 * @author      Yidong Wang <yidong@cnezsoft.com>
 * @package     sso
 * @version     $Id$
*/
$lang->sso = new stdclass();
$lang->sso->settings = '配置';
$lang->sso->turnon   = '是否打开';
$lang->sso->redirect = '自动跳回然之';
$lang->sso->code     = '代号';
$lang->sso->key      = '密钥';
$lang->sso->addr     = '接口地址';
$lang->sso->bind     = '用户绑定';
$lang->sso->addrNotice = '比如：http://www.ranzhi.com/sys/sso-check.html';

$lang->sso->turnonList = array();
$lang->sso->turnonList[1] = '打开';
$lang->sso->turnonList[0] = '关闭';

$lang->sso->bindType = '绑定方式';
$lang->sso->bindUser = '绑定用户';

$lang->sso->bindTypeList['bind'] = '绑定已有用户';
$lang->sso->bindTypeList['add']  = '添加新用户';

$lang->sso->help = <<<EOD
<p>1、接口地址的填写，如果是PATH_INFO ：http://然之网址/sys/sso-check.html，如果是GET：http://然之网址/sys/index.php?m=sso&f=check</p>
<p>2、代号和密钥必须与然之后台设置的一致。</p>
EOD;
$lang->sso->bindNotice     = '添加的新用户暂时没有权限，需要联系豆包管理员，给该用户分配权限。';
$lang->sso->bindNoPassword = '密码不能为空';
$lang->sso->bindNoUser     = '该用户的登录密码错误，或该用户不存在！';
$lang->sso->bindHasAccount = '该用户名已经存在，请更换用户名，或直接绑定到该用户。';
