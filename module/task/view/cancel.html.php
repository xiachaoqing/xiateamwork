<?php
/**
 * The cancel file of task module of ZenTaoPMS.
 *

 * @author      Jia Fu <fujia@cnezsoft.com>
 * @package     task
 * @version     $Id: cancel.html.php 935 2010-07-06 07:49:24Z jajacn@126.com $
*/
?>
<?php include '../../common/view/header.html.php';?>
<?php include '../../common/view/kindeditor.html.php';?>
<div id='mainContent' class='main-content'>
  <div class='center-block'>
    <div class='main-header'>
      <h2>
        <span class='label label-id'><?php echo $task->id;?></span>
        <?php echo isonlybody() ? ("<span title='$task->name'>" . $task->name . '</span>') : html::a($this->createLink('task', 'view', 'task=' . $task->id), $task->name);?>
        <?php if(!isonlybody()):?>
        <small> <?php echo $lang->arrow . $lang->task->cancel;?></small>
        <?php endif;?>
      </div>
    </div>

    <form method='post' target='hiddenwin'>
      <table class='table table-form'>
        <tr>
          <th class='w-50px'><?php echo $lang->comment;?></th>
          <td><?php echo html::textarea('comment', '', "rows='6' class='form-control'");?></td>
        </tr>
        <tr>
          <td colspan='2' class='text-center'>
            <?php echo html::submitButton($lang->task->cancel);?>
            <?php echo html::linkButton($lang->goback, $this->session->taskList);?>
          </td>
        </tr>
      </table>
    </form>
    <hr class='small' />
    <div class='main'><?php include '../../common/view/action.html.php';?></div>
  </div>
</div>
<?php include '../../common/view/footer.html.php';?>
