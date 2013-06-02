#!/bin/sh
_zenity="/usr/bin/zenity"
_out="/tmp/whois.output.$$"

filename=$(${_zenity} --title  "Выбор настроек" --entry --text "Укажите chroot образ для сборки" )

if [ "$filename" = "" ]
 then
        filename=`zenity --file-selection --title="Выбор chroot образа"`
                case $? in
                        0)  aum -v --chroot="$filename" ;;
                        *)  zenity --info --text="Не выбрано имя файла" ;;
                esac
fi

arch=`zenity --title "Архитектура" --entry --text "Укажите архтитектуру. Например i586 или x86_64"`


srcname=$(${_zenity} --title  "Выбор настроек" --entry --text "Укажите путь к SRC пакету" )
if [ "$srcname" = "" ]
 then
   srcname=`zenity --file-selection --title="Выбор src пакета"`
        case $? in
                 0)  aum -v --chroot="$srcname" ;;
                 *)  zenity --info --text="Не выбрано имя файла" ;;
        esac

fi

aum -v --chroot=$filename --distrib=http://mirror.yandex.ru/mageia/distrib/3/$arch $srcname \
      2>&1 | zenity --text-info --title "Putting files..." --width 600 --height 300

exit 0
