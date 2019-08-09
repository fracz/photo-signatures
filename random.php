<?php

function getDirContents($dir, &$results = []) {
    $files = scandir($dir);
    foreach ($files as $key => $value) {
        $path = $dir . DIRECTORY_SEPARATOR . $value;
        if (!is_dir($path)) {
            $results[] = $path;
        } else if ($value != "." && $value != "..") {
            getDirContents($path, $results);
            $results[] = $path;
        }
    }
    return $results;
}

$dirs = array_filter(scandir('/share/Photo'), function ($file) {
    return $file{0} != '.';
});
shuffle($dirs);
$dir = $dirs[38];
$photos = array_filter(getDirContents('/share/Photo/' . $dir), function ($file) {
    return strtolower(end(explode('.', $file))) == 'jpg';
});
shuffle($photos);

$photo = $photos[0];

$place = str_replace('/share/Photo/', '', $photo);
$place = str_replace('/' . basename($photo), '', $place);
$exif = exif_read_data($photo);
$time = strtotime($exif['DateTimeOriginal']);

?><!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible"
        content="ie=edge">
    <title>Random image quest</title>
    <style>
        body {
            padding: 0;
            margin: 0;
            background-size: contain;
            height: 100vh;
            background-position: center;
            background-color: black;
            background-repeat: no-repeat;
        }

        .location {
            position: absolute;
            text-align: center;
            background: rgba(0, 0, 0, .5);
            width: 100%;
            color: white;
            padding: 30px 0;
            font-size: 40px;
            top: 30%;
        }
    </style>
    <script>
      var hidden = true;

      function toggle() {
        document.getElementById("location").style.display = hidden ? 'block' : 'none';
        hidden = !hidden;
      }
    </script>
</head>
<body style="background-image: url('/image.php?image=<?= urlencode($photo) ?>')"
    onclick="toggle()"
    ondblclick="window.location.href = ''">
<div id="location"
    class="location"
    style="display: none">
    <h1><?= $place ?></h1>
    <h2><?= date('H:i, d.m.Y', $time) ?></h2>
</div>
</body>
</html>
