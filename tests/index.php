<?php
include_once '../src/Imager.php';

$imager = new Sem\Image\Imager();

$imager->load('1.png');
$imager->resizeToWidth(100);

?>
<img src="<?= $imager->base64(IMAGETYPE_PNG);?>" />
