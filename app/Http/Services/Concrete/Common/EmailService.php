<?php
/**
 * Created by PhpStorm.
 * User: n.zekavica
 * Date: 14.4.2022.
 * Time: 16:31
 */

namespace App\Http\Services\Concrete\Common;

use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Mail;

class EmailService
{
    public static function send(string $sendTo, Mailable $mailable)
    {
        Mail::to($sendTo)->send($mailable);
    }
}