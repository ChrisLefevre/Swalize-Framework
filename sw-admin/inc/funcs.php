<?php 

/**
 * swcnt_sadmin class.
 */
class swcnt_sadmin
{
    public $datastore;
    
    function __construct()
    {
        if (session_id() == '') {
            session_start();
        }
        
        global $swcnt_options;
        global $swcnt_plugins;
        $swcnt_languages     = $swcnt_options['languages'];
        $swcnt_secure_key    = $swcnt_options['secure_key'];
        $swcnt_blogmode      = $swcnt_options['blog'];
        $swcnt_catalogmode   = $swcnt_options['catalog'];
        $swcnt_portfoliomode = $swcnt_options['portfolio'];
        $swcnt_pagemode 	 = $swcnt_options['pages'];
        $swcnt_crypt         = $swcnt_options['crypt'];
		$this->ldb			 =  $swcnt_options['db_location'];        
        $key                 = md5($swcnt_secure_key);
        $this->key           = $key;
        $this->crypt         = $swcnt_crypt;

        
        
        $confx               = array();
        $swcnt_pluglist      = array();
        foreach ($swcnt_plugins as $pname) {
            include_once 'plugins/' . $pname . '/conf.php';
            
        }
        
        $this->plugins    = $swcnt_pluglist;
        $configfile       = $this->ldb.'db.' . substr(strtolower(md5($key . 'cfile')), 2, 8) . '.conf.php';
        $backupconfigfile = $this->ldb.'backup/db.' . substr(strtolower(md5($key . 'cfile')), 2, 8) . '.' . date("y-m-d") . 'conf.php';
        if (file_exists($configfile)) {
            $c     = file_get_contents($configfile);
            $c     = str_replace("<?php //", "", $c);
            $c     = $this->decrypt($c);
            $confx = json_decode($c, true);
        }
        
        $this->configfile    = $configfile;
        $this->blogmode      = $swcnt_blogmode;
        $this->catalogmode   = $swcnt_catalogmode;
        $this->portfoliomode = $swcnt_portfoliomode;
        $this->pagemode 	 = $swcnt_pagemode;
        $this->configbkpfile = $backupconfigfile;
        $this->key           = $key;
        $this->lang          = 'en';
        $this->confx         = $confx;
        $this->showMessage   = '';
        $this->langlist      = array(
            'fr' => array(
                'iso' => 'fr_FR',
                'txt' => "Français"
            )
            /* 	'nl' => array('iso'=>'nl_NL','txt'=>"Nederlands")
            'en' => array('iso'=>'en_US','txt'=>"English"),
            */
        );
    }
    
    public function loadDatastore($d)
    {
        
        $confx      = array();
        $configfile = $this->ldb.'db.' . $d . '.conf.php';
        
        
        
        
        if (file_exists($configfile)) {
            $c     = file_get_contents($configfile);
            $c     = str_replace("<?php //", "", $c);
            $c     = $this->decrypt($c);
            $confx = json_decode($c, true);
        }
        
        $this->datastore[$d] = $confx;
        return $confx;
    }
    
    public function searchInData($tb, $q)
    {
        $confx = $this->loadDatastore($tb);
        $ret   = array();
        if (!empty($confx)) {
            foreach ($confx as $key => $val) {
                if ($key == $q)
                    $ret[$key] = $val;
                if (array_search($q, $val, true)) {
                    $ret[$key] = $val;
                }
            }
        }
        
        return $ret;
    }
    
    public function setMylang($lang = '')
    {
        if ($lang == '') {
            if (!empty($_GET['language']))
                $lang = $_GET['language'];
            else if (!empty($_COOKIE['language']))
                $lang = $_COOKIE['language'];
            else
                $lang = 'en';
        }
        
        $directory = 'lang/';
        $langlist  = $this->langlist;
            }
    
    public function saveData($d = 'temp', $k, $v)
    {
        $confx         = $this->loadDatastore($d);
        $configfile    = $this->ldb.'db.' . $d . '.conf.php';
        $configbkpfile = $this->ldb.'backup/db.' . $d . '.' . date("y-m-d") . 'conf.php';
        
        
        
        $confx[$k] = $v;
        if (empty($v))
            unset($confx[$k]);
        $c = json_encode($confx);
        
        
        
        
        file_put_contents($configfile, '<?php //' . $this->encrypt($c));
        file_put_contents($configbkpfile, '<?php //' . $this->encrypt($c));
        $this->datastore[$d] = $confx;
    }
    
    public function unlog()
    {
        session_unset();
        session_destroy();
        setcookie("sw_logged_user", '', time() - 3600);
    }
    
    public function islogged()
    {
        if (!empty($_SESSION['swcnt_user'])) {
            return true;
        } else
            return false;
    }
    
    public function userlogged()
    {
        if (!empty($_SESSION['swcnt_user'])) {
            $u['mail']   = $_SESSION['swcnt_user'];
            $u['user']   = $this->getConfigItem('users', $_SESSION['swcnt_user']);
            $u['avatar'] = $this->get_gravatar($_SESSION['swcnt_user']);
            return $u;
        }
    }
    
    public function get_gravatar($email)
    {
        $grav_url = "http://www.gravatar.com/avatar/" . md5(strtolower(trim($email))) . "?d=mm";
        return $grav_url;
    }
    
    public function cleanHtml($string)
    {
        return trim(htmlspecialchars(strtolower($string)));
    }
    
