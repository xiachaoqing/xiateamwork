<?php
/**
 * The build module English file of ZenTaoPMS.
 *
 * @author      XCQ
 * @package     build
 * @version     $Id: en.php 4129 2013-01-18 01:58:14Z wwccss $
*/
$lang->build->common           = "Build";
$lang->build->create           = "Create Build";
$lang->build->edit             = "Edit";
$lang->build->linkStory        = "Link Story";
$lang->build->linkBug          = "Link Bug";
$lang->build->delete           = "Delete Build";
$lang->build->deleted          = "Deleted";
$lang->build->view             = "Build Details";
$lang->build->batchUnlink      = 'Batch Unlink';
$lang->build->batchUnlinkStory = 'Batch Unlink Story';
$lang->build->batchUnlinkBug   = 'Batch Unlink Bug';

$lang->build->confirmDelete      = "Do you want to delete this Build?";
$lang->build->confirmUnlinkStory = "Do you want to unlink this Story?";
$lang->build->confirmUnlinkBug   = "Do you want to unlink this Bug?";

$lang->build->basicInfo = 'Basic Info';

$lang->build->id            = 'ID';
$lang->build->product       = $lang->productCommon;
$lang->build->branch        = 'Platform/Branch';
$lang->build->project       = $lang->projectCommon;
$lang->build->name          = 'Name';
$lang->build->date          = 'Date';
$lang->build->builder       = 'Builder';
$lang->build->scmPath       = 'SCM Path';
$lang->build->filePath      = 'File Path';
$lang->build->desc          = 'Description';
$lang->build->files         = 'File';
$lang->build->last          = 'Last Build';
$lang->build->packageType   = 'Package Type';
$lang->build->unlinkStory   = 'Unlink Story';
$lang->build->unlinkBug     = 'Unlink Bug';
$lang->build->stories       = 'Finished Story';
$lang->build->bugs          = 'Resolved Bug';
$lang->build->generatedBugs = 'Left Bug';
$lang->build->noProduct     = " <span style='color:red'>This {$lang->projectCommon} has not linked to {$lang->productCommon}, so Build cannot be created. Please first <a href='%s'> link {$lang->productCommon}</a></span>";
$lang->build->noBuild       = 'No builds. ';

$lang->build->finishStories = '  %s Story is finished.';
$lang->build->resolvedBugs  = '  %s Bug is resolved.';
$lang->build->createdBugs   = '  %s Bug is  created.';

$lang->build->placeholder = new stdclass();
$lang->build->placeholder->scmPath  = ' Source code repository, e.g. Subversion/Git Library path';
$lang->build->placeholder->filePath = ' Path of this Build package for downloading.';

$lang->build->action = new stdclass();
$lang->build->action->buildopened = '$date, created by <strong>$actor</strong>, Build <strong>$extra</strong>.' . "\n";
$lang->backhome = 'back';
