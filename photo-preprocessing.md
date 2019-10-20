# Geotagging

[Exiftool documentation](https://sno.phy.queensu.ca/~phil/exiftool/geotag.html)

```
 exiftool -overwrite_original -progress -api GeoMaxIntSecs=0 -api GeoMaxExtSecs=900 -geotag gpx/20190907.gpx -geotag gpx/20190908.gpx .
```

# Setting file date to the EXIF date

On QNAP:

```
opkg install perl-image-exiftool jhead

```

```
jhead -ft *.jpg
```

# Fixing EXIF dates

Shift by hours

```
exiftool -overwrite_original -progress "-DateTimeOriginal+=0:0:1 0:0:0" -if '$datetimeoriginal =~ /^2019:10:13/' .
```

# Renaming files to names with dates
