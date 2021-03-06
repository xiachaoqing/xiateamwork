<?php
/**
 * The html template file of execute method of upgrade module of ZenTaoPMS.
 *
 * @author      XCQ
 * @package     upgrade
 * @version     $Id: execute.html.php 5119 2019-03-11 08:06:42Z wyd621@gmail.com $*/
?>
<?php include '../../common/view/header.lite.html.php';?>
<div class='container'>
  <div class='modal-dialog'>
    <div class='modal-header'>
      <strong><?php echo $lang->upgrade->result;?></strong>
    </div>
    <div class='modal-body'>
      <div class='alert alert-success mgb-10'>
        <strong><?php echo $lang->upgrade->success?></strong>
        <span class='pull-right'><?php echo html::a('index.php', $lang->upgrade->tohome, '', "class='btn btn-sm' id='tohome'")?></span>
      </div>
      <div class='panel adbox'>
        <div class='panel-heading'><strong><?php echo $lang->install->promotion?></strong></div>
        <div class='panel-body row'>
          <?php foreach($lang->install->product as $product):?>
          <div class='col-md-<?php echo ceil(12 / count($lang->install->product));?>'>
            <a class="card ad ad-<?php echo $product;?>" href="<?php echo $lang->install->{$product}->url;?>" target="_blank">
              <div class="img-wrapper" style="background-image:url(<?php echo $defaultTheme . $lang->install->{$product}->logo;?>)"><img src="<?php echo $defaultTheme . $lang->install->{$product}->logo;?>" alt=""></div>
              <div class="card-reveal">
                <h5 class="card-heading"><?php echo $lang->install->{$product}->name?></h5>
                <div class="card-content"><?php echo $lang->install->{$product}->desc?></div>
              </div>
            </a>
          </div>
          <?php endforeach;?>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
<?php
foreach($needProcess as $processKey => $value) echo 'var ' . $processKey . "Finish = false;\n";
if(isset($needProcess['updateFile'])):?>
$(function()
{
    $('a#tohome').closest('.alert').hide();
    $('.adbox').before("<div id='resultBox' class='alert alert-info'><p><?php echo $lang->upgrade->updateFile;?></p></div>");
    updateFile('<?php echo inlink('ajaxUpdateFile')?>');
})
function updateFile(link)
{
    $.getJSON(link, function(response)
    {
        if(response.result == 'finished')
        {
            $('#resultBox li span.' + response.type + '-num').html(num + response.count);
            updateFileFinish = true;
            $('#resultBox').append("<li class='text-success'>" + response.message + "</li>");
            <?php
            $condition = array();
            foreach($needProcess as $processKey => $value) $condition[] = $processKey . 'Finish == true';
            $condition = join(' && ', $condition);
            ?>
            if(<?php echo $condition?>)
            {
                $.get('<?php echo inlink('afterExec', "fromVersion=$fromVersion&processed=yes")?>');
                $('a#tohome').closest('.alert').show();
            }
        }
        else
        {
            if($('#resultBox li span.' + response.type + '-num').size() == 0 || response.type != response.nextType)
            {
                $('#resultBox').append("<li class='text-success'>" + response.message + "</li>");
            }
            var num = parseInt($('#resultBox li span.' + response.type + '-num').html());
            $('#resultBox li span.' + response.type + '-num').html(num + response.count);
            updateFile(response.next);
        }
    });
}
<?php endif;?>
</script>
<?php include '../../common/view/footer.lite.html.php';?>
