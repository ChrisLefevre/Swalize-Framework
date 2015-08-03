<?php
$title = $siteinfo['title'];
$actpage = 1;

$maxitems = 4;

if(isset($_GET['id'])) $actpage = intval($_GET['id']);
$posts = $sw ->  blogposts($actpage,$maxitems);
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
               
               <?php foreach ($posts as $k => $v) { ?>
		          
		               
		               <div class="post-preview">
                    <a href="<?php echo $site_url.'/'.$sw->uri('article',$v['urltxt']); ?>">
                        <h2 class="post-title">
                            <?php echo $v['title']; ?>
                        </h2>
                        <h3 class="post-subtitle">
                            <?php echo $v['headline']; ?>
                        </h3>
                    </a>
                    <p class="post-meta"><?php echo _("Posted by"); ?>  <?php echo $v['author']; ?> on <?php echo  $sw->dateTime($v['pubdate']); ?></p>
                </div>
                <hr>

		       <?php  }  ?>
               
               
                               <!-- Pager -->
                <ul class="pager">
	                <?php if ($actpage>1) { ?>
	                <li class="previous">
                        <a href="<?php echo $site_url.'/'.$sw->uri('',$actpage-1); ?>">&larr; <?php echo _("Next Posts"); ?> </a>
                    </li>
	                <?php } ?>
	                
	                
	                <?php if (count($posts) ==  $maxitems) { ?>
                    <li class="next">
                        <a href="<?php echo $site_url.'/'.$sw->uri('',$actpage+1); ?>"><?php echo _("Older Posts"); ?>  &rarr;</a>
                    </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </div>

    <hr>

 
<?php include 'template/inc_foot.php'; ?>