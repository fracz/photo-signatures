#!/bin/bash

for name in *
do
  date="$(echo "$name" | sed -r 's/(IMG|VID)_([0-9]{8})_([0-9]{4})([0-9]{2}).+/\2\3.\4/')"
  if [[ $date == ????????????.?? ]]
  then
    touch -amt ${date} "$name"
    echo "Updated "$name
  else
    echo "Skipped "$name
  fi
done

exiftool -overwrite_original -progress "-DateTimeOriginal<FileModifyDate" VID_20*.jpg
exiftool -overwrite_original -progress "-DateTimeOriginal<FileModifyDate" IMG_20*.jpg
