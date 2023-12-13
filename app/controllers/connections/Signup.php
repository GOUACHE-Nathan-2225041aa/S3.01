<?php

namespace app\controllers\connections;

use app\models\EmailVerification;
use app\models\User as UserModel;
use app\views\connections\Signup as SignupView;
use config\DataBase;
use config\EmailService;
use app\models\EmailVerification as EmailVerificationModel;
use PDO;
use PHPMailer\PHPMailer\Exception;

class Signup
{
    private PDO $PDO;

    public function __construct()
    {
        $this->PDO = DataBase::getConnection();
    }

    public function execute(): void
    {
        if (isset($_SESSION['password'])) {
            header('Location: /home');
            exit();
        }
        (new SignupView())->show();
    }

    public function verificationURL($url): void
    {
        $emailVerification = new EmailVerificationModel($this->PDO);
        $emailData = null;
        $isExpired = null;

        if (isset($url)) {
            $emailData = $emailVerification->getEmailByURL(htmlspecialchars($url));
        }

        if ($emailData === null) {
            $_SESSION['errorMessage'] = 'The verification link is invalid!';
            header('Location: /signup');
            exit();
        }

        $isExpired = $emailData['expiration_date'] < date('Y-m-d H:i:s');

        if ($isExpired) {
            $_SESSION['errorMessage'] = 'The verification link has expired!';
            header('Location: /signup');
            exit();
        }

        (new SignupView())->show(true, $emailData['email']);
    }

    public function sendVerificationURL($postData): void
    {
        $user = new UserModel($this->PDO);
        $isAccountExist = null;

        if (isset($postData['email'])) {
            $isAccountExist = $user->isUserEmailExist(htmlspecialchars($postData['email']));
        }

        if (!$isAccountExist) {
            $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://';
            $host = $_SERVER['HTTP_HOST'];

            $data = [
                'email' => htmlspecialchars($postData['email']),
                'url' => $this->generateVerificationURL(),
                'expiration_date' => date('Y-m-d H:i:s', strtotime('+1 hour')),
            ];

            $subject = 'Verify your email';
            $message = 'Please visit the following link to verify your email address: ' . $protocol . $host . '/signup/' . $data['url'] . '. If you received this verification email in error, please ignore it!';

            try {
                EmailService::getInstance()->sendEmail($data['email'], $subject, $message);
            } catch (Exception $e) {
                error_log('Email send failed: ' . $e->getMessage());
                return;
            }

            (new EmailVerification($this->PDO))->setEmail($data['email'], $data['url'], $data['expiration_date']);

            header('Location: /signup');
            exit();
        }
    }

    private function generateVerificationURL(): string
    {
        return rtrim(strtr(base64_encode(random_bytes(16)), '+/', '-_'), '=');
    }

    // TODO - refactor this method
    public function signup($postData): void
    {
        $user = new UserModel($this->PDO);
        $isAccountExist = null;
        $isUsernameTaken = null;

        if (isset($postData['username'])) {
            $isAccountExist = $user->isUserEmailExist(htmlspecialchars($postData['email']));
            $isUsernameTaken = $user->isUsernameExist(strtolower(htmlspecialchars($postData['username'])));
        }

        if (!isset($postData['password'])) {
            $_SESSION['errorMessage'] = 'Password is required!';
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit();
        }

        if ($isAccountExist) {
            $_SESSION['errorMessage'] = 'Account with this email already exist!';
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit();
        }

        if ($isUsernameTaken) {
            $_SESSION['errorMessage'] = 'Account with this username already exist!';
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit();
        }

        if (!isset($postData['email'])) {
            $_SESSION['errorMessage'] = 'Email is required!';
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit();
        }

        if (!isset($postData['username'])) {
            $_SESSION['errorMessage'] = 'Username is required!';
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit();
        }

        $data = [
            'username' => strtolower(htmlspecialchars($postData['username'])),
            'password' => password_hash(htmlspecialchars($postData['password']), PASSWORD_DEFAULT),
            'email' => htmlspecialchars($postData['email']),
            'ip' => $_SERVER['REMOTE_ADDR'],
        ];

        $user->createUser($data);
        (new EmailVerification($this->PDO))->deleteEmail(htmlspecialchars($postData['email']));
        header('Location: /login');
        exit();
    }
}
