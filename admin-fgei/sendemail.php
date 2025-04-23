<?php
include('../connection/conn.php');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Batch size and delay
$batch_size = 100; // Number of emails to send per batch
$delay = 60; // Delay in seconds between batches

// SQL query to fetch email addresses
$sql = "SELECT email FROM emails";
$result = $conn->query($sql);

// Check if there are any records
if ($result->num_rows > 0) {
    $emails = [];
    while ($row = $result->fetch_assoc()) {
        $emails[] = $row['email'];
    }

    // Send emails in batches
    for ($i = 0; $i < count($emails); $i += $batch_size) {
        $batch = array_slice($emails, $i, $batch_size);
        foreach ($batch as $to) {
            $subject = "this is check email";
            $message = "hello this is check email, how are you";
            $headers = "From: Your Name <reginductionfgei@induction-reg.fgei-cg.gov.pk>\r\n";
            $headers .= "Reply-To: reginductionfgei@induction-reg.fgei-cg.gov.pk\r\n"; // Optional, for replies
            $headers .= "Content-Type: text/html; charset=UTF-8\r\n"; // Optional, if sending HTML email

            // Send email
            if (mail($to, $subject, $message, $headers)) {
                echo "Email sent to: " . $to . "<br>";
            } else {
                echo "Failed to send email to: " . $to . "<br>";
            }
        }

        // Delay between batches
        sleep($delay);
    }
} else {
    echo "No participants found.";
}

$conn->close();
?>
