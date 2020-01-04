#!/bin/bash

if (( $# != 1 )); then
  echo -e "Usage: $0 directory"
  exit 1
fi

cd "$1" || exit 1

for name in *
do
  date="$(echo "$name" | sed -r 's/(.+)_([0-9]{8})_([0-9]{4})([0-9]{2}).+/\2\3.\4/')"
  if [[ $date == ????????????.?? ]]
  then
    touch -amt "$date" "$name"
    echo "Updated "$name
  else
    echo "Skipped "$name
  fi
done

exiftool -overwrite_original -P -progress -ext jpg "-CreateDate<FileModifyDate" "-DateTimeOriginal<FileModifyDate" .
exiftool -overwrite_original -P -progress -ext mp4 -api QuickTimeUTC "-CreateDate<FileModifyDate" "-MediaCreateDate<FileModifyDate" "-MediaModifyDate<FileModifyDate" "-TrackCreateDate<FileModifyDate" "-TrackModifyDate<FileModifyDate" .
