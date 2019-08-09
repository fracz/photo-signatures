<?php

header('Content-Type: image/jpeg');
$src = $_GET['image'];
if (strpos($src, '/share/Photo') !== 0){
  $src = '/share/Photo/' . $src;
}
readfile($src);
