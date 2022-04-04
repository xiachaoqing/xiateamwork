<?php include '../../common/view/header.html.php';?>
<?php include '../../common/view/datepicker.html.php';?>
<div id='mainContent' class='main-row'>
  <div class='side-col'>
    <?php include 'blockreportlist.html.php';?>
  </div>
  <div class='main-col'>
    <div class='cell'>
      <form method='post'>
        <div class="row" id='conditions'>
        <!-- <div class='col-sm-2'>
            <div class='input-group'>
              <span class='input-group-addon'><?php echo $lang->report->personnel;?></span>
              <?php echo html::select('use', $users, $use, "class='form-control chosen' ");?>
            </div>
          </div> -->
          <div class='col-sm-2'>
            <div class='input-group'>
              <span class='input-group-addon'><?php echo $lang->report->prolist;?></span>
              <?php echo html::select('pro', $productlist, $pro, "class='form-control chosen' ");?>
            </div>
            <!-- <div class='input-group'>
              <span class='input-group-addon'><?php echo $lang->report->personnel;?></span>
              <?php echo html::select('use', $users, $use, "class='form-control chosen' ");?>
            </div> -->
          </div>
              <div class='col-sm-2'>
            <div class='input-group'>
              <span class='input-group-addon'><?php echo $lang->report->personnel;?></span>
              <?php echo html::select('use', $users, $use, "class='form-control chosen' ");?>
            </div>
          </div>
          <div class='col-sm-4'>
            <div class='input-group input-group-sm'>
              <span class='input-group-addon'><?php echo $lang->report->beginAndEnd;?></span>
              <div class='datepicker-wrapper datepicker-date'><?php echo html::input('begin', $begin, "class='form-control' style='padding-right:10px' ");?></div>
              <span class='input-group-addon fix-border'><?php echo $lang->report->to;?></span>
              <div class='datepicker-wrapper datepicker-date'><?php echo html::input('end', $end, "class='form-control' style='padding-right:10px' ");?></div>
            </div>
          </div>
          <div class='col-sm-4'>
              <div class="row">
                <!-- <div class="col-sm-4">
                  <div class='input-group'>
                    <span class='input-group-addon'><?php echo $lang->report->workday;?></span>
                    <?php echo html::input('workday', $workday, "class='form-control'");?>
                  </div>
                </div> -->
                <div class="col-sm-6">
                  <div class='input-group'>
                    <span class='input-group-addon'>表格样式</span>
                    <?php echo html::select('format', $lang->report->format, $format, "class='form-control' ");?>
                  </div>
                </div>
                <!-- <div class="col-sm-2">
                  <?php echo html::select('assign', $lang->report->assign, $assign, "class='form-control' ");?>
                </div> -->
                <div class="col-sm-3">
                  <?php echo html::submitButton($lang->report->query, '', 'btn btn-primary btn-block');?>
                </div>
                <div class="col-sm-3">
                  <?php echo html::submitButton('下载', '', 'btn btn-primary btn-block show-table-export');?>
                </div>
            </div>
          </div>
        </div>
      </form>
    </div>
    <?php if(empty($workload)):?>
    <div class="cell">
      <div class="table-empty-tip">
        <p><span class="text-muted"><?php echo $lang->error->noData;?></span></p>
      </div>
    </div>
    <?php else:?>

    <div class='cell'>
      <div class='panel'>
        <div class="panel-heading">
          <div class="panel-title"><?php echo $title;?></div>
          <nav class="panel-actions btn-toolbar"></nav>
        </div>
        <?php if($format=='table'):?>
        <div data-ride='table'>
          <table class='table table-condensed table-striped table-bordered table-fixed no-margin' id="workload">
            <!-- 标头 -->
            <thead>
              <tr class='colhead text-center'>
                <th><?php echo $lang->report->prolist;?></th>
                <th class="w-200px"><?php echo $lang->report->protitle ;?></th>
                <th>人员</th>
                <th>人员实际天数</th>
                <th>人员消耗天数</th>  
                <th>产品消耗天数</th>
                <th>产品线消耗天数</th>
                <th>工作日</th>
                <th>总人数</th>
                <!-- <th class="w-100px"><?php echo $lang->report->workloadAB;?></th> -->
              </tr>
            </thead>
            <!-- 内容 -->
            <tbody>
              <?php $color = false;
               //总工时
               $total_hours=0;
               //总消耗
               $total_product=0;
               //总人数
               $total_peopel=0;
               //产品人数
               $cp_peopel=0;
              ?>
              <?php foreach($product as $prolist => $load):?>
              <?php if(!isset($productlist[$prolist])) continue;?>
              <tr class="text-center">
                <td rowspan="<?php echo count($load);?>"><?php echo $productlist[$prolist];?></td>
                <?php $id = 1;?>
                <?php foreach($load as $pros => $info):?>
                <?php $class = $color ? 'rowcolor' : '';?>
                <?php if($id != 1) echo '<tr class="text-center">';?>
                <td style='width: 110px;overflow:hidden;text-overflow:ellipsis;white-space: nowrap;' class="<?php echo $class;?>">
                  <?php echo $info->name;?>
                </td>
                <?php if(isset($workload[$prolist])):?>
                <td class="<?php echo isset($workload[$prolist][$pros]['user'])?'u50 '.$class:''.$class;?>">
                    <table class='table table-condensed  table-fixed no-margin'>
                        <?php foreach(array_unique($workload[$prolist][$pros]['user']) as $val):?>
                        <tr class="text-center">
                        <td style='border: none;';><?php echo isset($users[$val])?$users[$val]:$val;?></td>
                        </tr>
                        <?php endforeach;?>
                    </table>
                </td>

                <td  class="<?php echo isset($workload[$prolist][$pros])?'u50 '.$class:''.$class;?>">
                    <table class='table table-condensed  table-fixed no-margin'>
                        <?php foreach(array_unique($workload[$prolist][$pros]['user']) as $val):?>
                        <tr class="text-center">
                        <td style='border: none;';>
                          <?php echo isset($workload[$prolist][$pros][$val])?$workload[$prolist][$pros][$val]['consumed']:0;?>
                        </td>
                        </tr>
                        <?php endforeach;?>
                    </table>
                </td>

                <td  class="<?php echo isset($workload[$prolist][$pros])?'u50 '.$class:''.$class;?>">
                    <table class='table table-condensed  table-fixed no-margin'>
                        <?php foreach(array_unique($workload[$prolist][$pros]['user']) as $val):?>
                        <tr class="text-center">
                        <td style='border: none;';>
                          <?php echo isset($workload['uselist']['use'][$val][$pros])?$workload['uselist']['use'][$val][$pros]:0;?>
                        </td>
                        </tr>
                        <?php endforeach;?>
                    </table>
                </td>
                <td class="<?php echo isset($workload[$prolist][$pros])?'u50 '.$class:''.$class;?>">
                     <?php echo isset($workload['uselist']['list'][$pros])?$workload['uselist']['list'][$pros]:0;?>
                </td>

               <!-- <td  class="<?php echo $class;?>"><?php echo $allHour;?></td> -->
                <?php if($id == 1):?>
                <td class="u50" rowspan="<?php echo count($load);?>">
                <?php $total_pro=0;foreach($load as $pros => $info):?>
                     <?php  $total_product+=isset($workload['uselist']['list'][$pros])?$workload['uselist']['list'][$pros]:0;?>
                     <?php  $total_pro+=isset($workload['uselist']['list'][$pros])?$workload['uselist']['list'][$pros]:0;?>
                     <?php endforeach;?>
                <?php echo $total_pro;?>
                </td>
                <td class="u50" rowspan="<?php echo count($load);?>"><?php 
                   echo $allHour;?>
                </td>
                <td class="u50" rowspan="<?php echo count($load);?>"><?php 
                $cp_peopel+=count(array_unique($workload[$prolist]['user']));
                echo count(array_unique($workload[$prolist]['user']));?></td>
                <?php endif;?>


                <?php  else:?>
                <td  class="<?php echo $class;?>"></td>
                <td  class="<?php echo $class;?>">0</td>
                <td  class="<?php echo $class;?>">0</td>

                <?php if($id == 1):?>
                <td rowspan="<?php echo count($load);?>">0</td>
                <td rowspan="<?php echo count($load);?>">0</td>
                <td rowspan="<?php echo count($load);?>">0</td>
                <td rowspan="<?php echo count($load);?>">0</td>
                <?php endif;?>

                <?php endif;?>
                <?php if($id != 1) echo '</tr>'; $id ++;?>
                <?php $color = !$color;?>
                <?php endforeach;?>
              </tr>
              <?php endforeach;?>
            </tbody>
            <!-- 尾部 -->
            <tfoot class="fixed-tfoot">
              <tr class="colhead text-center">
              <td>总计</td>
              <td colspan='5'></td>
              <td><?php echo $total_product;?></td>
              <?php
              if(empty($pro)||$pro==0):?>
                <td><?php echo $allHour*count(array_unique($workload['users']));?></td>
                <td><?php echo count(array_unique($workload['users']));?></td>
              <?php else:?>
                <td><?php echo $allHour*$cp_peopel;?></td>
                <td><?php echo $cp_peopel;?></td>
              <?php endif;?>
              </tr>
            </tfoot>
          </table>
          <!-- 必须要有这个A标签，不然会报错-->
          <a id="dlink"></a>
        </div>
        <?php else:?>
          <div class="table-empty-tip">
            <p><span class="text-muted">暂无开发wiki</span></p>
          </div>
        <?php endif;?>
      </div>
    </div>
   <?php endif;?>
  </div>
