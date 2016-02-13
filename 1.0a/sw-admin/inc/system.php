<?php
include (ADMIN_URL . 'controls/models.php');

class sw

	{
	public $datastore;

	function __construct()
		{
		global $swcnt_plugins;
		global $swcnt_options;
		$this->plugins = $swcnt_pluglist;
		$swcnt_pluglist = array();
		foreach($swcnt_plugins as $pname)
			{
			include_once ADMIN_URL . 'plugins/' . $pname . '/conf.php';

			}

		$this->plugins = $swcnt_pluglist;
		$swcnt_languages = $swcnt_options['languages'];
		$swcnt_secure_key = $swcnt_options['secure_key'];
		$swcnt_urlrewriting = $swcnt_options['urlrewriting'];
		$swcnt_crypt = $swcnt_options['crypt'];
		$key = md5($swcnt_secure_key);
		if (isset($_GET['lang']) and in_array($_GET['lang'], $swcnt_languages)) $actlang = htmlentities($_GET['lang']);
		  else
		if (isset($swcnt_languages[0])) $actlang = $swcnt_languages[0];
		if ($actlang == '') $actlang = 'nolang';
		$this->lang = $actlang;
		$this->key = $key;
		$this->crypt = $swcnt_crypt;
		$this->urlrewriting = $swcnt_urlrewriting;
		}

	public

	function format_url($texte)
		{
		$texte = utf8_decode($texte);
		$texte = html_entity_decode($texte);
		$tofind = utf8_decode('ÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËéèêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ');
		$replac = utf8_decode('AAAAAAaaaaaaOOOOOOooooooEEEEeeeeCcIIIIiiiiUUUUuuuuyNn');
		$texte_pre_pre_pre = trim(strtolower(strtr($texte, $tofind, $replac)));
		$texte_pre_pre = preg_replace('/[^a-zA-Z0-9_]/i', '-', $texte_pre_pre_pre);
		$texte_pre = preg_replace('/-+/i', '-', $texte_pre_pre);
		$texte_final = substr($texte_pre, '0', '128');
		return $texte_final;
		}

	public

	function setmessage($message)
		{
		setcookie("sw_tmp_message", $message, time() + 3600 * 24 * 7 * 30, '/');
		}

	public

	function getmessage()
		{
		if (!empty($_COOKIE["sw_tmp_message"]))
			{
			setcookie("sw_tmp_message", '', time() - 3600 * 24 * 7 * 30, '/');
			return '<div class="alert alert-warning alert-dismissable">' . $_COOKIE["sw_tmp_message"] . '</div>';
			}

		return '';
		}

	public

	function form($string)
		{
		global $swcnt_form;
		if (!empty($swcnt_form[$string])) return $swcnt_form[$string];
		}

	public

	function saveform($string)
		{
		$form = $this->form($string);
		$thisformvalues = array();
		foreach($form as $k => $v)
			{
			if (!empty($_POST[$k])) $thisformvalues[$k] = htmlentities($_POST[$k]);
			}

			

		$this->saveData($string, date("Y-m-d H:i:s") , $thisformvalues);
		return $thisformvalues;
		}

	public

	function mailform($string, $email = '')
		{
		$form = $this->form($string);
		global $swcnt_options;
		if ($email == '') $email = $swcnt_options['contact_email'];
		$from = $swcnt_options['contact_email'];
		$body = $this->_("You have received a new message from your website contact form") . ".\n\n";
		$thisformvalues = array();
		foreach($form as $k => $v)
			{
			if (!empty($_POST[$k]))
				{
				$thisformvalues[$k] = htmlspecialchars($_POST[$k]);
				if ($k == 'email' or $k == 'mail') $from = $thisformvalues[$k];
				$body = $body . $k . " " . $thisformvalues[$k] . "\n\n";
				}
			}

		$subject = "Website email " . $string;
		$headers = "From: $from\n";
		$headers.= "Reply-To: $from";
		mail($email, $subject, $body, $headers);
		return true;
		}

	public

	function saveData($d = 'temp', $k, $v)
		{
		$confx = $this->loadDatastore($d);
		$configfile = ADMIN_URL . 'ldb/db.' . $d . '.conf.php';
		$configbkpfile = ADMIN_URL . 'ldb/backup/db.' . $d . '.' . date("y-m-d") . 'conf.php';
		$confx[$k] = $v;
		
		
	
		
		$c = json_encode($confx);
		file_put_contents($configfile, '<?php //' . $this->encrypt($c));
		file_put_contents($configbkpfile, '<?php //' . $this->encrypt($c));
		$this->datastore[$d] = $confx;
		}

	public

	function encrypt($string)
		{
		if ($this->crypt == 0) return base64_encode($string);
		  else
			{
			$iv_size = mcrypt_get_iv_size(MCRYPT_BLOWFISH, MCRYPT_MODE_ECB);
			$iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
			return mcrypt_encrypt(MCRYPT_BLOWFISH, $this->key, $string, MCRYPT_MODE_ECB, $iv);
			}
		}

	public

	function decrypt($crypttext)
		{
		if ($this->crypt == 0) return base64_decode($crypttext);
		  else
			{
			$crypttext = ($crypttext);
			$iv_size = mcrypt_get_iv_size(MCRYPT_BLOWFISH, MCRYPT_MODE_ECB);
			$iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
			return trim(mcrypt_decrypt(MCRYPT_BLOWFISH, $this->key, $crypttext, MCRYPT_MODE_ECB, $iv));
			}
		}

	public

	function get_tags_name($tag)
		{
		$actpage = 'tags_list';
		global $swcnt_tree;
		$actlang = $this->lang;
		$slots = array();
		$tagname = '';
		$doc = ADMIN_URL . 'ldb/' . $actlang . '_' . $actpage . '.source.json';
		if (file_exists($doc))
			{
			$d = file_get_contents($doc);
			$slots = json_decode($d, true);
			$keyword = $slots['keyword'];
			}

		$tagname = $keyword[$tag];
		return $tagname;
		}

	public

	function list_tags()
		{
		$actpage = 'tags_list';
		global $swcnt_tree;
		$actlang = $this->lang;
		$slots = array();
		$doc = ADMIN_URL . 'ldb/' . $actlang . '_' . $actpage . '.source.json';
		if (file_exists($doc))
			{
			$d = file_get_contents($doc);
			$slots = json_decode($d, true);
			return $slots['keyword'];
			}

		}

	public

	function w($word)
		{
		if (empty($_ENV['sw_words']))
			{
			$actpage = 'swcnt_words';
			global $swcnt_tree;
			$actlang = $this->lang;
			$slots = array();
			if ($actpage != '' and !empty($swcnt_tree[$actpage]['sw_blocks']))
				{
				$de = array();
				$structure = $swcnt_tree[$actpage]['sw_blocks'];
				foreach($structure as $key => $value)
					{
					$de[$key] = $value['label']; //$value;
					}

				$doc = ADMIN_URL . 'ldb/' . $actlang . '_' . $actpage . '.source.json';
				$this->structure = $structure;
				$this->doc = $doc;
				$this->page = $actpage;
				if (file_exists($doc))
					{
					$d = file_get_contents($doc);
					$slots = json_decode($d, true);
					}

				foreach($slots as $key => $value)
					{
					$de[$key] = $value;
					}
				}
			}

		$w = $_ENV['sw_words'];
		if (!empty($de[$word])) return $de[$word];
		  else return $word;
		}

	public

	function plugin_save($plugin, $document, $lang, $k, $v)
		{
		global $swcnt_plugins;
		$actlang = $this->lang;
		foreach($swcnt_plugins as $pname)
			{
			if ($pname == $plugin)
				{
				$doc = ADMIN_URL . 'ldb/' . $lang . '_plugin_' . $this->format_url($pname) . '_' . $this->format_url($document) . '.source.json';
				$vals = array();
				if (file_exists($doc))
					{
					$d = file_get_contents($doc);
					$vals = json_decode($d, true);
					}

				$vals[$k] = $v;
				$final = json_encode($vals);
				file_put_contents($doc, $final);
				}
			}
		}

	public

	function plugin_datas($plugin, $document, $lang)
		{
		global $swcnt_plugins;
		$actlang = $this->lang;
		foreach($swcnt_plugins as $pname)
			{
			if ($pname == $plugin)
				{
				$doc = ADMIN_URL . 'ldb/' . $lang . '_plugin_' . $this->format_url($pname) . '_' . $this->format_url($document) . '.source.json';
				$vals = array();
				if (file_exists($doc))
					{
					$d = file_get_contents($doc);
					$d = str_replace("[lang]", $actlang, $d);
					$d = str_replace("[site_url]", SITE_URL, $d);
					$d = str_replace("[base_url]", SITE_URL . $actlang . '/', $d);
					$vals = json_decode($d, true);
					}

				return $vals;
				}
			}
		}

	public

	function block($actpage)
		{
		global $swcnt_tree;
		$actlang = $this->lang;
		$slots = array();
		if ($actpage != '' and !empty($swcnt_tree[$actpage]['sw_blocks']))
			{
			$structure = $swcnt_tree[$actpage]['sw_blocks'];
			$doc = ADMIN_URL . 'ldb/' . $actlang . '_' . $actpage . '.source.json';
			$this->structure = $structure;
			$this->doc = $doc;
			$this->page = $actpage;
			if (file_exists($doc))
				{
				$d = file_get_contents($doc);
				$d = str_replace("[lang]", $actlang, $d);
				$d = str_replace("[site_url]", SITE_URL, $d);
				$d = str_replace("[base_url]", SITE_URL . $actlang . '/', $d);
				$slots = json_decode($d, true);
				}

			return $slots;
			}
		}
		
		
		
		
		
		
		

	function uri($page, $arg = '')
		{
		$swcnt_urlrewriting = $this->urlrewriting;
		if ($arg == '')
			{
			if ($swcnt_urlrewriting) return $this->lang . '/' . $page;
			  else return '?lang=' . $this->lang . '&page=' . $page;
			}
		  else
			{
			if ($swcnt_urlrewriting) return $this->lang . '/' . $page . '/' . $arg;
			  else return '?lang=' . $this->lang . '&page=' . $page . '&id=' . $arg;
			}
		}

	public

	function loadDatastore($d)
		{
		$confx = array();
		$configfile = ADMIN_URL . 'ldb/db.' . $d . '.conf.php';
		
		
		if (file_exists($configfile))
			{
			$c = file_get_contents($configfile);
			$c = str_replace("<?php //", "", $c);
			$c = $this->decrypt($c);
			$confx = json_decode($c, true);
			}

		$this->datastore[$d] = $confx;
		return $confx;
		}

	public

	function searchInData($tb, $q)
		{
		$confx = $this->loadDatastore($tb);
		$ret = array();
		if (!empty($confx))
			{
			foreach($confx as $key => $val)
				{
				if ($key == $q) $ret[$key] = $val;
				if (array_search($q, $val, true))
					{
					$ret[$key] = $val;
					}
				}
			}

		return $ret;
		}
		
		
	

	public

	function dtformat($timestamp, $format)
		{
		$mtime = strtotime($timestamp);
		$pubdate = date($format, $mtime);
		return $pubdate;
		}

	public

	function dateTime($timestamp, $format = 'dateonly')
		{
		$lang = $this->lang;
		$lday = array(
			$this->_("Sunday") ,
			$this->_("Monday") ,
			$this->_("Tuesday") ,
			$this->_("Wednesday") ,
			$this->_("Thursday") ,
			$this->_("Friday") ,
			$this->_("Saturday")
		);
		$lmonth = array(
			'',
			$this->_("January") ,
			$this->_("February") ,
			$this->_("March") ,
			$this->_("April") ,
			$this->_("May") ,
			$this->_("June") ,
			$this->_("July") ,
			$this->_("August") ,
			$this->_("September") ,
			$this->_("October") ,
			$this->_("November") ,
			$this->_("December")
		);
		$timestamp = strtotime($timestamp);
		$w_ = $lday[date('w', $timestamp) ]; // date('w d F Y', $timestamp);
		$d_ = date('d', $timestamp);
		$m_ = $lmonth[intval(date('m', $timestamp)) ];
		if ($format == 'dateonly') $rdate = $w_ . ', ' . $d_ . ' ' . $m_ . ' ' . date('Y', $timestamp);
		  else
		if ($format == 'datehour') $rdate = $w_ . ', ' . $d_ . ' ' . $m_ . ' ' . date('Y', $timestamp) . ' - ' . date('H:i', $timestamp);
		return $rdate;
		}

	public

	function _($t)
		{
		$lang = $this->lang;
		$word = $t;
		$word_key = $this->format_url($t);
		$doc = ADMIN_URL . 'ldb/xtext.list.json';
		$vals = array();
		if (file_exists($doc))
			{
			$d = file_get_contents($doc);
			$vals = json_decode($d, true);
			}

		if (!empty($vals[$word_key]))
			{
			$ldoc = ADMIN_URL . 'ldb/' . $lang . '_xtext.list.json';
			$lvals = array();
			if (file_exists($ldoc))
				{
				$ld = file_get_contents($ldoc);
				$lvals = json_decode($ld, true);
				if (!empty($lvals[$word_key])) $word = $lvals[$word_key];
				}
			}
		  else
			{
			$vals[$word_key] = $t;
			$final = json_encode($vals);
			file_put_contents($doc, $final);
			}

		return $word;
		}
	


		
		
		
		
		
		/* Blog functions */

	public

	function blogpost($id,$pubtype = 'blog')
		{
		$bpost = array();
		$blogposts = $this->searchInData($pubtype.'posts_' . $this->lang, $id);
		
		
		if (!empty($blogposts))
			{
			foreach($blogposts as $k => $v)
				{
				$bpost = $this->getPostBlogById($k,$pubtype);
				}
			}

		return $bpost;
		}

	public

	function blogposts($page = 1, $maxitems = 10, $cat = 0, $tag = '',$pubtype = 'blog')
		{
		$bpost = array();
		$blogposts = $this->loadDatastore($pubtype.'posts_' . $this->lang);
		
	
		
		// krsort($blogposts);

		$itemstart = ($page - 1) * $maxitems;
		$itemend = ($page) * $maxitems;
		if ($itemstart < 0) $itemstart = 0;
		if (!empty($blogposts))
			{
			$n = 0;
			$newblogposts = array();
			foreach($blogposts as $k => $v)
				{
				$v['postid'] = $k;
				$newblogposts[$v['dateupdate']] = $v;
				}

			krsort($newblogposts);
			foreach($newblogposts as $k => $v)
				{
				$tpost = $this->getPostBlogById($v['postid'],$pubtype);
				$tagpost = 0;
				$tags = explode(',', $tpost['keyword']);
				foreach($tags as $gt)
					{
					if ($tag == $this->format_url($gt) and $tag != '') $tagpost = 1;
					
					
					}
					
				if (($tpost['status'] == 1 and empty($cat) and $tag == '') or ($tpost['status'] == 1 and $cat == $tpost['category']) or ($tpost['status'] == 1 and $tagpost == 1))
					{
						
						
						
					if ($n >= $itemstart and $n < $itemend)
						{
						$bpost[$v['postid']] = $tpost;
						$bpost[$v['postid']]['lang'] = $v['lang'];
						$bpost[$v['postid']]['urltxt'] = $v['urltxt'];
						}

					$n++;
					}
				}
			}

		return $bpost;
		}
		
		
		
	public
	function getCatName($catId,$pubtype = 'blog') {
		
		$allcats = $this ->listCats();

					if(!empty($allcats[$catId])) return $allcats[$catId]; 
					else return ucFirst($catId);
		
		
	}
	

	public

	function getPostBlogById($id,$pubtype = 'blog')
		{
		global $swcnt_blog;
		if (!empty($swcnt_blog['sw_blocks']))
			{
			$structure = $swcnt_blog['sw_blocks'];
			$doc = ADMIN_URL . 'ldb/'.$pubtype.'/' . $id . '.source.json';
			$this->structure = $structure;
			$this->doc = $doc;
			if (file_exists($doc))
				{
				$d = file_get_contents($doc);
				$slots = json_decode($d, true);
				$slots['article'] = str_replace('"upload/', '"' . SITE_URL . ADMIN_URL . 'upload/', $slots['article']);
				if(!empty($slots['category'])) {
				$slots['categoryName'] = $this -> getCatName($slots['category'],$pubtype);
				}
}
				
				
				
				
			return $slots;
			}
		}
		
		
	public function listCats($pubtype = 'blog') {
			
			$listCats = array();
		
			$doc = ADMIN_URL .'ldb/'.$pubtype.'/' .$this->lang . '_cats.source.json';
			
			if (file_exists($doc))
					{
					$d = file_get_contents($doc);
					$vals = json_decode($d, true);
			if(!empty($vals ['elems'] )) {
			foreach($vals ['elems'] as $v)
					{
					
					
					$listCats[$v['slug']] = $v['name'];
					
					
					}
			}
			
					}	
			return $listCats;
			
					
	}	
	

	
	
}	
/* on charge la classe et le system SW */
$sw = new sw();
$sw_vars = array();
$page = 'hp';

if (!empty($_GET['page'])) $page = htmlentities($_GET['page']);
$blocks = $sw->block($page);

if(!empty($siteInfodatas)) $siteinfo = $sw->block($siteInfodatas); else $siteinfo = $sw->block('siteinfos');
if (!empty($siteinfo['site_url'])) $site_url = $siteinfo['site_url'];
else $site_url = '/';
  

  
  
$site_url = $siteinfo['site_url'];
$sw_vars['site_url'] = $site_url;
$sw_vars['returnmessage'] = $sw->getmessage();
define('TEMPLATE_URL', $site_url . '/template');
/* on charge les plugins */
$swcnt_pluglist = array();

foreach($swcnt_plugins as $pname)
	{
	$obj = ADMIN_URL . 'plugins/' . $pname . '/models.php';
	if (file_exists($obj)) include_once $obj;

	$obj = ADMIN_URL . 'plugins/' . $pname . '/system.php';
	if (file_exists($obj)) include_once $obj;

	}

?>
