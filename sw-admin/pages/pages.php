<?php 
	

	
	if ($spages->page=='new' or $spages->page=='edit') { 
			$spages -> save();
	?>
<section class="content-header">
    <h1>Page <?php echo $spages -> lang; ?><small><?php echo _("Add a new page"); ?></small></h1>

    <ol class="breadcrumb">
        <li>
            <a href="./"><?php echo _("Edition"); ?> </a>
        </li>

        <li class="active"><?php echo _("page"); ?> </li>
    </ol>
</section>

<section class="content">
    <div class='box box-primary'>
       

        <div class='box-body'>
            <?php    $spages -> showform(); ?>
        </div>
    </div>
</section>
<?php } else if ($spages->page=='cats' ) { 
	$spages_cat -> save();
	?>
	

<section class="content">
    <div class='box box-primary'>
       

        <div class='box-body'>
            <?php  $spages_cat  -> showform(); ?>
        </div>
    </div>
</section>
	
	
	
	
	
	
	
<?php	}else { 
		
		$pagesproducts = $adm ->  loadDatastore('pagesposts_'.$spages -> lang);  
		
		krsort($pagesproducts);
		 
			
?>



<section class="content-header">
   
    
    
    <div class="pull-right"><a href="?pages=new&amp;lang=<?php echo $spages -> lang; ?>" title="Add" class="btn  btn-sm bg-aqua color-palette"><i class="fa fa-plus"></i> <?php echo _("Add a new page"); ?> </a></div>
     <h1>Pages <small><?php echo _("Pages list"); ?>  <?php echo $spages -> lang; ?></small></h1>

    
</section><!-- Main content -->

<section class="content">

 
    
     <div class="box">
          
                <div class="box-body table-responsive no-padding">
                  <table class="table table-hover">
                    <tr>
                     
                      <th><?php echo _("Date"); ?> </th>
                      <th><?php echo _("Pages"); ?> </th>
                      <th></th>
              
                    </tr>
                    
                    <?php foreach($pagesproducts as $k => $v) { 
	                    
	                    if($v['status']!=2) {
	               
	                    if($v['status']==1) $stat = _('visible'); 
	                    else if($v['status']==3) $stat = _('showcase'); 
	                    else $stat = _('closed'); 
	                    
	                     ?>
	                    
	                    
	                 <tr>
                     
                      <td><?php echo $v['dateupdate']; ?></td>
                      <td><a href="?pages=edit&lang=<?php echo $v['lang']; ?>&post=<?php echo $k; ?>"><?php echo ucwords($v['title']); ?> - <?php echo ucwords($stat); ?></a></td>
                      <td></td>
                    <td>
	                </td>  </tr>
    
                    <?php } } ?>
                  </table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
    
    
    
    
    
</section>



<?php }