    public function encrypt($string)
    {
        if ($this->crypt == 0)
            return base64_encode($string);
        else {
            $iv_size = mcrypt_get_iv_size(MCRYPT_BLOWFISH, MCRYPT_MODE_ECB);
            $iv      = mcrypt_create_iv($iv_size, MCRYPT_RAND);
            return mcrypt_encrypt(MCRYPT_BLOWFISH, $this->key, $string, MCRYPT_MODE_ECB, $iv);
        }
    }
    
    public function decrypt($crypttext)
    {
        if ($this->crypt == 0)
            return base64_decode($crypttext);
        else {
            $crypttext = ($crypttext);
            $iv_size   = mcrypt_get_iv_size(MCRYPT_BLOWFISH, MCRYPT_MODE_ECB);
            $iv        = mcrypt_create_iv($iv_size, MCRYPT_RAND);
            return trim(mcrypt_decrypt(MCRYPT_BLOWFISH, $this->key, $crypttext, MCRYPT_MODE_ECB, $iv));
        }
    }
    
    public function getConfig($tb)
    {
        $confx   = $this->confx;
        $returna = array();
        if (!empty($confx[$tb])) {
            foreach ($confx[$tb] as $k => $v) {
                if (!empty($v))
                    $returna[$k] = $v;
            }
            
            return $returna;
        }
    }
    
    public function searchInConfig($tb, $q)
    {
        $confx = $this->confx;
        $ret   = array();
        if (!empty($confx[$tb])) {
            foreach ($confx[$tb] as $key => $val) {
                if ($key == $q)
                    $ret[$key] = $val;
                if (array_search($q, $val, true)) {
                    $ret[$key] = $val;
                }
            }
        }
        
        return $ret;
    }
    
    public function searchPatternInConfig($tb, $q)
    {
        
        // Exemple : $adm -> searchPatternInConfig('users','/^.*.com.*/');
        
        $confx = $this->confx;
        $ret   = array();
        if (!empty($confx[$tb])) {
            foreach ($confx[$tb] as $key => $val) {
                if (preg_match($q, $key))
                    $ret[$key] = $val;
                foreach ($val as $valk => $valv) {
                    if (preg_match($q, $valv))
                        $ret[$key] = $val;
                }
            }
        }
        
        return $ret;
    }
    
    public function getConfigItem($tb, $item)
    {
        $confx = $this->confx;
        if (!empty($confx[$tb][$item]))
            return $confx[$tb][$item];
        else
            return array();
    }
    
    public function setShowmessage($txt, $type)
    {
        if ($type == 'alert')
            $this->showMessage = '<div class="pad margin no-print"><div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h4><i class="icon fa fa-ban"></i> Ouuups ! </h4> ' . $txt . '</div></div>';
        if ($type == 'attention')
            $this->showMessage = '<div class="pad margin no-print"><div class="alert alert-warning alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h4><i class="icon fa fa-warning"></i> Attention</h4>
                    ' . $txt . '
                  </div></div>';
        if ($type == 'ok')
            $this->showMessage = '<div class="pad margin no-print"><div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h4>	<i class="icon fa fa-check"></i>  ' . $txt . '</h4>
                  </div></div>';
    }
    
    public function getShowmessage()
    {
        $txt               = $this->showMessage;
        $this->showMessage = '';
        return $txt;
    }
    
    public function setConfig($tb, $k, $v)
    {
        $configfile     = $this->configfile;
        $configbkpfile  = $this->configbkpfile;
        $confx          = $this->confx;
        $confx[$tb][$k] = $v;
        $c              = json_encode($confx);
        file_put_contents($configfile, '<?php //' . $this->encrypt($c));
        file_put_contents($configbkpfile, '<?php //' . $this->encrypt($c));
        $this->confx = $confx;
    }
    
    public function createPass($str)
    {
        $key   = $this->key;
        $str   = trim(strtolower($str));
        $npass = substr(strtolower(md5($key . $str)), 0, 25);
        return $npass;
    }
    
    public function login()
    {
        $users = $this->getConfig('users');
        if (empty($users)) {
            $password = $this->createPass('root');
            $parms    = array(
                'pass' => $password,
                'username' => 'root',
                'role' => 2
            );
            $this->setConfig('users', 'admin@swalize.com', $parms);
        }
        
        if (!empty($_POST['email']) and !empty($_POST['pass'])) {
            $email = $this->cleanHtml($_POST['email']);
            $pass  = $this->createPass($_POST['pass']);
            if (!empty($users[$email])) {
                if ($users[$email]['pass'] == $pass) {
                    $_SESSION['swcnt_user'] = $email;
                    if (!empty($_POST['restconnect'])) {
                        $cook = serialize(array(
                            $email,
                            $pass
                        ));
                        setcookie("sw_logged_user", $cook, time() + 3600 * 24 * 7 * 30);
                    }
                    
                    $this->setShowmessage('Vous êtes connecté', 'ok');
                    header("Location: ./");
                    exit();
                } else
                    $this->setShowmessage('Votre mot de passe est incorrecte', 'alert');
            } else
                $this->setShowmessage('Votre adresse e-mail est inconnue', 'alert');
        } else if (!empty($_COOKIE['sw_logged_user'])) {
            $credits = unserialize($_COOKIE['sw_logged_user']);
            $email   = $credits[0];
            $pass    = $credits[1];
            if (!empty($users[$email])) {
                if ($users[$email]['pass'] == $pass) {
                    $_SESSION['swcnt_user'] = $email;
                    $this->setShowmessage('Vous êtes connecté', 'ok');
                    header("Location: ./");
                    exit();
                }
            }
        }
    }
    
