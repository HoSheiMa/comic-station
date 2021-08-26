<?php
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
include 'configs.php';

require './lib/autoload.php';

if (isset($_GET['q'])) {
    switch ($_GET['q']) {
        case 'random_comics':
            $r = rand(0, 2000);
            $url = "https://xkcd.com/" . $r . "/info.0.json";
            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

            $resp = curl_exec($curl);
            curl_close($curl);
            echo $resp;
            break;
            case 'VerifyAccount':
                $mail = new PHPMailer(true);
        
                try {
                    $key = rand(0, 9999);
                    $_SESSION['key'] = $key;
                    $_SESSION['email'] = $_GET['e'];
                    $mail->isSMTP();                                            
                    $mail->Host       = 'smtp.gmail.com';                    
                    $mail->SMTPAuth   = true;                                   
                    $mail->Username   = '';                  
                    $mail->Password   = '';                               
                    $mail->Port       = 587;       
                    $mail->SMTPSecure = 'tls';                  
                  
                    $mail->setFrom('from@example.com', 'Mailer');
                    $mail->addAddress($_GET['e']);     
                    
                    $mail->isHTML(true);                                 
                    $mail->Subject = 'OTP from Comic Station';
                    $mail->Body    = 'This is the OTP to verify your account.<br/> <b>OTP: '.$key. '</b>';
        
                    $mail->send();
                } catch (Exception $e) {
                    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                }
                break;
                
        case 'CheckKey':
            if ($_SESSION['key'] == $_GET['k']) {
                $e = $_SESSION['email'];
                $conn->query("INSERT INTO `emails` (`email`) VALUES ('{$e}')");
                echo '{"success": true}';

            } else {
                echo '{"success": false}';
            }
            break;

        default:
            echo "Wrong Option";
    }
}