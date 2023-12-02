-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
-- Admin login: admin@gmail.com
-- Admin Password: 2002

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gym_codecampbd`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `AddUserProcedure` (IN `p_fname` VARCHAR(45), IN `p_lname` VARCHAR(45), IN `p_email` VARCHAR(45), IN `p_mobile` VARCHAR(45), IN `p_password` VARCHAR(100), IN `p_state` VARCHAR(45), IN `p_city` VARCHAR(45), IN `p_address` VARCHAR(200))   BEGIN
    INSERT INTO tbluser (fname, lname, email, mobile, password, state, city, address, create_date)
    VALUES (p_fname, p_lname, p_email, p_mobile, p_password, p_state, p_city, p_address, CURRENT_TIMESTAMP());
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `GetBookingDetails` (IN `ids` INT, OUT `payments` INT(30))   SELECT payment INTO payments 
FROM tblpayment
WHERE paymentId=ids$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `GetTotalPayments` (IN `p_user_id` INT)   BEGIN
    SELECT u.fname, u.lname, SUM(p.payment) AS total_payments
    FROM tbluser u
    JOIN tblbooking b ON u.id = b.userid
    JOIN tblpayment p ON b.id = p.bookingID
    WHERE u.id = p_user_id;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `deleted_users`
--

CREATE TABLE `deleted_users` (
  `id` int(11) NOT NULL,
  `fname` varchar(255) DEFAULT NULL,
  `lname` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `mobile` varchar(255) DEFAULT NULL,
  `PASSWORD` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `deleted_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `deleted_users`
--

INSERT INTO `deleted_users` (`id`, `fname`, `lname`, `email`, `mobile`, `PASSWORD`, `state`, `city`, `address`, `deleted_at`) VALUES
(2, 'ddd', 'ddf', 'df@gmail.com', '9968556', 'e10adc3949ba59abbe56e057f20f883e', 'fgfg', 'fsdf', NULL, '2023-11-13 13:09:36'),
(5, 'Anuj k', 'kumar', 'anuj.doca@Gmail.com', '1234567890', '202cb962ac59075b964b07152d234b70', 'sghsdg', 'sahgsh', NULL, '2023-11-13 06:47:56');

-- --------------------------------------------------------

--
-- Table structure for table `email_queue`
--

