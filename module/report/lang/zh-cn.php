<?php
/**
 * The report module zh-cn file of ZenTaoPMS.
 *
 * @author      XCQ
 * @package     report
 * @version     $Id: zh-cn.php 5080 2013-07-10 00:46:59Z wyd621@gmail.com $
*/
$lang->report->common     = '统计视图';
$lang->report->index      = '统计首页';
$lang->report->list       = '统计报表';
$lang->report->item       = '条目';
$lang->report->value      = '值';
$lang->report->percent    = '百分比';
$lang->report->undefined  = '未设定';
$lang->report->query      = '查询';

//产品线周报统计
$lang->report->prolist      = '产品线';
$lang->report->protitle     = '产品';
$lang->report->personnel     = '人员';
$lang->report->export      = "导出数据";
$lang->report->create = '生成报表';



$lang->report->colors[]   = 'AFD8F8';
$lang->report->colors[]   = 'F6BD0F';
$lang->report->colors[]   = '8BBA00';
$lang->report->colors[]   = 'FF8E46';
$lang->report->colors[]   = '008E8E';
$lang->report->colors[]   = 'D64646';
$lang->report->colors[]   = '8E468E';
$lang->report->colors[]   = '588526';
$lang->report->colors[]   = 'B3AA00';
$lang->report->colors[]   = '008ED6';
$lang->report->colors[]   = '9D080D';
$lang->report->colors[]   = 'A186BE';

$lang->report->assign['noassign'] = '未指派';
$lang->report->assign['assign'] = '已指派';

$lang->report->format['table'] = '表格';
$lang->report->format['wiki'] = 'wiki';

$lang->report->singleColor[] = 'F6BD0F';

$lang->report->projectDeviation = $lang->projectCommon . '偏差报表';
$lang->report->productSummary   = $lang->productCommon . '汇总表';
$lang->report->bugCreate        = 'Bug创建表';
$lang->report->bugAssign        = 'Bug指派表';
$lang->report->workload         = '员工负载表';
$lang->report->taskTime         = '人员任务表';
$lang->report->productTime      ='产品线周报统计';
$lang->report->financeTime      = '财务人力统计';
$lang->report->taskload         = '员工任务负载表';
$lang->report->workloadAB       = '工作负载';
$lang->report->bugOpenedDate    = 'Bug创建时间';
$lang->report->beginAndEnd      = '起止时间';
$lang->report->dept             = '部门';
$lang->report->deviationChart   = $lang->projectCommon . '偏差曲线';

$lang->reportList->project->lists[10] = $lang->projectCommon . '偏差报表|report|projectdeviation';
$lang->reportList->product->lists[10] = '产品线周报统计|report|producttime';
$lang->reportList->product->lists[13] = '财务人力统计|report|financetime';
$lang->reportList->product->lists[14] = $lang->productCommon . '汇总表|report|productsummary';
$lang->reportList->test->lists[10]    = 'Bug创建表|report|bugcreate';
$lang->reportList->test->lists[13]    = 'Bug指派表|report|bugassign';
// $lang->reportList->staff->lists[13]   = '员工负载表|report|workload';
$lang->reportList->staff->lists[10]   = '人员任务表|report|tasktime';
// $lang->reportList->staff->lists[11]   = '产品线周报统计|report|taskproduct';
$lang->reportList->staff->lists[13]   = '员工任务负载表|report|taskload';
$lang->report->id            = '编号';
$lang->report->project       = $lang->projectCommon;
$lang->report->product       = $lang->productCommon;
$lang->report->user          = '姓名';
$lang->report->bugTotal      = 'Bug';
$lang->report->task          = '任务数';

$lang->report->view         = '用户列表视图';
$lang->report->todo           = '用户日程';
$lang->report->story          = '用户需求';
$lang->report->bug            = '用户bug';
$lang->report->testTask       = '用户测试';
$lang->report->testCase       = '用户测试用例';
$lang->report->project        = '用户项目';
$lang->report->dynamic        = '用户动态';

$lang->report->estimate      = '总预计';
$lang->report->consumed      = '总消耗';
$lang->report->left          = '总剩余';
$lang->report->remain        = '剩余工时';
$lang->report->usetime       = '消耗工时';
$lang->report->deviation     = '偏差';
$lang->report->deviationRate = '偏差率';
$lang->report->total         = '总计';
$lang->report->to            = '至';
$lang->report->taskTotal     = "总任务数";
$lang->report->manhourTotal  = "总工时";
$lang->report->validRate     = "有效率";
$lang->report->validRateTips = "方案为已解决或延期/状态为已解决或已关闭";
$lang->report->unplanned     = '未计划';
$lang->report->workday       = '每天工时';
$lang->report->diffDays      = '工作日天数';

$lang->report->typeList['default'] = '默认';
$lang->report->typeList['pie']     = '饼图';
$lang->report->typeList['bar']     = '柱状图';
$lang->report->typeList['line']    = '折线图';

