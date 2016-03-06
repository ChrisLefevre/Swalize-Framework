<?php 

if ($adm->islogged()) { 
if (!empty($_GET['uploader'])) $idp = htmlentities($_GET['uploader']);
else $idp = 'default';

function findexts ($filename) 
 { 
 return strtolower(pathinfo($filename, PATHINFO_EXTENSION));
 
 } 


	$etape = 1;

$addimage = '';


if (!empty($_POST)) $etape = 3;

$errormessage = _('Wrong format');




if (isset($_FILES["file"])) {

if ($_FILES["file"]["size"] > 10000000) {
	
$errormessage = _('Image too Big');	
	
}	


$allowedExts = array("jpg", "jpeg", "gif", "png");
$extension = findexts($_FILES["file"]["name"]);
if ((($_FILES["file"]["type"] == "image/gif")
|| ($_FILES["file"]["type"] == "image/jpeg")
|| ($_FILES["file"]["type"] == "image/png")
|| ($_FILES["file"]["type"] == "image/pjpeg")
|| ($_FILES["file"]["type"] == "application/octet-stream")



)
&& ($_FILES["file"]["size"] < 10000000)
&& in_array($extension, $allowedExts))
  {
	  
	
	  
  if ($_FILES["file"]["error"] > 0)
    {
    echo "Return Code: " . $_FILES["file"]["error"] . "<br>";
    
    $errormessage = _('Bad picture').' '.$_FILES["file"]["error"];
    
    }
  else
    {
      if (file_exists("upload/temp/" . $_FILES["file"]["name"]))
      {
      echo $_FILES["file"]["name"] . " already exists. ";
       
       $errormessage = $_FILES["file"]["name"] . ' '. _('already exists');
      
      }
    else
      {
      move_uploaded_file($_FILES["file"]["tmp_name"],
      "upload/full/" . date("Ymd-His.").$extension);
     
	  $filename = "upload/full/" . date("Ymd-His.").$extension;
	 
	 /*
	  $addimage = "upload/gallery/" . date("Ymd-His.").$extension;
	  $thumbimage600 = "upload/600/" . date("Ymd-His.").$extension;
	  $thumbimage300 = "upload/300/" . date("Ymd-His.").$extension;
	  */
	  $thumbimage = "upload/thumb/" . date("Ymd-His.").$extension;
	  $tmpnimg = date("Ymd-His.").$extension;
	 
	  
	  list($width, $height) = getimagesize($filename);
	  
	/*  
$size = getimagesize($filename);
$ratio = $size[0]/$size[1]; // width/height

	  
	  if( $ratio > 0.80) {
    $new_width = 1200;
    $new_height = round(1200/$ratio);
}
else {
    $new_width = round(1200*$ratio);
    $new_height = 1200;
}

	
	$image_p = imagecreatetruecolor($new_width, $new_height);
	
	if(findexts($filename)=='jpg' or findexts($filename)=='jpeg')  $image = imagecreatefromjpeg($filename);
else if(findexts($filename)=='gif')  $image = imagecreatefromgif($filename);
else if(findexts($filename)=='png')  $image = imagecreatefrompng($filename);
	
	
	
	imagecopyresampled($image_p, $image, 0, 0,0, 0, $new_width, $new_height, $width, $height);    
	imagejpeg($image_p, $addimage, 100);
	
	*/
	
/*	
swcnt_image_resize($filename,$addimage, $width, $height, 0);


$squaresize = 600;
	

 swcnt_image_resize($filename,$thumbimage600,$squaresize, $squaresize, 1);	
 
 $squaresize = 300;
	

 swcnt_image_resize($filename,$thumbimage300,$squaresize, $squaresize, 1);	
	*/
	
	
	
$squaresize = 128;
	

 swcnt_image_resize($filename,$thumbimage,$squaresize, $squaresize, 1);

/*
imagejpeg($image_t, $thumbimage, 100);

unlink($filename);
*/
	$etape = 2;
	
	
	
	  }
    }
  }
else
  {

 $etape = 3;
  }
}


?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Download</title>








<style type="text/css">
body{margin:0}
#rightzone{width:150px;height:500px;position:absolute;z-index:100;right:0;top:0}
#zonerecad{height:500px;width:650px;overflow:auto}
.btn{display:inline-block;font-weight:400;text-align:center;vertical-align:middle;cursor:pointer;background-image:none;border:1px solid transparent;white-space:nowrap;padding:6px 12px;font-size:14px;line-height:1.42857143;border-radius:4px;-webkit-user-select:none;-moz-user-select:none;-ms-user-select:none;user-select:none;color:#fff;background-color:#428bca;border-color:#357ebd;position:relative;overflow:hidden;margin:0}
.fileUpload input.upload{position:absolute;top:0;right:0;margin:0;padding:0;font-size:20px;cursor:pointer;opacity:0;filter:alpha(opacity=0)}
.spinner{width:50px;height:30px;text-align:center;font-size:10px;margin-left:auto;margin-right:auto}
.spinner > div{background-color:#428bca;height:100%;width:6px;display:inline-block;-webkit-animation:stretchdelay 1.2s infinite ease-in-out;animation:stretchdelay 1.2s infinite ease-in-out}
.spinner .rect2{-webkit-animation-delay:-1.1s;animation-delay:-1.1s}
.spinner .rect3{-webkit-animation-delay:-1s;animation-delay:-1s}
.spinner .rect4{-webkit-animation-delay:-.9s;animation-delay:-.9s}
.spinner .rect5{-webkit-animation-delay:-.8s;animation-delay:-.8s}
@-webkit-keyframes stretchdelay {
0%,40%,100%{-webkit-transform:scaleY(0.4)}
20%{-webkit-transform:scaleY(1.0)}
}
@keyframes stretchdelay {
0%,40%,100%{transform:scaleY(0.4);-webkit-transform:scaleY(0.4)}
20%{transform:scaleY(1.0);-webkit-transform:scaleY(1.0)}
}
</style>
<script src="assets/plugins/jQuery/jQuery-2.1.4.min.js"></script>
</head>
<body><?php  if ($etape == 2) {  ?>
             
    			  <script type="text/javascript">
				  
	

$(document).ready(function () { 
	parent.document.getElementById('picturpreview-<?php echo $idp; ?>').src='upload/thumb/<?php echo  $tmpnimg ; ?>'; 
	parent.document.getElementById('picturelement-<?php echo $idp; ?>').value='<?php echo  $tmpnimg ; ?>'; 
	
	});			  
		
			   </script>          


               <?php } ?>
<form style="margin:0px;" action="" method="post" enctype="multipart/form-data">
<input type="hidden" name="MAX_FILE_SIZE" value="10000000">
<div class="fileUpload btn btn-primary">
    <span><?php echo _('Add Picture'); ?></span>
       <input onchange=" parent.document.getElementById('picturelement-<?php echo $idp; ?>').src='assets/dist/img/loading.gif';  form.submit()" id="buttonupload" class="upload" name="file" type="file">
</div>
<div id="tapp2" style="display:none">
<div class="spinner">
  <div class="rect1"></div>
  <div class="rect2"></div>
  <div class="rect3"></div>
  <div class="rect4"></div>
  <div class="rect5"></div>
</div>
</div>


					<input id="btupl2" style="display:none" class="btn-primary" type="button" value="<?php echo _("Uploading"); ?> ">
				</form>
	
               
                
                
</body>
</html><?php } ?>