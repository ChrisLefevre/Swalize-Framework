<?php


class swcnt_sadmin
{
	
	public $datastore;
	
	
	function __construct()
	{
		if(session_id() == '') {
		session_start();
		}
		global $swcnt_secure_key;
		$key = md5($swcnt_secure_key);
		$this->key = $key;
		$confx = array();
		

		
		$configfile = 'ldb/db.'.substr(strtolower(md5($key.'cfile')),2,8).'.conf.php';
		$backupconfigfile = 'ldb/backup/db.'.substr(strtolower(md5($key.'cfile')),2,8).'.'.date("y-m-d").'conf.php';
		
		if(file_exists($configfile))
		{
			$c = file_get_contents($configfile);
			$c = str_replace("<?php //","",$c);
			$c = $this->decrypt($c);
			$confx = json_decode($c,true);
			
		}
	$this->configfile = $configfile;
	$this->configbkpfile = $backupconfigfile;
	$this->key = $key;
	$this->confx = $confx;
	$this->showMessage = '';

	}



public function loadDatastore($d) {
	$confx = [];
	
	$configfile = 'ldb/db.'.$d.'.conf.php';
	if(file_exists($configfile))
		{
			$c = file_get_contents($configfile);
			$c = str_replace("<?php //","",$c);
			$c = $this->decrypt($c);
			$confx = json_decode($c,true);		
		}
		$this->datastore[$d] = $confx;
		return $confx;	
	
}


public function searchInData($tb,$q) {
		$confx = $this->loadDatastore($tb);
			
		$ret = [];
		
		if(!empty($confx)) {
			
		foreach ($confx as $key => $val) {
		
		if($key==$q) $ret[$key]=$val;
			
       if(array_search($q,$val,true)) {
	       $ret[$key]=$val;
	       
       			}   
       
       		}
  		}
  		return $ret;	
	}



public function saveData($d='temp',$k,$v) {
		
		$confx = $this->loadDatastore($d);
		$configfile = 'ldb/db.'.$d.'.conf.php';
		$configbkpfile = 'ldb/backup/db.'.$d.'.'.date("y-m-d").'conf.php';
		
		//$confx = $this->datastore[$d];
		$confx[$k]= $v;
		
		$c = json_encode($confx);
		
		file_put_contents($configfile,'<?php //'.$this->encrypt($c)) ; 
		file_put_contents($configbkpfile,'<?php //'.$this->encrypt($c)) ; 
	
		$this->datastore[$d] = $confx;
	}







public function unlog() { 
	
session_unset();	
session_destroy();
setcookie ("sw_logged_user", '' , time() - 3600);
} 

	
	
public function islogged() { 
	

	
if(!empty($_SESSION['swcnt_user'])) {
	return true;
	
	} else return false;

} 


public function userlogged() { 
	

	
if(!empty($_SESSION['swcnt_user'])) {
	
	$u['mail'] = $_SESSION['swcnt_user'];
	$u['user'] = $this->getConfigItem('users',$_SESSION['swcnt_user']);
	$u['avatar'] = $this->get_gravatar($_SESSION['swcnt_user']);	
	return $u ;
	
	
	} 

} 


public function get_gravatar($email) {
  
$grav_url = "http://www.gravatar.com/avatar/" . md5( strtolower( trim( $email) ) ) . "?d=mm" ;	
return $grav_url ;
}	
	
	
public function cleanHtml($string) { 
    return trim(htmlspecialchars(strtolower($string)));
} 

	

public function encrypt($string) { 
  $iv_size = mcrypt_get_iv_size(MCRYPT_BLOWFISH, MCRYPT_MODE_ECB); 
  $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND); 
  return (mcrypt_encrypt(MCRYPT_BLOWFISH, $this->key , $string, MCRYPT_MODE_ECB, $iv)); 
} 


