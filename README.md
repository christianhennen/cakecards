#CakeCards
##Description
A greeting card creation and emailing application based on CakePHP, Bootstrap and jQuery


The application is now feature complete but there is still some cleanup and documentation to do.

##Installation
###Via composer (recommended)
1. Clone the repository to your computer or download the latest release.

2. Open your preferred command line interface and change the directory to the downloaded folder, like so:
```
cd /var/www/htdocs/cakecards/
```

3. Install all dependencies via composer:
```
composer install
```

4. Copy the file Config/database.php.default and rename it to database.php

5. Edit the newly created file and fill out the variables according to your database configuration

6. Install the database schema to the configured database (you must be in the Console directory to do that):
```
./cake schema create
```
Be sure to have created a working database configuration in step 5 and to use a fresh, empty database before continuing. If everything's ready, answer the questions about dropping and creating database tables with Yes (y)

7. Direct your browser to the web server you installed the project on and append /users/add 
`http://localhost/cakecards/users/add`

8. Enter the credentials you'd like to use for your main user of the application

**IMPORTANT:** Once you've created the first user you can add new ones after you've logged in with an existing account!