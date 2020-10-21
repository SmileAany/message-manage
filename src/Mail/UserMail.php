<?php

namespace Smbear\MessageManage\Mail;

use Illuminate\Queue\SerializesModels;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;

class UserMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $params;

    public function __construct(array $params)
    {
        $this->params = $params;
    }

    public function build()
    {
        $this->view($this->getViewByType($this->params['type']))
            ->with($this->params);
    }
}