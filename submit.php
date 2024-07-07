<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data and sanitize it
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $phone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_STRING);
    $formName = filter_input(INPUT_POST, 'formName', FILTER_SANITIZE_STRING);

    // Validate that email is a valid address
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Redirect to an error page or handle the error as needed
        header("Location: /error.html");
        exit;
    }

    // Send email to administrator
    $to = "info@tgcindia.com";  
    $subject = "New Form Submission: $formName";
    $headers = "From: info@tgcindia.com\r\n";
    $headers .= "Reply-To: info@tgcindia.com\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
    $headers .= "X-Mailer: PHP/" . phpversion();

    $message = "You have received a new form submission.\n\n";
    $message .= "Name: $name\nEmail: $email\nPhone: $phone\nForm Name: $formName";

    if (mail($to, $subject, $message, $headers)) {
        // Send confirmation email to the user
        sendConfirmationEmail($name, $email);
        // Redirect to the thank you page
        header("Location: https://www.tgcindia.com/thanks/");
        exit;
    } else {
        // Redirect to an error page or handle the error as needed
        header("Location: /error.html");
        exit;
    }
}

function sendConfirmationEmail($name, $email) {
    $to = $email;
    $subject = "Thank You for Your Submission";
    $headers = "From: info@tgcindia.com\r\nReply-To: info@tgcindia.com\r\nX-Mailer: PHP/" . phpversion();
    $message = "Dear $name,\n\nThank you for your interest. We have received your submission and will contact you shortly.\n\nBest regards,\nTGC India";

    mail($to, $subject, $message, $headers);
}
?>
