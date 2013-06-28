# Laiz Sample Application: Task

Laiz Framework Application Sample.

## Framework Setup

    composer.phar create-project laiz/laiz-sample-task laiz-sample-task
    cd laiz-sample-task
    mkdir cache
    chmod o+w cache

## Apache Virtual Host Configuration

    <VirtualHost *:80>
        ServerAdmin webmaster@localhost
        ServerName localhost

        DocumentRoot /home/to/path/laiz-sample-task/public
        SetEnv APPLICATION_ENV "development"
        #SetEnv APPLICATION_ENV "production"
        <Directory /home/to/path/laiz-sample-task/public>
            DirectoryIndex index.html
            AllowOverride All
            Order allow,deny
            Allow from all
        </Directory>
    </VirtualHost>

## Setup Database

    createuser laiz-sample -P
    # Enter password: secret
    createdb -O laiz-sample laiz-sample-task
    psql -h localhost -U laiz-sample laiz-sample-task < db/version0.sql


## View in Browser

Access to localhost. Login id is `user1` and password is `my-password`.
Thereis in config/develop_auth.ini file.


## Change Authentication Adapter to Db

* Change from IniMd5 to Db in config/di.ini
* run vender/bin/migration.php
* Change Laiz/Sample/Task/Page/Session#add method

    $result = $auth->login($this->id, md5($this->password));