    public function saveUser()
    {
        if (!empty($_POST['email'])) {
            $email = $this->cleanHtml($_POST['email']);
            if (!empty($_POST['delete_user'])) {
                $parms = array();
                $this->setConfig('users', $email, $parms);
                $this->setShowmessage(_tr('Profil Saved'), 'attention');
            }
            
            $baseconf = $this->getConfigItem('users', $email);
            if (!empty($baseconf['username']))
                $username = trim($baseconf['username']);
            if (!empty($baseconf['pass']))
                $password = trim($baseconf['pass']);
            if (!empty($baseconf['role']))
                $role = intval($baseconf['role']);
            if (!empty($_POST['username']))
                $username = trim($_POST['username']);
            if (!empty($_POST['role']))
                $role = intval($_POST['role']);
            if (!empty($_POST['password']) and !empty($_POST['password2'])) {
                $password  = trim($_POST['password']);
                $password2 = trim($_POST['password2']);
                if ($password != $password2) {
                    $password = '';
                    $this->setShowmessage('Les Mots de passe ne correspondent pas', 'alert');
                } else {
                    $password = $this->createPass($password);
                }
            }
            
            if (!empty($username) and !empty($email) and !empty($password) and !empty($role)) {
                $parms = array(
                    'pass' => $password,
                    'username' => $username,
                    'role' => $role
                );
                $this->setConfig('users', $email, $parms);
                $this->setShowmessage(_tr('Profil Saved'), 'ok');
            }
        }
    }
}

class swcnt_tables
{
    function __construct()
    {
	    
    }
    
    public function form($string)
    {
        global $swcnt_form;
        if (!empty($swcnt_form[$string]))
            return $swcnt_form[$string];
    }
    
    public function showformtable($string, $editable = 1)
    {
        $form = $this->form($string);
        $adm  = new swcnt_sadmin();
        if (!empty($_POST['delete_this_form_obj'])) {
            $adm->saveData($string, $_POST['delete_this_form_obj'], array());
        }
        
        $mydatas = $adm->loadDatastore($string);
        if (!empty($form)) {
            echo ' <table id="datatable" class="table table-bordered table-striped">
                    <thead>
                    <tr>';
            foreach ($form as $k => $v) {
                echo '<th>' . $v['label'] . '</th>';
            }
            
            if ($editable == 1)
                echo '<th></th>';
            echo '</thead></tr>';
            foreach ($mydatas as $k => $v) {
                echo '<tr>';
                foreach ($form as $kk => $vv) {
                    if (!empty($v[$kk]))
                        echo '<td>' . $v[$kk] . ' </td>';
                    else
                        echo '<td></td>';
                }
                
                if ($editable == 1)
                    echo '<td><form action="" method="post"><button name="delete_this_form_obj" type="submit" class="btn btn-xs bg-red color-palette" value="' . $k . '"><i class="fa fa-eraser"></i> ' . _tr('delete') . '</button></form></td>';
                echo '</tr>';
            }
            
            echo '</table> ';
        }
    }
}

class swcnt_sforms
{
    public function format_url($texte)
    {
        $texte             = utf8_decode($texte);
        $texte             = html_entity_decode($texte);
        $tofind            = utf8_decode('ÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËéèêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ');
        $replac            = utf8_decode('AAAAAAaaaaaaOOOOOOooooooEEEEeeeeCcIIIIiiiiUUUUuuuuyNn');
        $texte_pre_pre_pre = trim(strtolower(strtr($texte, $tofind, $replac)));
        $texte_pre_pre     = preg_replace('/[^a-zA-Z0-9_]/i', '-', $texte_pre_pre_pre);
        $texte_pre         = preg_replace('/-+/i', '-', $texte_pre_pre);
        $texte_final       = substr($texte_pre, '0', '128');
        return $texte_final;
    }
    
    public function plugin_form($document, $structure, $lang)
    {
        global $swcnt_plugins;
        foreach ($swcnt_plugins as $pname) {
            if ($pname == $_GET['plugin']) {
                $doc  = $this->ldb.'' . $lang . '_plugin_' . $this->format_url($pname) . '_' . $this->format_url($document) . '.source.json';
                $vals = array();
                if (file_exists($doc)) {
                    $d    = file_get_contents($doc);
                    $vals = json_decode($d, true);
                }
                
                $this->createform($structure, $vals);
            }
        }
    }
    
    public function plugin_datas($document, $lang)
    {
        global $swcnt_plugins;
        foreach ($swcnt_plugins as $pname) {
            if ($pname == $_GET['plugin']) {
                $doc  = $this->ldb.'' . $lang . '_plugin_' . $this->format_url($pname) . '_' . $this->format_url($document) . '.source.json';
                $vals = array();
                if (file_exists($doc)) {
                    $d    = file_get_contents($doc);
                    $vals = json_decode($d, true);
                }
                
                return $vals;
            }
        }
    }
    
    public function plugin_save($document, $structure, $lang)
    {
        global $swcnt_plugins;
        $actlang = $this->lang;
        if (!empty($_GET['plugin']) and !empty($_POST)) {
            foreach ($swcnt_plugins as $pname) {
                if ($pname == $_GET['plugin']) {
                    $return = array();
                    foreach ($structure as $k => $v) {
                        if (!empty($_POST[$k])) {
                            $return[$k] = $_POST[$k];
                        }
                    }
                    
                    $final     = json_encode($return);
                    $doc       = $this->ldb.'' . $lang . '_plugin_' . $this->format_url($pname) . '_' . $this->format_url($document) . '.source.json';
                    $backupdoc = $this->ldb.'backup/' . $lang . '_plugin_' . $this->format_url($pname) . '_' . $this->format_url($document) . '.' . date("Y-m-d H:i") . 'source.json';
                    file_put_contents($doc, $final);
                    file_put_contents($backupdoc, $final);
                }
            }
        }
    }
    
