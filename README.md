<<<<<<< HEAD
DigiCare Backend  
================  
  
Install  
-------  
1. Clone project to public/web directory, eg. `sudo -uweb2 git clone https://maxfloden@bitbucket.org/maxfloden/carelink-backend.git`    
2. composer install and update, eg.  
`php composer-setup.php`  
`sudo -uweb2 php ./composer.phar install`  
`sudo -uweb2 php ./composer.phar update`  
3. chmod 777 on folder runtime/  
4. chmod 777 on folder web/uploads/ and inner folders  
5. Change config/db.php to update database data  
`nano config/db.php`  
6. Make sure correct file owner on all project files:  
`chown -R web2:client1 *`  
`chown -R web2:client1 .*`  
7. If you get error when accessing in browser, check issue #22:  
- Add short_open_tag=on to php.ini  
- This error "Invalid Parameter – yii\base\InvalidParamException The file or directory to be published does not exist: /var/www/clients/client1/web2/web/vendor/bower/jquery/dist"  
`mv vendor/bower-asset vendor/bower`  
  
Updates  
-------  
Use update.sh instead of git pull to make sure migrations etc is also run.  
`sudo -uweb2 ./update.sh`  
  
Developer  
---------  
- Any changes made to db must both be implemented in function to create new provider in controllers/ProviderController.php and as migration  
- For migrations extend ProvidersMigration and use p_{function } for operations with providers tables, table name should be without prefix. (Issue #27)  
=======
# Digicare
DigiCare is an eHealth and digital company.
DigiCare is an eHealth and digital company. We provide increased participation, security and quality in elderly care by simplifying and improving communication between the elderly, relatives and executives. Our app gives the elderly and their relatives access to relevant information, communication routes and services. Executives get a more efficient way of working, higher service levels and customer satisfaction as well as increased revenues.   
# Mobile Applications
Follow this repository for mobile applications of this project:   
https://github.com/AncapIT/digicare-app  
DigiCare is available for Android and iPhone and can be downloaded from Google Play and Apple AppStore.
>>>>>>> 6ef70bb7828307f80d6cc0600df3f4d39a308aa9
