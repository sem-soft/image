# Component for Image resizes
## Install by composer
composer require sem-soft/image
## Or add this code into require section of your composer.json and then call composer update in console
"sem-soft/image": "*"
## Usage
```
<?php
require './vendor/autoload.php';


$imager = new Sem\Image\Imager();

$imager->load('https://pp.vk.me/c626226/v626226456/2eb76/NT9Jhk2sJjo.jpg');
$imager->resizeToWidth(100);

?>
<img src="<?= $imager->base64(IMAGETYPE_PNG);?>" />
```
