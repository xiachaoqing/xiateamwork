<?php
/**
 * The install view file of extension module of ZenTaoPMS.
 *
 * @author      XCQ
 * @package     extension
 * @version     $Id$
*/
?>
<?php include '../../common/view/header.lite.html.php';?>
<div id='mainContent' class='main-content'>
  <div class='center-block'>
    <div class='main-header'>
      <h2>
        <span class='prefix' title='EXTENSION'><?php echo html::icon($lang->icons['extension']);?></span>
        <strong><?php echo $title;?></strong>
      </h2>
    </div>
    <?php if(isset($error) and $error):?>
    <div class='alert alert-success with-icon'>
      <i class='icon-check-circle'></i>
      <div class='content'>
        <h3><?php echo $lang->extension->needSorce;?></h3>
        <p><?php echo $error;?></p>
      </div>
    </div>
    <?php endif;?>
  </div>
</div>
</body>
</html>
