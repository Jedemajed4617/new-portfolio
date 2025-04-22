<?php

if (isset($_GET['type'])) {
    $type = $_GET['type'];
    switch ($type) {
        case 'mailto':
            MailToAdmin();
            break;
        default:
            echo "Invalid type specified.";
            break;
    }
} else{
    echo "No type specified.";
}

function MailToAdmin(){
    $message = $_POST['message'];
    $name = $_POST['name'];
    $email = $_POST['email'];

    $to = "tygoiedema@gmail.com"; // Enter your own email address here
    $subject = "Een klant neemt contact op via de website";
    $headers = "From: $name <$email>\r\n";
    $headers .= "Reply-To: $name <$email>\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

    $message = "Naam: $name\n";
    $message .= "Email: $email\n";
    $message .= "Bericht: $message\n";
    $message .= "Verzonden op: " . date("Y-m-d H:i:s") . "\n";
    $message .= "User agent: " . $_SERVER['HTTP_USER_AGENT'] . "\n";
    $message .= "Verzonden via: " . $_SERVER['HTTP_REFERER'] . "\n";
    $message .= "------------------------\n";
    $message .= "Dit is een automatisch gegenereerd bericht. Gelieve niet te antwoorden.\n";
    $message .= "------------------------\n";

    if (empty($message) || empty($name) || empty($email) || empty($to) ) {
        echo "Alle velden moeten ingevuld zijn.";
        return;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Email is onjuist!";
        return;
    }

    if (mail($to, $subject, $message, $headers)) {
        echo "Bericht succesvol verzonden!";
        return;
    } else {
        echo "Er is een fout opgetreden bij het verzenden van het bericht.";
        return;
    }

}