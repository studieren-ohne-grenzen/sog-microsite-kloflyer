#!/usr/bin/env bash

SCRIPT=$(readlink -f "$0")
DIR=$(dirname "$SCRIPT")

cd "$DIR"

npm --prefix . install jquery
cp node_modules/jquery/dist/jquery.min.js js
coffee -c js/scripts.coffee

# scp -r css img js *.html *.php ssh-w007b4ad@studieren-ohne-grenzen.org:/www/htdocs/w007b4ad/foerdern
