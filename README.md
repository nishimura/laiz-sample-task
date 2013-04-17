# Laiz Sample Application: Task

Laiz Framework Application Sample.

## Framework Setup

    composer.phar create-project laiz/laiz-sample-task laiz-sample-task
    cd laiz-sample-task
    mkdir logs cache
    chmod o+w logs cache

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


## Note

### Bug of zend-stdlib

    Unknown error: Polyfill autoload support (file library/Zend/Stdlib/compatibility/autoload.php) is no longer necessary;
    please remove your require statement referencing this file

Fixed: https://github.com/zendframework/Component_ZendStdlib/commit/acc746acf5e277e89f1ad527901f2fff8754aaab


    sed -i 's/require $vendorDir.*zend-stdlib.*//' vendor/composer/autoload_real.php

## Change Authentication Adapter to Db

* Change from IniMd5 to Db in config/di.ini
* run vender/bin/migration.php
* Change Laiz/Sample/Task/Page/Session#add method

    $result = $auth->login($this->id, md5($this->password));
