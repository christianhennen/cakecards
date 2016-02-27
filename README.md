[![Stories in Ready](https://badge.waffle.io/christianhennen/cakecards.svg?label=ready&title=Ready)](http://waffle.io/christianhennen/cakecards)

#CakeCards
##Description
A greeting card creation and emailing application based on CakePHP, Bootstrap and jQuery

##Installation
### Prerequisites
* PHP 5.6.0 or greater with:
  * PDO extension for the selected database type, e.g. PDOMySQL
  * mcrypt extension
* MySQL 4 or greater (check the CakePHP documentation for other database options)
* An empty database and a folder or subdomain on a server of your choice
* The Composer Dependency Manager 

###Via composer (recommended)
1. Open your preferred command line interface and change the directory to the folder of your web server you want the app to live in.
If you want the app to be available at http://yourserver.com/cakecards/ and your server directories can be found under /var/www just type:
    ```
    cd /var/www/htdocs/
    git clone https://github.com/christianhennen/cakecards.git
    ```
  to download all the necessary files. Type `git clone --help` for further information on cloning a repository.

2. Change to the cloned directory and install all dependencies via composer:
    ```
    cd cakecards/
    composer install
    ```
  Make sure you are using the correct version of PHP with composer when working with management tools like Plesk.
  The selected PHP version needs to use the extensions listed under Prerequisites.

3. Copy the file Config/database.php.default and rename it to database.php
    ```
    cp Config/database.default.php Config/database.php
    ```

4. Edit the newly created file (e.g. with `nano Config/database.php`) and fill out the variables according to your database configuration.
For more information about this file please consult the CakePHP Manual: http://book.cakephp.org/2.0/en/getting-started.html#cakephp-database-configuration

5. Install the database schema to the configured database:
    ```
    Console/cake schema create
    ```
  Be sure to have created a working database configuration in step 4 and to use a fresh, empty database before continuing.
  If everything's ready, answer the questions about dropping and creating database tables with Yes (y).

6. Direct your browser to the web server you installed the project on and append /users/add 
`http://yourserver.com/cakecards/users/add`

7. Enter the credentials you'd like to use for your main user of the application.

**IMPORTANT:** 
The first user you've just created will be assigned the role of a super admin. If you choose to add other users, they can be assigned this role as well. 
Be aware that if you delete every user with super admin privileges, the first user in the database will automatically be promoted to super admin.

##Upgrading
Upgrading the application is pretty straighforward:
1. Open a terminal and change to the installation directory (e.g. /var/www/htdocs/cakecards/)

2. Pull the latest changes from the repository
    ```
    cd /var/www/htdocs/cakecards
    git pull
    ```

3. Update the database schema (necessary if Config/schema.php has changed)
    ```
    Console/cake schema update
    ```
