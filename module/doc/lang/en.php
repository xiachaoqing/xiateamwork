<?php
/**
 * The doc module english file of ZenTaoPMS.
 *
 * @author      XCQ
 * @package     doc
 * @version     $Id: en.php 824 2010-05-02 15:32:06Z wwccss $
*/
/* Fields. */
$lang->doc->common         = 'Doc';
$lang->doc->id             = 'ID';
$lang->doc->product        = $lang->productCommon;
$lang->doc->project        = $lang->projectCommon;
$lang->doc->lib            = 'Library';
$lang->doc->module         = 'Module';
$lang->doc->title          = 'Title';
$lang->doc->digest         = 'Summary';
$lang->doc->comment        = 'Remark';
$lang->doc->type           = 'Type';
$lang->doc->content        = 'Text';
$lang->doc->keywords       = 'Tags';
$lang->doc->url            = 'URL';
$lang->doc->files          = 'File';
$lang->doc->addedBy        = 'Add By';
$lang->doc->addedDate      = 'Added';
$lang->doc->editedBy       = 'Edit By';
$lang->doc->editedDate     = 'Edited ';
$lang->doc->version        = 'Version';
$lang->doc->basicInfo      = 'Basic Info';
$lang->doc->deleted        = 'Deleted';
$lang->doc->fileObject     = 'The Object';
$lang->doc->whiteList      = 'White List';
$lang->doc->contentType    = 'Format';
$lang->doc->separator      = "<i class='icon-angle-right'></i>";
$lang->doc->fileTitle      = 'File Name';
$lang->doc->filePath       = 'File Path';
$lang->doc->extension      = 'Extension';
$lang->doc->size           = 'Size';
$lang->doc->download       = 'Download';
$lang->doc->acl            = 'Right';
$lang->doc->groups         = 'Groups';
$lang->doc->users          = 'Users';
$lang->doc->item           = ' Items';
$lang->doc->num            = 'Docs';
$lang->doc->searchResult   = 'Search Result';
$lang->doc->fullscreen     = 'Fullscreen';
$lang->doc->retrack        = 'Retrack';

$lang->doc->moduleDoc      = 'By Module';
$lang->doc->searchDoc      = 'Search';
$lang->doc->fast           = 'Qucik Entry';
$lang->doc->allDoc         = 'All Doc';
$lang->doc->openedByMe     = 'My';
$lang->doc->orderByOpen    = 'Last Added';
$lang->doc->orderByEdit    = 'Last Modified';
$lang->doc->orderByVisit   = 'Last Visited';
$lang->doc->todayEdited    = 'Update Today';
$lang->doc->pastEdited     = 'Updated';
$lang->doc->myDoc          = 'My Doc';
$lang->doc->myCollection   = 'My Favorite';

/* ???????????????*/
$lang->doc->index            = 'Doc Home';
$lang->doc->create           = 'Add Doc';
$lang->doc->edit             = 'Edit';
$lang->doc->delete           = 'Delete';
$lang->doc->browse           = 'List';
$lang->doc->view             = 'Details';
$lang->doc->diff             = 'Diff';
$lang->doc->sort             = 'Sort';
$lang->doc->manageType       = 'Manage Category';
$lang->doc->editType         = 'Edit';
$lang->doc->deleteType       = 'Delete';
$lang->doc->addType          = 'Add';
$lang->doc->childType        = 'Child';
$lang->doc->collect          = 'Add Favorites';
$lang->doc->cancelCollection = 'Remove Favorites';
$lang->doc->deleteFile       = 'Detele File';

$lang->doc->libName        = 'Name';
$lang->doc->libType        = 'Category';
$lang->doc->custom         = 'Custom Doc Library';
$lang->doc->customAB       = 'Custom Library';
$lang->doc->createLib      = 'Create Library';
$lang->doc->allLibs        = 'Library';
$lang->doc->objectLibs     = "{$lang->productCommon}/{$lang->projectCommon} Library List";
$lang->doc->showFiles      = 'Doc Library';
$lang->doc->editLib        = 'Edit Library';
$lang->doc->deleteLib      = 'Delete Library';
$lang->doc->fixedMenu      = 'Fix to Menu';
$lang->doc->removeMenu     = 'Remove from Menu';
$lang->doc->search         = 'Search';

/* ?????????????????? */
$lang->doc->allProduct     = 'All' . $lang->productCommon;
$lang->doc->allProject     = 'All' . $lang->projectCommon;

$lang->doc->libTypeList['product'] = $lang->productCommon . ' Library';
$lang->doc->libTypeList['project'] = $lang->projectCommon . ' Library';
$lang->doc->libTypeList['custom']  = 'Custom Library';

$lang->doc->libIconList['product'] = 'icon-cube';
$lang->doc->libIconList['project'] = 'icon-stack';
$lang->doc->libIconList['custom']  = 'icon-folder-o';

$lang->doc->systemLibs['product'] = $lang->productCommon;
$lang->doc->systemLibs['project'] = $lang->projectCommon;

global $config;
if($config->global->flow == 'onlyStory' or $config->global->flow == 'onlyTest') unset($lang->doc->systemLibs['project']);
if($config->global->flow == 'onlyStory' or $config->global->flow == 'onlyTest') unset($lang->doc->libTypeList['project']);
if($config->global->flow == 'onlyTask')  unset($lang->doc->systemLibs['product']);
if($config->global->flow == 'onlyTask')  unset($lang->doc->libTypeList['product']);

$lang->doc->aclList['open']    = 'Public';
$lang->doc->aclList['custom']  = 'Custom';
$lang->doc->aclList['private'] = 'Private';