public function decrypt($crypttext) { 
$crypttext = ($crypttext);
  $iv_size = mcrypt_get_iv_size(MCRYPT_BLOWFISH, MCRYPT_MODE_ECB); 
  $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND); 
  return trim(mcrypt_decrypt(MCRYPT_BLOWFISH, $this->key , $crypttext, MCRYPT_MODE_ECB, $iv)); 
} 

	public function getConfig($tb) {
		$confx = $this->confx;
		$returna = [];
		if(!empty($confx[$tb])) {
			foreach($confx[$tb] as $k => $v) {
				
				if(!empty($v)) $returna[$k] = $v;	
			} 
			return $returna;
		}
		
		
		
		
	}
	
	public function searchInConfig($tb,$q) {
		$confx = $this->confx;
		
		$ret = [];
		
		if(!empty($confx[$tb])) {
			
		foreach ($confx[$tb] as $key => $val) {
		
		if($key==$q) $ret[$key]=$val;
			
       if(array_search($q,$val,true)) {
	       $ret[$key]=$val;
	       
       			}   
       
       		}
  		}
  		return $ret;	
	}
	
	public function searchPatternInConfig($tb,$q) {
		
		// Exemple : $adm -> searchPatternInConfig('users','/^.*.com.*/');
  
		$confx = $this->confx;
		
		$ret = [];
		
		if(!empty($confx[$tb])) {
			
		foreach ($confx[$tb] as $key => $val) {
		if (preg_match($q,$key)) $ret[$key]=$val; 
		foreach ($val as $valk => $valv) {
			if (preg_match($q,$valv)) $ret[$key]=$val; 	

				}
		    }
  		}
  		return $ret;	
	}
	
	
	public function getConfigItem($tb,$item) {
		$confx = $this->confx;
		if(!empty($confx[$tb][$item])) return $confx[$tb][$item]; else return [];
		
	}
	
		
	public function setShowmessage($txt,$type) {
		
		
		if ($type=='alert') $this->showMessage =
		'<div class="pad margin no-print"><div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h4><i class="icon fa fa-ban"></i> Ouuups ! </h4> '.$txt.'</div></div>'; 
        if ($type=='attention') $this->showMessage =
		'<div class="pad margin no-print"><div class="alert alert-warning alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h4><i class="icon fa fa-warning"></i> Attention</h4>
                    '.$txt.'
                  </div></div>'; 
		if ($type=='ok') $this->showMessage = '<div class="pad margin no-print"><div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h4>	<i class="icon fa fa-check"></i>  '.$txt.'</h4>
                  </div></div>';
		
	}		
	
	public function getShowmessage() {
		
		$txt = $this->showMessage;
		$this->showMessage = '';
		return $txt ;
	}		
	
	
	public function setConfig($tb,$k,$v) {
		
		$configfile = $this->configfile;
		$configbkpfile = $this->configbkpfile;
		
		
		$confx = $this->confx;
		$confx[$tb][$k]= $v;
		
		$c = json_encode($confx);
		
		file_put_contents($configfile,'<?php //'.$this->encrypt($c)) ; 
		
		file_put_contents($configbkpfile,'<?php //'.$this->encrypt($c)) ; 
	
		$this->confx = $confx;
		
		
		
		
	}
	
	
	public function createPass($str) {
		
		$key = $this->key;
		$str = trim(strtolower($str));
		$npass = substr(strtolower(md5($key.$str)),0,25);
		return $npass;
	}
	
	
	public function login() { 
		$users = $this-> getConfig('users');
		
		if(empty($users)) {
			
			
			$password = $this->createPass('root');
			$parms = array(
				'pass' => $password,
				'username' => 'root',
				'role' => 2,
				);
				$this ->  setConfig('users','admin@swalize.com',$parms);
			
		}
		
		
		if(!empty($_POST['email']) and !empty($_POST['pass'])) {
				
				$email = $this->cleanHtml($_POST['email']);
				$pass = $this->createPass($_POST['pass']);
		
 
				
		
		
		if(!empty($users[$email])) {
		
		if($users[$email]['pass']==$pass) {
		$_SESSION['swcnt_user'] = $email;
		
		if(!empty($_POST['restconnect'])) {
			
			$cook = serialize(array($email,$pass));
			
			setcookie ("sw_logged_user", $cook , time() + 3600*24*7*30);
			
		}
		
		
		$this-> setShowmessage('Vous êtes connecté','ok');
		 header("Location: ./"); exit();
		 
		
		} else $this-> setShowmessage('Votre mot de passe est incorrecte','alert');
		
				
		} else $this-> setShowmessage('Votre adresse e-mail est inconnue','alert');
		
		}
		
		else if(!empty($_COOKIE['sw_logged_user'])) {
			
			$credits = unserialize($_COOKIE['sw_logged_user']);
			$email = $credits[0];
			$pass = $credits[1];
			
			if(!empty($users[$email])) {
		
		if($users[$email]['pass']==$pass) {
			$_SESSION['swcnt_user'] = $email;
			$this-> setShowmessage('Vous êtes connecté','ok');
			header("Location: ./"); exit();
			
			
			}
			
			}
			
			
		}
		
		
		
	} 

	
	
	
	public function saveUser()
	{



			
		if(!empty($_POST['email'])) {
			
			$email = $this->cleanHtml($_POST['email']);
			
			
			if(!empty($_POST['delete_user'])) {
				
				
				$parms = array(
				
				);
				$this ->  setConfig('users',$email,$parms);
				$this->setShowmessage('Ce profil est supprimé','attention');

				
				
			}

			
			
			
			
			
			$baseconf = $this -> getConfigItem('users',$email);
			
			
			if(!empty($baseconf['username'])) $username = $this->cleanHtml($baseconf['username']);
			if(!empty($baseconf['pass'])) $password = trim($baseconf['pass']);
			if(!empty($baseconf['role'])) $role = intval($baseconf['role']);


			if(!empty($_POST['username'])) $username = $this->cleanHtml($_POST['username']);
			if(!empty($_POST['role'])) $role = intval($_POST['role']);

			
			if(!empty($_POST['password']) and !empty($_POST['password2']) ) {
				
				$password = trim($_POST['password']);
				$password2 = trim($_POST['password2']);
				
				
				if($password!=$password2) { 
					$password ='';
					$this->setShowmessage('Les Mots de passe ne correspondent pas','alert');
					
					
					
					
					}
				else {
					$password = $this->createPass($password);
					
					
					}
				
				
				}
		
			


			if(!empty($username) and !empty($email) and !empty($password)  and !empty($role) ) {
				
				$parms = array(
				'pass' => $password,
				'username' => $username,
				'role' => $role,
				);
				$this ->  setConfig('users',$email,$parms);
				$this->setShowmessage('Le profil est sauvé','ok');
				
				}

			}



		}
	
	
	
		
}