CREATE TABLE `email_queue` (
  `email_id` int(11) NOT NULL,
  `recipient` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `body` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `email_queue`
--

INSERT INTO `email_queue` (`email_id`, `recipient`, `subject`, `body`, `created_at`) VALUES
(6, 'terdalomkar@gmail.com', 'WELCOME TO OUR GYM', 'DEAR terdalomkar@gmail.com,\n\nWELCOME TO OUR GYM! WE ARE EXCITED TO HAVE YOU AS A MEMBER.', '2023-11-13 05:49:25'),
(7, 'omkarte@gmail.com', 'WELCOME TO OUR GYM', 'DEAR omkarte@gmail.com,\n\nWELCOME TO OUR GYM! WE ARE EXCITED TO HAVE YOU AS A MEMBER.', '2023-11-13 16:29:39'),
(8, 'omkarterdal@gmail.com', 'WELCOME TO OUR GYM', 'DEAR omkarterdal@gmail.com,\n\nWELCOME TO OUR GYM! WE ARE EXCITED TO HAVE YOU AS A MEMBER.', '2023-11-13 18:46:10');

-- --------------------------------------------------------

--
-- Table structure for table `tbladdpackage`
--

CREATE TABLE `tbladdpackage` (
  `id` int(11) NOT NULL,
  `category` varchar(45) DEFAULT NULL,
  `titlename` varchar(450) DEFAULT NULL,
  `PackageType` varchar(45) DEFAULT NULL,
  `PackageDuratiobn` varchar(45) DEFAULT NULL,
  `Price` varchar(45) DEFAULT NULL,
  `uploadphoto` varchar(450) DEFAULT NULL,
  `Description` varchar(450) DEFAULT NULL,
  `create_date` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbladdpackage`
--

INSERT INTO `tbladdpackage` (`id`, `category`, `titlename`, `PackageType`, `PackageDuratiobn`, `Price`, `uploadphoto`, `Description`, `create_date`) VALUES
(1, '1', 'Free Fitness Gear Package', '1', '3 Month', '600', NULL, 'Free Fitness Gear\nComplimentary OnePass', '2022-03-05 02:55:34'),
(2, '1', '3 Months Membership Package', '1', '6 Month', '800', NULL, 'Book Six Days Different Trainers Class designed for fast Weight Loss', '2022-03-05 02:56:44'),
(3, '1', 'hgfhfgdfgdf', '1', '4 Month', '12000', NULL, 'hfdgfhfgh<div><br></div><div>fdgdfg</div>', '2022-05-22 02:34:08');

-- --------------------------------------------------------

--
-- Table structure for table `tbladmin`
--

CREATE TABLE `tbladmin` (
  `id` int(11) NOT NULL,
  `name` varchar(45) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `mobile` varchar(45) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `create_date` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbladmin`
--

INSERT INTO `tbladmin` (`id`, `name`, `email`, `mobile`, `password`, `create_date`) VALUES
(1, 'omkar', 'admin@gmail.com', '01608445456', '4ba29b9f9e5732ed33761840f4ba6c53', '2022-01-19 11:25:17');

-- --------------------------------------------------------

--
-- Table structure for table `tblbooking`
--

CREATE TABLE `tblbooking` (
  `id` int(11) NOT NULL,
  `package_id` varchar(45) DEFAULT NULL,
  `userid` varchar(45) DEFAULT NULL,
  `booking_date` timestamp NULL DEFAULT current_timestamp(),
  `payment` varchar(45) DEFAULT NULL,
  `paymentType` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tblbooking`
--

INSERT INTO `tblbooking` (`id`, `package_id`, `userid`, `booking_date`, `payment`, `paymentType`) VALUES
(1, '2', '1', '2022-03-05 03:53:21', '800', ''),
(2, '1', '1', '2022-03-05 03:53:28', '600', 'Partial Payment'),
(3, '2', '5', '2022-03-08 17:44:18', '300', 'Full Payment'),
(6, '1', '5', '2022-05-22 02:16:14', NULL, NULL),
(7, '2', '6', '2022-05-22 02:32:45', NULL, 'Full Payment'),
(8, '1', '7', '2023-10-07 09:56:35', NULL, 'Full Payment'),
(9, '1', '8', '2023-11-12 11:31:23', NULL, NULL),
(10, '2', '830', '2023-11-13 15:45:37', NULL, 'Full Payment'),
(11, '1', '830', '2023-11-14 11:18:36', NULL, NULL),
(12, '3', '830', '2023-11-14 11:19:05', NULL, NULL),
(13, '1', '830', '2023-11-14 14:40:08', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tblcategory`
--

CREATE TABLE `tblcategory` (
  `id` int(11) NOT NULL,
  `category_name` varchar(45) DEFAULT NULL,
  `status` varchar(45) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tblcategory`
--

INSERT INTO `tblcategory` (`id`, `category_name`, `status`) VALUES
(1, 'Category1', '0'),
(2, 'Category2', '0'),
(6, '3', '0'),
(7, '1', '0');

-- --------------------------------------------------------

--
-- Table structure for table `tblpackage`
--

CREATE TABLE `tblpackage` (
  `id` int(11) NOT NULL,
  `cate_id` varchar(45) DEFAULT NULL,
  `PackageName` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tblpackage`
--

INSERT INTO `tblpackage` (`id`, `cate_id`, `PackageName`) VALUES
(1, '1', 'fdgdfg'),
(3, '2', 'Package2'),
(5, '1', '');

-- --------------------------------------------------------

--
-- Table structure for table `tblpayment`
--

CREATE TABLE `tblpayment` (
  `paymentId` int(11) NOT NULL,
  `bookingID` varchar(45) DEFAULT NULL,
  `paymentType` varchar(45) DEFAULT NULL,
  `payment` varchar(45) DEFAULT NULL,
  `payment_date` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tblpayment`
--

INSERT INTO `tblpayment` (`paymentId`, `bookingID`, `paymentType`, `payment`, `payment_date`) VALUES
(1, '1', 'Partial Payment', '300', '2022-03-05 03:54:10'),
(4, '1', 'Full Payment', '500', '2022-05-22 01:01:58'),
(5, '3', 'Partial Payment', '300', '2022-05-22 01:09:53'),
(8, '3', 'Full Payment', '500', '2022-05-22 01:19:03'),
(9, '7', 'Partial Payment', '500', '2022-05-22 02:40:34'),
(10, '7', 'Full Payment', '300', '2022-05-22 02:41:14'),
(11, '8', 'Partial Payment', '200', '2023-10-07 10:20:42'),
(12, '8', 'Full Payment', '400', '2023-10-07 10:20:57'),
(13, '2', 'Partial Payment', '300', '2023-11-13 05:52:53'),
(14, '10', 'Partial Payment', '500', '2023-11-13 15:47:00'),
(15, '10', 'Full Payment', '300', '2023-11-13 15:47:15'),
(16, '1', '', '', '2023-11-13 15:50:12');

-- --------------------------------------------------------

--
-- Table structure for table `tbluser`
--

CREATE TABLE `tbluser` (
  `id` int(11) NOT NULL,
  `fname` varchar(45) DEFAULT NULL,
  `lname` varchar(45) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `mobile` varchar(45) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `state` varchar(45) DEFAULT NULL,
  `city` varchar(45) DEFAULT NULL,
  `address` varchar(200) DEFAULT NULL,
  `create_date` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbluser`
--

INSERT INTO `tbluser` (`id`, `fname`, `lname`, `email`, `mobile`, `password`, `state`, `city`, `address`, `create_date`) VALUES
(1, 'atul', 'kumar', 'atul@gmail.com', '8888888888', 'f925916e2754e5e03f75dd58a5733251', 'Uttar Pradesh', 'niuda', 'e-48 new asholk nagar hdd ', '2022-02-16 16:48:25'),
(3, 'anuj', 'kumar', 'anuj@gmail.com', '9999999999', 'f925916e2754e5e03f75dd58a5733251', 'up', 'noida', NULL, '2022-03-02 15:37:22'),
(4, 'sssssss', 'sssssss', 'sssssss', 'sssssss', 'f925916e2754e5e03f75dd58a5733251', 'sssssss', 'sssssss', NULL, '2022-03-05 03:27:28'),
(830, 'harish', 'mal', 'terdalomkar@gmail.com', '8974047039', '4ba29b9f9e5732ed33761840f4ba6c53', 'karna', 'bel', 'belagavi', '2023-11-13 05:49:25'),
(831, 'omkar', 'terdal', 'omkarte@gmail.com', '094004400290', '2002', 'kar', 'belafa', 'hindalfa', '2023-11-13 16:29:39'),
(832, 'om', 'tee', 'omkarterdal@gmail.com', '9704270492', '202cb962ac59075b964b07152d234b70', 'karunadu', 'belagavi', NULL, '2023-11-13 18:46:10');




--
-- Table structure for table `tbltrainers`
--
CREATE TABLE tbltrainers (
    id INT PRIMARY KEY AUTO_INCREMENT,
    trainer_name VARCHAR(100) NOT NULL,
    contact_number VARCHAR(20),
    email VARCHAR(255),
    address TEXT
);
--
-- Dumping data for table `tbltrainers`
--
INSERT INTO tbltrainers (trainer_name, contact_number, email, address) VALUES
('John Doe', '123-456-7890', 'john.doe@example.com', '123 Main Street, Cityville'),
('Jane Smith', '987-654-3210', 'jane.smith@example.com', '456 Oak Avenue, Townsville'),
('Bob Johnson', '555-123-4567', 'bob.johnson@example.com', '789 Pine Lane, Villagetown'),
('Alice Brown', '222-333-4444', 'alice.brown@example.com', '321 Cedar Road, Hamletville'),
('Charlie Davis', '999-888-7777', 'charlie.davis@example.com', '654 Elm Street, Boroughburg');



--
-- Triggers `tbluser`
--
DELIMITER $$
CREATE TRIGGER `delete_member` AFTER DELETE ON `tbluser` FOR EACH ROW INSERT INTO deleted_users (id, fname, lname,email,mobile,PASSWORD,state,city,address,deleted_at)
    VALUES (OLD.id, OLD.fname,OLD.lname, OLD.email,OLD.mobile,OLD.password,OLD.state,OLD.city,OLD. address,CURRENT_TIMESTAMP)
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `new_member` AFTER INSERT ON `tbluser` FOR EACH ROW INSERT INTO email_queue(recipient,subject,body) VALUES(NEW.email, 'WELCOME TO OUR GYM', CONCAT('DEAR ', NEW.email, ',\n\nWELCOME TO OUR GYM! WE ARE EXCITED TO HAVE YOU AS A MEMBER.'))
$$
DELIMITER ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `deleted_users`
--
ALTER TABLE `deleted_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `email_queue`
--
ALTER TABLE `email_queue`
  ADD PRIMARY KEY (`email_id`);

--
-- Indexes for table `tbladdpackage`
--
ALTER TABLE `tbladdpackage`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbladmin`
--
ALTER TABLE `tbladmin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblbooking`
--
ALTER TABLE `tblbooking`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblcategory`
--
ALTER TABLE `tblcategory`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblpackage`
--
ALTER TABLE `tblpackage`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblpayment`
--
ALTER TABLE `tblpayment`
  ADD PRIMARY KEY (`paymentId`);

--
-- Indexes for table `tbluser`
--
ALTER TABLE `tbluser`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `email_queue`
--
ALTER TABLE `email_queue`
  MODIFY `email_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tbladdpackage`
--
ALTER TABLE `tbladdpackage`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbladmin`
--
ALTER TABLE `tbladmin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tblbooking`
--
ALTER TABLE `tblbooking`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `tblcategory`
--
ALTER TABLE `tblcategory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tblpackage`
--
ALTER TABLE `tblpackage`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tblpayment`
--
ALTER TABLE `tblpayment`
  MODIFY `paymentId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `tbluser`
--
ALTER TABLE `tbluser`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=833;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