$lang->doc->typeList['html']     = 'Html';
$lang->doc->typeList['markdown'] = 'Markdown';
$lang->doc->typeList['url']      = 'Url';
// $lang->doc->typeList['word']     = 'Word';
// $lang->doc->typeList['ppt']      = 'PPT';
// $lang->doc->typeList['excel']    = 'Excel';

$lang->doc->types['text'] = 'Text';
$lang->doc->types['url']  = 'URL';

$lang->doc->contentTypeList['html']     = 'HTML';
$lang->doc->contentTypeList['markdown'] = 'MarkDown';

$lang->doc->browseType             = 'Category';
$lang->doc->browseTypeList['list'] = 'List';
$lang->doc->browseTypeList['grid'] = 'Card';

$lang->doc->fastMenuList['byediteddate']  = 'Last Modified';
//$lang->doc->fastMenuList['visiteddate']   = 'Recently Visited';
$lang->doc->fastMenuList['openedbyme']    = 'My Doc';
$lang->doc->fastMenuList['collectedbyme'] = 'My Favorite';

$lang->doc->fastMenuIconList['byediteddate']  = 'icon-folder-upload';
//$lang->doc->fastMenuIconList['visiteddate']   = 'icon-folder-move';
$lang->doc->fastMenuIconList['openedbyme']    = 'icon-folder-account';
$lang->doc->fastMenuIconList['collectedbyme'] = 'icon-folder-star';

$lang->doc->customObjectLibs['files']       = 'Show File Library';
$lang->doc->customObjectLibs['customFiles'] = 'Show Custom Library';

$lang->doc->orderLib = 'Library order settings';
$lang->doc->customShowLibs = 'Library display settings';
$lang->doc->customShowLibsList['zero']     = 'Display empty library';
$lang->doc->customShowLibsList['unclosed'] = 'Only display projects that are not closed';

$lang->doc->confirmDelete      = "Do you want to delete this document?";
$lang->doc->confirmDeleteLib   = "Do you want to delete this Doc Lib?";
$lang->doc->errorEditSystemDoc = "Ssytem document library doesn't have to be changed.";
$lang->doc->errorEmptyProduct  = "No {$lang->productCommon}. It cannot be created.";
$lang->doc->errorEmptyProject  = "No {$lang->projectCommon}. It cannot be created.";
$lang->doc->errorMainSysLib    = "This library cannot be deleted.";
$lang->doc->accessDenied       = "Access denied!";
$lang->doc->versionNotFount    = 'It does not exist in this build.';
$lang->doc->noDoc              = 'No docs. ';
$lang->doc->cannotCreateOffice = 'Sorry, %s can only be created in ZenTao Enterprise. Contact renee@easysoft.ltd to try ZenTao Enterprise.';
$lang->doc->noSearchedDoc      = 'Nothing searched.';
$lang->doc->noEditedDoc        = 'You have not edited any document.';
$lang->doc->noOpenedDoc        = 'You have not created any document.';
$lang->doc->noCollectedDoc     = 'You have not collected any document.';

$lang->doc->noticeAcl['lib']['product']['default'] = 'Users with privileges to access the selected products have access to it.';
$lang->doc->noticeAcl['lib']['product']['custom']  = 'Users with privileges to access the selected products or users in the whiltelist have access to visit it.';
$lang->doc->noticeAcl['lib']['project']['default'] = 'Users with privileges to access the selected projects have access to it.';
$lang->doc->noticeAcl['lib']['project']['custom']  = 'Users with privileges to access the selected projects or users in the whiltelist have access to it.';
$lang->doc->noticeAcl['lib']['custom']['open']     = 'All users have access to it.';
$lang->doc->noticeAcl['lib']['custom']['custom']   = 'Users in the whitelist have access to it.';
$lang->doc->noticeAcl['lib']['custom']['private']  = 'Only the one who created it has access to it.';

$lang->doc->noticeAcl['doc']['open']    = 'Users with privileges to access the doc lib which the doc belongs to have access to it.';
$lang->doc->noticeAcl['doc']['custom']  = 'Users in the whiltelist have access to visit it.';
$lang->doc->noticeAcl['doc']['private'] = 'Only the one who created it has access to it.';

$lang->doc->placeholder = new stdclass();
$lang->doc->placeholder->url = 'Url';

$lang->doclib = new stdclass();
$lang->doclib->name    = 'Name';
$lang->doclib->control = 'Access Control';
$lang->doclib->group   = 'Group';
$lang->doclib->user    = 'User';
$lang->doclib->files   = 'Files';
$lang->doclib->all     = 'All Library';
$lang->doclib->select  = 'Select';
$lang->doclib->project = $lang->projectCommon . ' Library';
$lang->doclib->product = $lang->productCommon . ' Library';

$lang->doclib->aclListA['default'] = 'Default';
$lang->doclib->aclListA['custom']  = 'Custom';

$lang->doclib->aclListB['open']    = 'Public';
$lang->doclib->aclListB['custom']  = 'Custom';
$lang->doclib->aclListB['private'] = 'Private';

$lang->doclib->create['product'] = 'Create ' . $lang->productCommon . ' Library';
$lang->doclib->create['project'] = 'Create ' . $lang->projectCommon . ' Library';
$lang->doclib->create['custom']  = 'Create Custom Library';

$lang->doclib->main['product'] =  'Main Library';
$lang->doclib->main['project'] =  'Main Library';

$lang->doclib->tabList['product'] = $lang->productCommon;
$lang->doclib->tabList['project'] = $lang->projectCommon;
$lang->doclib->tabList['custom']  = 'Custom';

$lang->doclib->nameList['custom'] = 'Doc lib name';
