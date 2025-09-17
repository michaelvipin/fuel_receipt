<?php
include 'db_connect.php';

$sql = "SELECT 
            id,
            name,
            email,
            created_at
        FROM users
        ORDER BY created_at DESC";

$result = $conn->query($sql);

if (!$result) {
    die("❌ SQL Error: " . $conn->error);
}

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td class='py-3 px-4 border-t border-gray-200'>{$row['id']}</td>
                <td class='py-3 px-4 border-t border-gray-200'>{$row['name']}</td>
                <td class='py-3 px-4 border-t border-gray-200'>{$row['email']}</td>
                <td class='py-3 px-4 border-t border-gray-200'>{$row['created_at']}</td>
            </tr>";
    }
} else {
    echo "<tr><td colspan='4' class='text-center py-4 text-gray-500'>No users found</td></tr>";
}
?>