    public function save()
    {
        
        
        if (!empty($this->structure)) {
            $structure = $this->structure;
            $doc       = $this->doc;
            $backupdoc = $this->backupdoc;
            if (!empty($_POST)) {
                $return = array();
                foreach ($structure as $k => $v) {
                    if (!empty($_POST[$k])) {
                        if (!empty($_POST[$k][0]['slug'])) {
                            foreach ($_POST[$k] as $atemp_num => $atemp_ko) {
                                $_POST[$k][$atemp_num]['slug'] = $this->format_url($_POST[$k][$atemp_num]['slug']);
                            }
                        }
                        
                        $return[$k] = $_POST[$k];
                    }
                }
                
                
                
                $final = json_encode($return);
                
                
                
                
                if (!empty($this->postId) and !empty($this->pubtype) and !empty($this->lang)) {
                    $pubtype = $this->pubtype;
                    if (!empty($return['title']))
                        $title = $return['title'];
                    
                    else
                        $title = $pubtype . ' ' . $this->postId;
                    
                    
                    if (!empty($return['pubdate']))
                        $pubdate = $return['pubdate'];
                    else
                        $pubdate = date("Y-m-d H:i:s");
                    $parms = array(
                        'title' => $return['title'],
                        'urltxt' => $this->format_url($return['title']),
                        'lang' => $this->lang,
                        'dateupdate' => $pubdate,
                        'status' => $return['status'],
                        'keyword' => $return['keyword'],
                        'category' => $return['category']
                    );
                    $a     = new swcnt_sadmin();
                    
                    $a->saveData($pubtype . 'posts_' . $this->lang, $this->postId, $parms);
                }
                
                
                
                file_put_contents($doc, $final);
                file_put_contents($backupdoc, $final);
                
                /* blog */
                if (empty($_GET['post']) and !empty($this->postId) and !empty($this->lang))
                    echo '<script>window.location.replace("?' . $pubtype . '=edit&lang=' . $this->lang . '&post=' . $this->postId . '");</script>';
                
                
                
            }
        }
    }
    
    public function saveTags($list = 'temp', $tag)
    {
        $doctags        = $this->doctags;
        $backupdoctags  = $this->backupdoctags;
        $alltags[$list] = array();
        if (file_exists($doctags)) {
            $d       = file_get_contents($doctags);
            $alltags = json_decode($d, true);
        }
        
        $tags = explode(',', $tag);
        foreach ($tags as $gt) {
            $alltags[$list][$this->format_url($gt)] = $gt;
        }
        
        $final = json_encode($alltags);
        file_put_contents($doctags, $final);
        file_put_contents($backupdoctags, $final);
    }
    
