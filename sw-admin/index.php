<?php 
/*
	error_reporting(E_ALL); 
	ini_set('display_errors', 1);
*/	
	
	include '../models.php';
	include 'inc/funcs.php';
	include 'inc/lang.php';

	
	$smod = new swcnt_smod();
	$adm = new swcnt_sadmin();
	
	$sblog = new swcnt_sblog();	
	$sblog_cat = new swcnt_sblog_cat();
	
	$scatalog = new swcnt_sblog('catalog');	
	$scatalog_cat = new swcnt_sblog_cat('catalog');
	
	$sportfolio = new swcnt_sblog('portfolio');	
	$sportfolio_cat = new swcnt_sblog_cat('portfolio');
	
	$spages = new swcnt_sblog('pages');	
	$spages_cat = new swcnt_sblog_cat('pages');	
	

$adm -> setMylang();	
	
if(!$adm->islogged()) {
	
$adm->login();
	
include 'inc/tmp_login.php';
		
}
else
	{
		
		
		
		if(!empty($smod->mod) and $smod->mod=='update') include('inc/update.php');
		else if(!empty($smod->mod) and $smod->mod=='uploader') include('inc/uploader.php');
		else {
		
		
		include 'inc/header.php';
		if(!empty($smod->mod)) include('pages/'.$smod->mod.'.php');
		
		else {
			?><div class="hp_div">
				
				<section class="content">
          <div class="callout callout-info"  style="
    position: fixed;
">
	           <div class="pull-left image">
	          <i class="material-icons" style="margin-right: 15px; font-size: 50px;">&#xE5C4;</i>
	           </div>
            <h4><?php _t('Hello'); ?> <?php echo ucFirst($ul['user']["username"]); ?>,</h4>
       <p><?php _t('Click in the left menu to start.'); ?></p>
          </div>
         

        </section>
			</div>
			
			
			<?php
			}
		
		
	 
		 include 'inc/footer.php';
		 	}
		 }
	

?>