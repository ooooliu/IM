#!/bin/bash

OS_TYPE=`uname`
BASEPATH=$(cd `dirname $0`; pwd)
GOWATCH_BIN=$BASEPATH/bin/gowatch_${OS_TYPE}_amd64
PHP_BIN=/app/server/php/bin/php
APP_ROOT=$BASEPATH/..

rm -rf $APP_ROOT/runtime/*

#$GOWATCH_BIN run --preCmd "$PHP_BIN $APP_ROOT/bin/hyperf.php di:init-proxy" \
$GOWATCH_BIN run --cmd "php" --args "$APP_ROOT/bin/hyperf.php, start" \
--files "$APP_ROOT/.env" \
--folder "$APP_ROOT/app/, $APP_ROOT/config/,$APP_ROOT/runtime/container/proxy/" \
--autoRestart=true