$lang->report->conditions    = '筛选条件：';
$lang->report->closedProduct = '关闭' . $lang->productCommon;
$lang->report->overduePlan   = '过期计划';

/* daily reminder. */
$lang->report->idAB         = 'ID';
$lang->report->bugTitle     = 'Bug标题';
$lang->report->taskName     = '任务名称';
$lang->report->todoName     = '待办名称';
$lang->report->testTaskName = '版本名称';
$lang->report->deadline     = '截止日期';

$lang->report->mailTitle           = new stdclass();
$lang->report->mailTitle->begin    = '提醒：您有';
$lang->report->mailTitle->bug      = " Bug(%s),";
$lang->report->mailTitle->task     = " 任务(%s),";
$lang->report->mailTitle->todo     = " 待办(%s),";
$lang->report->mailTitle->testTask = " 测试版本(%s),";

$lang->report->proVersion = '<a href="https://api.zentao.net/goto.php?item=proversion&from=reportpage" target="_blank">更多精彩，尽在专业版！</a>';
$lang->report->proVersionEn = '<a href="http://api.zentao.pm/goto.php?item=proversion&from=reportpage" target="_blank">Try ZenTao Pro for more!</a>';
$lang->user->common           = '用户';
$lang->user->id               = '用户编号';
$lang->user->company          = '所属公司';
$lang->user->dept             = '所属部门';
$lang->user->account          = '用户名';
$lang->user->password         = '密码';
$lang->user->password2        = '请重复密码';
$lang->user->role             = '职位';
$lang->user->group            = '分组';
$lang->user->realname         = '真实姓名';
$lang->user->nickname         = '昵称';
$lang->user->commiter         = '源代码帐号';
$lang->user->birthyear        = '出生年';
$lang->user->gender           = '性别';
$lang->user->email            = '邮箱';
$lang->user->basicInfo        = '基本信息';
$lang->user->accountInfo      = '帐号信息';
$lang->user->verify           = '安全验证';
$lang->user->contactInfo      = '联系信息';
$lang->user->skype            = 'Skype';
$lang->user->qq               = 'QQ';
$lang->user->mobile           = '手机';
$lang->user->phone            = '电话';
$lang->user->weixin           = '微信';
$lang->user->dingding         = '钉钉';
$lang->user->slack            = 'Slack';
$lang->user->whatsapp         = 'WhatsApp';
$lang->user->address          = '通讯地址';
$lang->user->zipcode          = '邮编';
$lang->user->join             = '入职日期';
$lang->user->visits           = '访问次数';
$lang->user->ip               = '最后IP';
$lang->user->last             = '最后登录';
$lang->user->ranzhi           = '然之帐号';
$lang->user->ditto            = '同上';
$lang->user->originalPassword = '原密码';
$lang->user->verifyPassword   = '您的系统登录密码';
$lang->user->resetPassword    = '忘记密码';

$lang->user->index           = "用户视图首页";
$lang->user->view            = "用户详情";
$lang->user->create          = "添加用户";
$lang->user->batchCreate     = "批量添加用户";
$lang->user->edit            = "编辑用户";
$lang->user->batchEdit       = "批量编辑";
$lang->user->unlock          = "解锁用户";
$lang->user->delete          = "删除用户";
$lang->user->unbind          = "解除然之绑定";
$lang->user->login           = "用户登录";
$lang->user->mobileLogin     = "手机访问";
$lang->user->editProfile     = "修改档案";
$lang->user->deny            = "访问受限";
$lang->user->confirmDelete   = "您确定删除该用户吗？";
$lang->user->confirmUnlock   = "您确定解除该用户的锁定状态吗？";
$lang->user->confirmUnbind   = "您确定解除该用户跟然之的绑定吗？";
$lang->user->relogin         = "重新登录";
$lang->user->asGuest         = "游客访问";
$lang->user->goback          = "返回前一页";
$lang->user->deleted         = '(已删除)';
$lang->user->search          = '搜索';

$lang->user->profile     = '档案';
$lang->user->project     = $lang->projectCommon;
$lang->user->task        = '任务';
$lang->user->bug         = 'Bug';
$lang->user->test        = '测试';
$lang->user->testTask    = '测试任务';
$lang->user->testCase    = '测试用例';
$lang->user->schedule    = '日程';
$lang->user->todo        = '待办';
$lang->user->story       = '需求';
$lang->user->dynamic     = '动态';

$lang->user->openedBy    = '由他创建';
$lang->user->assignedTo  = '指派给他';
$lang->user->finishedBy  = '由他完成';
$lang->user->resolvedBy  = '由他解决';
$lang->user->closedBy    = '由他关闭';
$lang->user->reviewedBy  = '由他评审';
$lang->user->canceledBy  = '由他取消';

$lang->user->testTask2Him = '负责版本';
$lang->user->case2Him     = '给他的用例';
$lang->user->caseByHim    = '他建的用例';

