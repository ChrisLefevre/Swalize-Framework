<?php
	
	include_once(ADMIN_URL.'controls/config.php');
	include (ADMIN_URL.'controls/models.php');
	
	class sw
{
	
	public $datastore;
	
	
	function __construct() {
		
		global $swcnt_options;
		$swcnt_languages = $swcnt_options['languages'];
		$swcnt_secure_key = $swcnt_options['secure_key'];
		$swcnt_urlrewriting = $swcnt_options['urlrewriting'];

		$key = md5($swcnt_secure_key);
		
		if	(isset($_GET['lang']) and in_array($_GET['lang'], $swcnt_languages)) $actlang  = htmlentities($_GET['lang']);
		else if (isset($swcnt_languages[0])) $actlang  =  $swcnt_languages[0];
		if	($actlang=='') $actlang = 'nolang';
		$this->lang  = $actlang;
		$this->key = $key;
		
		$this->urlrewriting = $swcnt_urlrewriting;
		
	}
	
	
	public function setmessage($message) {
		setcookie("sw_tmp_message", $message, time() + 3600*24*7*30);
	}
	
	public function getmessage() {
		if (!empty($_COOKIE["sw_tmp_message"])) {
		
			setcookie("sw_tmp_message", '', time() - 3600*24*7*30);
			return '<div class="alert alert-warning alert-dismissable">'.$_COOKIE["sw_tmp_message"].'</div>';	
		}
		return '';
	}
	
	
	public function form($string)
	{
		global $swcnt_form;
		if(!empty($swcnt_form[$string])) return $swcnt_form[$string];
		
	}
	
	public function saveform($string)
	{	$form = $this-> form($string);
		
		$thisformvalues = array();
		
		foreach ($form as $k => $v ) {
		if(!empty($_POST[$k])) $thisformvalues[$k] = htmlentities($_POST[$k]);
		
		
		}
		$this->saveData($string, date("Y-m-d H:i:s"), $thisformvalues);
		return $thisformvalues;
		
	}
	
	
	public function mailform($string,$email='')
	{	$form = $this-> form($string);
		
		global $swcnt_options;
		
		if ($email=='') $email= $swcnt_options['contact_email'];
		
		$from = $swcnt_options['contact_email'];
		
		
		
		$body = _("You have received a new message from your website contact form").".\n\n";

		
		$thisformvalues = array();
		
		foreach ($form as $k => $v ) {
		if(!empty($_POST[$k])) { 
		
			
		$thisformvalues[$k] = htmlentities($_POST[$k]);
		if ($k=='email' or $k=='mail') $from = $thisformvalues[$k];
			$body = $body . $k." ".$thisformvalues[$k]."\n\n";
		
		
		}
		}
		
		$subject = "Website email ".$string;
		
		$headers = "From: $from\n"; 
		
		$headers .= "Reply-To: $from";	
		mail($email,$subject,$body,$headers);
		return true;			
	
		
		
	}
	
	
		
	public function saveData($d='temp', $k, $v)
	{

		$confx = $this->loadDatastore($d);
		$configfile = ADMIN_URL.'ldb/db.'.$d.'.conf.php';
		$configbkpfile = ADMIN_URL.'ldb/backup/db.'.$d.'.'.date("y-m-d").'conf.php';

		//$confx = $this->datastore[$d];
		$confx[$k]= $v;

		$c = json_encode($confx);

		file_put_contents($configfile, '<?php //'.$this->encrypt($c)) ;
		file_put_contents($configbkpfile, '<?php //'.$this->encrypt($c)) ;

		$this->datastore[$d] = $confx;
	}


	
	
	public function showform($string,$action="",$btnname="Send")
	{	$form = $this-> form($string);
		
		echo ' <form name="sentMessage" id="contactForm" method="post" action="'.$action.'" novalidate>';
		
		foreach ($form as $k => $v ) {
			echo ' <div class="row control-group">
                        <div class="form-group col-xs-12 floating-label-form-group controls">
                            <label>'.$v['label'].'</label>';
                            
                            
                            if(!empty($v['required'])) $req = 'required data-validation-required-message="'.$v['required'].'"'; else $req =''; 
                            
                       if($v['type']== 'input_txt')   echo ' <input type="text" name="'.$k.'"  class="form-control" placeholder="'.$v['label'].'" id="inp_'.$k.'" '.$req.' /> ';
                            
                            
                              if($v['type']== 'textarea')   echo ' <textarea rows="5" name="'.$k.'"  class="form-control" placeholder="'.$v['label'].'" id="inp_'.$k.'" '.$req.'></textarea>';

                            
                            echo '<p class="help-block text-danger"></p>
                        </div>
                    </div>
                    ';
			
			}
			
			echo '                  <br>
                    <div id="success"></div>
                    <div class="row">
                        <div class="form-group col-xs-12">
                            <button type="submit" class="btn btn-default">'.$btnname.'</button>
                        </div>
                    </div>
                </form>';
		
		
		
				
	}
	

	
	
	
	public function encrypt($string)
	{
		$iv_size = mcrypt_get_iv_size(MCRYPT_BLOWFISH, MCRYPT_MODE_ECB);
		$iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
		return mcrypt_encrypt(MCRYPT_BLOWFISH, $this->key , $string, MCRYPT_MODE_ECB, $iv);
	}


