<?php

chdir(dirname(__DIR__));


error_reporting(-1);

require 'vendor/autoload.php';

class Configure extends Laiz\Core\Configure
{
    protected function getPageNamespace()
    {
        return 'Laiz\Sample\Task\Page';
    }
    protected function configureContainer(Laiz\Core\Container $di)
    {
        parent::configureContainer($di);

        // Global Filter
        $di->setParameters('Laiz\Sample\Task\Filter\Menu',
                           ['iniFile' =>
                            'src/Laiz/Sample/Task/Filter/menu.ini']);
        $filterContainer = $di->get('Laiz\Core\FilterContainer');
        $filterContainer->add('Laiz\Sample\Task\Filter\Vars');
        $filterContainer->add('Laiz\Sample\Task\Filter\Menu');
        $filterContainer->add('Laiz\Sample\Task\Filter\Auth');

        // Login Url
        $di->setParameters('Laiz\Session\Auth\Auth',
                           ['uri' => '/login.html']);
        $di->setMethods('Laiz\Sample\Task\Filter\Auth', 'setLoginUri');

        // Auth
        $di->setParameters('Laiz\Session\Auth\Adapter\IniMd5',
                           ['configFile' => 'config/develop_auth.ini']);
        $di->setMethods('Laiz\Session\Auth\Adapter\IniMd5',
                        'setConfigFile');
        $di->setAlias('Zend\Authentication\Adapter\AdapterInterface',
                      'Laiz\Session\Auth\Adapter\IniMd5');
        $di->setMethods('Zend\Authentication\AuthenticationService',
                        'setAdapter');

        // Auth (DB)
        /* $di->setAlias('Zend\Authentication\Adapter\AdapterInterface',
         *               'Laiz\Session\Auth\Adapter\Db');
         * $di->setParameters('Laiz\Session\Auth\Adapter\Db',
         *                    ['voName' => 'TaskUser',
         *                     'idName' => 'loginId',
         *                     'credentialName' => 'password']);
         * $di->setMethods('Zend\Authentication\AuthenticationService',
         *                 'setAdapter');
         * $di->setMethods('Laiz\Session\Auth\Adapter\Db',
         *                 ['setVoName', 'setIdName', 'setCredentialName']); */

        // DB
        $dsn = 'pgsql:host=localhost;dbname=laiz-sample-task;user=laiz-sample;password=secret';
        $di->setParameters('Laiz\Db\Db', ['dsn' => $dsn]);
        $di->setMethods('Laiz\Db\Db', 'setDsn');

        $db = $di->get('Laiz\Db\Db');
        spl_autoload_register(array($db, 'autoload'));

        // View
        //$di->register('laizViewBehaviors', array());
    }
}

Laiz\Core\Controller::newInstance(Configure::getContainer())->run();
