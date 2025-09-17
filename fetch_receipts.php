<?php
include 'db_connect.php';

$sql = "SELECT 
            r.receipt_no,
            u.name AS name,
            u.vehicle_no,
            r.fuel_type,
            r.receipt_date,
            t.amount,
            t.payment_mode,
            t.status
        FROM receipts r
        JOIN users u ON r.user_id = u.id
        JOIN transactions t ON r.transaction_id = t.id
        ORDER BY r.receipt_date DESC";

$result = $conn->query($sql);

if (!$result) {
    die("❌ SQL Error: " . $conn->error);
}

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $statusClass = ($row['status'] == "Success") 
                        ? "bg-green-100 text-green-800" 
                        : (($row['status'] == "Refunded") 
                            ? "bg-yellow-100 text-yellow-800" 
                            : "bg-red-100 text-red-800");

        echo "<tr>
                <td class='py-3 px-4 border-t border-gray-200'>{$row['receipt_no']}</td>
                <td class='py-3 px-4 border-t border-gray-200'>{$row['name']}</td>
                <td class='py-3 px-4 border-t border-gray-200'>{$row['vehicle_no']}</td>
                <td class='py-3 px-4 border-t border-gray-200'>{$row['receipt_date']}</td>
                <td class='py-3 px-4 border-t border-gray-200'>₹{$row['amount']}</td>
                <td class='py-3 px-4 border-t border-gray-200'>{$row['payment_mode']}</td>
                <td class='py-3 px-4 border-t border-gray-200'>
                    <span class='px-2 py-1 text-xs rounded-full $statusClass'>{$row['status']}</span>
                </td>
            </tr>";
    }
} else {
    echo "<tr><td colspan='7' class='text-center py-4 text-gray-500'>No receipts found</td></tr>";
}
?>
