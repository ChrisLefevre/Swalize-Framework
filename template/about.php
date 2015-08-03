<?php
$title = $siteinfo['title'];





include 'template/inc_head.php';
?>    <!-- Page Header -->
    <!-- Set your background image for this header on the line below. -->
    <header class="intro-header" style="background-image: url('<?php echo TEMPLATE_URL; ?>/img/about-bg.jpg')">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                    <div class="page-heading">
                        <h1><?php echo $blocks['title']; ?></h1>
                        <hr class="small">
                        <span class="subheading"><?php echo $blocks['headline']; ?></span>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
              <?php echo $blocks['article']; ?>
            </div>
        </div>
    </div>

    <hr>

  <div class="container">
 <div class="row">
            <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                <h2><?php echo _('Register to Newsletter'); ?></h2>
              
               
                  <?php 
	                  
	                  	echo $returnmessage;
	                  
	                  $sw->showform('newslettermail',$site_url.'/'.$sw->uri('addnewsletter'),'Register');	
	                  
	                                   
	                  ?>
                    
            </div>
        </div>
  </div>
  
   <hr>
  
<?php include 'template/inc_foot.php'; ?>