    private function addformelem($k, $v, $vals)
    {
	    if(empty($v['placeholder'])) $v['placeholder'] = '';
 	    
        echo '<div class="form-group">';
      
      
      
      if (!empty($v['type']) and $v['type'] == 'separation') {
	         
	         echo '<hr/><h3>' . $v['label'] . '</h3>';

	       
	         
	         }
        

      
      
        if (!empty($v['type']) and $v['type'] != 'separation')
            echo '<label for="' . $k . '">' . $v['label'] . '</label>';
        $vv = '';
        if (!empty($vals[$k])) {
            if (!is_array($vals[$k]))
                $vv = htmlspecialchars($vals[$k], ENT_QUOTES);
            else
                $vv = ($vals[$k]);
        }
        
        if (empty($v['type'])) {
            echo '
			<div class="row">
			    <div class="col-md-6">
			
			<label>' . $v['label'] . '</label></div> <div class="col-md-6"><input type="text" value="' . $vv . '" id="input' . $k . '" name="' . $k . '" class="form-control" placeholder="' . $v['label'] . '" /></div></div>';
        }
        
        if ($v['type'] == 'checkbox') {
            echo '<td>';
            foreach ($v['options'] as $key_o => $value_o) {
                
                $checked_o = 0;
                
                if (is_array($vv)) {
                    
                    if (in_array($key_o, $vv)) {
                        $checked_o = 1;
                    }
                }
                
                if ($checked_o == 0)
                    echo '<div  class="checkbox"><label><input type="checkbox" id="inputtitle_' . $k . '" name="' . $k . '[]" value="' . $key_o . '">' . $value_o . '</label></div>';
                else
                    echo '<div  class="checkbox"><label><input type="checkbox" checked id="inputtitle_' . $k . '" name="' . $k . '[]" value="' . $key_o . '">' . $value_o . '</label></div>';
            }
            
            echo '</select>';
            echo ' </td>';
        }
        
        
        if ($v['type'] == 'select') {
            echo '<td><select id="inputtitle_' . $k . '" name="' . $k . '" class="form-control">';
            foreach ($v['options'] as $key_o => $value_o) {
                if ($key_o == $vv)
                    echo '<option selected value="' . $key_o . '">' . $value_o . '</option>';
                else
                    echo '<option value="' . $key_o . '">' . $value_o . '</option>';
            }
            
            echo '</select>';
            echo ' </td>';
        }
        
        
        
        
        if ($v['type'] == 'tags') {
            echo '<input type="text" data-role="tagsinput"  value="' . $vv . '" id="input' . $k . '" name="' . $k . '" class="form-control"  placeholder="' . $v['placeholder'] . '" />';
            $this->saveTags($k, $vv);
        }
        
        if(!empty($v['height'])) $styleHeight = 'style="height:'. $v['height'].'px"'; else $styleHeight = '';
        
        if ($v['type'] == 'input_txt')
            echo '<input type="text" value="' . $vv . '" id="input' . $k . '" name="' . $k . '" class="form-control" placeholder="' . $v['placeholder'] . '" />';
       

        if ($v['type'] == 'link')
            echo ' <div class="input-group" style="width: 100%;"><input type="text" style="width: 30%; float: left;" value="' . $vv['text']. '" id="input' . $k . '_txt" name="' . $k . '[text]" class="form-control" placeholder="' . $v['placeholder'] . '" />
                  <input type="text" style="width: 30%; float: left; margin-right: 1%;" value="' . $vv['link'].'" id="input' . $k . '_lnk" name="' . $k . '[link]" class="form-control" placeholder="http://" /></div>		
            ';
            
           
            
            
            
        if ($v['type'] == 'textarea')
            echo '<textarea '.$styleHeight.' id="input' . $k . '" name="' . $k . '" rows="9" class="form-control" rows="10" placeholder="' . $v['placeholder'] . '">' . $vv . '</textarea>';
        if ($v['type'] == 'htmlarea')
            echo '<textarea '.$styleHeight.' id="input' . $k . '" name="' . $k . '" rows="9" class="form-control summernote" rows="20"  placeholder="' . $v['placeholder'] . '">' . $vv . '</textarea>';
        if ($v['type'] == 'blogarea')
            echo '<textarea '.$styleHeight.' id="input' . $k . '" name="' . $k . '" rows="25" class="form-control tinymce" rows="20"  placeholder="' . $v['placeholder'] . '">' . $vv . '</textarea>';
        
        
                 
                 
                 
                 
        
        if ($v['type'] == 'list') {
            $sub = $v['submenu'];
            
            
            echo '<div class="box-body table-responsive no-padding" style="padding-bottom: 20px !important;" id="dtable_listact_ref_' . $k . '">';
            
            
            if (!empty($v['fixewidth']))
                echo '<table class="table table-hover dtable" style="width:' . $v['fixewidth'] . 'px;" >';
            else
                echo '<table class="table table-hover dtable">';
            echo '<tbody><tr><th></th>';
            foreach ($sub as $o) {
                echo '<th>' . $o['label'] . '</th>';
            }
            
            echo '<th></th></tr>';
            $vvclean = array();
            if (is_array($vv)) {
                foreach ($vv as $tmpk => $tmpv) {
                    $vvclean[$tmpk] = $tmpv;
                }
            }
            
            $nitemax = count($vvclean);
            sort($vvclean);
            for ($i = 0; $i <= $nitemax; $i++) {
                echo '<tr id="liItem' . $k . '-' . $i . '">';
                echo '<td class="movable"><i class="fa fa-fw fa-sort"></i> <input type="hidden" value="' . $i . '" id="inputtitle" name="' . $k . '[' . $i . '][position]" class="form-control" /></td>';
                foreach ($sub as $ok => $ov) {
                    $value = '';
                    if (!empty($vvclean[$i])) {
                        $value = htmlspecialchars($vvclean[$i][$ok]);
                    }
                    
                    
                    
                    /* Add a Textarea, Select and Picture in list */
                    if ($ov['type'] == 'select') {
                        echo '<td><select id="inputtitle_' . $i . '_' . $ok . '" name="' . $k . '[' . $i . '][' . $ok . ']" class="form-control">';
                        foreach ($ov['options'] as $key_o => $value_o) {
                            if ($key_o == $value)
                                echo '<option selected value="' . $key_o . '">' . $value_o . '</option>';
                            else
                                echo '<option value="' . $key_o . '">' . $value_o . '</option>';
                        }
                        
                        echo '</select>';
                        echo ' </td>';
                    }
                    
                    if ($ov['type'] == 'picture') {
                        if (!empty($value))
                            $thumb = '../files/thumb/' . $value;
                        else
                            $thumb = 'assets/dist/img/boxed-bg.jpg';
                        if (!empty($value))
                            $prev = '../files/full/' . $value;
                        else
                            $prev = '';
                        echo '<td><div>
	              <iframe class="picturbtn" src="?uploader=' . $i . '_' . $k . '-' . $ok . '" width="100px" frameborder="0" scrolling="no" height="35px"></iframe>
	              <a href="' . $prev . '" data-title="' . $v['label'] . '" data-toggle="lightbox"><img class="picturpreview" id="picturpreview-' . $i . '_' . $k . '-' . $ok . '" width="40" height="40" src="' . $thumb . '" /></a>
	              <input name="' . $k . '[' . $i . '][' . $ok . ']" value="' . $value . '" id="picturelement-' . $i . '_' . $k . '-' . $ok . '" type="hidden" />
	              </div></td>';
                    }
                    
                    if ($ov['type'] == 'textarea')
                        echo '<td><input onclick="SetTempFormModal(\'#inputtitle_' . $i . '_' . $k . '-' . $ok . '\')" type="text" value="' . $value . '" id="inputtitle_' . $i . '_' . $k . '-' . $ok . '" name="' . $k . '[' . $i . '][' . $ok . ']" class="form-control" placeholder="' . $ov['placeholder'] . '"></td>';
                    if ($ov['type'] == 'input_txt')
                        echo '<td><input type="text" value="' . $value . '" id="inputtitle_' . $i . '_' . $ok . '" name="' . $k . '[' . $i . '][' . $ok . ']" class="form-control" placeholder="' . $ov['placeholder'] . '"></td>';
                    
                    
                    //echo '</tr><tr>';
                    
                    
                }
                
                
                
                
                if ($i == $nitemax)
                    echo '<td><a href="#" onclick="$( \'#formeditor\').submit(); return false" class="btn bg-green color-palette" title="Remove"><i class="fa fa-save"></i> Sauver</a> 
</td></tr>';
                else
                    echo '<td><a href="#" onclick="$(\'#liItem' . $k . '-' . $i . '\').remove(); return false" class="btn bg-red color-palette" title="Remove"><i class="fa fa-eraser"></i> Effacer</a> 
</td></tr>';
            }
            
            echo '</tbody></table>';
            
            
            echo '<a href="javascript:void(0)" class="addelemdtable btn  btn-sm bg-aqua color-palette" data-widget="add" title="Add"><i class="fa fa-check"></i> Ajouter</a>    

                </div>
';
            
            
            
            
        }
        
        
        
        
        
        
        
        
        
        if ($v['type'] == 'user') {
            echo '<select id="input' . $k . '" name="' . $k . '" class="form-control" >';
            $admm  = new swcnt_sadmin();
            $users = $admm->getConfig('users');
            foreach ($users as $vu) {
                if ($vu['username'] == $vv)
                    echo '<option selected="selected" value="' . $vu['username'] . '">' . $vu['username'] . '</option>';
                else
                    echo '<option value="' . $vu['username'] . '">' . $vu['username'] . '</option>';
            }
            
            echo '</select>';
        }
        
        if ($v['type'] == 'datetime') {
            $date = '';
            $time = '';
            if (!empty($vv))
                $datetime = $vv;
            else if (!empty($v['default']))
                $datetime = $v['default'];
            if (isset($datetime)) {
                $date = date('d/m/Y', strtotime($datetime));
                $time = date('H:i', strtotime($datetime));
            }
            
            echo '

            <div class="input-group">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                       <input type="text" value="' . $date . '" placeholder="' . $v['placeholder'] . '"  class="form-control" data-inputmask="\'alias\': \'dd/mm/yyyy\'" onchange="convdate(\'dt_' . $k . '\');" id="dt_' . $k . '_d" data-mask="">

                    </div>

            <div class="input-group">
                      <div class="input-group-addon">
                        <i class="fa fa-clock-o"></i>
                      </div>

                      <input type="text"  value="' . $time . '"onchange="convdate(\'dt_' . $k . '\');" id="dt_' . $k . '_t"  placeholder="' . $v['placeholder'] . '"  class="form-control" data-inputmask="\'alias\': \'hh:mm\'" data-mask="">
                    </div>
                    <input name="' . $k . '" type="hidden" id="dt_' . $k . '"   value="' . $datetime . '">



                    ';
        }
        
        if ($v['type'] == 'picture') {
            if (!empty($vv))
                $thumb = '../files/thumb/' . $vv;
            else
                $thumb = 'assets/dist/img/boxed-bg.jpg';
            if (!empty($vv))
                $prev = '../files/full/' . $vv;
            else
                $prev = '';
            echo '<div>
<iframe class="picturbtn" src="?uploader=' . $k . '" width="150px" frameborder="0" scrolling="no" height="35px"></iframe>
<a href="' . $prev . '" data-title="' . $v['label'] . '" data-toggle="lightbox"><img class="picturpreview" id="picturpreview-' . $k . '" width="40" height="40" src="' . $thumb . '" /></a>
<input name="' . $k . '" value="' . $vv . '" id="picturelement-' . $k . '" type="hidden" />
</div>';
        }
        
        echo ' </div>';
    }
    
