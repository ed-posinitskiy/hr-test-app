<?php

return array(
    'doctrine' => array(
        'connection' => array(
            'orm_default' => array(
                'driverClass' => 'Doctrine\DBAL\Driver\PDOMySql\Driver',
                'params' => array(
                    'host' => 'localhost',
                    'port' => '3306',
                    'user' => '',
                    'password' => '',
                    'dbname' => '',
                    'driverOptions' => array(
                        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"
                    )
                )
            )
        ),
        'configuration' => array(
            'orm_default' => array(
                'metadata_cache' => 'filesystem',
                'query_cache' => 'filesystem',
                'generate_proxies' => false
            )
        )
    )
);