</div>
<style>
.list-group-item {
    position: relative;
    display: block;
    padding: 10px 15px;
    margin-bottom: -1px;
    background-color: #fff;
    border: 1px solid #ddd;
}
.list-group-item {
    border-radius: 0!important;
}
td{ word-wrap:break-word;word-break:break-all;}
</style>
<script type="text/javascript">
    $(function () {
        $(document).on('click', '.show-table-export', function(){
            if($("#workload").text()){
              HtmlExportToExcel('workload','财务人力统计');
            }else{
              alert('没有数据可以导出');
            }
        })
    });
    function HtmlExportToExcel(tableid,file_name) {
        var filename =file_name; //'Book'
        if (getExplorer() == 'ie' || getExplorer() == undefined) {
            HtmlExportToExcelForIE(tableid, filename);
        }
        else {
            HtmlExportToExcelForEntire(tableid, filename)
        }
    }
//IE浏览器导出Excel
function HtmlExportToExcelForIE(tableid, filename) {
    try {             
        var curTbl = document.getElementById(tableid);  
        var oXL;  
        try{  
            oXL = new ActiveXObject("Excel.Application"); //创建AX对象excel  
        }catch(e){  
            alert("无法启动Excel!\n\n如果您确信您的电脑中已经安装了Excel，"+"那么请调整IE的安全级别。\n\n具体操作：\n\n"+"工具 → Internet选项 → 安全 → 自定义级别 → 对没有标记为安全的ActiveX进行初始化和脚本运行 → 启用");  
            return false;  
        }  
        var oWB = oXL.Workbooks.Add(); //获取workbook对象  
        var oSheet = oWB.ActiveSheet;//激活当前sheet  
        var sel = document.body.createTextRange();  
        sel.moveToElementText(curTbl); //把表格中的内容移到TextRange中  
        try{
            sel.select(); //全选TextRange中内容  
        }catch(e1){
            e1.description
        }
        sel.execCommand("Copy");//复制TextRange中内容  
        oSheet.Paste();//粘贴到活动的EXCEL中  
        oXL.Visible = true; //设置excel可见属性  
        var fname = oXL.Application.GetSaveAsFilename(filename+".xls", "Excel Spreadsheets (*.xls), *.xls");  
        oWB.SaveAs(fname);  
        oWB.Close();  
        oXL.Quit(); 

    } catch (e) {
        alert(e.description);
    }
}
 
