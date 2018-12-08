#!/bin/bash

if [ $# -ne 1 ];
then
    echo "Arg error"
    exit 1
fi

path="$( dirname "$( dirname `realpath "${BASH_SOURCE[0]}"` )" )/config/passwd"

if [ -a $path ];
then
    if [ ! -w $path ];
    then
        echo "passwd file not writable"
        exit 1
    fi
fi

touch ${path} && chmod 640 ${path} && echo -n $1 > $path
exit $?
