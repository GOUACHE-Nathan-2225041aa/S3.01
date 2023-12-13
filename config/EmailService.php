<?php

namespace config;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class EmailService
{
private PHPMailer $mailer;

    public function __construct()
    {
        $this->mailer = new PHPMailer(true);
        $this->init();
    }

    private function init(): void
    {
        $config = parse_ini_file('email.ini');
        if ($config === false) {
            throw new Exception("Error loading configuration file.");
        }
        try {
            $this->mailer->isSMTP();
            $this->mailer->Host = $config['host'];
            $this->mailer->SMTPAuth = $config['SMTPAuth'];
            $this->mailer->SMTPSecure = $config['SMTPSecure'];
            $this->mailer->Port = $config['port'];
            $this->mailer->Username = $config['username'];
            $this->mailer->Password = $config['password'];
            $this->mailer->setFrom($config['emailSender'], $config['nameSender']);
        } catch (Exception $e) {
            throw new Exception('Email init failed: ' . $this->mailer->ErrorInfo);
        }
    }

    public function sendEmail(string $user, string $subject, string $message): void
    {
        $this->mailer->clearAddresses();

        try {
            $this->mailer->addAddress($user);
        } catch (Exception $e) {
            throw new Exception('Email addAddress failed: ' . $this->mailer->ErrorInfo);
        }

        $this->mailer->Subject = $subject;
        $this->mailer->Body = $message;

        try {
            $this->mailer->send();
        } catch (Exception $e) {
            throw new Exception('Email send failed: ' . $this->mailer->ErrorInfo);
        }
    }
}