class swcnt_sforms
{
	
	
function format_url($texte) {
$texte = html_entity_decode($texte);
$tofind = utf8_decode('ÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËéèêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ');
$replac = utf8_decode('AAAAAAaaaaaaOOOOOOooooooEEEEeeeeCcIIIIiiiiUUUUuuuuyNn');
$texte_pre_pre_pre = trim(strtolower(strtr($texte,$tofind,$replac)));
$texte_pre_pre = preg_replace('/[^a-zA-Z0-9_]/i', '-', $texte_pre_pre_pre);
$texte_pre = preg_replace('/-+/i', '-', $texte_pre_pre);
$texte_final = substr($texte_pre, '0', '128');
return $texte_final;
}	
	
	
	public function save()
	{
		if (!empty($this->structure))
		{
			$structure = $this->structure;
			$doc = $this->doc;
			$backupdoc = $this->backupdoc;


			if
			(!empty($_POST))
			{

				$return = array();



				foreach
				($structure as $k => $v)
				{

					if
					(!empty($_POST[$k]))
					{

						$return[$k] = $_POST[$k];

					}


				}

				$final = json_encode($return);


				
				
				if(!empty($this->postId) and !empty($this->lang)) {
					if (!empty($return['title'])) $title = $return['title']; else  $title = 'post '.$this->postId;
					
					 if (!empty($return['pubdate'])) $pubdate = $return['pubdate']; else $pubdate = date("Y-m-d H:i:s");
				$parms = array(
				'title' => $return['title'],
				'urltxt' => $this->format_url($return['title']),
				'lang' => $this->lang,
				'dateupdate' => $pubdate
				);
				
				$a = new swcnt_sadmin();
				$a->saveData('blogposts_'.$this->lang,$this->postId,$parms);
				

				}
				
				
				
				file_put_contents($doc, $final) ;
				file_put_contents($backupdoc, $final) ;
				

			}

		}

	}

