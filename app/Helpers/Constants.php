<?php
/**
 * Created by PhpStorm.
 * User: n.zekavica
 * Date: 6.4.2022.
 * Time: 22:09
 */
namespace App\Helpers;

class Constants
{
    const ENUM_AVAILABILITY_STATUS = [
        'busy',
        'free'
    ];

    const DATE_FORMAT_MYSQL       = 'Y-m-d';
    const TIME_FORMAT_MYSQL       = 'H:i:s';
    const DATETIME_FORMAT_MYSQL   = 'Y-m-d H:i:s';

    const DATE_FORMAT_PROJECT     = 'd-m-Y';
    const TIME_FORMAT_PROJECT     = 'H:i';
    const DATETIME_FORMAT_PROJECT = 'd-m-Y H:i';

}