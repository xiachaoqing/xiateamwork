<?php
/**
 * The structure view file of extension module of ZenTaoPMS.
 *

 * @author      Yangyang Shi <shiyangyang@cnezsoft.com>
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
        <strong><?php echo $extension->name . '[' . $extension->code . '] ' .$lang->extension->structure . ':';?></strong>
      </h2>
    </div>
    <div class='with-padding'>
      <pre><?php
      $appRoot = $this->app->getAppRoot();
      $files   = json_decode($extension->files);
      foreach($files as $file => $md5) echo $appRoot . $file . "\n";
      ?></pre>  
    </div>
  </div>
</div>
<?php include '../../common/view/footer.lite.html.php';?>
