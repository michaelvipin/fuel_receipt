<?php
include 'db_connect.php';

$sql = "SELECT 
            t.id AS txn_id,
            t.transaction_date,
            u.name AS name,
            t.amount,
            t.status
        FROM transactions t
        JOIN users u ON t.user_id = u.id
        ORDER BY t.transaction_date DESC";

$result = $conn->query($sql);

if (!$result) {
    die("❌ SQL Error: " . $conn->error);
}

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $statusClass = ($row['status'] == "Success") 
                        ? "bg-green-100 text-green-800" 
                        : (($row['status'] == "Failed") 
                            ? "bg-red-100 text-red-800" 
                            : "bg-yellow-100 text-yellow-800");

        echo "<tr>
                <td class='py-3 px-4 border-t border-gray-200'>{$row['txn_id']}</td>
                <td class='py-3 px-4 border-t border-gray-200'>{$row['transaction_date']}</td>
                <td class='py-3 px-4 border-t border-gray-200'>{$row['name']}</td>
                <td class='py-3 px-4 border-t border-gray-200'>₹{$row['amount']}</td>
                <td class='py-3 px-4 border-t border-gray-200'>
                    <span class='px-2 py-1 text-xs rounded-full $statusClass'>{$row['status']}</span>
                </td>
            </tr>";
    }
} else {
    echo "<tr><td colspan='5' class='text-center py-4 text-gray-500'>No transactions found</td></tr>";
}
?>