	public function decrypt($crypttext)
	{
		$crypttext = ($crypttext);
		$iv_size = mcrypt_get_iv_size(MCRYPT_BLOWFISH, MCRYPT_MODE_ECB);
		$iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
		return trim(mcrypt_decrypt(MCRYPT_BLOWFISH, $this->key , $crypttext, MCRYPT_MODE_ECB, $iv));
	}

	
	function block($actpage) {
		
		global $swcnt_tree;
		$actlang = $this->lang ;
		$slots = [];
		
		if
		($actpage!='' and !empty($swcnt_tree[$actpage]['sw_blocks']))
		{

			$structure = $swcnt_tree[$actpage]['sw_blocks'];


			$doc = ADMIN_URL.'ldb/'.$actlang.'_'.$actpage.'.source.json';
			$this->structure = $structure;
			$this->doc = $doc;
			$this->page = $actpage;
			
			if
			(file_exists($doc))
			{

				$d = file_get_contents($doc);
				$slots  = json_decode($d, true);
				
				
			}
			return $slots;
			
		}

	}
	
function blogpost($id) {
	$bpost  = [] ;	
	
$blogposts = $this -> searchInData('blogposts_'.$this -> lang,$id);
if (!empty($blogposts)) {
	
	foreach($blogposts as $k => $v) {
		$bpost = $this ->  getPostBlogById($k);
		
		}
	
	}
	return $bpost ;
}
	
	
function blogposts($page = 1,$maxitems=10) {
$bpost  = [] ;	
	
$blogposts =  $this->loadDatastore('blogposts_'.$this -> lang);
krsort($blogposts);

$itemstart = ($page -1)*$maxitems;
$itemend = ($page)*$maxitems;
if($itemstart<0) $itemstart=0;




if (!empty($blogposts)) {
$n = 0;	
	foreach($blogposts as $k => $v) {
		
		if($n>=$itemstart and $n<$itemend) {
		
	
		
		
		
		$bpost[$k] = $this ->  getPostBlogById($k);
		$bpost[$k]['lang'] = $v['lang'];
		$bpost[$k]['urltxt'] = $v['urltxt'];
			}
			$n++;
		}
	
	}
	return $bpost ;
}
		
	
	
	
	
	
	
	
	
	/*
		
		
		
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
		
		
		
		*/
	
	
	
	
	
	function uri($page,$arg='') {
		
		

		$swcnt_urlrewriting = $this->urlrewriting ;
		
		if( $arg== '') {
		if($swcnt_urlrewriting) return $this->lang.'/'.$page;
		else return '?lang='.$this->lang.'&page='.$page;
			
			
			
		} else {
		if($swcnt_urlrewriting) return $this->lang.'/'.$page.'/'.$arg;
		else return '?lang='.$this->lang.'&page='.$page.'&id='.$arg;
			
			
			
		}
		
		

		
		
		}
		
		public function loadDatastore($d)
	{
		$confx = [];

		$configfile = ADMIN_URL.'ldb/db.'.$d.'.conf.php';
		if
		(file_exists($configfile))
		{
			$c = file_get_contents($configfile);
			$c = str_replace("<?php //", "", $c);
			$c = $this->decrypt($c);
			$confx = json_decode($c, true);
		}
		$this->datastore[$d] = $confx;
		return $confx;

	}

		
		
		public function searchInData($tb, $q)
	{
		$confx = $this->loadDatastore($tb);

		$ret = [];
		
	
		
		if
		(!empty($confx))
		{

			foreach ($confx as $key => $val)
			{

				if
				($key==$q) $ret[$key]=$val;

				if
				(array_search($q, $val, true))
				{
					$ret[$key]=$val;

				}

			}
		}
		return $ret;
	}

		
		function getPostBlogById($id) {
		
		global $swcnt_blog;
		if
			(!empty($swcnt_blog['sw_blocks']))
			{

				$structure = $swcnt_blog['sw_blocks'];


				$doc = ADMIN_URL.'ldb/blog/'.$id.'.source.json';
				
				$this->structure = $structure;
				$this->doc = $doc;
				
				if
			(file_exists($doc))
			{

				$d = file_get_contents($doc);
				$slots  = json_decode($d, true);
				
				
			}
			return $slots;
				

			}
			
			}
	
	
	function dtformat($timestamp,$format) {
	$mtime = strtotime($timestamp);
	$pubdate = date($format, $mtime);
	return $pubdate;
	}
	function dateTime($timestamp,$format='dateonly') {
				
		$lang = $this->lang; 
		$lday = [_("Sunday"),_("Monday"), _("Tuesday"), _("Wednesday"), _("Thursday"), _("Friday"), _("Saturday")];
		$lmonth = ['',_("January"),_("February"), _("March"), _("April"), _("May"), _("June"), _("July"), _("August"), _("September"), _("October"), _("November"), _("December")];
		$timestamp = strtotime($timestamp);
		$w_ = $lday[date('w', $timestamp)]; // date('w d F Y', $timestamp);
		$d_ = date('d', $timestamp); 
		$m_ = $lmonth[intval(date('m', $timestamp))];
		if ($format=='dateonly') $rdate = $w_.', '.$d_.' '.$m_.' '.date('Y', $timestamp);
		else if ($format=='datehour') $rdate = $w_.', '.$d_.' '.$m_.' '.date('Y', $timestamp).' - '.date('H:i', $timestamp);			
		
		return $rdate;
	}
	
	
	
	
	
	
}
	
	
	?>