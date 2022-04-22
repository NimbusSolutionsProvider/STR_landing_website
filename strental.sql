-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 17, 2022 at 05:14 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 7.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `strental`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` bigint(20) NOT NULL,
  `email` text DEFAULT NULL,
  `password` text DEFAULT NULL,
  `time_stamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `email`, `password`, `time_stamp`) VALUES
(1, 'admin@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b', '2022-01-23 17:36:49');

-- --------------------------------------------------------

--
-- Table structure for table `benefits`
--

CREATE TABLE `benefits` (
  `id` bigint(20) NOT NULL,
  `name` text DEFAULT NULL,
  `thought` text DEFAULT NULL,
  `time_stamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `benefits`
--

INSERT INTO `benefits` (`id`, `name`, `thought`, `time_stamp`) VALUES
(1, 'Service Enablement', 'This works as a SaaS model, providing services and support with an easily manageable platform for any rental services to use as their own to manage their rental services.', '2022-01-25 17:30:33'),
(2, 'User Friendly', 'The user experience will be pleasing with easily navigational screens and interfaces. ', '2022-01-25 17:30:51'),
(3, 'Easily Configurable', 'The SRT Software is easily configurable and will provide support for integrations, API mapping, service and payment management, language translators and others. ', '2022-01-25 17:31:07'),
(4, 'Data Management', 'We gather all the SRT, property and compliance data/information into a centralised repository. This data/information is available to our SRTs incase they need to address problems with your tenants concerning rental compliance. We keep updating our repository with data/information on a weekly/bi-weekly/monthly bases giving our SRTs a comprehensive look at everything happening with their property. ', '2022-01-25 17:31:27'),
(5, 'Multi-User Management', 'The SRT software will provide multi-user access for personalised usage. There will be login credentials for SRTs, Admin, Independent users (Complainants). The data/information access will be restricted and provided based on the logins, roles and responsibilities.', '2022-01-25 17:31:48'),
(7, 'Fully Automated WorkFlow', 'A pre-configured workflow accelerator will capture and process all the steps and tasks for rapid processing of short-term rental registrations, compliances, licenses and other details. ', '2022-01-25 17:32:53'),
(8, 'Self Hosted or SaaS', 'Savvy SRT can be deployed into your own public or private cloud infrastructure. We also offer the whole solution as a  SaaS(software as as a service). ', '2022-02-17 04:44:01'),
(9, 'Real-Time Data and Mapping', 'The SRT software provides real-time data/information to its users, automated updates and other details.', '2022-02-17 04:51:42');

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

CREATE TABLE `contact` (
  `id` bigint(20) NOT NULL,
  `name` text DEFAULT NULL,
  `email` text DEFAULT NULL,
  `subject` text DEFAULT NULL,
  `phno` text DEFAULT NULL,
  `message` text DEFAULT NULL,
  `time_stamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `contact`
--

INSERT INTO `contact` (`id`, `name`, `email`, `subject`, `phno`, `message`, `time_stamp`) VALUES
(24, 'Vansh Patpatia', 'vansh10patpatia@gmail.com', 'Demo', '+918449129069', 'Demo', '2022-01-21 12:48:09');

-- --------------------------------------------------------

--
-- Table structure for table `coreservices`
--

CREATE TABLE `coreservices` (
  `id` bigint(20) NOT NULL,
  `name` text DEFAULT NULL,
  `icon` text DEFAULT NULL,
  `time_stamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `about` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `coreservices`
--

INSERT INTO `coreservices` (`id`, `name`, `icon`, `time_stamp`, `about`) VALUES
(6, 'License Management', 'uploads/1644855159_001-driver-license.png', '2022-02-17 04:36:54', 'Easy management of new applications, licenses renewals, issue resolutions and other support. Ensure that the License are compliance'),
(7, 'Dashboard', 'uploads/1644855551_dashboard.png', '2022-02-14 16:19:11', 'A dashboard screen to display all the data/information. The data/information will be shown in a graphical form through charts/infographics.'),
(8, 'Compliance Management', 'uploads/1644855653_checklist.png', '2022-02-17 04:39:24', 'This feature allows to monitor licensed Short Term Rentals. This will allow to keep track about the rental recurrences, length of stay, duration, license number verification, and revenue projections of each Short Term Rentals registered with us.'),
(9, 'Property Management', 'uploads/1644855741_property.png', '2022-02-17 04:38:27', 'Tracking and monitoring the properties. Allows the Short Term Rental users to search through different locations for property information, their prices and other details.');

-- --------------------------------------------------------

--
-- Table structure for table `homepageslider`
--

CREATE TABLE `homepageslider` (
  `id` bigint(20) NOT NULL,
  `imageAlt` text DEFAULT NULL,
  `image` text DEFAULT NULL,
  `time_stamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `homepageslider`
--

INSERT INTO `homepageslider` (`id`, `imageAlt`, `image`, `time_stamp`) VALUES
(18, '', 'uploads/1644920454_Artboard – 5.png', '2022-02-15 10:20:54'),
(19, '', 'uploads/1644920493_Artboard – 6.png', '2022-02-15 10:21:33'),
(20, '', 'uploads/1644920543_Artboard – 8.png', '2022-02-15 10:22:23'),
(21, '', 'uploads/1644920557_Artboard – 7.png', '2022-02-15 10:22:37'),
(22, 'Adhere to Standards.  We Ensure You Be Compliant. ', 'uploads/1645072380_aa.jpg', '2022-02-17 04:33:00');

-- --------------------------------------------------------

--
-- Table structure for table `priceplan`
--

CREATE TABLE `priceplan` (
  `id` bigint(20) NOT NULL,
  `name` text DEFAULT NULL,
  `price` text DEFAULT NULL,
  `benefits` text DEFAULT NULL,
  `time_stamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `priceplan`
--

INSERT INTO `priceplan` (`id`, `name`, `price`, `benefits`, `time_stamp`) VALUES
(1, 'Personal', 'NA', 'benefits', '2022-01-21 13:47:04'),
(2, 'Business', 'NA', 'benefits', '2022-01-19 14:40:32'),
(3, 'Expert', 'NA', 'benefits', '2022-01-19 14:40:42');

-- --------------------------------------------------------

--
-- Table structure for table `queries`
--

CREATE TABLE `queries` (
  `id` bigint(20) NOT NULL,
  `name` text DEFAULT NULL,
  `email` text DEFAULT NULL,
  `message` text DEFAULT NULL,
  `time_stamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `queries` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `queries`
--

INSERT INTO `queries` (`id`, `name`, `email`, `message`, `time_stamp`, `queries`) VALUES
(1, 'Demo', 'Demo', 'Demo', '2022-01-23 17:51:59', 'Demo'),
(2, 'Demo', 'vansh10patpatia@gmail.com', 'Demo', '2022-01-23 19:15:00', 'mail'),
(3, 'Lol', 'ggg@g.com', 'Ghhhhhhhh', '2022-02-12 06:23:59', 'Ggggg');

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` bigint(20) NOT NULL,
  `name` text DEFAULT NULL,
  `icon` text DEFAULT NULL,
  `time_stamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `name`, `icon`, `time_stamp`) VALUES
(12, 'SaaS Services & Support', 'uploads/1644691181_customer-service.png', '2022-02-17 04:41:07'),
(13, 'Dedicated 24x7 Compliant Support', 'uploads/1644691228_24x7.png', '2022-02-12 18:40:28'),
(14, 'Dashboard', 'uploads/1644691275_dashboard.png', '2022-02-12 18:41:15'),
(15, 'Property Management', 'uploads/1644691311_house.png', '2022-02-12 18:41:51'),
(16, 'Notifications', 'uploads/1644691345_notification.png', '2022-02-12 18:42:25'),
(17, 'Request Exception', 'uploads/1644691379_interview.png', '2022-02-12 18:42:59'),
(18, 'Administration Support ', 'uploads/1644691429_blogger.png', '2022-02-12 18:43:49'),
(19, 'Property Identification', 'uploads/1644691465_property.png', '2022-02-12 18:44:25'),
(20, 'Geographical Location Monitoring', 'uploads/1644691528_position.png', '2022-02-12 18:45:28'),
(21, 'Fraud Monitoring', 'uploads/1644691575_fraud-alert.png', '2022-02-12 18:46:15'),
(22, 'Multi-User Management', 'uploads/1644691606_team.png', '2022-02-12 18:46:46'),
(23, 'Rental Monitoring', 'uploads/1644691724_monitoring.png', '2022-02-12 18:48:44');

-- --------------------------------------------------------

--
-- Table structure for table `testimonials`
--

CREATE TABLE `testimonials` (
  `id` bigint(20) NOT NULL,
  `name` text DEFAULT NULL,
  `thought` text DEFAULT NULL,
  `time_stamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `testimonials`
--

INSERT INTO `testimonials` (`id`, `name`, `thought`, `time_stamp`) VALUES
(1, 'Director for Major IT Company', 'One of the best complaint support process management. Resolves all my compliant issues!', '2022-01-23 18:06:01'),
(2, 'CEO of a Manufacturing Unit', 'Tracking my properties for rent is easy and managing the client and payment is also fast.', '2022-01-23 18:57:45'),
(3, 'President of a Manufacturing Unit', 'Provides all the needed compliance support. This has made easy for me to able to manage my property, and renew by compliance', '2022-01-23 18:58:03');

-- --------------------------------------------------------

--
-- Table structure for table `webconfig`
--

CREATE TABLE `webconfig` (
  `id` bigint(20) NOT NULL,
  `mainHeading` text DEFAULT NULL,
  `subHeading` text DEFAULT NULL,
  `whatWeDo` text DEFAULT NULL,
  `whatWeDoImage` text DEFAULT NULL,
  `videoLink` text DEFAULT NULL,
  `time_stamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `Name` text DEFAULT NULL,
  `facebookLink` text DEFAULT NULL,
  `instagramLink` text DEFAULT NULL,
  `youtubeLink` text DEFAULT NULL,
  `twitterLink` text DEFAULT NULL,
  `mission` text DEFAULT NULL,
  `vision` text DEFAULT NULL,
  `complaint` text DEFAULT NULL,
  `whatWeDoSubHeading` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `webconfig`
--

INSERT INTO `webconfig` (`id`, `mainHeading`, `subHeading`, `whatWeDo`, `whatWeDoImage`, `videoLink`, `time_stamp`, `Name`, `facebookLink`, `instagramLink`, `youtubeLink`, `twitterLink`, `mission`, `vision`, `complaint`, `whatWeDoSubHeading`) VALUES
(1, 'A single Stop for Short Term Rental Property Management, Compliance Management & Tracking, Monitoring, and Enforcement….', '', 'Compliance being one of the key processes that has to be completed before the SRTs (property owners) can rental their properties. Because short-term rentals are most often used by people on short vacation or holidaying, where stay might vary from a few nights to several weeks or sometimes leased for as long as a month. It becomes essential to keep track of all the properties, owners, rentals and to ensure that they are all compliant. \r\n', 'assets/Home/whatwedo.png', '', '2022-02-17 04:20:10', 'STRental', 'https://www.facebook.com', 'https://www.instagram.com', 'https://www.youtube.com', NULL, 'To build a Paradise on Earth for our clients to have comfort, happiness, and enjoyment through rental services.', 'Make every moment entertaining to ensure that our services embark a journey of a lifetime\r\nfor the rentals and make it pleasant to extend it further\r\nbettering their enjoyment and lifestyle.', 'Short-term vacation rentals have mushroomed with many communities longing to go on vacations on work or leisure. To provide the best of services, many rental providers are struggling because of enforce regulations that have to be followed to preserve security, protection, checks, quality, individual scanning and keep the surroundings communities safe. <br> <br>\r\nAt Savvy, we have been assessing the present changing situation and moulding our approach towards providing the best services and support to our clients and ensuring that our client are fully compliant for them to provide their customers with enjoyable, flexible and cost-effective stay. We have been working on various initiatives to make it comfortable for our client to make their customers stay as they are at their HOME. <br> <br>\r\nBe Compliant to provide Best and Safe Services. \r\n', 'Without being compliant, the property owners cannot perform their rental business efficiently. Savvy STR ensure the SRTs do the business RIGHT way and be complaint');

-- --------------------------------------------------------

--
-- Table structure for table `whyus`
--

CREATE TABLE `whyus` (
  `id` bigint(20) NOT NULL,
  `name` text DEFAULT NULL,
  `icon` text DEFAULT NULL,
  `time_stamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `about` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `whyus`
--

INSERT INTO `whyus` (`id`, `name`, `icon`, `time_stamp`, `about`) VALUES
(2, '24x7 Support', 'uploads/1642964166_mission.png', '2022-01-25 17:20:44', 'We work in a sophisticated platform with a self-managed and highly-skilled team tracking, monitoring all your compliant issues and resolving them. \r\n'),
(3, 'Truly Collaborative', 'uploads/1642964218_1f7ec9958ca8d8e6ae291aafdd54a8f2-sticker.png', '2022-01-25 17:21:02', 'We work encapsulated in a Matrix Organizational Structure, which enables Transparent Processes, compliant management, 24x7 support, easy complaints, Bridging Geographies and reaching clients\r\n'),
(4, 'Customer Centric ', 'uploads/1643131300_user-manage.png', '2022-01-25 17:21:40', 'Provide sophisticated features specifically for customers – dashboard, tracking & monitoring their properties, compliant and also raise issues/concerns/complaints and get them resolved \r\n'),
(5, 'Self-Packed Portal', 'uploads/1643131324_propmanage.png', '2022-01-25 17:22:04', 'A portal, that is self-driven and will provide all the information as needed. Property, Geolocation, Rentals, Time duration, rates, client management, compliant and other details\r\n'),
(6, 'User-Friendly', 'uploads/1643131367_notif.png', '2022-01-25 17:22:47', 'Easily navigationally and highly interactive, allows you to enter and access data/information. This will allow to accessible with fully-automated backend processes and data management'),
(7, 'Privacy', 'uploads/1643131389_location.png', '2022-01-25 17:23:09', 'All the personal and professional data will be kept secured and protected and will be available only through authenticated login for multiple user logins\r\n');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `benefits`
--
ALTER TABLE `benefits`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `coreservices`
--
ALTER TABLE `coreservices`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `homepageslider`
--
ALTER TABLE `homepageslider`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `priceplan`
--
ALTER TABLE `priceplan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `queries`
--
ALTER TABLE `queries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `testimonials`
--
ALTER TABLE `testimonials`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `webconfig`
--
ALTER TABLE `webconfig`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `whyus`
--
ALTER TABLE `whyus`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `benefits`
--
ALTER TABLE `benefits`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `contact`
--
ALTER TABLE `contact`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `coreservices`
--
ALTER TABLE `coreservices`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `homepageslider`
--
ALTER TABLE `homepageslider`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `priceplan`
--
ALTER TABLE `priceplan`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `queries`
--
ALTER TABLE `queries`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `testimonials`
--
ALTER TABLE `testimonials`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `webconfig`
--
ALTER TABLE `webconfig`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `whyus`
--
ALTER TABLE `whyus`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
