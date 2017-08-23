# TransparencyBot
IRC Bot used for Logging Weekly Meetings

## Features
* Two way slack chanel
* Agenda Notes
* Meeting Notes
* Request Introduction for join's during meeting
* E-Mail notifications
* Web access for prior meetings
* Live stream of meeting to website

## Install
* cd /var/www/html; git clone https://github.com/MarylandPirateParty/TransparencyBot.git; chown -R www-data:www-data TransparencyBot 
* crontab -e (use nano)
* add cron: * * * * * /usr/bin/php -f /var/www/html/TransparencyBot/bot.php >/dev/null 2>&1

Update
* cd /var/www/html/TransparencyBot; git pull origin master

Notes
* bot activities should persist if the bot is completely restarted
