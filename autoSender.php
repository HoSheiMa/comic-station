<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
include 'configs.php';

require './lib/autoload.php';

$emails = $conn->query('SELECT * FROM `emails` WHERE 1');

while($email = $emails->fetch_object()){
        $e = $email->email;
        $r = rand(0, 2000);
        $url = "https://xkcd.com/" . $r . "/info.0.json";
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        $resp = curl_exec($curl);
        curl_close($curl);
        $resp = json_decode($resp);
        $mail = new PHPMailer(true);

        try {
            $key = rand(0, 9999);
            $mail->isSMTP();                                            
            $mail->Host       = 'smtp.gmail.com';                     
            $mail->SMTPAuth   = true;                                   
            $mail->Username   = '';                    
            $mail->Password   = '';                               
            $mail->Port       = 587;                        
            $mail->SMTPSecure = 'tls';                            

            $mail->setFrom('from@example.com', 'Mailer');
            $mail->addAddress($e);    
            
            $mail->isHTML(true);                                 
            $mail->Subject = 'Update from Comic Station';
            $title = $resp->title;
            $img = $resp->img;
            $alt= $resp->alt;
            $mail->Body    = '
            Hello '. $e.'. <br />
            We have an update from Comic Station, We would like to suggest you a new Comic to read.
            <div>
                <b>Comic Name: </b>'.$title.'                 
                <br />
                <b>Comic Details:</b> '.$alt.'
            </div> 
            <br />
            <img width="100%" src="' . $img . '"  alt=""/>   
            <br />
            <br/>
            To UnSubscribe , click on the button 
            <a href="http://localhost/unSubscribe.php?e='.$e.'" style="border: 0; background: #e50914; padding: 5px;color:#fff">Unsubscribe</a>
            ';
            
            $mail->send();
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
        break;
        }