$lang->user->errorDeny    = "抱歉，您无权访问『<b>%s</b>』模块的『<b>%s</b>』功能。请联系管理员获取权限。点击后退返回上页。";
$lang->user->loginFailed  = "登录失败，请检查您的用户名或密码是否填写正确。";
$lang->user->lockWarning  = "您还有%s次尝试机会。";
$lang->user->loginLocked  = "密码尝试次数太多，请联系管理员解锁，或%s分钟后重试。";
$lang->user->weakPassword = "您的密码强度小于系统设定。";

$lang->user->roleList['']       = '';
$lang->user->roleList['dev']    = '研发';
$lang->user->roleList['qa']     = '测试';
$lang->user->roleList['pm']     = '项目经理';
$lang->user->roleList['po']     = '产品经理';
$lang->user->roleList['td']     = '研发主管';
$lang->user->roleList['pd']     = '产品主管';
$lang->user->roleList['qd']     = '测试主管';
$lang->user->roleList['top']    = '高层管理';
$lang->user->roleList['others'] = '其他';

$lang->user->genderList['m'] = '男';
$lang->user->genderList['f'] = '女';

$lang->user->passwordStrengthList[0] = "<span style='color:red'>弱</span>";
$lang->user->passwordStrengthList[1] = "<span style='color:#000'>中</span>";
$lang->user->passwordStrengthList[2] = "<span style='color:green'>强</span>";

$lang->user->statusList['active'] = '正常';
$lang->user->statusList['delete'] = '删除';

$lang->user->keepLogin['on']      = '保持登录';
$lang->user->loginWithDemoUser    = '使用demo帐号登录：';

$lang->user->tpl = new stdclass();
$lang->user->tpl->type    = '类型';
$lang->user->tpl->title   = '模板名';
$lang->user->tpl->content = '内容';
$lang->user->tpl->public  = '是否公开';

$lang->user->placeholder = new stdclass();
$lang->user->placeholder->account     = '英文、数字和下划线的组合，三位以上';
$lang->user->placeholder->password1   = '六位以上';
$lang->user->placeholder->role        = '职位影响内容和用户列表的顺序。';
$lang->user->placeholder->group       = '分组决定用户的权限列表。';
$lang->user->placeholder->commiter    = '版本控制系统(subversion)中的帐号';
$lang->user->placeholder->verify      = '请输入您的系统登录密码';

$lang->user->placeholder->passwordStrength[1] = '6位以上，包含大小写字母，数字。';
$lang->user->placeholder->passwordStrength[2] = '10位以上，包含大小写字母，数字，特殊字符。';

$lang->user->error = new stdclass();
$lang->user->error->account       = "【ID %s】的用户名应该为：三位以上的英文、数字或下划线的组合";
$lang->user->error->accountDupl   = "【ID %s】的用户名已经存在";
$lang->user->error->realname      = "【ID %s】的真实姓名必须填写";
$lang->user->error->password      = "【ID %s】的密码必须为六位以上";
$lang->user->error->mail          = "【ID %s】的邮箱地址不正确";
$lang->user->error->reserved      = "【ID %s】的用户名已被系统预留";

$lang->user->error->verifyPassword   = "验证失败，请检查您的系统登录密码是否正确";
$lang->user->error->originalPassword = "原密码不正确";

$lang->user->contactFieldList['skype']    = $lang->user->skype;
$lang->user->contactFieldList['qq']       = $lang->user->qq;
$lang->user->contactFieldList['dingding'] = $lang->user->dingding;
$lang->user->contactFieldList['weixin']   = $lang->user->weixin;
$lang->user->contactFieldList['mobile']   = $lang->user->mobile;
$lang->user->contactFieldList['slack']    = $lang->user->slack;
$lang->user->contactFieldList['whatsapp'] = $lang->user->whatsapp;
$lang->user->contactFieldList['phone']    = $lang->user->phone;

$lang->user->contacts = new stdclass();
$lang->user->contacts->common   = '联系人';
$lang->user->contacts->listName = '列表名称';
$lang->user->contacts->userList = '用户列表';

$lang->user->contacts->manage        = '维护列表';
$lang->user->contacts->contactsList  = '已有列表';
$lang->user->contacts->selectedUsers = '选择用户';
$lang->user->contacts->selectList    = '选择列表';
$lang->user->contacts->createList    = '创建新列表';
$lang->user->contacts->noListYet     = '还没有创建任何列表，请先创建联系人列表。';
$lang->user->contacts->confirmDelete = '您确定要删除这个列表吗？';
$lang->user->contacts->or            = ' 或者 ';

$lang->user->resetFail       = "重置密码失败，检查用户名是否存在！";
$lang->user->resetSuccess    = "重置密码成功，请用新密码登录。";
$lang->user->noticeResetFile = "<h5>普通用户请联系管理员重置密码</h5>
    <h5>管理员请登录豆包网所在的服务器，创建<span> '%s' </span>文件。</h5>
    <p>注意：</p>
    <ol>
    <li>文件内容为空。</li>
    <li>如果之前文件存在，删除之后重新创建。</li>
    </ol>"; 
