<?php
/**
 * The profile view file of my module of ZenTaoPMS.
 *
 * @author      XCQ
 * @package     my
 * @version     $Id: profile.html.php 4694 2013-05-02 01:40:54Z 631753810@qq.com $
*/
?>
<?php include '../../common/view/header.html.php';?>
<?php if(!isonlybody()):?>
<style>
.main-content{width: 600px; margin: 0 auto;}
</style>
<?php endif;?>
<div id='mainContent' class='main-content'>
  <div class='main-header'>
    <h2><?php echo html::icon($lang->icons['user']);?> <?php echo $lang->my->profile;?></h2>
    <div class='actions pull-right'>
      <?php echo html::a($this->createLink('my', 'editprofile'), $lang->user->editProfile, '', "class='btn btn-primary'");?>
    </div>
  </div>
  <table class='table table-borderless table-data'>
    <tr>
      <th class='rowhead w-100px'><?php echo $lang->user->dept;?></th>
      <td>
      <?php
      if(empty($deptPath))
      {
          echo "/";
      }
      else
      {
          foreach($deptPath as $key => $dept)
          {
              if($dept->name) echo $dept->name;
              if(isset($deptPath[$key + 1])) echo $lang->arrow;
          }
      }
      ?>
      </td>
    </tr>
    <tr>
      <th><?php echo $lang->user->account;?></th>
      <td><?php echo $user->account;?></td>
    </tr>
    <tr>
      <th><?php echo $lang->user->realname;?></th>
      <td><?php echo $user->realname;?></td>
    </tr>
    <tr>
      <th><?php echo $lang->user->role;?></th>
      <td><?php echo $lang->user->roleList[$user->role];?></td>
    </tr>
    <tr>
      <th><?php echo $lang->group->priv;?></th>
      <td><?php foreach($groups as $group) echo $group->name . ' '; ?></td>
    </tr>
    <tr>
      <th><?php echo $lang->user->commiter;?></th>
      <td><?php echo $user->commiter;?></td>
    </tr>
    <tr>
      <th><?php echo $lang->user->email;?></th>
      <td><?php echo $user->email;?></td>
    </tr>
    <tr> 
      <th><?php echo $lang->user->join;?></th>
      <td><?php echo formatTime($user->join);?></td>
    </tr>
    <tr>
      <th><?php echo $lang->user->visits;?></th>
      <td><?php echo $user->visits;?></td>
    </tr>
    <tr>
      <th><?php echo $lang->user->ip;?></th>
      <td><?php echo $user->ip;?></td>
    </tr>
    <tr>
      <th><?php echo $lang->user->last;?></th>
      <td><?php echo $user->last;?></td>
    </tr>
    <?php foreach(explode(',', $config->user->contactField) as $field):?>
    <tr>
      <th><?php echo $lang->user->$field;?></th>
      <td>
        <?php
        if($field == 'skype' and $user->$field)
        {
            echo html::a("callto://$user->skype", $user->skype);
        }
        elseif($field == 'qq' and $user->$field)
        {
            echo html::a("tencent://message/?uin=$user->qq", $user->qq);
        }
        else
        {
            echo $user->$field;
        }
        ?>
      </td>
    </tr>  
    <?php endforeach;?>
    <tr>
      <th><?php echo $lang->user->address;?></th>
      <td><?php echo $user->address;?></td>
    </tr>  
    <tr>
      <th><?php echo $lang->user->zipcode;?></th>
      <td><?php echo $user->zipcode;?></td>
    </tr>
    <?php if($user->ranzhi):?>
    <tr>
      <th><?php echo $lang->user->ranzhi;?></th>
      <td>
        <?php echo $user->ranzhi . ' ';?>
        <?php if(common::hasPriv('my', 'unbind')) echo html::a($this->createLink('my', 'unbind'), "<i class='icon-unlink'></i>", 'hiddenwin', "class='bin-icon' title='{$lang->user->unbind}'");?>
      </td>
    </tr>
    <?php endif;?>
  </table>
</div>
<?php include '../../common/view/footer.html.php';?>
