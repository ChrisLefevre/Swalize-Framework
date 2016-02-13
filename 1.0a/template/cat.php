<?php
$title = $siteinfo['title'];

$actpage = 1;
$maxitems = 48;

$catid = htmlentities($_GET['id']);


//$title = ucfirst($tagname). ' - ' .$siteinfo['title'];

$posts = $sw ->  blogposts($actpage,$maxitems,$catid);


$title = $sw -> getCatName($catid). ' - ' .$siteinfo['title'];


include 'template/inc_head.php';
?>
    <!-- Set your background image for this header on the line below. -->
    <header class="intro-header" style="background-image: url('<?php echo TEMPLATE_URL; ?>/img/home-bg.jpg')">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                    <div class="site-heading">
                        <h1><?php echo $title; ?></h1>
                        <hr class="small">
                        <span class="subheading"><?php echo $siteinfo['baseline']; ?></span>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
               
               <?php
	               
	           
	               
	                foreach ($posts as $k => $v) {
	               
	               
	              
	               
	                ?>
		          
		          
		          
		               
		               <div class="post-preview">
                    <a href="<?php echo $sw_vars['site_url'].$sw->uri('article',$v['urltxt']); ?>">
                        <h2 class="post-title">
                            <?php echo $v['title']; ?>
                        </h2>
                        <h3 class="post-subtitle">
                            <?php echo $v['headline']; ?>
                        </h3>
                    </a>
                    <p class="post-meta"><?php echo $sw->_("Posted by"); ?>  <?php echo $v['author']; ?> <?php echo $sw->_("on"); ?> <?php echo  $sw->dateTime($v['pubdate']); ?></p>
                </div>
                 <?php if($v!=end($posts)) echo '<hr>'; ?>

		       <?php  }  ?>
               
               
                               <!-- Pager -->
                <ul class="pager">
	                <?php if ($actpage>1) { ?>
	                <li class="previous">
                        <a href="<?php echo $site_url.$sw->uri('',$actpage-1); ?>">&larr; <?php echo $sw->_("Next Posts"); ?> </a>
                    </li>
	                <?php } ?>
	                
	                
	                <?php if (count($posts) ==  $maxitems) { ?>
                    <li class="next">
                        <a href="<?php echo $site_url.$sw->uri('',$actpage+1); ?>"><?php echo $sw->_("Older Posts"); ?>  &rarr;</a>
                    </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </div>

    <hr>

 
<?php include 'template/inc_foot.php'; ?>