    private function createform($structure, $vals)
    {
        
        $sidebar = 0;
        
        echo ' <form action="" id="formeditor" method="post">  <div class="box-body">
		<div class="row">';
        
        foreach ($structure as $k => $v) {
            if (!empty($v['sidebar']))
                $sidebar = 1;
        }
        
        
        if ($sidebar == 1) {
            echo '<div class="col-md-9">';
            foreach ($structure as $k => $v) {
                if (empty($v['sidebar']))
                    $this->addformelem($k, $v, $vals);
            }
            
            echo '</div><div class="col-md-3">';
            foreach ($structure as $k => $v) {
                if (!empty($v['sidebar']))
                    $this->addformelem($k, $v, $vals);
            }
            
            echo '</div>';
            
        }
        
        else {
            
            echo '<div class="col-md-12">';
            foreach ($structure as $k => $v) {
                $this->addformelem($k, $v, $vals);
            }
            
            echo '</div>';
            
            
            
        }
        
        echo '</div>';
        echo ' </div><div class="box-footer">
                    <button type="submit" class="btn btn-primary">Sauver</button>
                  </div></form>';
    }
    
    public function showform()
    {
        if (!empty($this->structure)) {
            $structure = $this->structure;
            $doc       = $this->doc;
            $backupdoc = $this->backupdoc;
            $vals      = array();
            if (file_exists($doc)) {
                $d    = file_get_contents($doc);
                $vals = json_decode($d, true);
            }
            
            
            
            
            $this->createform($structure, $vals);
        }
    }
    
    public function showdatas()
    {
        if (!empty($this->structure)) {
            $structure = $this->structure;
            $doc       = $this->doc;
            $backupdoc = $this->backupdoc;
            $vals      = array();
            if (file_exists($doc)) {
                $d    = file_get_contents($doc);
                $vals = json_decode($d, true);
            }
            
            return $vals;
        }
    }
}

class swcnt_sblog extends swcnt_sforms
{
    private $actpage;
    private $actlang;
    public $mod;
    public $page;
    public $lang;
    public $pagetitle;
    
