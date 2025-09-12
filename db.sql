-- This SQL script provides the necessary table structures for the Digital Fuel Receipt Hub.
-- It is designed for a MySQL database.

--
-- Table structure for table `users`
--
-- This table stores information about registered users.
-- The 'role' column can be 'user' or 'admin'.
-- 'status' can be 'active' or 'inactive'.
--

CREATE TABLE `users` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `full_name` VARCHAR(100) NOT NULL,
  `email` VARCHAR(100) NOT NULL UNIQUE,
  `password_hash` VARCHAR(255) NOT NULL,
  `vehicle_no` VARCHAR(20) NOT NULL,
  `role` VARCHAR(10) NOT NULL DEFAULT 'user',
  `status` VARCHAR(10) NOT NULL DEFAULT 'active',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


--
-- Table structure for table `transactions`
--
-- This table logs every payment attempt, linking to a user.
-- 'status' can be 'success', 'failed', or 'pending'.
--

CREATE TABLE `transactions` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT NOT NULL,
  `amount` DECIMAL(10, 2) NOT NULL,
  `payment_mode` VARCHAR(50) NOT NULL,
  `status` VARCHAR(20) NOT NULL,
  `transaction_date` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


--
-- Table structure for table `receipts`
--
-- This table stores details for successful transactions, generating a unique receipt number.
--

CREATE TABLE `receipts` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `receipt_no` VARCHAR(50) NOT NULL UNIQUE,
  `transaction_id` INT NOT NULL,
  `user_id` INT NOT NULL,
  `fuel_type` VARCHAR(50),
  `receipt_date` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`transaction_id`) REFERENCES `transactions`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Sample data inserts (for testing)
--

-- Add an admin user (password should be hashed in a real application, e.g., 'admin123')
INSERT INTO `users` (`full_name`, `email`, `password_hash`, `vehicle_no`, `role`, `status`) VALUES
('Admin', 'admin@example.com', '$2y$10$...', 'N/A', 'admin', 'active');

-- Add a regular user (password should be hashed, e.g., 'user123')
INSERT INTO `users` (`full_name`, `email`, `password_hash`, `vehicle_no`, `role`, `status`) VALUES
('Rose', 'user@example.com', '$2y$10$...', 'TN-07-AB-1234', 'user', 'active');
