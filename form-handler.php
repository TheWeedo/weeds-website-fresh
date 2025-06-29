
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $honeypot = $_POST["website"];
    if (!empty($honeypot)) {
        echo "Spam detected.";
        exit;
    }

    $name = strip_tags(trim($_POST["name"]));
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $message = trim($_POST["message"]);

    if (empty($name) || !filter_var($email, FILTER_VALIDATE_EMAIL) || empty($message)) {
        http_response_code(400);
        echo "Invalid input.";
        exit;
    }

    $recipient = "info@wellnessbyweedo.com";
    $subject = "New Contact Form Submission";
    $email_content = "Name: $name\n";
    $email_content .= "Email: $email\n\n";
    $email_content .= "Message:\n$message\n";

    $headers = "From: $name <$email>";

    if (mail($recipient, $subject, $email_content, $headers)) {
        http_response_code(200);
        echo "Message sent successfully.";
    } else {
        http_response_code(500);
        echo "Failed to send email.";
    }
} else {
    http_response_code(403);
    echo "Invalid request.";
}
?>
