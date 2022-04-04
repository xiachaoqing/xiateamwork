<?php if($extView = $this->getExtViewFile(__FILE__)){include $extView; return helper::cd();}?>
<div id="mainMenu" class="clearfix">
  <div class="btn-toolbar">
  <?php
    $date = isset($date) ? $date : helper::today();
    $end = empty($end) ? helper::today():$end;
    $begin = empty($begin) ? helper::today():$begin;
    echo "<div class='input-control w-120px'>" . $userList . "</div>";
    
    $methodName = $this->app->getMethodName();
     echo '<div class="col-sm-1"><button type="button" id="sub" class="btn btn-primary btn-block" data-loading="稍候...">查询</button></div>';
    if($config->global->flow == 'full')
    {
        $label  = "<span class='text'>{$lang->user->schedule}</span>";
        $active = $methodName == 'todo' ? ' btn-active-text' : '';
        common::printLink('report', 'todo', "account=$account", $label, '', "class='btn btn-link $active'");
    }
    if($config->global->flow != 'onlyTask' and $config->global->flow != 'onlyTest')
    {
        $label  = "<span class='text'>{$lang->user->story}</span>";
        $active = $methodName == 'story' ? ' btn-active-text' : '';
        common::printLink('report', 'story', "account=$account&begin=".strtotime($begin)."&end=".strtotime($end), $label, '', "class='btn btn-link $active'");
    }

    if($config->global->flow == 'full' or $config->global->flow == 'onlyTask') 
    {
        $label  = "<span class='text'>{$lang->user->task}</span>";
        $active = $methodName == 'task' ? ' btn-active-text' : '';
        common::printLink('report', 'task', "account=$account&begin=".strtotime($begin)."&end=".strtotime($end), $label, '', "class='btn btn-link $active'");
    }

    if($config->global->flow == 'full' or $config->global->flow == 'onlyTest') 
    {
        $label  = "<span class='text'>{$lang->user->bug}</span>";
        $active = $methodName == 'bug' ? ' btn-active-text' : '';
        common::printLink('report', 'bug', "account=$account&begin=".strtotime($begin)."&end=".strtotime($end), $label, '', "class='btn btn-link $active'");

        $label  = "<span class='text'>{$lang->user->test}</span>";
        $active = ($methodName == 'testtask' or $methodName == 'testcase')? ' btn-active-text' : '';
        common::printLink('report', 'testtask', "account=$account&begin=".strtotime($begin)."&end=".strtotime($end), $label, '', "class='btn btn-link $active'");
    }

    $label  = "<span class='text'>{$lang->user->dynamic}</span>";
    $active = $methodName == 'dynamic' ? ' btn-active-text' : '';
    common::printLink('report', 'dynamic',  "type=today&account=$account", $label, '', "class='btn btn-link $active'");

    if($config->global->flow == 'full' or $config->global->flow == 'onlyTask')
    {
        $label  = "<span class='text'>{$lang->user->project}</span>";
        $active = $methodName == 'project' ? ' btn-active-text' : '';
        common::printLink('report', 'project',  "account=$account&begin=".strtotime($begin)."&end=".strtotime($end), $label, '', "class='btn btn-link $active'");
    }
    ?>
  </div>
</div>
<!-- <script type="text/javascript">
        $("button").click(function(){
            changeParams(this);
        });
</script> -->
