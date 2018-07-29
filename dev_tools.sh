#!/bin/bash

RED='\e[0;31m'
GREEN='\e[0;32m'
NC='\e[0m'

echo -e "${GREEN}python 开发或环境配置${NC}"

sudo easy_install pip
sudo pip install fabric fabtools

echo -e "${GREEN} 配置 ssh 开始 ${NC}"
read -p "输入ssh keygen comment, 如exyour_email@example.com :" comment
if [ $comment =="" ]; then
   exit 0;
fi

ssh-keygen -t rsa -b 4096 -C "${comment}"
eval "$(ssh-agent -s)"

read -p "输入刚才生成的私钥路径:" keygen

echo -e "${RED}"
while [ ! -f $keygen ]; do
   read -p "私钥不存在请从新输入:" keygen
done
echo -e "${NC}"

read -p "输入刚才生成的公钥路径:" pubpath

echo -e "${RED}"
while [ ! -f $pubpath ]; do
   read -p "公钥不存在请从新输入:" pubpath
done
echo -e "${NC}"

ssh-add ${keygen}
ssh-copy-id -i ${pubpath} app_git@144.217.73.99

cat >> $HOME/.ssh/config<<EOF
Host yeeyi.app
     HostName 144.217.73.99
     Port 22
     User app_git
     IdentityFile ${keygen}
EOF
