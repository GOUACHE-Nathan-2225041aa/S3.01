<?php

namespace app\controllers\connections;

use app\models\EmailVerification as EmailVerificationModel;
use app\models\User as UserModel;
use app\services\EmailService;
use app\services\Localization as LocalizationService;
use app\views\connections\Recovery as RecoveryView;
use config\DataBase;
use PDO;
use PHPMailer\PHPMailer\Exception;

class Recovery
{
    private PDO $PDO;

    public function __construct()
    {
        $this->PDO = DataBase::getConnectionAccount();
    }

    public function execute(): void
    {
        $loc = (new LocalizationService())->getArray('recovery');
        (new RecoveryView())->show($loc);
    }

    public function recovery(array $data): void
    {
        $parts = explode('/', $data['path']);
        $url = end($parts);
        $postData = $data['post'];
        $user = new UserModel($this->PDO);
        $emailVerification = new EmailVerificationModel($this->PDO);
        $isLinkExpired = null;
        $email = null;

        if (!isset($postData['password']) || !isset($postData['passwordConfirmation'])) {
            $_SESSION['errorMessage'] = 'The password field is empty!';
            header('Location: /recovery');
            exit();
        }

        if ($postData['password'] !== $postData['passwordConfirmation']) {
            $_SESSION['errorMessage'] = 'The passwords do not match!';
            header('Location: /recovery');
            exit();
        }

        $email = $emailVerification->getEmailByURL(htmlspecialchars($url));

        if ($email === null) {
            $_SESSION['errorMessage'] = 'The verification link is invalid!';
            header('Location: /recovery');
            exit();
        }

        $isLinkExpired = $email['expiration_date'] < date('Y-m-d H:i:s');

        if ($isLinkExpired) {
            $_SESSION['errorMessage'] = 'The verification link has expired!';
            header('Location: /recovery');
            exit();
        }

        $data = [
            'email' => $email['email'],
            'password' => password_hash(htmlspecialchars($postData['password']), PASSWORD_DEFAULT),
            'ip' => $_SERVER['REMOTE_ADDR']
        ];

        $user->updatePassword($data['email'], $data['password'], $data['ip']);
        $emailVerification->deleteEmail($data['email']);

        $_SESSION['errorMessage'] = 'Password has been reset!';
        header('Location: /login');
        exit();
    }

    public function verificationURL(array $data): void
    {
        $path = $data['path'];
        $url = null;

        if (preg_match('/\/recovery\/([^\/]+)$/', $path, $matches)) {
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
            header('Location: /recovery');
            exit();
        }

        $isExpired = $emailData['expiration_date'] < date('Y-m-d H:i:s');

        if ($isExpired) {
            $_SESSION['errorMessage'] = 'The verification link has expired!';
            header('Location: /recovery');
            exit();
        }

        $loc = (new LocalizationService())->getArray('recovery');
        (new RecoveryView())->show($loc, true, $emailData['email']);
    }

    public function sendVerificationURL(array $data): void
    {
        $postData = $data['post'];
        $user = new UserModel($this->PDO);
        $emailVerification = new EmailVerificationModel($this->PDO);
        $isAccountExist = null;
        $isLinkExpired = null;
        $email = null;

        if (!isset($postData['email'])) {
            $_SESSION['errorMessage'] = 'The email field is empty!';
            header('Location: /recovery');
            exit();
        }

        $isAccountExist = $user->isUserEmailExist(htmlspecialchars($postData['email']));
        $email = $emailVerification->getEmail(htmlspecialchars($postData['email']));

        if ($email !== null) {
            $isLinkExpired = $email['expiration_date'] < date('Y-m-d H:i:s');
        }

        if (!$isAccountExist) {
            $_SESSION['errorMessage'] = 'The email is not associated with an account!';
            header('Location: /recovery');
            exit();
        }

        if ($email !== null && !$isLinkExpired) {
            $_SESSION['errorMessage'] = 'A recovery email has already been sent!';
            header('Location: /recovery');
            exit();
        }

        $data = [
            'email' => htmlspecialchars($postData['email']),
            'url' => $this->generateVerificationURL(),
            'expiration_date' => date('Y-m-d H:i:s', strtotime('+15 minutes'))
        ];

        $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://';
        $host = $_SERVER['HTTP_HOST'];

        $subject = 'Account Recovery';
        $message = 'Click on the link below to reset your password: ' . $protocol . $host . '/recovery/' . $data['url'];

        try {
            EmailService::getInstance()->sendEmail($data['email'], $subject, $message);
        } catch (Exception $e) {
            $_SESSION['errorMessage'] = 'An error occurred while sending the email!';
            header('Location: /recovery');
            exit();
        }

        if ($isLinkExpired) {
            $emailVerification->updateURL($data['email'], $data['url'], $data['expiration_date']);
        } else {
            $emailVerification->setEmail($data['email'], $data['url'], $data['expiration_date']);
        }

        $_SESSION['errorMessage'] = 'Recovery email has been sent!';
        header('Location: /recovery');
        exit();
    }

    private function generateVerificationURL(): string
    {
        return rtrim(strtr(base64_encode(random_bytes(16)), '+/', '-_'), '=');
    }
}
