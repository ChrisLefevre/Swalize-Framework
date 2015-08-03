<?php



$users = $adm ->  getConfig('users');
?>


<?php echo $adm->getShowmessage(); ?>








<div id="modal-user-settings" class="modal fade modal-primary" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
	

             
	<form action="?update=user" method="post">
    <div class="modal-dialog">
        <div class="modal-content">
  

            <div class="modal-header text-center">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>

                <h4 class="modal-title"><?php echo _("Add Member"); ?> </h4>
            </div>

            <div class="modal-body">
                <div class="text-blue">
                    <div class="form-group has-feedback">
                        <input type="text"  name="username" class="form-control" placeholder="Nom complet">
                    </div>

                    <div class="form-group has-feedback">
                        <input type="email" name="email" class="form-control" placeholder="E-mail">
                    </div>

                    <div class="form-group">
                        <select  name="role" class="form-control">
                            <option value="1">
                                <?php echo _("Editor"); ?> 
                            </option>

                            <option value="2">
                                <?php echo _("Admin"); ?> 
                            </option>
                        </select>
                    </div>

                    <div class="form-group has-feedback">
                        <input name="password" type="password" id="password" class="form-control" placeholder="Mot de passe">
                    </div>

                    <div class="form-group has-feedback">
                        <input name="password2" id="password2" onkeyup="if($(this).val()!=$('#password').val()) $(this).parent().addClass('has-error'); else  $(this).parent().removeClass('has-error');" type="password" class="form-control" placeholder="Retapez le Mot de passe">
                    </div>
                </div>

                <div class="checkbox">
                    <label><input type="checkbox" onchange="document.getElementById('password').type = this.checked ? 'text' : 'password'; document.getElementById('password2').type = this.checked ? 'text' : 'password'"> <?php echo _("Show password"); ?> </label>
                </div>
            </div>

            <div class="modal-footer">
                <button type="submit" name="add"  value="1"  class="btn btn-outline"><?php echo _("Add"); ?> </button>
            </div>
        </div>
    </div>
</form>

</div>

<div id="modal-user-settings-edit" class="modal fade modal-primary" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">

<form action="?update=user" method="post">
    <div class="modal-dialog">
        <div class="modal-content">
  

            <div class="modal-header text-center">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>

                <h4 class="modal-title"><?php echo _("Modify Member"); ?> </h4>
            </div>

            <div class="modal-body">
                <div class="text-blue">
                   
                    <div class="form-group has-feedback">
                        <input type="hidden"  id="form_email" name="email" class="form-control" placeholder="E-mail">
                    </div>

                   
                    <div class="form-group has-feedback">
                        <input type="text" id="form_username" name="username" class="form-control" placeholder="Nom complet">
                    </div>

                   
                    <div class="form-group">
                        <select id="form_role" name="role" class="form-control">
                            <option value="1">
                                <?php echo _("Editor"); ?> 
                            </option>

                            <option value="2">
                                <?php echo _("Admin"); ?> 
                            </option>
                        </select>
                    </div>

             
                </div>

              
            </div>

            <div class="modal-footer">
                <button type="submit" name="edit" value="1" class="btn btn-outline"><?php echo _("Save"); ?> </button>
            </div>
        </div>
    </div>
</form>
</div>




<div id="modal-user-settings-delete" class="modal fade modal-primary" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">

<form action="?update=user" method="post">
    <div class="modal-dialog">
        <div class="modal-content">
  

            <div class="modal-header text-center">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>

                
            <input type="hidden"  id="form_email3" name="email" class="form-control" placeholder="E-mail">

           
           
                <button type="submit" name="delete_user" value="1" class="btn btn-outline"><?php echo _("Click here if you are sure you want to delete"); ?>  <strong id="form_username2"></strong> ?</button>
            </div>
        </div>
    </div>
</form>
</div>





