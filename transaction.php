<?php
require 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id      = $_POST['user_id'];
    $amount       = $_POST['amount'];
    $payment_mode = $_POST['payment_mode'];
    $status       = $_POST['status'] ?? 'Success';   // default Success
    $fuel_type    = $_POST['fuel_type'];

    // Insert into transactions
    $stmt = $conn->prepare("
        INSERT INTO transactions (user_id, amount, payment_mode, status) 
        VALUES (?, ?, ?, ?)
    ");
    $stmt->bind_param("idss", $user_id, $amount, $payment_mode, $status);

    if ($stmt->execute()) {
        $transaction_id = $stmt->insert_id;

        // Generate unique receipt no
        $receipt_no = "RCPT-" . time() . "-" . $transaction_id;

        // Insert into receipts
        $stmt2 = $conn->prepare("
            INSERT INTO receipts (receipt_no, transaction_id, user_id, fuel_type) 
            VALUES (?, ?, ?, ?)
        ");
        $stmt2->bind_param("siis", $receipt_no, $transaction_id, $user_id, $fuel_type);

        if ($stmt2->execute()) {
            echo "✅ Transaction and Receipt saved! <br>Receipt No: " . $receipt_no;
        } else {
            echo "❌ Receipt Error: " . $stmt2->error;
        }

    } else {
        echo "❌ Transaction Error: " . $stmt->error;
    }
}
?>
