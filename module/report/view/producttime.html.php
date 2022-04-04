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
          <div class='col-sm-2'>
            <div class='input-group'>
              <span class='input-group-addon'><?php echo $lang->report->prolist;?></span>
              <?php echo html::select('pro', $productlist, $pro, "class='form-control chosen' ");?>
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
          <div class='col-sm-6'>
            <div class="row">
              <div class="col-sm-3">
                <div class='input-group'>
                  <span class='input-group-addon'><?php echo $lang->report->workday;?></span>
                  <?php echo html::input('workday', $workday, "class='form-control'");?>
                </div>
              </div>
              <div class="col-sm-4">
                <div class='input-group'>
                  <span class='input-group-addon'>表格样式</span>
                  <?php echo html::select('format', $lang->report->format, $format, "class='form-control' ");?>
                </div>
              </div>
              <div class="col-sm-2">
                <?php echo html::select('assign', $lang->report->assign, $assign, "class='form-control' ");?>
              </div>
              <div class="col-sm-3">
                <?php echo html::submitButton($lang->report->query, '', 'btn btn-primary btn-block');?>
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
                <th class="w-110px"><?php echo $lang->report->prolist;?></th>
                <th class="w-110px"><?php echo $lang->report->protitle ;?></th>
                <th class="w-130px">项目</th>
                <th class="w-100px">人员</th>
                <th>人数</th>
                <th>任务数</th>
                <th><?php echo $lang->report->usetime;?></th>
                <th><?php echo $lang->report->remain;?></th>
                <th>总人数</th>
                <th>总任务</th>
                <th class="w-100px">人员清单</th>
                <th><?php echo $lang->report->consumed;?></th>
                <th><?php echo $lang->report->left;?></th>
                <th>总工时</th>
                <th>工作比例</th>
                <!-- <th class="w-100px"><?php echo $lang->report->workloadAB;?></th> -->
              </tr>
            </thead>
            <!-- 内容 -->
            <tbody>
              <?php $color = false;
               //总任务
               $total_task=0;
               //总耗时
               $total_time=0;
               //总剩余
               $total_left=0;
               //总工时
               $total_hours=0;
              ?>
              <?php foreach($product as $prolist => $load):?>
              <?php if(!isset($productlist[$prolist])) continue;?>
              <tr class="text-center">
                <td rowspan="<?php echo count($load);?>"><?php echo $productlist[$prolist];?></td>
                <?php $id = 1;?>
                <?php foreach($load as $pro => $info):?>
                <?php $class = $color ? 'rowcolor' : '';?>
                <?php if($id != 1) echo '<tr class="text-center">';?>
                <td style='width: 110px;overflow:hidden;text-overflow:ellipsis;white-space: nowrap;' title="<?php echo $info->name;?>" class="<?php echo $class;?>">
                <?php echo html::a($this->createLink('product', 'view', "productID={$info->id}"),$info->name);?>
                </td>
                <?php if(isset($workload[$prolist])):?>
                <td>
                    <table class='table table-condensed  table-fixed no-margin'>
                        <?php foreach(array_unique($workload[$prolist][$pro]['projectName']) as $pk=>$proname):?>
                        <tr class="text-center">
                        <td style='border: none;' title="<?php echo $proname;?>"> <?php echo html::a($this->createLink('project', 'view', "project={$pk}"),$proname);?></td>
                        </tr>
                        <?php endforeach;?>
                      </table>
                </td>
                <td class="<?php echo isset($workload[$prolist][$pro]['user'])?'u50 '.$class:''.$class;?>">
                    <table class='table table-condensed  table-fixed no-margin'>
                        <?php foreach(array_unique($workload[$prolist][$pro]['user']) as $val):?>
                        <tr class="text-center">
                        <td style='border: none;';><?php echo $users[$val];?></td>
                        </tr>
                        <?php endforeach;?>
                      </table>
                </td>
                <td  class="<?php echo isset($workload[$prolist][$pro])?'u50 '.$class:''.$class;?>"><?php echo isset($workload[$prolist][$pro])?count(array_unique($workload[$prolist][$pro]['user'])):0;?></td>
                <td  class="<?php echo isset($workload[$prolist][$pro])?'u50 '.$class:''.$class;?>"><?php echo isset($workload[$prolist][$pro])?count(array_unique($workload[$prolist][$pro]['task'])):0;?></td>
                <td  class="<?php echo isset($workload[$prolist][$pro])?'u50 '.$class:''.$class;?>"><?php echo isset($workload[$prolist][$pro])?$workload[$prolist][$pro]['consumed']:0;?></td>
                <td  class="<?php echo isset($workload[$prolist][$pro])?'u50 '.$class:''.$class;?>"><?php echo isset($workload[$prolist][$pro])?$workload[$prolist][$pro]['manhour']:0;?></td>
               <!-- <td  class="<?php echo $class;?>"><?php echo $allHour;?></td> -->
                <?php if($id == 1):?>
                <td class="u50" rowspan="<?php echo count($load);?>"><?php echo count(array_unique($workload[$prolist]['user']));?></td>
                <td class="u50" rowspan="<?php echo count($load);?>"><?php 
                    $total_task+=count(array_unique($workload[$prolist]['task']));
                    echo count(array_unique($workload[$prolist]['task']));
                ?></td>
                <td class="u50" rowspan="<?php echo count($load);?>">
                    <table class='table table-condensed table-fixed no-margin'>
                        <?php foreach(array_unique($workload[$prolist]['user']) as $val):?>
                        <tr class="text-center">
                        <td style='border: none;';><?php echo $users[$val];?></td>
                        </tr>
                        <?php endforeach;?>
                      </table>
                </td>
                <td class="u50" rowspan="<?php echo count($load);?>"><?php 
                   $total_time+=$workload[$prolist]['total']['consumed'];
                   echo $workload[$prolist]['total']['consumed'];
                ?></td>
                <td class="u50" rowspan="<?php echo count($load);?>"><?php 
                  $total_left+=$workload[$prolist]['total']['manhour']; 
                  echo $workload[$prolist]['total']['manhour'];
                ?></td>
                <td class="u50" rowspan="<?php echo count($load);?>"><?php 
                   $total_hours+=$allHour*count(array_unique($workload[$prolist]['user']));
                   echo $allHour*count(array_unique($workload[$prolist]['user']));?>
                </td>
                <td class="u50" rowspan="<?php echo count($load);?>"><?php echo round($workload[$prolist]['total']['consumed'] / ($allHour*count(array_unique($workload[$prolist]['user']))), 2) . '%';?></td>
                <?php endif;?>


                <?php  else:?>
                <td  class="<?php echo $class;?>"></td>
                <td  class="<?php echo $class;?>"></td>
                <td  class="<?php echo $class;?>">0</td>
                <td  class="<?php echo $class;?>">0</td>
                <td  class="<?php echo $class;?>">0</td>
                <td  class="<?php echo $class;?>">0</td>

                <?php if($id == 1):?>
                <td rowspan="<?php echo count($load);?>">0</td>
                <td rowspan="<?php echo count($load);?>">0</td>
                <td rowspan="<?php echo count($load);?>"></td>
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
              <!-- <td colspan='6'></td> -->
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td><?php echo count($workload['users'])?></td>
              <td><?php echo $total_task;?></td>
              <td></td>
              <td><?php echo $total_time;?></td>
              <td><?php echo $total_left;?></td>
              <td><?php echo $total_hours;?></td>
              <td><?php echo round( $total_time/$total_hours, 2) . '%';?></td>
              </tr>
            </tfoot>
          </table>
        </div>
        <?php else:?>
        <div>
          <h4 class='text-center'>产品线纬度来统计</h4>
            <ul class="list-group"> 
              <p>
                <?php 
                //总任务
                $cptotal_task=0;
                //总耗时
                $cptotal_time=0;
                //总剩余
                $cptotal_left=0;
                //总工时
                $cptotal_hours=0;
                //总人数
                $cptotal_man=0;
                ?>
                <li class="list-group-item">|| 产品线 ||  产品 || 人数 || 任务数 || 消耗工时 || 剩余工时 || 人员清单 || 总工时 || 工作比例 ||</li>
                <?php foreach($productlist as $prkey => $proval):?>
                <?php if($prkey!=0):?>
                  <li class="list-group-item">
                  | <?php echo $proval;?> |
                  <?php foreach($product[$prkey] as $pro => $info):?>
                    <?php echo $info->name;?>
                  <?php endforeach;?> |
                  <?php if(isset($workload[$prkey])):?>
                  <?php $cptotal_man+=count(array_unique($workload[$prkey]['user']));
                    echo isset($workload[$prkey])?count(array_unique($workload[$prkey]['user'])):0;?>|
                  <?php $cptotal_task+=count(array_unique($workload[$prkey]['task']));
                    echo isset($workload[$prkey])?count(array_unique($workload[$prkey]['task'])):0;?>|
                  <?php $cptotal_time+=$workload[$prkey]['total']['consumed'];
                    echo isset($workload[$prkey])?$workload[$prkey]['total']['consumed']:0;?>|
                  <?php $cptotal_left+=$workload[$prkey]['total']['manhour']; 
                      echo isset($workload[$prkey])?$workload[$prkey]['total']['manhour']:0;?>|
                  <?php foreach(array_unique($workload[$prkey]['user']) as $val):?>
                      <?php echo $users[$val];?></td>
                  <?php endforeach;?>|
                  <?php $cptotal_hours+=$allHour*count(array_unique($workload[$prkey]['user']));
                    echo $allHour*count(array_unique($workload[$prkey]['user']));?>|
                  <?php echo round($workload[$prkey]['total']['consumed'] / ($allHour*count(array_unique($workload[$prkey]['user']))), 2) . '%';?>|
                  </li>
                <?php  else:?>
                  0 | 0 | 0 | 0 | | 0 | 0 |
                  <?php endif;?>
                </li>
                <?php endif;?>
                <?php endforeach;?>
                <li class="list-group-item">|总计| | <?php echo $cptotal_man?>|<?php echo $cptotal_task;?>|<?php echo $cptotal_time;?>|<?php echo $cptotal_left;?>| |<?php echo $cptotal_hours;?>|<?php echo round( $cptotal_time/$cptotal_hours, 2) . '%';?>|</li>
              </p>
            </ul>
          <h4 class='text-center'>产品纬度来统计</h4>
          <ul class="list-group"> 
              <p>
              <li class="list-group-item">|| 产品线 ||  产品 || 项目 || 人数 || 任务数 || 消耗工时 || 剩余工时 || 人员清单 || 总工时 || 工作比例 ||</li>
              <?php
               //总任务
               $total_task=0;
               //总耗时
               $total_time=0;
               //总剩余
               $total_left=0;
               //总工时
               $total_hours=0;
               //总人数
               $total_man=0;
              ?>
              <?php foreach($product as $prolist => $load):?>
              <!-- 总工时会过滤到重复的人 -->
              <?php $total_hours+=$allHour*count(array_unique($workload[$prolist]['user']));?>
              <?php foreach($load as $pro => $info):?>
              <?php if(!isset($productlist[$prolist])) continue;?>
              <li class="list-group-item"><?php echo '| '.$productlist[$prolist].' |';?>
               <?php echo html::a($this->createLink('product', 'view', "productID={$info->id}"), $info->name).' |';?>
              <?php if(isset($workload[$prolist])):?>
              <?php if(isset($workload[$prolist][$pro]['projectName'])):?>
              <?php foreach(array_unique($workload[$prolist][$pro]['projectName']) as $pk=>$proname):?>
                    <?php echo $proname?>
              <?php endforeach;?>
              <?php else:?>
                <?php echo '无';?>
              <?php endif;?>|
              <?php 
                // $total_man+=count(array_unique($workload[$prolist][$pro]['user']));
                echo isset($workload[$prolist][$pro])?count(array_unique($workload[$prolist][$pro]['user'])).' |':'0 |';?>
              <?php $total_task+=count(array_unique($workload[$prolist][$pro]['task']));
              echo isset($workload[$prolist][$pro])?count(array_unique($workload[$prolist][$pro]['task'])).' |':'0 |';?>
              <?php 
              $total_time+=$workload[$prolist][$pro]['consumed'];
              echo isset($workload[$prolist][$pro])?$workload[$prolist][$pro]['consumed'].' |':'0 |';?>
              <?php 
              $total_left+=$workload[$prolist][$pro]['manhour'];
              echo isset($workload[$prolist][$pro])?$workload[$prolist][$pro]['manhour'].' |':'0 |';?>
              <?php foreach(array_unique($workload[$prolist][$pro]['user']) as $val):?>
                <?php echo $users[$val];?>
              <?php endforeach;?> |
              <?php 
                   echo $allHour*count(array_unique($workload[$prolist][$pro]['user'])).' |';?>
              <?php echo round($workload[$prolist][$pro]['consumed'] / ($allHour*count(array_unique($workload[$prolist][$pro]['user']))), 2) . '%'.' |';?>
  
            <?php  else:?>
             无 | 0 | 0 | 0 | 0 | | 0 | 0 |
                <?php endif;?>
              </li>   
               <?php endforeach;?>
              <?php endforeach;?>
              <li class="list-group-item">|总计| | | |<?php echo $total_task;?>|<?php echo $total_time;?>|<?php echo $total_left;?>| |<?php echo $total_hours;?>|<?php echo round( $total_time/$total_hours, 2) . '%';?>|</li>
            </p>
          </ul>
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
<?php include '../../common/view/footer.html.php';?>
