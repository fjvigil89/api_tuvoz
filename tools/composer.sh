#!/bin/bash

ENV=${1:-master}
echo Deploying $ENV
#ssh -i /root/.ssh/id_rsa root@wh-bk.upr.edu.cu  'cd /home/Sync-UPR/master && sudo php ../../composer.phar update --prefer-dist -o'

echo "from Composer"