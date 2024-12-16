<?php

namespace App\Services;

use App\DTOs\Auth\SendEmailDTO;
use App\Helpers\ServiceResponse;
use App\Helpers\ServiceResponseExtensions;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class SendMailService
{
    public function sendEmail(string $to, string $subject, string $html)
    {
        $response = new ServiceResponse();
        $sendEmailDTO = new SendEmailDTO();

        try {
            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->Host = $sendEmailDTO->smtpServer;
            $mail->SMTPAuth = true;
            $mail->Username = $sendEmailDTO->username;
            $mail->Password = $sendEmailDTO->password;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = $sendEmailDTO->port;

            // Cài đặt người gửi và người nhận
            $mail->setFrom($sendEmailDTO->senderEmail, $sendEmailDTO->senderName);
            $mail->addAddress($to);

            // Cài đặt encoding
            $mail->CharSet = 'UTF-8';
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body = $html;

            if ($mail->send()) {
                ServiceResponseExtensions::setSuccess($response, "Hãy kiểm tra email của bạn!");
            } else {
                ServiceResponseExtensions::setError($response, "Failed to send email.");
            }
        } catch (Exception $e) {
            ServiceResponseExtensions::setError($response, 'Mail error: ' . $mail->ErrorInfo);
        }
        return $response;
    }
}
