<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

// CORS headers to allow requests from different origins
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the phone number and booking details from the form
    $userPhone = $_POST['phone'];
    $bookingDetails = $_POST['booking_details'];

    // Prepare email details
    $to = "your-email@example.com"; // Replace with your email address
    $subject = "New Booking Request";
    $message = "
    <html>
    <head>
        <title>New Booking</title>
    </head>
    <body>
        <p>You have received a new booking request:</p>
        <p><strong>Booking Details:</strong></p>
        <p>$bookingDetails</p>
        <p><strong>User's Phone Number:</strong> $userPhone</p>
    </body>
    </html>
    ";

    // Set content-type header for HTML email
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

    // Add additional headers
    $headers .= "From: no-reply@yourwebsite.com" . "\r\n"; // Replace with your website's domain

    // Send email
    if (mail($to, $subject, $message, $headers)) {
        echo json_encode(['status' => 'success', 'message' => 'Booking details sent via email']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to send email']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}
?>
