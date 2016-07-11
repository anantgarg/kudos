# Installation instructions

1. Rename config.default.php to config.php and rename .htaccess.default to .htaccess
2. Create a new database
3. Edit config.php and add the necessary details
4. Update .htaccess if need be
5. Run yoursite.com/kudos/install

# Twitter integration

1. Go to <https://apps.twitter.com/app/new>
2. Enter website & callback URL same as that of your kudos URL
3. Go to "Keys and Access Tokens" tab and copy API Key and API Secret into the config.php file
4. Click on Twitter option in the Connect tab and follow the onscreen instructions

# Facebook integration

1. Go to <https://developers.facebook.com/apps>
2. Click on Add a New App
3. Select Website
4. Enter a name e.g. "Kudos for YourSite"
5. Enter your site URL
6. Go to the app dashboard and copy App ID & App Secret into the config.php file (You need to submit the app for review)
7. Click on Facebook option in the Connect tab and follow the onscreen instructions

# Zendesk integration

1. Click on Zendesk option in the Connect tab
2. Enter a name for your new channel
3. Add your login email (used for logging into Zendesk)
4. Find your API key in Settings -> Channels -> API
5. Enter your Zendesk URL e.g. "yoursite.zendesk.com"

# Cron job

1. Run yoursite.com/kudos/cron once every day to pull the latest feeds
2. For the first time, you can also run it manually
