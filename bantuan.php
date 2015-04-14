<?php

	header("Content-Disposition: attachment; filename=bantuan.pdf");
	header("Content-length: ".filesize("bantuan.pdf"));
	header("Content-type: application/pdf");
	$fp  = fopen("bantuan.pdf", 'r');
   	$content = fread($fp, filesize("bantuan.pdf"));
   	fclose($fp);
	echo $content;
?>