//非IE浏览器导出Excel
var HtmlExportToExcelForEntire = (function() {
    var uri = 'data:application/vnd.ms-excel;base64,',
template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><meta charset="UTF-8"><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>',
base64 = function(s) { return window.btoa(unescape(encodeURIComponent(s))) },
format = function(s, c) { return s.replace(/{(\w+)}/g, function(m, p) { return c[p]; }) }
    return function(table, name) {
        if (!table.nodeType) { table = document.getElementById(table); }
        var ctx = { worksheet: name || 'Worksheet', table: table.innerHTML }
        document.getElementById("dlink").href = uri + base64(format(template, ctx));
        document.getElementById("dlink").download = name + ".xls";
        document.getElementById("dlink").click();
    }
})()
 
function getExplorer() {
    var explorer = window.navigator.userAgent;
    //ie 
    if (explorer.indexOf("MSIE") >= 0) {
        return 'ie';
    }
    //firefox 
    else if (explorer.indexOf("Firefox") >= 0) {
        return 'Firefox';
    }
    //Chrome
    else if (explorer.indexOf("Chrome") >= 0) {
        return 'Chrome';
    }
    //Opera
    else if (explorer.indexOf("Opera") >= 0) {
        return 'Opera';
    }
    //Safari
    else if (explorer.indexOf("Safari") >= 0) {
        return 'Safari';
    }
}
</script>
<?php include '../../common/view/footer.html.php';?>
