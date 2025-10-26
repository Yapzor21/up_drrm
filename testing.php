<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Send SMS via PhilSMS</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f1f3f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background: white;
            padding: 20px 30px;
            border-radius: 12px;
            box-shadow: 0 3px 8px rgba(0,0,0,0.2);
            width: 400px;
        }
        h2 {
            text-align: center;
            color: #333;
        }
        label {
            font-weight: bold;
            margin-top: 10px;
            display: block;
        }
        input, textarea, button {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border-radius: 8px;
            border: 1px solid #ccc;
            font-size: 15px;
        }
        button {
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
            margin-top: 15px;
        }
        button:hover {
            background-color: #0056b3;
        }
        .response {
            margin-top: 15px;
            background: #e9ecef;
            padding: 10px;
            border-radius: 8px;
            font-size: 14px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Send SMS via PhilSMS</h2>
    <form method="POST">
        <label for="recipient">Recipient (e.g. +639171234567):</label>
        <input type="text" name="recipient" id="recipient" required>

        <label for="message">Message:</label>
        <textarea name="message" id="message" rows="4" required></textarea>

        <button type="submit" name="send">Send Message</button>
    </form>

    <?php
    if (isset($_POST['send'])) {
        $recipient = trim($_POST['recipient']);
        $message = trim($_POST['message']);

        // API data
        $send_data = [
            'sender_id' => 'PhilSMS',
            'recipient' => $recipient,
            'message' => $message
        ];

        $token = '3392|GZKHRdfziTh9KuMwqHqt3jNC9M5pSfLYndr4OzHk'; // Replace with your actual token

        $parameters = json_encode($send_data);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://app.philsms.com/api/v3/sms/send");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $parameters);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Content-Type: application/json",
            "Authorization: Bearer $token"
        ]);

        $response = curl_exec($ch);
        curl_close($ch);

        echo "<div class='response'><strong>API Response:</strong><br><pre>$response</pre></div>";
    }
    ?>
</div>

</body>
</html>
