<?php
// Replace these credentials with your email server settings
$server = 'mail.pohpunpanyafoundation.org';
$username = 'admin@pohpunpanyafoundation.org';
$password = '!@dminF!5c0j7f8';

// Connect to the POP3 server
$inbox = imap_open($server, $username, $password);

if (!$inbox) {
    die('Failed to connect to the POP3 server: ' . imap_last_error());
}

// Get the total number of emails in the INBOX
$total_emails = imap_num_msg($inbox);

// Loop through each email
for ($i = 1; $i <= $total_emails; $i++) {
    // Fetch the email header
    $header = imap_headerinfo($inbox, $i);

    // Get the sender and subject of the email
    $sender = $header->from[0]->mailbox . "@" . $header->from[0]->host;
    $subject = $header->subject;

    // Print the sender and subject of the email
    echo "Email #$i: From: $sender - Subject: $subject" . PHP_EOL;
    
    // Fetch the email body (plain text part only)
    $body = imap_fetchbody($inbox, $i, 1.1);
    
    // Print the email body
    echo "Body: $body" . PHP_EOL . PHP_EOL;
}

// Close the connection to the POP3 server
imap_close($inbox);
?>