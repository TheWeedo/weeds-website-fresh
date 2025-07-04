<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST["name"]);
    $address = htmlspecialchars($_POST["address"]);
    $phone = htmlspecialchars($_POST["phone"]);
    $email = htmlspecialchars($_POST["email"]);
    $instructions = htmlspecialchars($_POST["instructions"]);
    $cart = htmlspecialchars($_POST["cart"]);

    $to = "info@wellnessbyweedo.com";
    $subject = "New Order from $name";

    $message = "You have received a new order from your website.\n\n";
    $message .= "Name: $name\n";
    $message .= "Address: $address\n";
    $message .= "Phone: $phone\n";
    $message .= "Email: $email\n";
    $message .= "Instructions: $instructions\n\n";
    $message .= "Order Summary:\n$cart\n";

    $headers = "From: $email\r\n";
    $headers .= "Reply-To: $email\r\n";

    mail($to, $subject, $message, $headers);

    // Redirect to thank you page
    header("Location: thank-you.html");
    exit();
} else {
    echo "There was a problem processing your order.";
}
?>