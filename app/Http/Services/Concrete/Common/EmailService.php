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
    private static $instance = null;

    public static function getInstance(): self
    {
        if (!isset(self::$instance)) {
            self::$instance = new EmailService();
        }
        return self::$instance;
    }

    public function send(string $sendTo, Mailable $mailable)
    {
        Mail::to($sendTo)->send($mailable);
    }
}