    function __construct($pubtype = 'blog')
    {
        
        /* $pubtype = 'blog','catalog','portfolio', 'page' */
        
        $this->pubtype = $pubtype;
        
        global ${'swcnt_' . $pubtype};
        global $swcnt_options;
        
        $this->ldb		 =  $swcnt_options['db_location'];   
        $swcnt_blog      = ${'swcnt_' . $pubtype};
        $swcnt_languages = $swcnt_options['languages'];
        $actmode         = '';
        $actpage         = '';
        $actlang         = '';
        $actpostId       = date('ymdHis');
        if (isset($_GET['lang']) and in_array($_GET['lang'], $swcnt_languages))
            $actlang = htmlentities($_GET['lang']);
        else if (isset($swcnt_languages[0]))
            $actlang = $swcnt_languages[0];
        
        
        if (isset($_GET[$pubtype]))
            $actpage = htmlentities($_GET[$pubtype]);
        if (isset($_GET[$pubtype]) and !empty($_GET['post']))
            $actpostId = htmlentities($_GET['post']);
        
        
        if (!empty($swcnt_blog['sw_blocks'])) {
            $structure = $swcnt_blog['sw_blocks'];
            if (!empty($structure['category']['options'])) {
                $sblog_cat = new swcnt_sblog_cat($pubtype);
                $xdatas    = $sblog_cat->showdatas();
                if(!empty($xdatas['elems'])) {
                foreach ($xdatas['elems'] as $v) {
                    $structure['category']['options'][$v['slug']] = $v['name'];
                	}
                }
            }
            
            $doc                 = $this->ldb.'' . $pubtype . '/' . $actpostId . '.source.json';
            $backupdoc           = $this->ldb.'backup/' . $pubtype . '/' . $actpostId . '.' . date("Y-m-d H:i") . 'source.json';
            $this->structure     = $structure;
            $this->doc           = $doc;
            $this->backupdoc     = $backupdoc;
            $doctags             = $this->ldb.'' . $actlang . '_tags_list.source.json';
            $backupdoctags       = $this->ldb.'backup/' . $actlang . '_tags_list.' . date("Y-m-d H:i") . 'source.json';
            $this->doctags       = $doctags;
            $this->backupdoctags = $backupdoctags;
        }
        
        $this->postId = $actpostId;
        $this->page   = $actpage;
        $this->lang   = $actlang;
    }
}





class swcnt_sblog_cat extends swcnt_sforms
{
    private $actpage;
    private $actlang;
    public $mod;
    
    public $page;
    
    public $lang;
    
    public $pagetitle;
    
    function __construct($pubtype = 'blog')
    {
        
        /* $pubtype = 'blog','catalog','portfolio', 'page' */
        
        $this->pubtype = $pubtype;
        global ${'swcnt_' . $pubtype};
        global $swcnt_options;
        $this->ldb			 =  $swcnt_options['db_location'];   
        $swcnt_blog = ${'swcnt_' . $pubtype};
        
        $swcnt_languages = $swcnt_options['languages'];
        $actmode         = '';
        $actpage         = '';
        $actlang         = '';
        $actpostId       = date('ymdHis');
        if (isset($_GET['lang']) and in_array($_GET['lang'], $swcnt_languages))
            $actlang = htmlentities($_GET['lang']);
        else if (isset($swcnt_languages[0]))
            $actlang = $swcnt_languages[0];
        if (isset($_GET[$pubtype]))
            $actpage = htmlentities($_GET[$pubtype]);
        
        
        
       
        $swcnt_blogcatform = array(
            'elems' => array(
                'label' => $swcnt_blog['sw_cat_title'],
                'type' => 'list',
                'placeholder' => '',
                'submenu' => array(
                    'slug' => array(
                        'label' => _tr('Slug name'),
                        'type' => 'input_txt',
                        'placeholder' => 'business,news,livestyle,...'
                    ),
                    'name' => array(
                        'label' => _tr('Name'),
                        'type' => 'input_txt',
                        'placeholder' => 'Business,News,Livestyle,...'
                    ), 
                    'description' => array(
                        'label' => _tr('Description'),
                        'type' => 'textarea',
                        'placeholder' => 'Blablabla'
                    )

                )
            )
        );
        if (!empty($swcnt_blogcatform)) {
            $structure       = $swcnt_blogcatform;
            $doc             = $this->ldb.'' . $pubtype . '/' . $actlang . '_cats.source.json';
            $backupdoc       = $this->ldb.'backup/' . $pubtype . '/' . $actlang . '_cats' . date("Y-m-d H:i") . 'source.json';
            $this->structure = $structure;
            $this->doc       = $doc;
            $this->backupdoc = $backupdoc;
        }
        
        $this->page = $actpage;
        $this->lang = $actlang;
    }
}


















class swcnt_smod extends swcnt_sforms
{
    private $actpage;
    private $actlang;
    public $mod;
    
    public $page;
    
    public $lang;
    
    public $pagetitle;
    
