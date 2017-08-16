# TransparencyBot
IRC Bot used for Logging Weekly Meetings

## Commands
* start meeting
* end meeting

## File Index
* config.php
* bot.php 

## config.php
* This file is all you should have to modify
* IRC server
* IRC port
* Local Party Name
* Room to Join to await commands

## bot.php
* This is the nuts and bolts of the bot's lifespan 
* Commands are stored here

**Code from almost EVERY example of PHP/IRC was used in some way.**

# Requirements
* php
* git

Install
* cd /var/www/html; git clone https://github.com/MarylandPirateParty/TransparencyBot.git; chown -R www-data:www-data TransparencyBot 
* crontab -e (use nano)
* add cron: * * * * * /usr/bin/php -f /var/www/html/TransparencyBot/bot.php >/dev/null 2>&1

Update
* cd /var/www/html/TransparencyBot; git pull origin master

