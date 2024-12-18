<?php
// Include the Twilio PHP SDK
require_once '/path/to/vendor/autoload.php'; // Adjust the path to where the Twilio SDK is located
use Twilio\Rest\Client;

// Twilio credentials (replace with your actual credentials)
$sid = 'your_twilio_sid';  // Your Twilio SID
$token = 'your_twilio_token';  // Your Twilio Auth Token
$twilio_number = 'your_twilio_number';  // Your Twilio phone number (e.g., +1234567890)

header('Content-Type: application/json'); // Ensure the response is JSON

// Enable CORS
header('Access-Control-Allow-Origin: *'); // Allow all origins (use more restrictive settings in production)
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

// Check if the request is a POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the phone number and booking details from the POST request
    $userPhone = isset($_POST['phone']) ? $_POST['phone'] : '';
    $bookingDetails = isset($_POST['booking_details']) ? $_POST['booking_details'] : '';

    // Validate inputs
    if (empty($userPhone) || empty($bookingDetails)) {
        echo json_encode(['status' => 'error', 'message' => 'Missing required fields']);
        exit;
    }

    try {
        // Create a Twilio client
        $client = new Client($sid, $token);

        // Send the SMS
        $message = $client->messages->create(
            $userPhone, // Phone number to send to
            [
                'from' => $twilio_number, // Your Twilio phone number
                'body' => "New Booking Received: $bookingDetails" // Message body
            ]
        );

        // Return success response
        echo json_encode(['status' => 'success', 'message' => 'Notification Sent']);
    } catch (Exception $e) {
        // If there is an error, return the error message
        echo json_encode(['status' => 'error', 'message' => 'Failed to send SMS: ' . $e->getMessage()]);
    }
} else {
    // Return error if the request method is not POST
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}
?>