	private function addformelem($k,$v,$vals) {
		
		
		
		echo '<div class="form-group"> <label for="'.$k.'">'.$v['label'].'</label>
                                            ';
				$vv = '';
				if
				(!empty($vals[$k]))
				{
					$vv = htmlentities($vals[$k]);

				}

				if ($v['type']=='input_txt')
					echo '<input type="text" value="'.$vv.'" id="input'.$k.'" name="'.$k.'" class="form-control" placeholder="'.$v['placeholder'].'" />';
					
				if ($v['type']=='textarea')
					echo '<textarea id="input'.$k.'" name="'.$k.'" rows="9" class="form-control" rows="10" placeholder="'.$v['placeholder'].'">'.$vv.'</textarea>';


				if ($v['type']=='htmlarea')
					echo '<textarea id="input'.$k.'" name="'.$k.'" rows="9" class="form-control summernote" rows="20"  placeholder="'.$v['placeholder'].'">'.$vv.'</textarea>';
					
					
					
					if ($v['type']=='datetime') {
						
						$date = '';
						$time  = '';
						
						if(!empty($vv)) $datetime = $vv;
						else if(!empty($v['default'])) $datetime = $v['default'];
						
						if(isset($datetime)) {
						$date = date('d/m/Y',strtotime($datetime));
						$time = date('H:i',strtotime($datetime));					
							
							
						}
						
					echo ' 
				
            <div class="input-group">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                       <input type="text" value="'.$date.'" placeholder="'.$v['placeholder'].'"  class="form-control" data-inputmask="\'alias\': \'dd/mm/yyyy\'" onchange="convdate(\'dt_'.$k.'\');" id="dt_'.$k.'_d" data-mask=""> 
   
                    </div>
           
            <div class="input-group">
                      <div class="input-group-addon">
                        <i class="fa fa-clock-o"></i>
                      </div>
                
                      <input type="text"  value="'.$time .'"onchange="convdate(\'dt_'.$k.'\');" id="dt_'.$k.'_t"  placeholder="'.$v['placeholder'].'"  class="form-control" data-inputmask="\'alias\': \'hh:mm\'" data-mask="">
                    </div>
                    <input name="'.$k.'" type="hidden" id="dt_'.$k.'"   value="'.$datetime.'">
          
					
					                    
                    ';
					
					}
					
					
			

					if ($v['type']=='picture') {
					
					if(!empty($vv)) $thumb = 'upload/thumb/'.$vv; else $thumb =  'assets/dist/img/boxed-bg.jpg';
					if(!empty($vv)) $prev = 'upload/gallery/'.$vv; else $prev =  '';
					
					echo '<div>
<iframe class="picturbtn" src="?uploader='.$k.'" width="150px" frameborder="0" scrolling="no" height="35px"></iframe>
<a href="'.$prev.'" data-title="'.$v['label'].'" data-toggle="lightbox"><img class="picturpreview" id="picturpreview-'.$k.'" width="40" height="40" src="'.$thumb.'" /></a>
<input name="'.$k.'" value="'.$vv.'" id="picturelement-'.$k.'" type="hidden" />
</div>';
					
						 }
				echo ' </div>';
		
		}

	
	private function createform($structure,$vals) {
		
		echo ' <form action="" method="post">  <div class="box-body">
		<div class="row">
            <div class="col-md-9">';
            
            foreach ($structure as $k => $v)
			{
			if(empty($v['sidebar'])) $this->addformelem($k,$v,$vals);
			}
            
            echo '</div><div class="col-md-3">';
            
            foreach ($structure as $k => $v)
			{
			if(!empty($v['sidebar'])) $this->addformelem($k,$v,$vals);
			}
            
            echo '</div></div>';

			
			
				echo ' </div><div class="box-footer">
                    <button type="submit" class="btn btn-primary">Sauver</button>
                  </div></form>';
		
		
	}
	


