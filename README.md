# TransparencyBot
IRC Bot used for Logging Weekly Meetings
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
* git clone https://github.com/MarylandPirateParty/TransparencyBot.git

Update
* cd TransparencyBot; git pull origin master

Run
* crontab -e
* "* * * * * /usr/bin/php -f /var/www/html/TransparencyBot/bot.php >/dev/null 2>&1"

