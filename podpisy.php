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
                <i class="icon author"></i>
                <span>{{ photo.author }}</span>,
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
    'DSC_0996.JPG' => [
        'author' => 'Wojtek',
        'location' => 'Warszawa, Park Szczęśliwicki',
        'latitude' => '52°12\'26.5"N',
        'longitude' => '20°57\'39.3"E',
    ],
    'DSC_2645.JPG' => [
        'author' => 'Kasia',
        'location' => 'Wiedeń, Hundertwasserhaus',
        'latitude' => '48°12\'27.6"N',
        'longitude' => '16°23\'38.8"E',
    ],
    'DSC_6568.JPG' => [
        'author' => 'Kasia',
        'location' => 'Mersea Island',
        'latitude' => '51°46\'25.6"N',
        'longitude' => '0°54\'58.1"E',
    ],
    'DSC_7997.JPG' => [
        'author' => 'Kasia',
        'location' => 'Londyn, St. Katharine Docks',
        'latitude' => '51°30\'15.4"N',
        'longitude' => '0°04\'31.2"W',
    ],
    'Praga_0214.JPG' => [
        'author' => 'Kasia',
        'location' => 'Dolni Morava, Sky Walk',
        'focalLength' => '8',
        'aperture' => '11',
    ],
    'Praga_1228.JPG' => [
        'author' => 'Kasia',
        'location' => 'Praga, Katedra św. Wita',
        'focalLength' => '8',
        'aperture' => '16',
    ],
    'Praga_1538.JPG' => [
        'author' => 'Wojtek',
        'location' => 'Praga, widok z Wieży Petrińskiej',
    ]
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
    $photosData[] = array_merge([
        'author' => 'Kasia',
        'location' => 'Londyn',
        'filename' => $exif['FileName'],
        'time' => date('G:i d.m.Y', $exif['FileDateTime']),
        'iso' => $exif['ISOSpeedRatings'],
        'flash' => !!$exif['Flash'],
        'aperture' => explode('/', $exif['COMPUTED']['ApertureFNumber'])[1],
        'exposureTime' => '1/' . (explode('/', $exif['ExposureTime'])[1] / 10),
        'focalLength' => number_format(explode('/', $exif['FocalLength'])[0] / 10, 0),
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
