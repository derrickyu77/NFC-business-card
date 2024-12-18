<?php
require_once '/path/to/vendor/autoload.php'; // Twilio's SDK path
use Twilio\Rest\Client;

// Twilio credentials
$sid = 'your_twilio_sid';
$token = 'your_twilio_token';
$twilio_number = 'your_twilio_number';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the phone number and booking details
    $userPhone = $_POST['phone'];
    $bookingDetails = $_POST['booking_details'];

    // Create a Twilio client
    $client = new Client($sid, $token);

    // Send SMS
    $message = $client->messages->create(
        $userPhone, // Phone number to send to
        [
            'from' => $twilio_number, // Your Twilio phone number
            'body' => "New Booking Received: $bookingDetails"
        ]
    );

    // Respond back with a success message
    echo json_encode(['status' => 'success', 'message' => 'Notification Sent']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}
?>
