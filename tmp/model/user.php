<?php
global $app;
helper::cd($app->getBasePath());
helper::import('module/user/model.php');
helper::cd();
class extuserModel extends userModel 
{
public function checkUserLimit()
{
    return $this->loadExtension('bizext')->checkUserLimit();
}

public function getProUserLimit()
{
    return $this->loadExtension('bizext')->getProUserLimit();
}public function identify($account, $password)
{
    /* If ionCube is not loaded, jump to loader-wizard.php. */
    $user = parent::identify($account,$password);
    if($user and !extension_loaded('ionCube Loader'))
    {
        $user->rights = $this->authorize($account);
        $user->groups = $this->getGroups($account);
        $this->session->set('user', $user);

        $documentRoot = isset($_SERVER['SCRIPT_FILENAME']) ? dirname($_SERVER['SCRIPT_FILENAME']) : $_SERVER['DOCUMENT_ROOT'];
        $link         = is_file($documentRoot . '/loader-wizard.php') ? 'loader-wizard.php' : 'http://www.ioncube.com/lw/';
        die(js::locate($link, 'parent'));
    }

    return $this->loadExtension('ldapauth')->identify($account, $password, $user);
}

public function getLDAPConfig()
{
    return $this->loadExtension('ldapauth')->getLDAPConfig();
}

public function getLDAPUser()
{
    return $this->loadExtension('ldapauth')->getLDAPUser();
}

public function importLDAP()
{
if(isset($this->config->bizVersion))
{
    $userLimit = $this->getProUserLimit();
    if($userLimit)
    {
        $user = $this->dao->select("COUNT('*') as count")->from(TABLE_USER)
            ->where('deleted')->eq(0)
            ->andWhere('feedback')->eq(0)
            ->fetch();
        $maxUsers = $user->count >= $userLimit;

        foreach($this->post->add as $i => $add)
        {
            if(!$maxUsers)
            {
                $user->count++;
                if($user->count >= $userLimit) $maxUsers = true;
            }
            else
            {
                unset($_POST['add'][$i]);
            }
        }
    }
}
    return $this->loadExtension('ldapauth')->importLDAP();
}

public function getUserWithoutLDAP()
{
    return $this->loadExtension('ldapauth')->getUserWithoutLDAP();
}
    public function batchCreate()
    {
if(isset($this->config->bizVersion))
{
    $proUserLimit = $this->getProUserLimit();
    if($proUserLimit)
    {
        $user = $this->dao->select("COUNT('*') as count")->from(TABLE_USER)
            ->where('deleted')->eq(0)
            ->andWhere('feedback')->eq('0')
            ->fetch();
        $maxUsers = $user->count >= $proUserLimit;

        foreach($this->post->account as $i => $account)
        {
            if(!empty($this->post->feedback[$i])) continue;
            if(empty($account)) continue;
            if(!$maxUsers)
            {
                $user->count++;
                if($user->count >= $proUserLimit) $maxUsers = true;
            }
            else
            {
                $_POST['account'][$i] = '';
            }
        }
    }
}
        if(empty($_POST['verifyPassword']) or $this->post->verifyPassword != md5($this->app->user->password . $this->session->rand)) die(js::alert($this->lang->user->error->verifyPassword));

        $users    = fixer::input('post')->get();
        $data     = array();
        $accounts = array();
        for($i = 0; $i < $this->config->user->batchCreate; $i++)
        {
            $users->account[$i] = trim($users->account[$i]);
            if($users->account[$i] != '')
            {
                if(strtolower($users->account[$i]) == 'guest') die(js::error(sprintf($this->lang->user->error->reserved, $i+1)));
                $account = $this->dao->select('account')->from(TABLE_USER)->where('account')->eq($users->account[$i])->fetch();
                if($account) die(js::error(sprintf($this->lang->user->error->accountDupl, $i+1)));
                if(in_array($users->account[$i], $accounts)) die(js::error(sprintf($this->lang->user->error->accountDupl, $i+1)));
                if(!validater::checkAccount($users->account[$i])) die(js::error(sprintf($this->lang->user->error->account, $i+1)));
                if($users->realname[$i] == '') die(js::error(sprintf($this->lang->user->error->realname, $i+1)));
                if($users->email[$i] and !validater::checkEmail($users->email[$i])) die(js::error(sprintf($this->lang->user->error->mail, $i+1)));
                $users->password[$i] = (isset($prev['password']) and $users->ditto[$i] == 'on' and empty($users->password[$i])) ? $prev['password'] : $users->password[$i];
                if(!validater::checkReg($users->password[$i], '|(.){6,}|')) die(js::error(sprintf($this->lang->user->error->password, $i+1)));
                $role = $users->role[$i] == 'ditto' ? (isset($prev['role']) ? $prev['role'] : '') : $users->role[$i];

                $data[$i] = new stdclass();
                $data[$i]->dept     = $users->dept[$i] == 'ditto' ? (isset($prev['dept']) ? $prev['dept'] : 0) : $users->dept[$i];
                $data[$i]->account  = $users->account[$i];
                $data[$i]->realname = $users->realname[$i];
                $data[$i]->role     = $role;
                $data[$i]->group    = $users->group[$i] == 'ditto' ? (isset($prev['group']) ? $prev['group'] : '') : $users->group[$i];
                $data[$i]->email    = $users->email[$i];
                $data[$i]->gender   = $users->gender[$i];
                $data[$i]->password = md5(trim($users->password[$i]));
                $data[$i]->commiter = $users->commiter[$i];
                $data[$i]->join     = empty($users->join[$i]) ? '0000-00-00' : ($users->join[$i]);
                $data[$i]->skype    = $users->skype[$i];
                $data[$i]->qq       = $users->qq[$i];
                $data[$i]->dingding = $users->dingding[$i];
                $data[$i]->weixin   = $users->weixin[$i];
                $data[$i]->mobile   = $users->mobile[$i];
                $data[$i]->slack    = $users->slack[$i];
                $data[$i]->whatsapp = $users->whatsapp[$i];
                $data[$i]->phone    = $users->phone[$i];
                $data[$i]->address  = $users->address[$i];
                $data[$i]->zipcode  = $users->zipcode[$i];

                /* Change for append field, such as feedback.*/
                if(!empty($this->config->user->batchAppendFields))
                {
                    $appendFields = explode(',', $this->config->user->batchAppendFields);
                    foreach($appendFields as $appendField)
                    {
                        if(empty($appendField)) continue;
                        if(!isset($users->$appendField)) continue;
                        $fieldList = $users->$appendField;
                        $data[$i]->$appendField = $fieldList[$i];
                    }
                }

                $accounts[$i]     = $data[$i]->account;
                $prev['dept']     = $data[$i]->dept;
                $prev['role']     = $data[$i]->role;
                $prev['group']    = $data[$i]->group;
                $prev['password'] = $users->password[$i];
            }
        }

        $this->loadModel('mail');
        foreach($data as $user)
        {
            if($user->group)
            {
                $group = new stdClass();
                $group->account = $user->account;
                $group->group   = $user->group;
                $this->dao->replace(TABLE_USERGROUP)->data($group)->exec();
            }
            unset($user->group);
            $this->dao->insert(TABLE_USER)->data($user)->autoCheck()->exec();
            if(dao::isError())
            {
                echo js::error(dao::getError());
                die(js::reload('parent'));
            }
            else
            {
                $this->computeUserView($user->account);
                if($this->config->mail->mta == 'sendcloud' and !empty($user->email)) $this->mail->syncSendCloud('sync', $user->email, $user->realname);
            }
        }
    }

