<?php
require_once('include/config.php');
require 'vendor/autoload.php';

$action = 'login';
if(isset($_SESSION['data']['user_login'])) {
        $action = 'show';
}
if(isset($_GET['a'])) {
        $action = $_GET['a'];
}

switch($action) {
        case 'form-login':
                $stmt = $db->prepare('SELECT COUNT(*) as `nb` FROM `users` WHERE username = :login AND password = SHA2(CONCAT(SHA1(:login),:pass), 512)');
                $stmt->bindParam(':login', $_POST['username']);
                $stmt->bindParam(':pass', $_POST['password']);
                $stmt->execute();
                $row = $stmt->fetch();
                if($row['nb'] != 1) {
                        $action = 'login';
                } else {
                        $_SESSION['data']['user_login'] = $_POST['username'];
                        $action = 'show';
                        header('Location: https://devbox.u-angers.fr/~adamgreenan3801/');exit;
                }
                break;
        case 'logout':
                unset($_SESSION['data']);
                header('Location: https://devbox.u-angers.fr/~adamgreenan3801/');exit;
                break;
        case 'show':
                if(isset($_SESSION['data']['user_login'])) {
                } else {
                        $action = 'login';
                }
                break;
        case '':

                break;
}

$tree_data = [
        'tree' => [
            'title' => 'Common hawthorn',
            'latinTitle' => 'Crataegus monogyna',
            'image' => 'images/crataegus-monogyna.jpg',
            'description' => 'Common hawthorn (Crataegus monogyna) is a flowering tree that is actually part of the rose family.'
        ],
        'tree2' => [
            'title2' => 'Oak Tree',
            'latinTitle2' => 'Crataegus monogyna',
            'image2' => 'images/download.jpeg',
            'description2' => 'The Oak tree is known for its tree-ness.'
        ]
    ];


function enable2faForUser($userId) {
        # Generate secret key
        $ga = new Google\Authenticator\GoogleAuthenticator(); // create a secret
        $secret = $ga->createSecret();
        # Store hashed secret key in user record
        storeHashedSecretKey($userId, $secret);
        # Generate QR code URL
        $qrCodeUrl = getQRCodeUrl($secret);
        # Display instructions and QR code to user (UI integration)
        displayEnable2faInstructions($qrCodeUrl);
      }

function loginWith2fa($username, $password, $enteredCode) {
        
        
        # Retrieve user record based on username
        $user = getUserRecord($username);
        # Check password validity (use separate logic)
        if (verifyPassword($user, $password)) {
          # Retrieve hashed secret key from user record
          $hashedSecretKey = getHashedSecretKey($user);
          # Verify entered code using secret key
          $checkResult = verifyCode($hashedSecretKey, $enteredCode);
          if ($checkResult) {
            # Login successful, grant access
            return true;
          } else {
            # Invalid code, display error
            return false;
          }
        } else {
          # Invalid password, display error
          return false;
        }
      }

$template = $twig->load($action.'.twig');
  echo $template->render($tree_data,array(
  'data' => $_SESSION['data'],));