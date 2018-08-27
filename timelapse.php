<?php
ini_set('memory_limit', '3G');

const REGEX = '#^\d_\d+(08|12|16)000\d\.jpg$#';
const START_FROM = '#07-24#';
const OUT = 'timelapse-out';

$path = '//router/ftp/hikvision';
$files = scandir($path);

if (!is_dir(OUT)) {
    mkdir(OUT, 0777, true);
}

$total = count($files);
$current = 0;

$started = !START_FROM;

foreach ($files as $file) {
    echo "\r$current / $total";
    ++$current;
    if (!$started) {
        $started = preg_match(START_FROM, $file);
        if (!$started) {
            continue;
        }
    }
    if (!is_dir($path . '/' . $file)) {
        $archivePath = 'phar://' . $path . '/' . $file;
        $filesInArchive = scandir($archivePath);
//        $archive = new PharData($path . '/' . $file);
        $matchingFiles = array_filter($filesInArchive, function ($filepath) {
            return preg_match(REGEX, $filepath);
        });
        unset($filesInArchive);
        if ($matchingFiles) {
            foreach ($matchingFiles as $matchingFile) {
//                /** @var PharFileInfo $matchingFile */
//                $img = $matchingFile->getContent();
                $img = file_get_contents($archivePath . '/' . $matchingFile);
                file_put_contents(OUT . '/' . $matchingFile, $img);
                unset($img);
            }
        }
    }
}
