<?php
/**
 * The assigntome block view file of block module of ZenTaoPMS.
 *

 * @author      Yidong Wang <yidong@cnezsoft.com>
 * @package     block
 * @version     $Id$
*/
?>
<div id='assigntomeBlock'>
  <ul class="nav nav-secondary">
    <?php $isFirstTab = true; ?>
    <?php foreach($hasViewPriv as $type => $bool):?>
    <?php if($config->global->flow != 'full' && $config->global->flow != 'onlyTask' && $type == 'task') continue;?>
    <?php if($config->global->flow != 'full' && $config->global->flow != 'onlyTest' && $type == 'bug') continue;?>
    <li<?php if($isFirstTab) {echo ' class="active"'; $isFirstTab = false;}?>><a data-tab href='#assigntomeTab-<?php echo $type;?>'><?php echo $lang->block->availableBlocks->$type;?></a></li>
    <?php endforeach;?>
  </ul>
  <div class="tab-content">
    <?php $isFirstTab = true; ?>
    <?php foreach($hasViewPriv as $type => $bool):?>
    <?php if($config->global->flow != 'full' && $config->global->flow != 'onlyTask' && $type == 'task') continue;?>
    <?php if($config->global->flow != 'full' && $config->global->flow != 'onlyTest' && $type == 'bug') continue;?>
    <div class="tab-pane<?php if($isFirstTab) {echo ' active'; $isFirstTab = false;}?>" id="assigntomeTab-<?php echo $type?>">
      <?php include "{$type}block.html.php";?>
    </div>
    <?php endforeach;?>
  </div>
</div>
<style>
#assigntomeBlock {position: relative;}
#assigntomeBlock .block-todoes {padding-top: 10px}
#assigntomeBlock > .nav {position: absolute; top: -41px; left: 120px;}
#assigntomeBlock .block-todoes .todoes-form{top: -50px;}
</style>
