<?php
/*
 * @Description: 配置项
 * @Author: xiachaoqing
 * @Date: 2019-07-26 09:50:46
 * @LastEditTime : 2020-01-17 11:29:17
 * @LastEditors  : xiachaoqing
 */
/* Open daily reminder.*/
$config->report                          = new stdclass();
$config->report->dailyreminder           = new stdclass();
$config->report->dailyreminder->bug      = true;
$config->report->dailyreminder->task     = true;
$config->report->dailyreminder->todo     = true;
$config->report->dailyreminder->testTask = true;
$config->report->list->productExport     = 'assignedTo,consumed,left,line,product,id,parent,story,name,project,projectName';
$config->report->list->taskExport      = '';
