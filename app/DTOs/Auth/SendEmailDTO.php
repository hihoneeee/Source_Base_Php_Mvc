<?php

namespace App\DTOs\Auth;

class SendEmailDTO
{
    public string $senderName;
    public string $senderEmail;
    public string $smtpServer;
    public int $port;
    public string $username;
    public string $password;

    public function __construct()
    {
        $this->senderName = SENDER_NAME;
        $this->senderEmail = SENDER_EMAIL;
        $this->smtpServer = SMTP_SERVER;
        $this->port = 587;
        $this->username = USER_NAME;
        $this->password = PASSWORD;
    }
}
