<?php

namespace App\Http\Services\Concrete\Common;

use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Mail;

/**
 * Class EmailService
 *
 * @package App\Http\Services\Concrete\Common
 * @author  Nikola Zekavica <nikolazekavica88@yahoo.com>
 */
class EmailService
{
    /**
     * @var EmailService
     */
    private static $instance = null;

    /**
     * Get instance of EmailService
     *
     * @return EmailService
     */
    public static function getInstance(): self
    {
        if (!isset(self::$instance)) {
            self::$instance = new EmailService();
        }
        return self::$instance;
    }

    /**
     * Send mail.
     *
     * @param string $sendTo
     *
     * @param Mailable $mailable
     */
    public function send(string $sendTo, Mailable $mailable)
    {
        Mail::to($sendTo)->send($mailable);
    }
}