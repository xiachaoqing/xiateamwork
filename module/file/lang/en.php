<?php
/**
 * The file module English file of ZenTaoPMS.
 *
 * @author      XCQ
 * @package     file
 * @version     $Id: en.php 4129 2013-01-18 01:58:14Z wwccss $
*/
$lang->file = new stdclass();
$lang->file->common        = 'File';
$lang->file->uploadImages  = 'Batch Upload Images';
$lang->file->download      = 'Download Files';
$lang->file->uploadDate    = 'Uploaded';
$lang->file->edit          = 'Rename';
$lang->file->inputFileName = 'Enter File Name';
$lang->file->delete        = 'Delete File';
$lang->file->label         = 'Label:';
$lang->file->maxUploadSize = "<span class='text-red'>%s</span>";
$lang->file->applyTemplate = "Apply Template";
$lang->file->tplTitle      = "Template Name";
$lang->file->setPublic     = "Set Public Template";
$lang->file->exportFields  = "Export Fields";
$lang->file->exportRange   = "Data Range";
$lang->file->defaultTPL    = "Default Template";
$lang->file->setExportTPL  = "Settings";
$lang->file->preview       = "Preview";
$lang->file->addFile       = 'Add';
$lang->file->beginUpload   = 'Upload';
$lang->file->uploadSuccess = 'Uploaded!';

$lang->file->pathname  = 'Path Name';
$lang->file->title     = 'Title';
$lang->file->fileName  = 'File Name';
$lang->file->untitled  = 'Untitled';
$lang->file->extension = 'Format';
$lang->file->size      = 'Size';
$lang->file->encoding  = 'Encoding';
$lang->file->addedBy   = 'Added By';
$lang->file->addedDate = 'Added';
$lang->file->downloads = 'Downloads';
$lang->file->extra     = 'Extra';

$lang->file->dragFile            = 'Please drag here.';
$lang->file->childTaskTips       = 'It\'s child task where \'>\' before the name.';
$lang->file->errorNotExists      = "<span class='text-red'>'%s' is not found.</span>";
$lang->file->errorCanNotWrite    = "<span class='text-red'>'%s' is not writable. Please change its permission. Enter <span class='code'>sudo chmod -R 777 '%s'</span></span> in Linux.";
$lang->file->confirmDelete       = " Do you want to delete it?";
$lang->file->errorFileSize       = " File size exceeds the limit. It cannot be uploaded!";
$lang->file->errorFileUpload     = " Uploading failed. File size might exceeds the limit.";
$lang->file->errorFileFormate    = " Uploading failed, file format is limited.";
$lang->file->errorFileMove       = " Uploading failed, there was an error when moving file.";
$lang->file->dangerFile          = " File has been rejected to upload for security issues.";
$lang->file->errorSuffix         = 'Format is incorrect. .zip files ONLY!';
$lang->file->errorExtract        = 'Extracting file failed. File might be damaged or invalid files in the zip package.';
$lang->file->uploadImagesExplain = 'Note: upload .jpg, .jpeg, .gif, and .png images. The image name will be taken as the title of the story and the image as its content.';
