<?php 


$id = htmlentities($_GET['id']);
$bpost = $sw->blogpost($id) ; 



if (!empty($bpost)) {

$title = $bpost['title'].' - '.$siteinfo['title'];

include 'template/inc_head.php';


//print_r($bpost);
?>

    <!-- Page Header -->
    <!-- Set your background image for this header on the line below. -->
    <header class="intro-header" style="background-image: url('<?php echo TEMPLATE_URL; ?>/img/post-bg.jpg')">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                    <div class="post-heading">
                        <h1><?php echo $bpost['title']; ?></h1>
                        <h2 class="subheading"><?php echo $bpost['headline'];  ?></h2>
                        <span class="meta"><?php echo _("Posted by"); ?>  <?php echo $bpost['author']; ?> <?php echo _("on"); ?>  <?php echo  $sw->dateTime($bpost['pubdate']); ?></span>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Post Content -->
    <article>
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                   
                   <?php echo $bpost['article']; ?>
                   
                   
                                   </div>
            </div>
        </div>
    </article>

    <hr>

   <?php include 'template/inc_foot.php'; } ?>