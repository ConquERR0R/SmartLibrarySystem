-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 13, 2025 at 01:26 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `project`
--

-- --------------------------------------------------------

--
-- Table structure for table `add_book`
--

CREATE TABLE `add_book` (
  `id` int(10) NOT NULL,
  `books_name` varchar(50) NOT NULL,
  `books_image` varchar(5000) NOT NULL,
  `books_author_name` varchar(50) NOT NULL,
  `genre` varchar(100) DEFAULT NULL,
  `books_publication_name` varchar(50) NOT NULL,
  `books_purchase_date` varchar(20) NOT NULL,
  `books_price` varchar(10) NOT NULL,
  `books_quantity` varchar(20) NOT NULL,
  `books_availability` varchar(20) NOT NULL,
  `librarian_username` varchar(20) NOT NULL,
  `books_file` varchar(5000) NOT NULL,
  `status` enum('active','archived') DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `add_book`
--

INSERT INTO `add_book` (`id`, `books_name`, `books_image`, `books_author_name`, `genre`, `books_publication_name`, `books_purchase_date`, `books_price`, `books_quantity`, `books_availability`, `librarian_username`, `books_file`, `status`) VALUES
(1, 'Theoretical Numerical Analysis', 'books-image/5ebaa3080bb0327177a67d697223498a41GxQsLNarL._SX328_BO1,204,203,200_.jpg', 'Kendall Atkinson', NULL, 'Dover Publications', '15/03/19', '420', '11', '10', 'pompously', 'books-file/nalrs.pdf', 'active'),
(2, 'Health Informatics', 'books-image/9749fdc83fefbcc9cf3a55b16c7a353041SZngIJfuL._SX389_BO1,204,203,200_.jpg', 'Nancy Staggers', NULL, 'Elsevier Mosby', '12/03/19', '480', '16', '17', 'pompously', 'books-file/Contents and Front Matter.pdf', 'active'),
(3, 'Digital Image Processing', 'books-image/f5546d1614746fed61c4162163d81a59196018.jpg', 'Rafael C. Gonzalez', NULL, 'Prentice Hall', '20/03/19', '500', '21', '23', 'pompously', 'books-file/IT6005-SCAD-MSM-by www.LearnEngineering.in.pdf', 'archived'),
(6, 'Artificial Intelligence', 'books-image/17385102edb4831bab1b8b0577389d5e0133001989.jpg', ' Peter Norvig', NULL, 'Dover Publications', '25/03/19', '420', '5', '9', 'admin', 'books-file/17385102edb4831bab1b8b0577389d5eArtificial Intelligence.pdf', 'archived'),
(7, 'Parallel and Distributed Processing', 'books-image/1554233254.jpg', 'Jose Rolim', NULL, 'Elsevier Science', '02/0419', '350', '11', '10', 'admin', 'books-file/1554233331.pdf', 'active'),
(8, 'The Guest Book: A Novel', 'books-image/1568430614.jpg', 'test', NULL, 'test', '10/5/19', '200', '10', '11', 'admin', 'books-file/1568430614.pdf', 'active'),
(9, 'Brave New World', 'books-image/brave.png', 'Aldous Huxley', 'Fiction', '', '', '', '5', '9', 'admin', 'books-file/brave.pdf', 'active'),
(10, 'The Sign of the Four', 'books-image/conandoyle.png', 'Arthur Conan Doyle', 'Mystery', '', '', '', '5', 'available', 'admin', 'books-file/conandoyle.pdf', 'active'),
(11, 'Dracula', 'books-image/dracula.png', 'Bram Stoker', 'Horror', '', '', '', '5', '1', 'admin', 'books-file/dracula.pdf', 'active'),
(12, 'Frankenstein', 'books-image/franken.png', 'Mary Shelley', 'Horror', '', '', '', '5', '3', 'admin', 'books-file/franken.pdf', 'active'),
(13, 'Game of Thrones', 'books-image/games.png', 'George R.R. Martin', 'Fantasy', '', '', '', '5', '1', 'admin', 'books-file/games.pdf', 'active'),
(14, 'HTML, CSS & JavaScript', 'books-image/hcj.png', 'Unknown', 'Educational', '', '', '', '5', '2', 'admin', 'books-file/hcj.pdf', 'active'),
(15, 'Head First Java', 'books-image/java.png', 'Kathy Sierra', 'Programming', '', '', '', '5', '3', 'admin', 'books-file/java.pdf', 'active'),
(16, 'Pride and Prejudice', 'books-image/pnp.png', 'Jane Austen', 'Romance', '', '', '', '5', '1', 'admin', 'books-file/pnp.pdf', 'active'),
(17, 'The Lord of the Rings', 'books-image/ring.png', 'J.R.R. Tolkien', 'Fantasy', '', '', '', '5', '2', 'admin', 'books-file/ring.pdf', 'active'),
(18, 'Romeo and Juliet', 'books-image/rnj.png', 'William Shakespeare', 'Drama', '', '', '', '5', '1', 'admin', 'books-file/rnj.pdf', 'active'),
(19, 'The Adventures of Sherlock Holmes', 'books-image/sherlock.png', 'Arthur Conan Doyle', 'Mystery', '', '', '', '5', '1', 'admin', 'books-file/sherlock.pdf', 'active'),
(20, 'Sense and Sensibility', 'books-image/sns.png', 'Jane Austen', 'Drama', '', '', '', '5', '1', 'admin', 'books-file/sns.pdf', 'active'),
(21, 'The Cask of Amontillado', 'books-image/tca.png', 'Edgar Allan Poe', 'Classic', '', '', '', '5', '1', 'admin', 'books-file/tca.pdf', 'active'),
(22, 'The Time Machine', 'books-image/tm.png', 'H.G. Wells', 'Sci-Fi', '', '', '', '5', '2', 'admin', 'books-file/tm.pdf', 'active'),
(23, 'The Woman in Black', 'books-image/womaninblack.png', 'Susan Hill', 'Horror', '', '', '', '5', '2', 'admin', 'books-file/womaninblack.pdf', 'active'),
(24, 'The Mystery of the Yellow Room', 'books-image/yelloroom.png', 'Gaston Leroux', 'Mystery', '', '', '', '5', 'available', 'admin', 'books-file/yelloroom.pdf', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `book_reservation`
--

CREATE TABLE `book_reservation` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `book_id` int(11) NOT NULL,
  `book_name` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `book_reservation`
--

INSERT INTO `book_reservation` (`id`, `username`, `book_id`, `book_name`, `date`, `status`) VALUES
(1, 'davictor', 6, 'Artificial Intelligence', '2025-12-12', 'active'),
(2, '$user', 0, '$bookName', '2025-12-12', 'declined'),
(3, '$user', 0, '$bookName', '2025-12-12', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `borrow_records`
--

CREATE TABLE `borrow_records` (
  `id` int(10) NOT NULL,
  `username` varchar(50) NOT NULL,
  `user_type` varchar(20) NOT NULL,
  `book_id` int(10) NOT NULL,
  `borrow_date` date NOT NULL,
  `due_date` date NOT NULL,
  `return_date` date DEFAULT NULL,
  `status` varchar(20) NOT NULL,
  `penalty` decimal(10,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `clearances`
--

CREATE TABLE `clearances` (
  `id` int(10) NOT NULL,
  `username` varchar(50) NOT NULL,
  `user_type` varchar(20) NOT NULL,
  `semester` varchar(20) NOT NULL,
  `cleared` tinyint(1) NOT NULL DEFAULT 0,
  `cleared_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `finezone`
--

CREATE TABLE `finezone` (
  `id` int(10) NOT NULL,
  `username` varchar(50) NOT NULL,
  `utype` varchar(10) NOT NULL,
  `email` varchar(50) NOT NULL,
  `booksname` varchar(50) NOT NULL,
  `fine` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `finezone`
--

INSERT INTO `finezone` (`id`, `username`, `utype`, `email`, `booksname`, `fine`) VALUES
(31, 'Neuton', 'student', 'neuton@gmail.com', 'Combinatorics and Graph Theory', '50'),
(32, 'Xerxis', 'student', 'xerxis@gmail.com', 'Digital Image Processing', '50'),
(33, 'Chyra', 'student', 'chyra@gmail.com', 'Artificial Intelligence', '50');

-- --------------------------------------------------------

--
-- Table structure for table `genres`
--

CREATE TABLE `genres` (
  `id` int(11) NOT NULL,
  `genre_name` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `genres`
--

INSERT INTO `genres` (`id`, `genre_name`) VALUES
(1, 'Fiction'),
(2, 'Non-Fiction'),
(3, 'Science'),
(4, 'Engineering'),
(5, 'Mathematics'),
(6, 'Technology'),
(7, 'History'),
(8, 'Programming'),
(9, 'Novel'),
(10, 'Educational'),
(11, 'Medical'),
(12, 'Philosophy');

-- --------------------------------------------------------

--
-- Table structure for table `issue_book`
--

CREATE TABLE `issue_book` (
  `id` int(10) NOT NULL,
  `utype` varchar(10) NOT NULL,
  `regno` varchar(20) NOT NULL,
  `name` varchar(50) NOT NULL,
  `sem` varchar(10) NOT NULL,
  `session` varchar(10) NOT NULL,
  `dept` varchar(10) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `email` varchar(20) NOT NULL,
  `booksname` varchar(50) NOT NULL,
  `booksissuedate` varchar(10) NOT NULL,
  `booksreturndate` varchar(10) NOT NULL,
  `status` enum('Borrowed','Returned','Pending Return','Lost','Damaged') NOT NULL DEFAULT 'Borrowed',
  `return_type` enum('Normal','Damaged','Lost') DEFAULT NULL,
  `actual_return_date` date DEFAULT NULL,
  `fine` decimal(10,2) DEFAULT 0.00,
  `overdue_days` int(11) DEFAULT 0,
  `username` varchar(20) NOT NULL,
  `book_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `issue_book`
--

INSERT INTO `issue_book` (`id`, `utype`, `regno`, `name`, `sem`, `session`, `dept`, `phone`, `email`, `booksname`, `booksissuedate`, `booksreturndate`, `status`, `return_type`, `actual_return_date`, `fine`, `overdue_days`, `username`, `book_id`) VALUES
(44, '', '', '', '', '', '', '', '', 'Digital Image Processing', '2025-12-09', '2025-12-16', 'Returned', NULL, NULL, 0.00, 0, 'chyra12', NULL),
(45, '', '', '', '', '', '', '', '', 'Artificial Intelligence', '2025-12-09', '2025-12-16', 'Returned', 'Normal', '2025-12-09', 0.00, 0, 'chyra12', NULL),
(46, '', '', '', '', '', '', '', '', 'Digital Image Processing', '2025-12-09', '2025-12-16', 'Returned', 'Normal', '2025-12-09', 0.00, 0, 'chyra12', NULL),
(47, '', '', '', '', '', '', '', '', 'Artificial Intelligence', '2025-12-09', '2025-12-16', 'Returned', 'Normal', '2025-12-09', 0.00, 0, 'chyra12', NULL),
(48, '', '', '', '', '', '', '', '', 'Theoretical Numerical Analysis', '2025-12-09', '2025-12-16', 'Returned', 'Normal', '2025-12-09', 0.00, 0, 'chyra12', NULL),
(49, '', '', '', '', '', '', '', '', 'Health Informatics', '2025-12-09', '2025-12-16', 'Returned', 'Normal', '2025-12-09', 0.00, 0, 'chyra12', NULL),
(50, '', '', '', '', '', '', '', '', 'Artificial Intelligence', '2025-12-09', '2025-12-16', 'Returned', 'Normal', '2025-12-09', 0.00, 0, 'chyra12', NULL),
(51, '', '', '', '', '', '', '', '', 'The Guest Book: A Novel', '2025-12-09', '2025-12-16', 'Returned', 'Normal', '2025-12-09', 0.00, 0, 'chyra12', NULL),
(52, '', '', '', '', '', '', '', '', 'Digital Image Processing', '2025-12-09', '2025-12-16', 'Returned', 'Normal', '2025-12-09', 0.00, 0, 'chyra12', NULL),
(53, '', '', '', '', '', '', '', '', 'Artificial Intelligence', '2025-12-09', '2025-12-16', 'Returned', 'Normal', '2025-12-09', 0.00, 0, 'chyra12', NULL),
(54, '', '', '', '', '', '', '', '', 'Health Informatics', '2025-12-09', '2025-12-16', 'Returned', 'Normal', '2025-12-12', 0.00, 0, 'chyra12', NULL),
(55, '', '', '', '', '', '', '', '', 'Digital Image Processing', '2025-12-09', '2025-12-16', 'Returned', 'Normal', '2025-12-11', 0.00, 0, 'davictor', NULL),
(56, '', '', '', '', '', '', '', '', 'The Time Machine', '2025-12-11', '2025-12-18', 'Returned', 'Normal', '2025-12-11', 0.00, 0, 'davictor', NULL),
(57, '', '', '', '', '', '', '', '', 'The Cask of Amontillado', '2025-12-11', '2025-12-18', 'Returned', 'Normal', '2025-12-11', 0.00, 0, 'davictor', NULL),
(58, '', '', '', '', '', '', '', '', 'Brave New World', '2025-12-11', '2025-12-18', 'Returned', 'Normal', '2025-12-11', 0.00, 0, 'davictor', NULL),
(59, '', '', '', '', '', '', '', '', 'Dracula', '2025-12-11', '2025-12-18', 'Returned', 'Normal', '2025-12-11', 0.00, 0, 'davictor', NULL),
(60, '', '', '', '', '', '', '', '', 'Frankenstein', '2025-12-11', '2025-12-18', 'Returned', 'Normal', '2025-12-11', 0.00, 0, 'davictor', NULL),
(61, 'student', '', 'davictor', '', '', '', '', '', 'Brave New World', '2025-12-12', '2025-12-19', 'Returned', 'Normal', '2025-12-12', 0.00, 0, 'davictor', 9),
(62, 'student', '', 'davictor', '', '', '', '', '', 'Brave New World', '2025-12-12', '2025-12-19', 'Returned', 'Normal', '2025-12-12', 0.00, 0, 'davictor', 9),
(63, 'teacher', '', 'chyra12', '', '', '', '', '', 'Artificial Intelligence', '2025-12-12', '2025-12-19', 'Returned', 'Normal', '2025-12-12', 0.00, 0, 'chyra12', 6),
(64, 'student', '', 'davictor', '', '', '', '', '', 'Digital Image Processing', '2025-12-12', '2025-12-19', 'Returned', 'Normal', '2025-12-12', 0.00, 0, 'davictor', 3),
(65, 'student', '', 'davictor', '', '', '', '', '', 'The Time Machine', '2025-12-12', '2025-12-19', 'Returned', 'Normal', '2025-12-12', 0.00, 0, 'davictor', 22),
(66, 'student', '', 'davictor', '', '', '', '', '', 'Head First Java', '2025-12-12', '2025-12-19', 'Returned', 'Normal', '2025-12-12', 0.00, 0, 'davictor', 15),
(67, 'student', '', 'davictor', '', '', '', '', '', 'The Lord of the Rings', '2025-12-12', '2025-12-19', 'Returned', 'Normal', '2025-12-12', 0.00, 0, 'davictor', 17),
(68, 'student', '', 'davictor', '', '', '', '', '', 'Romeo and Juliet', '2025-12-12', '2025-12-19', 'Returned', 'Normal', '2025-12-12', 0.00, 0, 'davictor', 18),
(69, 'student', '', 'davictor', '', '', '', '', '', 'Pride and Prejudice', '2025-12-12', '2025-12-19', 'Returned', 'Normal', '2025-12-12', 0.00, 0, 'davictor', 16),
(70, 'Student', '', 'davictor', '', '', '', '', '', 'Brave New World', '2025-12-12', '2025-12-19', 'Returned', 'Normal', '2025-12-12', 0.00, 0, 'davictor', 9),
(71, 'Student', '', 'davictor', '', '', '', '', '', 'Brave New World', '2025-12-12', '2025-12-19', 'Returned', 'Normal', '2025-12-12', 0.00, 0, 'davictor', 9),
(72, 'Student', '', 'davictor', '', '', '', '', '', 'Brave New World', '2025-12-12', '2025-12-19', 'Returned', 'Normal', '2025-12-12', 0.00, 0, 'davictor', 9),
(73, 'Student', '', 'davictor', '', '', '', '', '', 'Brave New World', '2025-12-12', '2025-12-19', 'Returned', 'Normal', '2025-12-12', 0.00, 0, 'davictor', 9),
(74, '', '', '', '', '', '', '', '', 'The Woman in Black', '2025-12-13', 'Not Return', 'Returned', 'Normal', '2025-12-12', 102165.00, 20433, 'davictor', 23),
(75, '', '', '', '', '', '', '', '', 'Head First Java', '2025-12-13', 'Not Return', 'Returned', 'Normal', '2025-12-12', 102165.00, 20433, 'davictor', 15),
(76, '', '', '', '', '', '', '', '', 'HTML, CSS & JavaScript', '2025-12-13', 'Not Return', 'Returned', 'Normal', '2025-12-12', 102165.00, 20433, 'chyra12', 14),
(77, '', '', '', '', '', '', '', '', 'Brave New World', '2025-12-13', 'Not Return', 'Returned', 'Normal', '2025-12-12', 102165.00, 20433, 'chyra12', 9),
(78, '', '', '', '', '', '', '', '', 'Frankenstein', '2025-12-13', 'Not Return', 'Returned', 'Normal', '2025-12-12', 102165.00, 20433, 'chyra12', 12),
(79, '', '', '', '', '', '', '', '', 'The Lord of the Rings', '2025-12-13', 'Not Return', 'Returned', 'Normal', '2025-12-12', 102165.00, 20433, 'chyra12', 17),
(80, '', '', '', '', '', '', '', '', 'Frankenstein', '2025-12-13', 'Not Return', 'Returned', 'Normal', '2025-12-12', 102165.00, 20433, 'chyra12', 12),
(81, '', '', '', '', '', '', '', '', 'The Lord of the Rings', '2025-12-13', 'Not Return', 'Borrowed', NULL, NULL, 0.00, 0, 'venus', 12),
(82, '', '', '', '', '', '', '', '', 'The Lord of the Rings', '2025-12-13', 'Not Return', 'Borrowed', NULL, NULL, 0.00, 0, 'venus', 12),
(83, '', '', '', '', '', '', '', '', '$book_name', '2025-12-13', 'Not Return', 'Borrowed', NULL, NULL, 0.00, 0, '$username', 0),
(84, '', '', '', '', '', '', '', '', '$book_name', '2025-12-13', 'Not Return', 'Borrowed', NULL, NULL, 0.00, 0, '$username', 0),
(85, '', '', '', '', '', '', '', '', '$book_name', '2025-12-13', 'Not Return', 'Borrowed', NULL, NULL, 0.00, 0, '$username', 0),
(86, '', '', '', '', '', '', '', '', '$book_name', '2025-12-13', 'Not Return', 'Borrowed', NULL, NULL, 0.00, 0, '$username', 0),
(87, '', '', '', '', '', '', '', '', '$book_name', '2025-12-13', 'Not Return', 'Borrowed', NULL, NULL, 0.00, 0, '$username', 0),
(88, '', '', '', '', '', '', '', '', 'Game of Thrones', '2025-12-13', '', 'Borrowed', NULL, NULL, 0.00, 0, 'chyra12', NULL),
(89, '', '', '', '', '', '', '', '', 'Brave New World', '2025-12-13', '', 'Borrowed', NULL, NULL, 0.00, 0, 'chyra12', NULL),
(90, '', '', '', '', '', '', '', '', 'Digital Image Processing', '2025-12-13', '', 'Borrowed', NULL, NULL, 0.00, 0, 'chyra12', NULL),
(91, '', '', '', '', '', '', '', '', 'Artificial Intelligence', '2025-12-13', '', 'Borrowed', NULL, NULL, 0.00, 0, 'chyra12', NULL),
(92, '', '', '', '', '', '', '', '', 'Romeo and Juliet', '2025-12-13', '', 'Borrowed', NULL, NULL, 0.00, 0, 'chyra12', NULL),
(93, '', '', '', '', '', '', '', '', 'Brave New World', '2025-12-13', '', 'Returned', 'Normal', '2025-12-13', 102170.00, 20434, 'davictor', NULL),
(94, '', '', '', '', '', '', '', '', '$book_name', '2025-12-13', '', 'Borrowed', NULL, NULL, 0.00, 0, '$username', 0),
(95, '', '', '', '', '', '', '', '', '$book_name', '2025-12-13', '', 'Borrowed', NULL, NULL, 0.00, 0, '$username', 0),
(96, '', '', '', '', '', '', '', '', 'Parallel and Distributed Processing', '2025-12-13', '', 'Returned', 'Normal', '2025-12-13', 102170.00, 20434, 'davictor', 7),
(97, '', '', '', '', '', '', '', '', 'Frankenstein', '2025-12-13', '', 'Borrowed', NULL, NULL, 0.00, 0, 'chyra12', 12),
(98, '', '', '', '', '', '', '', '', 'Theoretical Numerical Analysis', '2025-12-13', '', 'Returned', 'Normal', '2025-12-13', 102170.00, 20434, 'victor12', 1),
(99, '', '', '', '', '', '', '', '', 'The Woman in Black', '2025-12-13', '', 'Returned', 'Normal', '2025-12-13', 102170.00, 20434, 'victor12', 23),
(100, '', '', '', '', '', '', '', '', 'The Adventures of Sherlock Holmes', '2025-12-13', '', 'Returned', 'Normal', '2025-12-13', 102170.00, 20434, 'victor12', 19),
(101, '', '', '', '', '', '', '', '', 'Sense and Sensibility', '2025-12-13', '', 'Returned', 'Normal', '2025-12-13', 102170.00, 20434, 'victor12', 20),
(102, '', '', '', '', '', '', '', '', 'The Cask of Amontillado', '2025-12-13', '', 'Borrowed', NULL, NULL, 0.00, 0, 'chyra12', 21),
(103, '', '', '', '', '', '', '', '', 'Sense and Sensibility', '2025-12-13', '', 'Borrowed', NULL, NULL, 0.00, 0, 'chyra12', 20),
(104, '', '', '', '', '', '', '', '', 'Head First Java', '2025-12-13', '', 'Borrowed', NULL, NULL, 0.00, 0, 'chyra12', 15),
(105, '', '', '', '', '', '', '', '', 'HTML, CSS & JavaScript', '2025-12-13', '', 'Borrowed', NULL, NULL, 0.00, 0, 'chyra12', 14),
(106, '', '', '', '', '', '', '', '', 'Head First Java', '2025-12-13', '', 'Returned', 'Normal', '2025-12-13', 102170.00, 20434, 'davictor', 15),
(107, '', '', '', '', '', '', '', '', 'Game of Thrones', '2025-12-13', '', 'Returned', 'Normal', '2025-12-13', 102170.00, 20434, 'davictor', 13),
(108, '', '', '', '', '', '', '', '', 'HTML, CSS & JavaScript', '2025-12-13', '', 'Returned', 'Normal', '2025-12-13', 102170.00, 20434, 'davictor', 14),
(109, '', '', '', '', '', '', '', '', 'Head First Java', '2025-12-13', '', 'Borrowed', NULL, NULL, 0.00, 0, 'davictor', 15),
(110, '', '', '', '', '', '', '', '', 'The Woman in Black', '2025-12-13', '', 'Borrowed', NULL, NULL, 0.00, 0, 'victor12', 23),
(111, '', '', '', '', '', '', '', '', 'Romeo and Juliet', '2025-12-13', '', 'Borrowed', NULL, NULL, 0.00, 0, 'victor12', 18),
(112, '', '', '', '', '', '', '', '', 'HTML, CSS & JavaScript', '2025-12-13', '', 'Borrowed', NULL, NULL, 0.00, 0, 'victor12', 14),
(113, '', '', '', '', '', '', '', '', 'Pride and Prejudice', '2025-12-13', '', 'Borrowed', NULL, NULL, 0.00, 0, 'victor12', 16),
(114, '', '', '', '', '', '', '', '', 'Theoretical Numerical Analysis', '2025-12-13', '', 'Borrowed', NULL, NULL, 0.00, 0, 'victor12', 1),
(115, '', '', '', '', '', '', '', '', 'The Cask of Amontillado', '2025-12-13', '', 'Borrowed', NULL, NULL, 0.00, 0, 'victor12', 21),
(116, '', '', '', '', '', '', '', '', 'The Adventures of Sherlock Holmes', '2025-12-13', '', 'Borrowed', NULL, NULL, 0.00, 0, 'victor12', 19);

-- --------------------------------------------------------

--
-- Table structure for table `lib_registration`
--

CREATE TABLE `lib_registration` (
  `id` int(2) NOT NULL,
  `name` varchar(50) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `address` varchar(100) NOT NULL,
  `photo` varchar(500) NOT NULL,
  `status` varchar(7) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lib_registration`
--

INSERT INTO `lib_registration` (`id`, `name`, `username`, `password`, `email`, `phone`, `address`, `photo`, `status`) VALUES
(1, 'Victor David', 'victordavid', 'admin', 'victordavid@gmail.com', '09191234567', 'pusok cemento lapu-lapu city', 'upload/1765191822.jpg', ''),
(3, 'Administrator ', 'admin', 'admin', 'admin@gmail.com', '09191234567', 'n/a', 'upload/1765191822.jpg', '');

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE `message` (
  `id` int(10) NOT NULL,
  `susername` varchar(50) NOT NULL,
  `rusername` varchar(50) NOT NULL,
  `title` varchar(100) DEFAULT NULL,
  `msg` varchar(300) NOT NULL,
  `read1` varchar(10) NOT NULL,
  `time` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `message`
--

INSERT INTO `message` (`id`, `susername`, `rusername`, `title`, `msg`, `read1`, `time`) VALUES
(15, 'admin', 'mamun22', 'ttttt', 'mmnbvvv', 'y', '2019-09-14 10:51:44am'),
(16, 'victordavid', 'danielpadilla', 'kickout', 'hooy', 'y', '2025-12-09 07:32:06am'),
(17, 'admin', 'chyra12', 'change you anime profile', 'ilisi na dayun ', 'y', '2025-12-09 09:46:24am'),
(18, 'chyra12', 'chyra12', 'change you anime profile', 'ilisi na dayun ', 'y', '2025-12-09 09:57:13am');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `is_read` enum('no','yes') DEFAULT 'no',
  `created_at` datetime DEFAULT current_timestamp(),
  `status` varchar(20) DEFAULT 'unread'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `username`, `message`, `is_read`, `created_at`, `status`) VALUES
(19, 'admin', '📚 New request from Teacher Chyra Torrejos for book: Health Informatics', 'no', '2025-12-09 11:30:24', 'unread'),
(20, 'chyra12', '📦 Your book return (Digital Image Processing) has been received.', 'no', '2025-12-09 11:30:50', 'unread'),
(21, 'chyra12', '📦 Your book return (Artificial Intelligence) has been received.', 'no', '2025-12-09 11:30:58', 'unread'),
(22, 'admin', '📚 New request from Teacher Chyra Torrejos for book: Artificial Intelligence', 'no', '2025-12-11 22:31:06', 'unread'),
(23, 'admin', '📚 New request from Teacher Chyra Torrejos for book: Digital Image Processing', 'no', '2025-12-11 22:31:29', 'unread'),
(24, 'admin', '📚 New request from Teacher Chyra Torrejos for book: The Woman in Black', 'no', '2025-12-11 22:31:35', 'unread'),
(25, 'admin', '📚 New request from Teacher Chyra Torrejos for book: The Lord of the Rings', 'no', '2025-12-11 22:31:42', 'unread'),
(26, 'davictor', '📦 Your book return (Digital Image Processing) has been received.', 'no', '2025-12-11 22:41:55', 'unread'),
(27, 'davictor', '📦 Your book return (Brave New World) has been received.', 'no', '2025-12-11 22:41:59', 'unread'),
(28, 'davictor', '📦 Your book return (Dracula) has been received.', 'no', '2025-12-11 22:42:03', 'unread'),
(29, 'davictor', '📦 Your book return (The Cask of Amontillado) has been received.', 'no', '2025-12-11 22:42:07', 'unread'),
(30, 'davictor', '📦 Your book return (The Time Machine) has been received.', 'no', '2025-12-11 22:42:11', 'unread'),
(31, 'davictor', '📦 Your book return (Frankenstein) has been received.', 'no', '2025-12-11 22:48:11', 'unread'),
(32, 'admin', '📚 New request from Teacher Chyra Torrejos for book: Romeo and Juliet', 'no', '2025-12-12 15:48:28', 'unread'),
(33, 'staff', '📘 Teacher Chyra Torrejos requested book: Artificial Intelligence', 'yes', '2025-12-12 15:50:37', 'unread'),
(34, 'staff', '📘 Teacher Chyra Torrejos requested book: Digital Image Processing', 'yes', '2025-12-12 15:50:40', 'unread'),
(35, 'staff', 'New reservation from student davictor for Brave New World', 'yes', '2025-12-12 16:22:45', 'unread'),
(36, 'davictor', 'Your reservation for Brave New World has been approved.', 'no', '2025-12-12 16:26:37', 'unread'),
(37, 'staff', 'New reservation from teacher Chyra Torrejos for Artificial Intelligence', 'yes', '2025-12-12 16:27:21', 'unread'),
(38, 'staff', '📘 Teacher Chyra Torrejos requested book: Brave New World', 'yes', '2025-12-12 16:55:15', 'unread'),
(39, 'staff', '📘 Teacher Chyra Torrejos requested book: Theoretical Numerical Analysis', 'yes', '2025-12-12 16:55:42', 'unread'),
(40, 'staff', 'New reservation from student davictor for Digital Image Processing', 'yes', '2025-12-12 16:57:27', 'unread'),
(41, 'staff', 'New reservation from student davictor for Dracula', 'yes', '2025-12-12 16:57:36', 'unread'),
(42, 'davictor', 'Your reservation for Brave New World has been approved.', 'no', '2025-12-12 16:57:55', 'unread'),
(43, 'chyra12', 'Your reservation for Artificial Intelligence has been approved.', 'no', '2025-12-12 17:04:34', 'unread'),
(44, 'davictor', 'Your reservation for Digital Image Processing has been approved.', 'no', '2025-12-12 17:04:42', 'unread'),
(45, 'davictor', '📦 Your book return (Brave New World) has been received.', 'no', '2025-12-12 17:17:17', 'unread'),
(46, 'davictor', '📦 Your book return (Brave New World) has been received.', 'no', '2025-12-12 17:17:21', 'unread'),
(47, 'davictor', '📦 Your book return (Digital Image Processing) has been received.', 'no', '2025-12-12 17:17:24', 'unread'),
(48, 'staff', 'New reservation from student davictor for The Time Machine', 'yes', '2025-12-12 17:17:32', 'unread'),
(49, 'davictor', 'Your reservation for The Time Machine has been approved.', 'no', '2025-12-12 17:18:03', 'unread'),
(50, 'davictor', 'Your reservation for Dracula has been declined.', 'no', '2025-12-12 17:18:43', 'unread'),
(51, 'staff', 'New reservation from student davictor for The Lord of the Rings', 'yes', '2025-12-12 17:28:27', 'unread'),
(52, 'staff', 'New reservation from student davictor for Head First Java', 'yes', '2025-12-12 17:28:30', 'unread'),
(53, 'davictor', 'Your reservation for Head First Java has been approved.', 'no', '2025-12-12 17:29:00', 'unread'),
(54, 'davictor', 'Your reservation for The Lord of the Rings has been approved.', 'no', '2025-12-12 17:31:54', 'unread'),
(55, 'davictor', '📦 Your book return (The Time Machine) has been received.', 'no', '2025-12-12 17:32:49', 'unread'),
(56, 'davictor', '📦 Your book return (Head First Java) has been received.', 'no', '2025-12-12 17:32:53', 'unread'),
(57, 'davictor', '📦 Your book return (The Lord of the Rings) has been received.', 'no', '2025-12-12 17:32:57', 'unread'),
(58, 'staff', 'New reservation from student davictor for Dracula', 'yes', '2025-12-12 17:33:05', 'unread'),
(59, 'staff', 'New reservation from student davictor for Pride and Prejudice', 'yes', '2025-12-12 17:33:08', 'unread'),
(60, 'staff', 'New reservation from student davictor for Romeo and Juliet', 'yes', '2025-12-12 17:33:12', 'unread'),
(61, 'chyra12', '📦 Your book return (Health Informatics) has been received.', 'no', '2025-12-12 17:33:41', 'unread'),
(62, 'chyra12', '📦 Your book return (Artificial Intelligence) has been received.', 'no', '2025-12-12 17:33:46', 'unread'),
(63, 'staff', '📘 Teacher Chyra Torrejos requested book: Game of Thrones', 'yes', '2025-12-12 17:34:00', 'unread'),
(64, 'davictor', 'Your reservation for Romeo and Juliet has been approved.', 'no', '2025-12-12 17:34:44', 'unread'),
(65, 'davictor', 'Your reservation for Pride and Prejudice has been approved.', 'no', '2025-12-12 17:34:47', 'unread'),
(66, 'davictor', 'Your reservation for Dracula has been declined.', 'no', '2025-12-12 17:34:49', 'unread'),
(67, 'staff', 'New reservation from student davictor for Dracula', 'yes', '2025-12-12 17:40:18', 'unread'),
(68, 'davictor', 'Your reservation for Dracula has been declined.', 'no', '2025-12-12 18:40:14', 'unread'),
(69, 'davictor', '📦 Your book return (Romeo and Juliet) has been received.', 'no', '2025-12-12 19:16:05', 'unread'),
(70, 'davictor', '📦 Your book return (Pride and Prejudice) has been received.', 'no', '2025-12-12 19:16:09', 'unread'),
(71, 'davictor', '📦 Your book return (Brave New World) has been received.', 'no', '2025-12-12 20:52:40', 'unread'),
(72, 'davictor', '📦 Your book return (Brave New World) has been received.', 'no', '2025-12-12 20:52:44', 'unread'),
(73, 'davictor', '📦 Your book return (Brave New World) has been received.', 'no', '2025-12-12 20:52:49', 'unread'),
(74, 'chyra12', '📦 Your book return (HTML, CSS & JavaScript) has been received.', 'no', '2025-12-13 02:41:07', 'unread'),
(75, 'chyra12', '📦 Your book return (Brave New World) has been received.', 'no', '2025-12-13 02:41:11', 'unread'),
(76, 'davictor', '📦 Your book return (Brave New World) has been received.', 'no', '2025-12-13 03:59:37', 'unread'),
(77, 'davictor', '📦 Your book return (The Woman in Black) has been received.', 'no', '2025-12-13 03:59:41', 'unread'),
(78, 'davictor', '📦 Your book return (Head First Java) has been received.', 'no', '2025-12-13 03:59:44', 'unread'),
(79, 'chyra12', '📦 Your book return (Frankenstein) has been received.', 'no', '2025-12-13 04:11:06', 'unread'),
(80, 'chyra12', '📦 Your book return (The Lord of the Rings) has been received.', 'no', '2025-12-13 04:11:10', 'unread'),
(81, 'chyra12', '📦 Your book return (Frankenstein) has been received.', 'no', '2025-12-13 04:11:14', 'unread'),
(82, 'davictor', '📦 Your book return (Brave New World) has been received.', 'no', '2025-12-13 19:04:06', 'unread'),
(83, 'davictor', '📦 Your book return (Parallel and Distributed Processing) has been received.', 'no', '2025-12-13 19:04:10', 'unread'),
(84, 'davictor', '📦 Your book return (Head First Java) has been received.', 'no', '2025-12-13 19:04:13', 'unread'),
(85, 'victor12', '📦 Your book return (Theoretical Numerical Analysis) has been received.', 'no', '2025-12-13 19:04:49', 'unread'),
(86, 'victor12', '📦 Your book return (The Woman in Black) has been received.', 'no', '2025-12-13 19:04:53', 'unread'),
(87, 'victor12', '📦 Your book return (The Adventures of Sherlock Holmes) has been received.', 'no', '2025-12-13 19:04:57', 'unread'),
(88, 'victor12', '📦 Your book return (Sense and Sensibility) has been received.', 'no', '2025-12-13 19:05:01', 'unread'),
(89, 'davictor', '📦 Your book return (Game of Thrones) has been received.', 'no', '2025-12-13 20:16:06', 'unread'),
(90, 'davictor', '📦 Your book return (HTML, CSS & JavaScript) has been received.', 'no', '2025-12-13 20:16:14', 'unread');

-- --------------------------------------------------------

--
-- Table structure for table `notifications_status`
--

CREATE TABLE `notifications_status` (
  `id` int(11) NOT NULL,
  `admin_username` varchar(50) NOT NULL,
  `message` varchar(255) NOT NULL,
  `sender` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_read` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notifications_status`
--

INSERT INTO `notifications_status` (`id`, `admin_username`, `message`, `sender`, `created_at`, `is_read`) VALUES
(1, 'admin', '', '', '2025-12-08 16:31:34', 0),
(2, 'admin', '📘 Request: danielpadilla requested Health Informatics', 'danielpadilla', '2025-12-08 16:59:14', 0),
(3, 'admin', '📘 Request: danielpadilla requested Parallel and Distributed Processing', 'danielpadilla', '2025-12-08 17:32:22', 0),
(4, 'admin', '📘 Request: danielpadilla requested Digital Image Processing', 'danielpadilla', '2025-12-08 17:47:11', 0);

-- --------------------------------------------------------

--
-- Table structure for table `penalties`
--

CREATE TABLE `penalties` (
  `id` int(10) NOT NULL,
  `username` varchar(50) NOT NULL,
  `user_type` varchar(20) NOT NULL,
  `borrow_id` int(10) DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `reason` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `paid` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `penalties`
--

INSERT INTO `penalties` (`id`, `username`, `user_type`, `borrow_id`, `amount`, `reason`, `created_at`, `paid`) VALUES
(1, 'davictor', 'student', NULL, 790.00, 'lost book', '2025-12-13 16:24:10', 0);

-- --------------------------------------------------------

--
-- Table structure for table `request_books`
--

CREATE TABLE `request_books` (
  `id` int(10) NOT NULL,
  `name` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `utype` varchar(10) NOT NULL,
  `bname` varchar(50) NOT NULL,
  `burl` varchar(500) NOT NULL,
  `read1` varchar(3) NOT NULL,
  `status` enum('pending','approved','borrowed','rejected','cancelled') NOT NULL DEFAULT 'pending',
  `req_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `request_type` enum('borrow','reserve') NOT NULL DEFAULT 'reserve'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `request_books`
--

INSERT INTO `request_books` (`id`, `name`, `username`, `email`, `utype`, `bname`, `burl`, `read1`, `status`, `req_date`, `request_type`) VALUES
(42, 'davictor', 'davictor', 'davictor@gmail.com', 'student', 'Brave New World', '', 'yes', 'approved', '2025-12-12 02:20:02', 'reserve'),
(43, 'Chyra Torrejos', 'chyra12', 'chyra@gmail.com', 'teacher', 'Romeo and Juliet', '', 'no', 'approved', '2025-12-12 07:48:28', 'reserve'),
(44, 'Chyra Torrejos', 'chyra12', 'chyra@gmail.com', 'Teacher', 'Artificial Intelligence', '', 'no', 'approved', '2025-12-12 07:50:37', 'reserve'),
(45, 'Chyra Torrejos', 'chyra12', 'chyra@gmail.com', 'Teacher', 'Digital Image Processing', '', 'no', 'approved', '2025-12-12 07:50:40', 'reserve'),
(46, 'Chyra Torrejos', 'chyra12', 'chyra@gmail.com', 'Teacher', 'Brave New World', '', 'no', 'approved', '2025-12-12 08:55:15', 'reserve'),
(47, 'Chyra Torrejos', 'chyra12', 'chyra@gmail.com', 'Teacher', 'Theoretical Numerical Analysis', '', 'no', '', '2025-12-12 08:55:42', 'reserve'),
(48, 'Chyra Torrejos', 'chyra12', 'chyra@gmail.com', 'Teacher', 'Game of Thrones', '', 'no', 'approved', '2025-12-12 09:34:00', 'reserve');

-- --------------------------------------------------------

--
-- Table structure for table `reservations`
--

CREATE TABLE `reservations` (
  `id` int(11) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `utype` varchar(20) DEFAULT NULL,
  `action_type` enum('borrow','reserve') NOT NULL DEFAULT 'reserve',
  `book_id` int(11) DEFAULT NULL,
  `book_name` varchar(255) DEFAULT NULL,
  `reserved_at` datetime DEFAULT NULL,
  `status` varchar(50) DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reservations`
--

INSERT INTO `reservations` (`id`, `username`, `email`, `utype`, `action_type`, `book_id`, `book_name`, `reserved_at`, `status`) VALUES
(26, 'chyra12', NULL, 'teacher', 'reserve', 11, 'Dracula', '2025-12-13 02:36:29', 'reserved'),
(27, 'chyra12', NULL, 'teacher', 'reserve', 12, 'Frankenstein', '2025-12-13 02:36:32', 'approved'),
(28, 'chyra12', NULL, 'teacher', 'reserve', 11, 'Dracula', '2025-12-13 02:41:17', 'reserved'),
(29, 'chyra12', NULL, 'teacher', 'reserve', 13, 'Game of Thrones', '2025-12-13 02:41:20', 'reserved'),
(30, 'chyra12', NULL, 'teacher', 'reserve', 11, 'Dracula', '2025-12-13 02:54:10', 'requested'),
(31, 'chyra12', NULL, 'teacher', 'reserve', 12, 'Frankenstein', '2025-12-13 02:54:13', 'approved'),
(32, 'chyra12', NULL, 'teacher', 'reserve', 17, 'The Lord of the Rings', '2025-12-13 02:54:17', 'approved'),
(33, 'venus', NULL, NULL, 'reserve', 12, 'The Lord of the Rings', '2025-12-13 03:11:39', 'approved'),
(34, 'venus', NULL, NULL, 'reserve', 12, 'The Lord of the Rings', '2025-12-13 03:12:12', 'approved'),
(35, 'chyra12', NULL, 'teacher', 'reserve', 9, 'Brave New World', '2025-12-13 03:15:30', 'reserved'),
(36, 'chyra12', NULL, 'teacher', 'reserve', 11, 'Dracula', '2025-12-13 03:15:32', 'requested'),
(37, 'chyra12', NULL, 'teacher', 'reserve', 24, 'The Mystery of the Yellow Room', '2025-12-13 03:15:37', 'requested'),
(38, 'chyra12', NULL, 'teacher', 'reserve', 19, 'The Adventures of Sherlock Holmes', '2025-12-13 03:15:40', 'reserved'),
(39, 'victor12', NULL, 'teacher', 'reserve', 11, 'Dracula', '2025-12-13 03:21:24', 'requested'),
(40, 'victor12', NULL, 'teacher', 'reserve', 12, 'Frankenstein', '2025-12-13 03:21:27', 'reserved'),
(41, 'victor12', NULL, 'teacher', 'reserve', 13, 'Game of Thrones', '2025-12-13 03:21:29', 'reserved'),
(42, 'victor12', NULL, 'teacher', 'reserve', 11, 'Dracula', '2025-12-13 03:25:46', 'requested'),
(43, 'victor12', NULL, 'teacher', 'reserve', 3, 'Digital Image Processing', '2025-12-13 03:25:48', 'reserved'),
(44, 'victor12', NULL, 'teacher', 'reserve', 17, 'The Lord of the Rings', '2025-12-13 03:31:10', 'requested'),
(45, 'victor12', NULL, 'teacher', 'reserve', 22, 'The Time Machine', '2025-12-13 03:31:12', 'reserved'),
(46, 'victor12', NULL, 'teacher', 'reserve', 10, 'The Sign of the Four', '2025-12-13 03:31:14', 'requested'),
(47, '$username', NULL, NULL, 'reserve', 0, '$book_name', '2025-12-13 03:32:16', 'converted'),
(48, '$username', NULL, NULL, 'reserve', 0, '$book_name', '2025-12-13 03:32:36', 'declined'),
(49, '$username', NULL, NULL, 'reserve', 0, '$book_name', '2025-12-13 03:33:33', 'converted'),
(50, '$username', NULL, 'student', 'reserve', 0, '$bookName', '2025-12-13 17:51:59', 'requested'),
(51, '$username', NULL, 'student', 'reserve', 0, '$bookName', '2025-12-13 17:52:08', 'reserved'),
(52, 'vjajajajja', NULL, 'student', '', 0, '$bookName', '2025-12-13 17:55:08', 'requested'),
(53, 'davictor', NULL, 'student', 'reserve', 7, 'Parallel and Distributed Processing', '2025-12-13 18:01:14', 'converted'),
(54, 'sample', NULL, 'student', '', 0, '$bookName', '2025-12-13 18:02:20', 'requested'),
(55, 'sample', NULL, 'student', '', 0, '$bookName', '2025-12-13 18:02:36', 'requested'),
(56, 'sample', NULL, 'student', '', 0, '$bookName', '2025-12-13 18:02:41', 'requested'),
(57, 'sample', NULL, 'student', '', 0, '$bookName', '2025-12-13 18:02:47', 'requested'),
(58, 'victor12', NULL, 'teacher', 'reserve', 23, 'The Woman in Black', '2025-12-13 18:08:37', 'declined'),
(59, 'victor12', NULL, 'teacher', '', 20, 'Sense and Sensibility', '2025-12-13 18:08:41', 'declined'),
(60, 'chyra12', NULL, 'teacher', '', 12, 'Frankenstein', '2025-12-13 18:12:39', 'converted'),
(61, 'victor12', NULL, 'teacher', '', 1, 'Theoretical Numerical Analysis', '2025-12-13 18:13:53', 'converted'),
(62, 'victor12', NULL, 'teacher', '', 23, 'The Woman in Black', '2025-12-13 18:13:59', 'converted'),
(63, 'victor12', NULL, 'teacher', '', 19, 'The Adventures of Sherlock Holmes', '2025-12-13 18:14:47', 'converted'),
(64, 'victor12', NULL, 'teacher', 'reserve', 20, 'Sense and Sensibility', '2025-12-13 18:14:50', 'converted'),
(65, 'sample', NULL, 'student', '', 0, '$bookName', '2025-12-13 18:15:54', 'declined'),
(66, 'sample', NULL, 'student', '', 0, '$bookName', '2025-12-13 18:15:58', 'declined'),
(67, 'sample', NULL, 'student', '', 0, '$bookName', '2025-12-13 18:16:02', 'declined'),
(68, 'chyra12', NULL, 'teacher', '', 20, 'Sense and Sensibility', '2025-12-13 18:17:02', 'converted'),
(69, 'chyra12', NULL, 'teacher', 'reserve', 21, 'The Cask of Amontillado', '2025-12-13 18:17:07', 'converted'),
(70, 'chyra12', NULL, 'teacher', '', 14, 'HTML, CSS & JavaScript', '2025-12-13 18:18:56', 'converted'),
(71, 'chyra12', NULL, 'teacher', '', 15, 'Head First Java', '2025-12-13 18:19:03', 'converted'),
(72, 'chyra12', NULL, 'teacher', 'reserve', 16, 'Pride and Prejudice', '2025-12-13 18:20:35', 'reserved'),
(73, 'chyra12', NULL, 'teacher', 'reserve', 10, 'The Sign of the Four', '2025-12-13 18:20:51', 'reserved'),
(74, 'davictor', NULL, 'student', '', 11, 'Dracula', '2025-12-13 18:23:11', 'declined'),
(75, 'davictor', NULL, 'student', 'reserve', 15, 'Head First Java', '2025-12-13 18:23:14', 'converted'),
(76, 'davictor', NULL, 'student', 'reserve', 11, 'Dracula', '2025-12-13 20:13:16', 'reserved'),
(77, 'davictor', NULL, 'student', '', 15, 'Head First Java', '2025-12-13 20:13:32', 'converted'),
(78, 'davictor', NULL, 'student', '', 14, 'HTML, CSS & JavaScript', '2025-12-13 20:13:35', 'converted'),
(79, 'davictor', NULL, 'student', '', 13, 'Game of Thrones', '2025-12-13 20:13:38', 'converted'),
(80, 'victor12', NULL, 'teacher', 'reserve', 23, 'The Woman in Black', '2025-12-13 20:15:00', 'converted'),
(81, 'victor12', NULL, 'teacher', '', 18, 'Romeo and Juliet', '2025-12-13 20:15:15', 'converted'),
(82, 'victor12', NULL, 'teacher', '', 14, 'HTML, CSS & JavaScript', '2025-12-13 20:15:32', 'converted'),
(83, 'victor12', NULL, 'teacher', '', 19, 'The Adventures of Sherlock Holmes', '2025-12-13 20:17:35', 'converted'),
(84, 'victor12', NULL, 'teacher', '', 21, 'The Cask of Amontillado', '2025-12-13 20:17:38', 'converted'),
(85, 'victor12', NULL, 'teacher', '', 1, 'Theoretical Numerical Analysis', '2025-12-13 20:17:42', 'converted'),
(86, 'victor12', NULL, 'teacher', '', 16, 'Pride and Prejudice', '2025-12-13 20:17:49', 'converted');

-- --------------------------------------------------------

--
-- Table structure for table `reservations_backup`
--

CREATE TABLE `reservations_backup` (
  `id` int(10) NOT NULL DEFAULT 0,
  `username` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `user_type` varchar(255) DEFAULT NULL,
  `book_id` int(11) DEFAULT NULL,
  `book_name` varchar(255) DEFAULT NULL,
  `reserved_at` datetime DEFAULT NULL,
  `status` varchar(255) DEFAULT 'pending',
  `staff_seen` enum('yes','no') DEFAULT 'no'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reservations_backup`
--

INSERT INTO `reservations_backup` (`id`, `username`, `email`, `user_type`, `book_id`, `book_name`, `reserved_at`, `status`, `staff_seen`) VALUES
(1, 'davictor', 'davictor@gmail.com', 'student', 9, 'Brave New World', '2025-12-12 16:22:45', 'approved', 'no'),
(2, 'chyra12', 'chyra@gmail.com', 'teacher', 6, 'Artificial Intelligence', '2025-12-12 16:27:21', 'approved', 'no'),
(3, 'davictor', 'davictor@gmail.com', 'student', 3, 'Digital Image Processing', '2025-12-12 16:57:27', 'approved', 'no'),
(4, 'davictor', 'davictor@gmail.com', 'student', 11, 'Dracula', '2025-12-12 16:57:36', 'pending', 'no'),
(5, 'davictor', 'davictor@gmail.com', 'student', 22, 'The Time Machine', '2025-12-12 17:17:32', 'approved', 'no'),
(6, 'davictor', 'davictor@gmail.com', 'student', 17, 'The Lord of the Rings', '2025-12-12 17:28:27', 'approved', 'no'),
(7, 'davictor', 'davictor@gmail.com', 'student', 15, 'Head First Java', '2025-12-12 17:28:30', 'approved', 'no'),
(8, 'davictor', 'davictor@gmail.com', 'student', 11, 'Dracula', '2025-12-12 17:33:05', 'pending', 'no'),
(9, 'davictor', 'davictor@gmail.com', 'student', 16, 'Pride and Prejudice', '2025-12-12 17:33:08', 'approved', 'no'),
(10, 'davictor', 'davictor@gmail.com', 'student', 18, 'Romeo and Juliet', '2025-12-12 17:33:12', 'approved', 'no'),
(11, 'davictor', 'davictor@gmail.com', 'student', 11, 'Dracula', '2025-12-12 17:40:18', 'pending', 'no'),
(41, '$username', '$email', '$type', 0, '$bookName', '2025-12-12 19:38:12', 'pending', 'no'),
(42, 'davictor', NULL, 'Student', 9, 'Brave New World', '2025-12-12 19:38:42', 'requested', 'no'),
(43, 'davictor', NULL, 'Student', 12, 'Frankenstein', '2025-12-12 19:38:45', 'reserved', 'no'),
(44, 'chyra12', NULL, 'Teacher', 11, 'Dracula', '2025-12-12 19:39:51', 'requested', 'no'),
(45, 'chyra12', NULL, 'Teacher', 12, 'Frankenstein', '2025-12-12 19:39:53', 'reserved', 'no'),
(46, 'chyra12', NULL, 'Teacher', 13, 'Game of Thrones', '2025-12-12 19:39:59', 'requested', 'no'),
(47, 'chyra12', NULL, 'Teacher', 18, 'Romeo and Juliet', '2025-12-12 19:40:02', 'reserved', 'no');

-- --------------------------------------------------------

--
-- Table structure for table `staff_registration`
--

CREATE TABLE `staff_registration` (
  `id` int(10) NOT NULL,
  `name` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `address` varchar(100) NOT NULL,
  `photo` varchar(500) NOT NULL,
  `status` varchar(10) NOT NULL DEFAULT 'active',
  `vkey` varchar(250) NOT NULL,
  `verified` varchar(3) NOT NULL DEFAULT 'no'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `staff_registration`
--

INSERT INTO `staff_registration` (`id`, `name`, `username`, `password`, `email`, `phone`, `address`, `photo`, `status`, `vkey`, `verified`) VALUES
(1, 'Library Staff', 'staff', 'staff123', 'staff@gmail.com', '09190000000', 'CTU Library', 'upload/1765523671_beru.png', 'active', 'staffkey123', 'yes');

-- --------------------------------------------------------

--
-- Table structure for table `std_registration`
--

CREATE TABLE `std_registration` (
  `id` int(10) NOT NULL,
  `name` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `sem` varchar(10) NOT NULL,
  `dept` varchar(10) NOT NULL,
  `session` varchar(5) NOT NULL,
  `regno` varchar(20) NOT NULL,
  `address` varchar(100) NOT NULL,
  `utype` varchar(7) NOT NULL,
  `photo` varchar(500) NOT NULL,
  `status` varchar(7) NOT NULL,
  `vkey` varchar(250) NOT NULL,
  `verified` varchar(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `std_registration`
--

INSERT INTO `std_registration` (`id`, `name`, `username`, `password`, `email`, `phone`, `sem`, `dept`, `session`, `regno`, `address`, `utype`, `photo`, `status`, `vkey`, `verified`) VALUES
(55, 'davictor', 'davictor', 'davictor', 'davictor@gmail.com', '0927276168', '1th', 'EEE', '1/15', '100', 'taga pusok', 'student', 'upload/1765251155_victor.png', 'active', '8587be0a1104623ede222c7ce0f1fa72', 'no'),
(56, 'ron ron', 'ronron187', 'ron123', 'ron@gmail.com', '0999999999999', '4th', 'Others', '15', '1010', 'lapulapu', 'student', 'upload/avatar.jpg', 'pending', '6064df73ddfeddc6ab0d1433d907c687', 'no'),
(57, 'chyvictor', 'chyvictor', '$password', 'chyvictor@gmail.com', '099999999999', '1', 'ict', '14', '909090', 'pusok', '', '', 'pending', '', ''),
(58, 'naruto uzumaki', 'naruto', '123456', 'naruto@gmail.com', '099999999999', '8th', 'EEE', '14/15', '44444', 'pusok', 'student', 'upload/avatar.jpg', 'pending', '44db90ae4321e560ca5f69bd2a7bbf09', 'no');

-- --------------------------------------------------------

--
-- Table structure for table `t_issuebook`
--

CREATE TABLE `t_issuebook` (
  `id` int(10) NOT NULL,
  `utype` varchar(20) NOT NULL,
  `idno` varchar(20) NOT NULL,
  `name` varchar(50) NOT NULL,
  `lecturer` varchar(20) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `booksname` varchar(50) NOT NULL,
  `booksissuedate` varchar(20) NOT NULL,
  `booksreturndate` varchar(20) NOT NULL,
  `username` varchar(20) NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'Borrowed'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `t_issuebook`
--

INSERT INTO `t_issuebook` (`id`, `utype`, `idno`, `name`, `lecturer`, `phone`, `email`, `booksname`, `booksissuedate`, `booksreturndate`, `username`, `status`) VALUES
(17, 'teacher', '1001', 'Victor', 'CSE', '09191234567', 'victor12@gmail.com', 'Theoretical Numerical Analysis', '05/04/2019', '05/05/2019', 'victor12', 'Borrowed');

-- --------------------------------------------------------

--
-- Table structure for table `t_registration`
--

CREATE TABLE `t_registration` (
  `id` int(10) NOT NULL,
  `name` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `lecturer` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `idno` varchar(20) NOT NULL,
  `address` varchar(100) NOT NULL,
  `utype` varchar(7) NOT NULL,
  `photo` varchar(500) NOT NULL,
  `status` varchar(7) NOT NULL,
  `vkey` varchar(250) NOT NULL,
  `verified` varchar(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `t_registration`
--

INSERT INTO `t_registration` (`id`, `name`, `username`, `password`, `lecturer`, `email`, `phone`, `idno`, `address`, `utype`, `photo`, `status`, `vkey`, `verified`) VALUES
(1, 'Chyra Torrejos', 'chyra12', 'chyra12', 'CSE', 'chyra@gmail.com', '09191234567', '1001', 'Abuno basak lapu lapu city', 'teacher', 'upload/1765249268.jpg', 'active', 'dsfdfsghrfjhyetryt5ergbfvh', 'yes'),
(2, 'Victor', 'Victor12', 'victor', 'CSE', 'victor12@gmail.com', '09281234567', '1008', 'Sonadanga 2nd phase', 'teacher', 'upload/avatar.jpg', 'active', 'iuyirtytrfhgn4w3erterfgvggfhgfh', 'yes'),
(4, 'Gabriel Luna', 'gabrielluna', '123456', 'cse', 'gabriellunal@gmail.com', '09192345678', '1245555655', 'khulna', 'teacher', 'upload/avatar.jpg', 'active', '7a3b7cd62fe6740522ecb64f7e9b1ee3', 'no'),
(5, 'A Little Tea', 'littletea', '$password', 'cse', 'tea@gmail.com', '0921929129', '712637163', 'basak', '', '', 'pending', '', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `add_book`
--
ALTER TABLE `add_book`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `book_reservation`
--
ALTER TABLE `book_reservation`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `borrow_records`
--
ALTER TABLE `borrow_records`
  ADD PRIMARY KEY (`id`),
  ADD KEY `username` (`username`),
  ADD KEY `book_id` (`book_id`);

--
-- Indexes for table `clearances`
--
ALTER TABLE `clearances`
  ADD PRIMARY KEY (`id`),
  ADD KEY `username` (`username`);

--
-- Indexes for table `finezone`
--
ALTER TABLE `finezone`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `genres`
--
ALTER TABLE `genres`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `issue_book`
--
ALTER TABLE `issue_book`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lib_registration`
--
ALTER TABLE `lib_registration`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications_status`
--
ALTER TABLE `notifications_status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `penalties`
--
ALTER TABLE `penalties`
  ADD PRIMARY KEY (`id`),
  ADD KEY `username` (`username`),
  ADD KEY `borrow_id` (`borrow_id`);

--
-- Indexes for table `request_books`
--
ALTER TABLE `request_books`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `staff_registration`
--
ALTER TABLE `staff_registration`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `std_registration`
--
ALTER TABLE `std_registration`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_issuebook`
--
ALTER TABLE `t_issuebook`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_registration`
--
ALTER TABLE `t_registration`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `add_book`
--
ALTER TABLE `add_book`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `book_reservation`
--
ALTER TABLE `book_reservation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `borrow_records`
--
ALTER TABLE `borrow_records`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `clearances`
--
ALTER TABLE `clearances`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `finezone`
--
ALTER TABLE `finezone`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `genres`
--
ALTER TABLE `genres`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `issue_book`
--
ALTER TABLE `issue_book`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=117;

--
-- AUTO_INCREMENT for table `lib_registration`
--
ALTER TABLE `lib_registration`
  MODIFY `id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `message`
--
ALTER TABLE `message`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;

--
-- AUTO_INCREMENT for table `notifications_status`
--
ALTER TABLE `notifications_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `penalties`
--
ALTER TABLE `penalties`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `request_books`
--
ALTER TABLE `request_books`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;

--
-- AUTO_INCREMENT for table `staff_registration`
--
ALTER TABLE `staff_registration`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `std_registration`
--
ALTER TABLE `std_registration`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `t_issuebook`
--
ALTER TABLE `t_issuebook`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `t_registration`
--
ALTER TABLE `t_registration`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
