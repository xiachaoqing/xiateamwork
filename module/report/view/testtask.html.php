<?php
/**
 * The testtask view file of my module of ZenTaoPMS.
 *
 * @author      XCQ
 * @package     dashboard
 * @version     $Id$
*/
?>
<?php include '../../common/view/header.html.php';?>
<?php include './featurebar.html.php';?>
<div id='mainContent'>
  <nav id='contentNav'>
    <ul class='nav nav-default'>
      <?php
      echo "<li class='active'>"  . html::a($this->createLink('user', 'testtask', "account=$account"),  $lang->user->testTask2Him) . "</li>";
      echo "<li>"  . html::a($this->createLink('user', 'testcase', "account=$account&type=case2Him"),  $lang->user->case2Him) . "</li>";
      echo "<li>" . html::a($this->createLink('user', 'testcase', "account=$account&type=caseByHim"),  $lang->user->caseByHim) . "</li>";
      ?>
    </ul>
  </nav>

  <div class='main-table'>
    <table class='table has-sort-head'>
      <?php $vars = "account=$account&orderBy=%s&recTotal=$recTotal&recPerPage=$recPerPage&pageID=$pageID"; ?>
      <thead>
        <tr class='colhead'>
          <th class='w-id'>  <?php common::printOrderLink('id',      $orderBy, $vars, $lang->idAB);?></th>
          <th>               <?php common::printOrderLink('name',    $orderBy, $vars, $lang->testtask->name);?></th>
          <th>               <?php common::printOrderLink('project', $orderBy, $vars, $lang->testtask->project);?></th>
          <th>               <?php common::printOrderLink('build',   $orderBy, $vars, $lang->testtask->build);?></th>
          <th class='w-100px'><?php common::printOrderLink('begin',   $orderBy, $vars, $lang->testtask->begin);?></th>
          <th class='w-100px'><?php common::printOrderLink('end',     $orderBy, $vars, $lang->testtask->end);?></th>
          <th class='w-80px'><?php common::printOrderLink('status',  $orderBy, $vars, $lang->statusAB);?></th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($tasks as $task):?>
        <tr>
          <td><?php echo html::a($this->createLink('testtask', 'view', "taskID=$task->id"), sprintf('%03d', $task->id));?></td>
          <td class='text-left nobr'><?php echo html::a($this->createLink('testtask', 'view', "taskID=$task->id"), $task->name);?></td>
          <td class='nobr'><?php echo $task->projectName?></td>
          <td class='nobr'><?php $task->build == 'trunk' ? print($lang->trunk) : print(html::a($this->createLink('build', 'view', "buildID=$task->build"), $task->buildName));?></td>
          <td><?php echo $task->begin?></td>
          <td><?php echo $task->end?></td>
          <td class='task-<?php echo $task->status?>'><?php echo $lang->testtask->statusList[$task->status];?></td>
        </tr>
        <?php endforeach;?>
      </tbody>
    </table>
    <?php if($tasks):?>
    <div class="table-footer"><?php $pager->show('right', 'pagerjs');?></div>
    <?php endif;?>
  </div>
</div>
<?php include '../../common/view/footer.html.php';?>