	public  function showform()
	{
		if (!empty($this->structure))
		{
			$structure = $this->structure;
			$doc = $this->doc;
			$backupdoc = $this->backupdoc;
			$vals = array();



			if
			(file_exists($doc))
			{

				$d = file_get_contents($doc);
				$vals  = json_decode($d, true);

			}

			$this->createform($structure,$vals);

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

	function __construct()
	{
		global $swcnt_blog;
		global $swcnt_languages;

		$actmode = '';
		$actpage = '';
		$actlang = '';
		$actpostId = date('ymdhis');
		
		
		if
		(isset($_GET['lang']) and in_array($_GET['lang'], $swcnt_languages)) $actlang  = htmlentities($_GET['lang']);
		else if
			(isset($swcnt_languages[0])) $actlang  =  $swcnt_languages[0];
			
		if (isset($_GET['blog'])) $actpage = htmlentities($_GET['blog']);
		if (isset($_GET['blog']) and !empty($_GET['post'])) $actpostId= htmlentities($_GET['post']);
		
			

		if
		(!empty($swcnt_blog['sw_blocks']))
		{
			
			$structure = $swcnt_blog['sw_blocks'];

			
			$doc = 'ldb/blog/'.$actpostId.'.source.json';
			$backupdoc = 'ldb/backup/blog/'.$actpostId.'.'.date("Y-m-d H:i").'source.json';
			$this->structure = $structure;
			$this->doc = $doc;
			$this->backupdoc = $backupdoc;
		
		}


			
		$this->postId = $actpostId;
		$this->page  = $actpage;
		$this->lang  = $actlang;

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
		global $swcnt_languages;

		$actmode = '';
		$actpage = '';
		$actlang = '';
		$pagetitle = '';
		$listmods = ['editor', 'users', 'setting','update','blog','uploader'];

		if
		(isset($_GET['lang']) and in_array($_GET['lang'], $swcnt_languages)) $actlang  = htmlentities($_GET['lang']);
		else if
			(isset($swcnt_languages[0])) $actlang  =  $swcnt_languages[0];


			foreach
			($_GET as $k => $l)
			{
				if
				(in_array($k, $listmods))
				{

					$actmode = $k;
					if
					($actmode=='editor') $actpage = $l;
				}

			}





		if
		($actlang=='') $actlang = 'nolang';
		
		if
		($actpage!='' and !empty($swcnt_tree[$actpage]['sw_title']))
		{

			$pagetitle = $swcnt_tree[$actpage]['sw_title'];

		}


		if
		($actpage!='' and !empty($swcnt_tree[$actpage]['sw_blocks']))
		{

			$structure = $swcnt_tree[$actpage]['sw_blocks'];


			$doc = 'ldb/'.$actlang.'_'.$actpage.'.source.json';
			$backupdoc = 'ldb/backup/'.$actlang.'_'.$actpage.'.'.date("Y-m-d H:i").'source.json';
			$this->structure = $structure;
			$this->doc = $doc;
			$this->backupdoc = $backupdoc;
			$this->actpage = $actpage;
		}
		$this->tree = $swcnt_tree;
		$this->mod  = $actmode;
		$this->page  = $actpage;
		$this->lang  = $actlang;
		$this->listmods  = $listmods;
		$this->pagetitle = $pagetitle;
		
	}


	

	public function listpages()
	{
		$actpage = $this->actpage;
		$tree = $this->tree;
		$lang = $this->lang;

		foreach
		($tree as $t => $v)
		{
			$a_ = ($actpage==$t) ? 'class="active"' : '';
			echo ' <li '.$a_.'><a href="?editor='.$t.'&lang='.$lang.'"><i class="fa fa-circle-o"></i> '.$v['sw_title'].'</a></li>';
		}
	}
	
	



}




?>