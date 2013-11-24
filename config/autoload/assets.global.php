<?php
return array(
    'asset_manager' => array(
        'resolver_configs' => array(
            'collections' => array(
                'js/compact.js' => array(
                    'js/jquery.min.js',
                    'js/bootstrap.min.js'
                ),
                'js/ie-conditional.js' => array(
                    'js/respond.min.js',
                    'js/html5shiv.js'
                ),
                'css/compact.css' => array(
                    'css/bootstrap.min.css',
                    'css/bootstrap-responsive.min.css',
                    'css/style.css'
                ),
            ),
            'paths' => array(
                __DIR__ . '/../../assets/bootstrap',
                __DIR__ . '/../../assets/custom',
            ),
            'filters' => array(
                'js' => array(
                    'filter' => 'JSMin'
                ),
                'css' => array(
                    'filter' => 'CssMin'
                )
            )
        )
    )
);