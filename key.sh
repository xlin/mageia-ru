#!/bin/bash

rep_i586="/root/key/"
spisok_i586=`ls ${rep_i586}`;
pass=" "


for rpmpkg586 in `echo $spisok_i586`
do
if  rpm --checksig $rep_i586$rpmpkg586
then
#               echo "Есть подпись!"
        echo $rpmpkg586 >> pkg_sig.log
else   
        echo "Нет подписи!"
        echo $rpmpkg586 >> pkg_no_sig.log
        /usr/bin/expect << EOF
                spawn rpm --addsign $rep_i586$rpmpkg586
                expect "Введите ключевую фразу: " { send " \n" }
                expect "# " { send "q" }
                exit
EOF
fi
done
