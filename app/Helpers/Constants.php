<?php

namespace App\Helpers;

/**
 * Class Constants
 *
 * @package App\Helpers
 * @author  Nikola Zekavica <nikolazekavica88@yahoo.com>
 */
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

    const VERIFICATION_USER_LINK  = '/api/users/verify?code=';

    const START_DATE_LIMIT_SEARCH = 3;
    const END_DATE_LIMIT_SEARCH   = 3;
}