<?php
	
$source = file_get_contents("sw-admin/ldb/en_siteinfos.source.json");
$datas = json_decode($source, true);

?><html>
	<head>
	<meta charset="UTF-8">
	<title><?php echo $datas['title']; ?></title>
	</head>
	<body>
		<h1><?php echo $datas['title']; ?></h1>
		
		<h3><?php echo $datas['baseline']; ?></h3>
		<pre>
<?php
	
var_dump($datas);

?>

		</pre>
	</body>
</html>
