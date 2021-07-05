<?php

return [
    /*
    |--------------------------------------------------------------------------
    | UTF-8 Bom
    |--------------------------------------------------------------------------
    |
    | The UTF-8 BOM is a sequence of bytes at the start of a text stream (0xEF, 0xBB, 0xBF)
    | that allows the reader to more reliably guess a file as being encoded in UTF-8.
    | Suitable for exporting Japanese data
    |
    */
    'utf-8-bom' => false,

    /*
    |--------------------------------------------------------------------------
    | Validator Support
    |--------------------------------------------------------------------------
    |
    | This is a sample defines how to validate CSV data:
    | - `user.header` is to identify the format of CSV file, that compare the standard header to the CSV header.
    | The "Invalid Header" message of Exception is threw if there is an error
    |
    | - `user.validator` is based on Laravel Validator. If you have multiple user tables or models you may configure multiple
    |       + `user.validator.rules`: set the Laravel validation rules
    |       + `user.validator.messages`: customize the Laravel default error messages
    |       + `user.validator.attributes`: customize the validation attributes
    */
    'user' => [
        'header' => [
            'fname' => 'First Name',
            'lname' => 'Last Name',
            'email' => 'Email',
        ],
        'validator' => [
            'rules' => [
                'fname' => 'required',
                'lname' => 'required',
                'email' => 'required|email',
            ],
            'messages' => [],
            'attributes' => [],
        ],
    ],
];
