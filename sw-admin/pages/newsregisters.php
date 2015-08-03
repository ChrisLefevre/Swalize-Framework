<?php






$table = new swcnt_tables();


?>




<section class="content-header">
    <h1>Mailing list <small><?php echo _("All E-mails"); ?> </small></h1>

    <ol class="breadcrumb">
        <li>
            <a href="./"><?php echo _("Admin"); ?> </a>
        </li>

        <li class="active"><?php echo _("Mailing list"); ?> </li>
    </ol>
</section>




 


<section class="content">
   <div class="box">
          
                <div class="box-body table-responsive">
                             
                             <?php 
	 
	 $table -> showformtable('newslettermail');

	 
	 ?>
                             
                             
                             
                              </div><!-- /.box-body -->
              </div>
              
              
             
</section>
