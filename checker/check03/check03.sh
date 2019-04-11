#!/bin/zsh
host=localhost:8100
#Ex03 : cookies
name=Name
value=Okalm

echo Exercice 01
	curl  http://$host/ex01/phpinfo.php > ex01.res

echo "\n\n"
echo Exercice 02
echo You should see:
	echo login:
	echo login: mmontinet
	echo login: mmontinet 
	echo oklma: okalm 
	echo Bonjour: Salut
	curl  "http://$host/ex02/print_get.php?"
	curl  "http://$host/ex02/print_get.php?login="
	curl  "http://$host/ex02/print_get.php?login=mmontinet"
	curl  "http://$host/ex02/print_get.php?login=mmontinet&oklma=okalm&Bonjour=salut"

echo "\n\n"
echo Exercice 03
echo You should see: $value
	curl -b cook.txt -c cook.txt  "http://$host/ex03/cookie_crisp.php?action=set&name=$name&value=$value"
	curl -b cook.txt -c cook.txt  "http://$host/ex03/cookie_crisp.php?action=get&name=$name&value=$value"
	curl -b cook.txt -c cook.txt  "http://$host/ex03/cookie_crisp.php?action=get&name=badname&value=$value"
	curl -b cook.txt -c cook.txt  "http://$host/ex03/cookie_crisp.php?action=del&name=$name&value=$value"
	curl -b cook.txt -c cook.txt  "http://$host/ex03/cookie_crisp.php?action=get&name=$name&value=$value"
	curl -b cook.txt -c cook.txt  "http://$host/ex03/cookie_crisp.php?action=get&name=badname&value=$value"
	curl -b cook.txt -c cook.txt  "http://$host/ex03/cookie_crisp.php?action=del&name=badname&value=$value"

echo "\n\n"
echo Exercice 04
	curl --head http://$host/ex04/raw_text.php
	curl http://$host/ex04/raw_text.php

# echo "\n\n"
# echo Exercice 05
# 	curl --head http://$host/ex05/read_img.php
# 	curl http://$host/ex05/read_img.php > ex05.png

# echo "\n\n"
# echo Exercice 06
# 	curl --user zaz:jaimelespetitsponeys http://$host/ex06/members_only.php > ex06.png
# 	curl -v --user root:root http://$host/ex06/members_only.php
