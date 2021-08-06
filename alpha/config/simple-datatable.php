<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Default paginator view
    |--------------------------------------------------------------------------
    |
    */
    'paginator_view' => 'components.simple-datatable.default-bootstrap-4',

    /*
    |--------------------------------------------------------------------------
    | Default simple paginator view
    |--------------------------------------------------------------------------
    |
    */
    'simple_paginator_view' => 'components.simple-datatable.default-bootstrap-4',

    /*
    |--------------------------------------------------------------------------
    | Default makeup for simple table view
    |--------------------------------------------------------------------------
    |
    */
    'default_table_makeup' => 'table-striped table-hover',

    /*
    |--------------------------------------------------------------------------
    | Setting views for specified datatable
    |--------------------------------------------------------------------------
    |
    */
    'views' => [
        'users' => [
            'items' => [
                'increment' => '#',
                'id' => 'ID',
                'name' => 'Name',
                'email' => 'Email',
                'action' => '',
            ],
        ],
    ],
];
