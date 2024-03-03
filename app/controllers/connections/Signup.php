<?php

namespace app\controllers\connections;

use app\models\EmailVerification as EmailVerificationModel;
use app\models\User as UserModel;
use app\services\EmailService;
use app\services\Localization as LocalizationService;
use app\views\connections\Signup as SignupView;
use config\DataBase;
use PDO;
use PHPMailer\PHPMailer\Exception;
use Ramsey\Uuid\Uuid;

class Signup
{
    private PDO $PDO;

    public function __construct()
    {
        $this->PDO = DataBase::getConnectionAccount();
    }

    public function execute(): void
    {
        if (isset($_SESSION['username'])) {
            header('Location: /home');
            exit();
        }
        $loc = (new LocalizationService())->getArray('signup');
        (new SignupView())->show($loc);
    }

    public function verificationURL(array $data): void
    {
        $path = $data['path'];
        $url = null;

        if (preg_match('/\/signup\/([^\/]+)$/', $path, $matches)) {
            $url = $matches[1];
        }

        $emailVerification = new EmailVerificationModel($this->PDO);
        $emailData = null;
        $isExpired = null;

        if ($url !== null) {
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

        $loc = (new LocalizationService())->getArray('signup');
        (new SignupView())->show($loc, true, $emailData['email']);
    }

    public function sendVerificationURL(array $data): void
    {
        $postData = $data['post'];
        $user = new UserModel($this->PDO);
        $emailVerification = new EmailVerificationModel($this->PDO);
        $isAccountExist = null;
        $isLinkExpired = null;
        $email = null;

        if (isset($postData['email'])) {
            if ($postData['email'] === '') {
                $_SESSION['errorMessage'] = 'Email is required!';
                header('Location: /signup');
                exit();
            }
            $isAccountExist = $user->isUserEmailExist(htmlspecialchars($postData['email']));
            $email = $emailVerification->getEmail(htmlspecialchars($postData['email']));

            if ($email !== null) {
                $isLinkExpired = $email['expiration_date'] < date('Y-m-d H:i:s');
            }
        }

        if (!$isAccountExist || $isLinkExpired) {
            $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://';
            $host = $_SERVER['HTTP_HOST'];

            $data = [
                'email' => htmlspecialchars($postData['email']),
                'url' => $this->generateVerificationURL(),
                'expiration_date' => date('Y-m-d H:i:s', strtotime('+1 hour')),
                'ip' => $_SERVER['REMOTE_ADDR']
            ];

            $subject = 'Verify your email';
            $message = 'Please visit the following link to verify your email address: ' . $protocol . $host . '/signup/' . $data['url'] . '. If you received this verification email in error, please ignore it!';

            try {
                EmailService::getInstance()->sendEmail($data['email'], $subject, $message);
            } catch (Exception $e) {
                error_log('Email send failed: ' . $e->getMessage());
                return;
            }

            if (!$isAccountExist) {
                $uuid = Uuid::uuid4();
                $data['uuid'] = $uuid->toString();
                $user->createUnverifiedUser($data);
            }

            if ($isLinkExpired) {
                $emailVerification->updateURL($data['email'], $data['url'], $data['expiration_date']);
            } else {
                $emailVerification->setEmail($data['email'], $data['url'], $data['expiration_date']);
            }

            $_SESSION['errorMessage'] = 'Verification email has been sent!';
            header('Location: /signup');
            exit();
        } else {
            if ($email !== null) {
                $_SESSION['errorMessage'] = 'Verification email has already been sent!';
                header('Location: ' . $_SERVER['HTTP_REFERER']);
                exit();
            }

            $_SESSION['errorMessage'] = 'Account with this email already exist!';
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit();
        }
    }

    private function generateVerificationURL(): string
    {
        return rtrim(strtr(base64_encode(random_bytes(16)), '+/', '-_'), '=');
    }

    // TODO - refactor this method
    public function signup(array $data): void
    {
        $parts = explode('/', $data['path']);
        $url = end($parts);
        $postData = $data['post'];
        $user = new UserModel($this->PDO);
        $isUsernameTaken = null;
        $emailVerification = new EmailVerificationModel($this->PDO);

        if (isset($postData['username'])) {
            $isUsernameTaken = $user->isUsernameExist(strtolower(htmlspecialchars($postData['username'])));
        }

        if (!isset($postData['password'])) {
            $_SESSION['errorMessage'] = 'Password is required!';
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit();
        }

        if (!isset($postData['passwordConfirmation'])) {
            $_SESSION['errorMessage'] = 'Password confirmation is required!';
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit();
        }

        if ($postData['password'] !== $postData['passwordConfirmation']) {
            $_SESSION['errorMessage'] = 'Passwords do not match!';
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

        $email = $emailVerification->getEmailByURL(htmlspecialchars($url));

        if ($email === null) {
            $_SESSION['errorMessage'] = 'The verification link is invalid!';
            header('Location: /signup');
            exit();
        }

        $data = [
            'username' => strtolower(htmlspecialchars($postData['username'])),
            'password' => password_hash(htmlspecialchars($postData['password']), PASSWORD_DEFAULT),
            'email' => $email['email'],
            'ip' => $_SERVER['REMOTE_ADDR'],
        ];

        $user->finalizeUserAccountCreation($data);
        $emailVerification->deleteEmail(htmlspecialchars($postData['email']));
        header('Location: /login');
        exit();
    }
}