    function __construct()
    {
        global $swcnt_tree;
        global $swcnt_options;
        global $swcnt_plugins;
        
        $this->ldb			 =  $swcnt_options['db_location'];   
        $swcnt_pluglist = array();
        foreach ($swcnt_plugins as $pname) {
            include_once 'plugins/' . $pname . '/conf.php';
            
        }
        
        $swcnt_languages = $swcnt_options['languages'];
        $actmode         = '';
        $actpage         = '';
        $actlang         = '';
        $pagetitle       = '';
        $listmods        = array(
            'editor',
            'users',
            'setting',
            'update',
            'blog',
            'catalog',
            'portfolio',
            'pages',
            'uploader',
            'contact',
            'newsregisters',
            'translate',
            'plugin'
        );
        if (isset($_GET['lang']) and in_array($_GET['lang'], $swcnt_languages))
            $actlang = htmlentities($_GET['lang']);
        else if (isset($swcnt_languages[0]))
            $actlang = $swcnt_languages[0];
        foreach ($_GET as $k => $l) {
            if (in_array($k, $listmods)) {
                $actmode = $k;
                if ($actmode == 'editor')
                    $actpage = $l;
            }
        }
        
        if ($actlang == '')
            $actlang = 'nolang';
        if ($actpage != '' and !empty($swcnt_tree[$actpage]['sw_title'])) {
            $pagetitle = $swcnt_tree[$actpage]['sw_title'];
        }
        
        if ($actpage != '' and !empty($swcnt_tree[$actpage]['sw_blocks'])) {
            $structure           = $swcnt_tree[$actpage]['sw_blocks'];
            $doc                 = $this->ldb.'' . $actlang . '_' . $actpage . '.source.json';
            $backupdoc           = $this->ldb.'backup/' . $actlang . '_' . $actpage . '.' . date("Y-m-d H:i") . 'source.json';
            $doctags             = $this->ldb.'' . $actlang . '_tags_list.source.json';
            $backupdoctags       = $this->ldb.'backup/' . $actlang . '_tags_list.' . date("Y-m-d H:i") . 'source.json';
            $this->structure     = $structure;
            $this->doc           = $doc;
            $this->backupdoc     = $backupdoc;
            $this->doctags       = $doctags;
            $this->backupdoctags = $backupdoctags;
            $this->actpage       = $actpage;
        }
        
        $this->tree      = $swcnt_tree;
        $this->mod       = $actmode;
        $this->page      = $actpage;
        $this->lang      = $actlang;
        $this->listmods  = $listmods;
        $this->pagetitle = $pagetitle;
        $this->plugins   = $swcnt_pluglist;
    }
    
    public function listpages()
    {
        $actpage = $this->actpage;
        $tree    = $this->tree;
        $lang    = $this->lang;
        foreach ($tree as $t => $v) {
            $a_ = ($actpage == $t) ? 'class="active"' : '';
            echo ' <li ' . $a_ . '><a href="?editor=' . $t . '&lang=' . $lang . '"><i class="material-icons">&#xE86F;</i> ' . $v['sw_title'] . '</a></li>';
        }
    }
    
    public function listplugins()
    {
	    
	    
        if (!empty($_GET['plugin']))
            $this->plugact = $_GET['plugin'];
        else
            $this->plugact = '';
        if (!empty($_GET['plugpage']))
            $this->plugpage = $_GET['plugpage'];
        else
            $this->plugpage = '';
        $plugins = $this->plugins;
        foreach ($plugins as $t => $v) {
?>
			 <li class="treeview <?php
            echo ($this->plugact == $t) ? 'active' : '';
?>">
              <a href="?plugin=<?php
            echo $t . '&lang=' . $this->lang;
?>"><i class="material-icons"><?php if(empty($v['icon'])) echo '&#xE1BD;'; else echo $v['icon']; ?></i><span><?php
            echo $v['name'];
?> </span> <?php
            if (!empty($v['pages'])) {
?><i class="fa fa-angle-left pull-right"></i><?php
            }
?></a>
              <?php
            if (!empty($v['pages'])) {
?>
		           <ul class="treeview-menu">   
		              <?php
                foreach ($v['pages'] as $tpage => $vpage) {
                    $a_ = ($this->plugpage == $tpage) ? 'class="active"' : '';
                    echo ' <li ' . $a_ . '><a href="?plugin=' . $t . '&lang=' . $lang . '&plugpage=' . $tpage . '"><i class="material-icons">&#xE146;</i> ' . $vpage . '</a></li>';
                }
?>
		                 </ul>
	            <?php
            }
?>
              
              
            </li>
			<?php
        }
    }
}

function swcnt_image_resize($src, $dst, $width, $height, $crop = 0)
{
    if (!list($w, $h) = getimagesize($src))
        return "Unsupported picture type!";
    $type = strtolower(substr(strrchr($src, "."), 1));
    if ($type == 'jpeg')
        $type = 'jpg';
    switch ($type) {
        case 'bmp':
            $img = imagecreatefromwbmp($src);
            break;
        
        case 'gif':
            $img = imagecreatefromgif($src);
            break;
        
        case 'jpg':
            $img = imagecreatefromjpeg($src);
            break;
        
        case 'png':
            $img = imagecreatefrompng($src);
            break;
        
        default:
            return "Unsupported picture type!";
    }
    
    if ($w == $width and $h == $height) {
        $new_height = $height;
        $new_width  = $width;
        $crop_x     = 0;
        $crop_y     = 0;
    } else if ($w > $h) {
        $new_height = $height;
        $new_width  = floor($w * ($new_height / $h));
        $crop_x     = ceil(($w - $h) / 2);
        $crop_y     = 0;
    } else {
        $new_width  = $width;
        $new_height = floor($h * ($new_width / $w));
        $crop_x     = 0;
        $crop_y     = ceil(($h - $w) / 2);
    }
    
    $new = imagecreatetruecolor($width, $height);
    
    
    
    if ($type == "gif" or $type == "png") {
        imagecolortransparent($new, imagecolorallocatealpha($new, 0, 0, 0, 127));
        imagealphablending($new, false);
        imagesavealpha($new, true);
    }
    
    imagecopyresampled($new, $img, 0, 0, $crop_x, $crop_y, $new_width, $new_height, $w, $h);
    switch ($type) {
        case 'bmp':
            imagewbmp($new, $dst);
            break;
        
        case 'gif':
            imagegif($new, $dst);
            break;
        
        case 'jpg':
            imagejpeg($new, $dst);
            break;
        
        case 'png':
            imagepng($new, $dst);
            break;
    }
    
    return true;
}

?>