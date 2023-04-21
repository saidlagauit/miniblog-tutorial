-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 21, 2023 at 10:28 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `miniblog`
--

-- --------------------------------------------------------

--
-- Table structure for table `about`
--

CREATE TABLE `about` (
  `id` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `bio_a` text NOT NULL,
  `fb` text NOT NULL,
  `insta` text NOT NULL,
  `twt` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `about`
--

INSERT INTO `about` (`id`, `image`, `bio_a`, `fb`, `insta`, `twt`) VALUES
(1, 'about_6440901ec11c01.48676614.jpg', ' I\'m Said Lagauit, and I\'m a web developer.\n      <br />\n      <br />\n      I love to build websites for people, and I especially love to build websites that are beautiful, easy to use, and\n      make people smile.\n      <br />\n      <br />\n      If you\'re interested in working with me on one of your projects, please feel free to reach out!', 'https://www.facebook.com/lagauit.said/', 'https://www.instagram.com/said.lagauit/', 'https://twitter.com/said_lagauit/');

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `username` varchar(20) NOT NULL,
  `biographical` text NOT NULL,
  `email` varchar(255) NOT NULL,
  `fb` text NOT NULL,
  `twt` text NOT NULL,
  `in` text NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('administrator','author') NOT NULL DEFAULT 'author',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `name`, `username`, `biographical`, `email`, `fb`, `twt`, `in`, `password`, `role`, `created_at`) VALUES
(1, 'Said Lagauit', 'lagauit', 'I&#39;m a web developer and I love to build things.', 'lagauit@contact.com', 'https://www.facebook.com/lagauit.said/', 'https://twitter.com/said_lagauit/', 'https://www.linkedin.com/in/saidlagauit/', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'administrator', '2023-04-20 00:14:19'),
(10, 'saad a', 'saad', '', 'contact@saad.ma', '', '', '', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'author', '2023-04-21 17:53:26');

-- --------------------------------------------------------

--
-- Table structure for table `articles`
--

CREATE TABLE `articles` (
  `id` int(11) NOT NULL,
  `title` text NOT NULL,
  `cover` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `author` text NOT NULL DEFAULT 'none',
  `status_a` enum('0','1') NOT NULL DEFAULT '1',
  `categories` text NOT NULL DEFAULT 'uncategorized',
  `tags` text NOT NULL DEFAULT 'none',
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `articles`
--

INSERT INTO `articles` (`id`, `title`, `cover`, `content`, `author`, `status_a`, `categories`, `tags`, `created`, `updated`) VALUES
(23, 'new CSS framework', 'cover_6442f048bc4466.60183959.png', '# To create a new CSS framework, you will need to do the following:\r\n\r\n### I. Define the purpose of your framework\r\n\r\nBefore starting to create a CSS framework, you should consider what types of projects it will be used for and what design principles it will follow. Determine the main goals of the framework and what it should achieve. For example, if the framework is intended to be used for creating responsive websites, its design principles should focus on responsiveness and mobile-first design.\r\n\r\n### II. Determine the basic structure of your framework\r\n\r\nThis step involves deciding on the basic building blocks of your framework, such as a grid system, typography styles, and form elements. A grid system helps to create a consistent layout for your website or application. Typography styles define how text will look on your website, such as the font size, line height, and font family. Form elements are the different types of input fields you use on your website, such as text boxes, dropdown menus, and checkboxes.\r\n\r\n### III. Decide on the naming conventions for your framework\r\n\r\nNaming conventions are important because they help ensure that your code is easy to read and understand. You should choose clear and descriptive names for your classes, ids, and other selectors. Use naming conventions that are easy to remember and consistent throughout your framework.\r\n\r\n### IV. Create a prototype of your framework using HTML and CSS\r\n\r\nCreating a prototype of your framework involves building a basic structure using HTML and applying styles using CSS. This will allow you to see how your framework will look and function in a real-world scenario. Make sure your code is well-organized and easy to maintain.\r\n\r\n### V. Test your framework to ensure that it is functional and responsive\r\n\r\nOnce you have built a prototype of your framework, it&#39;s important to test it to ensure that it is functional and responsive. Test your framework on different devices and browsers to ensure that it works as expected. Make sure that it is accessible and user-friendly.\r\n\r\n### VI. Document your framework and create examples to show others how to use it\r\n\r\nFinally, you should document your framework and create examples to show others how to use it. Create documentation that explains the purpose of your framework, how to use it, and its benefits. Provide examples of how to use your framework to help others understand how it works. Make sure that your documentation is easy to understand and up-to-date.', 'lagauit', '0', 'framework', 'css', '2023-04-21 20:21:28', '2023-04-21 20:21:36');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `articlesid` int(20) NOT NULL,
  `comment` text NOT NULL,
  `name` text NOT NULL,
  `email` text NOT NULL,
  `website` text NOT NULL,
  `approved` enum('1','0') NOT NULL DEFAULT '1',
  `date_c` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `email` varchar(255) NOT NULL,
  `subject` text NOT NULL DEFAULT 'none',
  `message` text NOT NULL,
  `created_c` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contacts`
--

INSERT INTO `contacts` (`id`, `name`, `email`, `subject`, `message`, `created_c`) VALUES
(9, 'mark', 'mark@contact.me', 'need help urg', 'i have a problem with my personal website, can u help me?', '2023-04-21 17:38:49');

-- --------------------------------------------------------

--
-- Table structure for table `me`
--

CREATE TABLE `me` (
  `id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `bio` text NOT NULL,
  `pic` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `me`
--

INSERT INTO `me` (`id`, `name`, `bio`, `pic`) VALUES
(5, 'Said Lagauit', 'I\'m a web developer and I love to build things.', 'pic_64408182633642.68327156.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `role` varchar(70) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `role`) VALUES
(1, 'administrator'),
(2, 'author');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `about`
--
ALTER TABLE `about`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `me`
--
ALTER TABLE `me`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `role` (`role`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `about`
--
ALTER TABLE `about`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `articles`
--
ALTER TABLE `articles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `me`
--
ALTER TABLE `me`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;