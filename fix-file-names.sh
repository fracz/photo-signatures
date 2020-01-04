#!/usr/bin/env bash

if (( $# != 2 )); then
  echo -e "Usage: $0 prefix directory"
  exit 1
fi

PREFIX=$1
DIRECTORY=$2

FILENAME=$PREFIX'_%Y%m%d_%H%M%S-%%01.c.%%e'

exiftool -overwrite_original -progress -ext jpg -P -d $FILENAME '-filename<DateTimeOriginal' "$DIRECTORY"
exiftool -overwrite_original -progress -api QuickTimeUTC -ext mp4 -P -d $FILENAME '-filename<CreateDate' "$DIRECTORY"
