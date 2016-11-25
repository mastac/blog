<?php

return [

    'pdf' => [
        'enabled' => true,
//        'binary'  => '/usr/local/bin/wkhtmltopdf',
        'binary'  => base_path('vendor/h4cc/wkhtmltopdf-amd64/bin/wkhtmltopdf-amd64'),
        'timeout' => false,
        'options' => array(),
        'env'     => array(),
    ],
    'image' => [
        'enabled' => true,
        'binary'  => '/usr/local/bin/wkhtmltoimage',
        'timeout' => false,
        'options' => array(),
        'env'     => array(),
    ]

    // to work snappy need install
    // apt-get install libxrender1 libfontconfig
];