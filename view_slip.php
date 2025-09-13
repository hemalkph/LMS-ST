<?php
// 1. Include necessary files and perform security checks
require_once __DIR__ . '/auth_check.php';
require_once __DIR__ . '/../config.php';

// 2. Get and Validate the Payment ID from the URL
$payment_id = $_GET['id'] ?? null;
if (!$payment_id || !is_numeric($payment_id)) {
    die("Error: Invalid Payment ID provided.");
}

// 3. Fetch the image URL from the database
try {
    $stmt = $pdo->prepare("SELECT slip_image_url FROM payments WHERE id = :id");
    $stmt->execute([':id' => $payment_id]);
    $payment = $stmt->fetch();

    if (!$payment || empty($payment['slip_image_url'])) {
        die("Error: Payment slip not found or no image was uploaded for this payment.");
    }
    // The path stored in the DB is relative to the student pages, so it should work directly
    $image_url = $payment['slip_image_url'];

} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Payment Slip</title>
    <style>
        body { 
            margin: 0; 
            background: #f0f2f5; 
            font-family: sans-serif; 
            display: flex; 
            flex-direction: column; 
            align-items: center; 
            justify-content: center;
            min-height: 100vh;
            padding: 20px;
            box-sizing: border-box;
        }
        .container { 
            max-width: 800px; 
            width: 100%;
            background: white; 
            padding: 20px; 
            border-radius: 8px; 
            box-shadow: 0 2px 10px rgba(0,0,0,0.1); 
        }
        img { 
            max-width: 100%; 
            display: block; 
            margin: 0 auto;
        }
        .close-link { 
            display: inline-block; 
            margin-top: 20px; 
            padding: 10px 20px;
            background-color: #4f46e5;
            color: white;
            text-decoration: none; 
            border-radius: 6px;
        }
    </style>
</head>
<body>
    <div class="container">
        <img src="<?= htmlspecialchars($image_url) ?>" alt="Payment Slip Image">
    </div>
    <a href="javascript:window.close();" class="close-link">Close Window</a>
</body>
</html>