<div id="modal-user-settings-pass" class="modal fade modal-primary" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
	

             
	<form action="?update=user" method="post">
    <div class="modal-dialog">
        <div class="modal-content">
  

            <div class="modal-header text-center">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>

                <h4 class="modal-title"><?php echo _("Change password"); ?> </h4>
            </div>

            <div class="modal-body">
                <div class="text-blue">
                   

                    <div class="form-group has-feedback">
                        <input type="hidden"  id="form_email2"  name="email" class="form-control" placeholder="<?php echo _("E-mail"); ?> ">
                    </div>

                   
                    <div class="form-group has-feedback">
                        <input name="password" type="password" id="password_change" class="form-control" placeholder="<?php echo _("Password"); ?> ">
                    </div>

                    <div class="form-group has-feedback">
                        <input name="password2" id="password2_change" onkeyup="if($(this).val()!=$('#password_change').val()) $(this).parent().addClass('has-error'); else  $(this).parent().removeClass('has-error');" type="password" class="form-control" placeholder="<?php echo _("Retype password"); ?> ">
                    </div>
                </div>

                <div class="checkbox">
                    <label><input type="checkbox" onchange="document.getElementById('password_change').type = this.checked ? 'text' : 'password'; document.getElementById('password2_change').type = this.checked ? 'text' : 'password'"> <?php echo _("Show password"); ?> </label>
                </div>
            </div>

            <div class="modal-footer">
                <button type="submit" name="passedit"  value="1"  class="btn btn-outline"><?php echo _("Edit"); ?> </button>
            </div>
        </div>
    </div>
</form>

</div>

















  <script>
	       function openEditUser(n,e,r) {
		        $('#form_username').val(n);
		        $('#form_username2').text(n);
		        $('#form_email').val(e);
		        $('#form_email2').val(e);  
		        $('#form_email3').val(e);  
		        $('#form_role').val(r);
		        
	        }
	        
	       
	        
	        </script>


<section class="content-header">
   
    
    
    <div class="pull-right"><a href="#modal-user-settings" data-toggle="modal"  class="btn  btn-sm bg-aqua color-palette" data-widget="remove" data-toggle="tooltip" title="Add"><i class="fa fa-plus"></i> <?php echo _("New user"); ?> </a></div>
     <h1><?php echo _("Users"); ?> <small><?php echo _("Users list"); ?> </small></h1>

    
</section><!-- Main content -->

<section class="content">

 
    
     <div class="box">
          
                <div class="box-body table-responsive no-padding">
                  <table class="table table-hover">
                    <tr>
                     
                      <th><?php echo _("User"); ?> </th>
                      <th><?php echo _("E-mail"); ?> </th>
                      <th><?php echo _("Status"); ?> </th>
                 <th></th>
                    </tr>
                    
                    <?php foreach($users as $k => $v) { ?>
	                    
	                    
	                 <tr>
                     
                      <td><?php echo ucwords($v['username']); ?></td>
                      <td><?php echo $k; ?></td>
                      <td><?php if ($v['role']==2) echo '<span class="label label-success">'._('Admin').'</span>'; 
	                      			else echo '<span class="label label-warning">'._('Editeur').'</span>'; ?></td>
                    <td>
	               
	               <div class="btn-group">
                         <a  class="btn btn-default btn-xs" href="#modal-user-settings-edit" onclick="openEditUser('<?php echo addslashes($v['username']); ?>','<?php echo addslashes($k); ?>','<?php echo addslashes($v['role']); ?>');" data-toggle="modal"  ><i class="fa  fa-pencil"></i> <?php echo _("Profil"); ?> </a>
	                      
	                           <a  class="btn btn-default btn-xs" href="#modal-user-settings-pass" onclick="openEditUser('<?php echo addslashes($v['username']); ?>','<?php echo addslashes($k); ?>','<?php echo addslashes($v['role']); ?>');" data-toggle="modal"  ><i class="fa  fa-lock"></i> <?php echo _("Pass"); ?> </a> 
	                           
	                            <a  class="btn btn-default btn-xs" href="#modal-user-settings-delete" onclick="openEditUser('<?php echo addslashes($v['username']); ?>','<?php echo addslashes($k); ?>','<?php echo addslashes($v['role']); ?>');" data-toggle="modal"  ><i class="fa  fa-eraser"></i> <?php echo _("Delete"); ?> </a> 

	                           
	                    </div>
	                      </td>                    </tr>
    
                    <?php } ?>
                  </table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
    
    
    
    
    
</section>
