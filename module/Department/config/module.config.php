<?php

namespace Department;

return array(
    'controllers'  => array(
        'invokables' => array(
            'Department\Controller\Index' => 'Department\Controller\IndexController',
        ),
    ),
    'router'       => array(
        'routes' => array(
            'department' => array(
                'type'          => 'Literal',
                'options'       => array(
                    // Change this to something specific to your module
                    'route'    => '/department',
                    'defaults' => array(
                        // Change this value to reflect the namespace in which
                        // the controllers for your module are found
                        '__NAMESPACE__' => 'Department\Controller',
                        'controller'    => 'index',
                        'action'        => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes'  => array(
                    'list' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'       => '/list[/:page]',
                            'constraints' => array(
                                'page' => '[0-9]+',
                            ),
                            'defaults'    => array(
                                'action' => 'index'
                            ),
                        ),
                    ),
                    'add' => array(
                        'type'    => 'Literal',
                        'options' => array(
                            'route'       => '/add',
                            'defaults'    => array(
                                'action' => 'add'
                            ),
                        ),
                    ),
                    'edit' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'       => '/edit/:id',
                            'constraints' => array(
                                'id' => '[0-9]+',
                            ),
                            'defaults'    => array(
                                'action' => 'edit'
                            ),
                        ),
                    ),
                    'delete' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'       => '/delete/:id',
                            'constraints' => array(
                                'id' => '[0-9]+',
                            ),
                            'defaults'    => array(
                                'action' => 'delete'
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
    'doctrine' => array(
        'driver' => array(
            'department_entities' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'paths' => array(
                    __DIR__ . '/../src/' . __NAMESPACE__ . '/Entity'
                )
            ),
            'orm_default' => array(
                'drivers' => array(
                    __NAMESPACE__ . '\Entity' => 'department_entities'
                )
            )
        )
    ),
    'navigation' => array(
        'default' => array(
            array(
                'label' => 'Department',
                'route' => 'department/list'
            )
        )
    )
);