    public function create()
    {
if(isset($this->config->bizVersion) and empty($_POST['feedback']) and $this->checkUserLimit())
{
    dao::$errors['userLimit'][] = $this->lang->user->noticeUserLimit;
    return false;
}
        $_POST['account'] = trim($_POST['account']);
        if(!$this->checkPassword()) return;
        if(strtolower($_POST['account']) == 'guest') return false;

        $user = fixer::input('post')
            ->setDefault('join', '0000-00-00' )
            ->setIF($this->post->password1 != false, 'password', md5($this->post->password1))
            ->setIF($this->post->password1 == false, 'password', '')
            ->setIF($this->post->email != false, 'email', trim($this->post->email))
            ->remove('group, password1, password2, verifyPassword')
            ->get();

        if(isset($this->config->safe->mode) and $this->computePasswordStrength($this->post->password1) < $this->config->safe->mode)
        {
            dao::$errors['password1'][] = $this->lang->user->weakPassword;
            return false;
        }

        if(empty($_POST['verifyPassword']) or $this->post->verifyPassword != md5($this->app->user->password . $this->session->rand))
        {
            dao::$errors['verifyPassword'][] = $this->lang->user->error->verifyPassword;
            return false;
        }

        $this->dao->insert(TABLE_USER)->data($user)
            ->autoCheck()
            ->batchCheck($this->config->user->create->requiredFields, 'notempty')
            ->check('account', 'unique')
            ->check('account', 'account')
            ->checkIF($this->post->email != '', 'email', 'email')
            ->exec();
        if(!dao::isError())
        {
            $userID = $this->dao->lastInsertID();
            if($this->post->group)
            {
                $data = new stdClass();
                $data->account = $this->post->account;
                $data->group   = $this->post->group;
                $this->dao->insert(TABLE_USERGROUP)->data($data)->exec();
            }

            $this->computeUserView($user->account);
            $this->loadModel('action')->create('user', $userID, 'Created');
            $this->loadModel('mail');
            if($this->config->mail->mta == 'sendcloud' and !empty($user->email)) $this->mail->syncSendCloud('sync', $user->email, $user->realname);
        }
    }

//**//
}