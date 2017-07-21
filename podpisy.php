<html>
<head>
    <style type="text/css" media="all">
        * {
            box-sizing: border-box;
        }

        #photos {
            transform: scale(.6);
        }

        .photo-info {
            font-family: Arial;
            font-size: 16px;
            text-align: right;
            width: 18cm;
            height: 3cm;
            padding: 15px;
            border: 1px grey dotted;
            float: left;
            margin: 10px;
        }

        .exif-item {
            margin: 3px 5px;
            display: inline-block;
        }

        .exif-item span {
            display: inline-block;
            vertical-align: middle;
        }

        .icon {
            display: inline-block;
            vertical-align: middle;
        }

        .icon.aperture {

            background: url(flickr-icons.png) -77px -78px no-repeat;
            width: 22px;
            height: 22px;
        }

        .icon.focal {
            background: url(flickr-icons.png) -40px -126px no-repeat;
            width: 20px;
            height: 22px;
        }

        .icon.exposure {
            background: url(flickr-icons.png) -100px -78px no-repeat;
            width: 20px;
            height: 22px;
        }

        .icon.iso {
            background: url(flickr-icons.png) -109px -126px no-repeat;
            width: 24px;
            height: 16px;
        }

        .icon.flash-off {
            background: url(flickr-icons.png) 0 -126px no-repeat;
            width: 19px;
            height: 24px;
        }

        .icon.flash-on {
            background: url(flickr-icons.png) -172px 0 no-repeat;
            width: 17px;
            height: 24px;
        }

        .icon.location {
            background: url(flickr-icons.png) -172px -25px no-repeat;
            width: 17px;
            height: 23px;
        }

        .icon.author {
            background: url(flickr-icons.png) 0 -78px no-repeat;
            width: 22px;
            height: 22px;
        }

        .icon.clock {
            background: url(clock.png);
            width: 22px;
            height: 22px;
        }

        .icon.image {
            background: url(image.png);
            background-size: contain;
            width: 22px;
            height: 22px;
        }
    </style>
</head>
<body style="-webkit-print-color-adjust:exact;">

<div id="photos">
    <div class="photo-info" v-for="photo in photos">
        <div>
            <span class="exif-item">
                <i class="icon location"></i>
                <span>{{ photo.location }}, {{ photo.latitude }}, {{ photo.longitude }}</span>
            </span>
            <span class="exif-item">
                <i class="icon clock"></i>
                <span>{{ photo.time }}</span>
            </span>
        </div>
        <div class="row">
            <span class="exif-item">
                <i class="icon aperture"></i>
                <span>ƒ/{{ photo.aperture }}</span>
            </span>

            <span class="exif-item">
                <i class="icon focal"></i>
                <span>{{ photo.focalLength }} mm</span>
            </span>

            <span class="exif-item">
                <i class="icon exposure"></i>
                <span>{{ photo.exposureTime }}</span>
            </span>

            <span class="exif-item">
                <i class="icon iso"></i>
                <span>{{ photo.iso }}</span>
            </span>

            <span class="exif-item" v-if="!photo.flash">
                <i class="icon flash-off"></i>
            </span>

            <span class="exif-item" v-if="photo.flash">
                <i class="icon flash-on"></i>
            </span>
        </div>
        <div>
            <span class="exif-item">
                <i class="icon image"></i>
<!--                <span>{{ photo.author }}</span>,-->
                <span>{{ photo.filename }}</span>
            </span>
        </div>
    </div>
</div>

<?php
const BASE = __DIR__ . '/photos/';
$photos = array_diff(scandir(BASE), array('.', '..', '.gitignore'));
$photosData = [];
$customData = [
    'DSC_3631.JPG' => ['location' => 'Wąwóz Vintigar, Słowenia'],
    'DSC_3879.JPG' => ['location' => 'Spodnja Sorica, Słowenia'],
    'DSC_4173.JPG' => ['location' => 'Canal Grande, Wenecja'],
    'DSC_4442.JPG' => ['location' => 'Plac Świętego Marka, Wenecja'],
    'DSC_5016.JPG' => ['location' => 'Viale Miramare, Triest, Włochy'],
    'DSC_5932.JPG' => ['location' => 'Triest, Włochy'],
    'DSC_6753.JPG' => ['location' => 'Jeziora plitwickie, Chorwacja'],
    'DSC_7280_hdr.JPG' => ['location' => 'Karlobag, Chorwacja'],
    'DSC_7309_hdr.JPG' => ['location' => 'Karlobag, Chorwacja'],
    'DSC_7892.JPG' => ['location' => 'Rovnj, Chorwacja'],
    'DSC_8421.JPG' => ['location' => 'Rovnj, Chorwacja'],
    'DSC_9224.JPG' => ['location' => 'Piran, Słowenia'],
    'Macedonia_2017_1118.JPG' => ['location' => 'Jezioro Ohrydzkie, Macedonia'],
    'Macedonia_2017_3489.JPG' => ['location' => 'Kratowo, Macedonia'],
];
foreach ($photos as $photo) {
    $path = BASE . $photo;
    $exif = exif_read_data($path);
    if (isset($exif['GPSLatitude'])) {
        eval('$lat = [' . $exif['GPSLatitude'][0] . ',' . $exif['GPSLatitude'][1] . ',round(' . $exif['GPSLatitude'][2] . ', 1)];');
        $lat = "$lat[0]°$lat[1]'$lat[2]\"" . $exif['GPSLatitudeRef'];
        eval('$lng = [' . $exif['GPSLongitude'][0] . ',' . $exif['GPSLongitude'][1] . ',round(' . $exif['GPSLongitude'][2] . ', 1)];');
        $lng = "$lng[0]°$lng[1]'$lng[2]\"" . $exif['GPSLongitudeRef'];
    }
//    var_dump($exif);
    $focalLength = number_format(explode('/', $exif['FocalLength'])[0] / 10, 1);
    $photosData[] = array_merge([
        'author' => 'Kasia',
        'location' => 'Londyn',
        'filename' => $exif['FileName'],
        'time' => date('G:i d.m.Y', strtotime($exif['DateTimeOriginal'])),
        'iso' => $exif['ISOSpeedRatings'],
        'flash' => !!$exif['Flash'],
        'aperture' => explode('/', $exif['COMPUTED']['ApertureFNumber'])[1],
        'exposureTime' => '1/' . (explode('/', $exif['ExposureTime'])[1] / 10),
        'focalLength' => intval($focalLength) == $focalLength ? intval($focalLength) : $focalLength,
        'latitude' => $lat ?? '',
        'longitude' => $lng ?? '',
    ], $customData[$photo] ?? []);
}
?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.1.10/vue.min.js"></script>
<script>
    new Vue({
        el: '#photos',
        data: {
            photos: <?=json_encode($photosData)?>
        }
    })
</script>

</body>
</html>
