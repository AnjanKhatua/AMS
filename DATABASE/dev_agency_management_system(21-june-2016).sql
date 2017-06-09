-- phpMyAdmin SQL Dump
-- version 4.0.10.7
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 21, 2016 at 06:43 AM
-- Server version: 5.5.45-cll-lve
-- PHP Version: 5.4.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `dev_agency_management_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `ams_booking`
--

CREATE TABLE IF NOT EXISTS `ams_booking` (
  `booking_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `staff_request_id` int(10) unsigned NOT NULL,
  `staff_id` int(10) unsigned NOT NULL,
  `confirmation_date` date NOT NULL,
  `confirmation_time` time NOT NULL,
  `confirm_by_whom` enum('D','A','C','M') COLLATE utf8_unicode_ci NOT NULL COMMENT 'D=> Director/Super visor,A=>Admin,C=>Co-ordinator,M=>Manager',
  `cancellation_date` date NOT NULL,
  `cancellation_time` time NOT NULL,
  `cancel_by_whom` int(10) unsigned NOT NULL,
  `cancel_requested_by` enum('D','A','C','M','S','H') COLLATE utf8_unicode_ci NOT NULL COMMENT 'D=> Director/Super visor,A=>Admin,C=>Co-ordinator,M=>Manager,S=>Staff himself/Herself, H=>Hospital',
  PRIMARY KEY (`booking_id`),
  KEY `staff_id` (`staff_id`),
  KEY `staff_request_id` (`staff_request_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=15 ;

--
-- Dumping data for table `ams_booking`
--

INSERT INTO `ams_booking` (`booking_id`, `staff_request_id`, `staff_id`, `confirmation_date`, `confirmation_time`, `confirm_by_whom`, `cancellation_date`, `cancellation_time`, `cancel_by_whom`, `cancel_requested_by`) VALUES
(1, 6, 12, '2016-06-16', '15:07:09', 'A', '2016-06-17', '15:37:08', 1, 'A'),
(2, 7, 13, '2016-06-16', '16:54:31', 'A', '0000-00-00', '00:00:00', 0, ''),
(3, 8, 12, '2016-06-16', '19:11:21', 'A', '2016-06-16', '19:19:24', 1, 'M'),
(4, 2, 12, '2016-06-16', '18:54:52', 'A', '0000-00-00', '00:00:00', 0, ''),
(5, 8, 10, '2016-06-17', '11:12:14', 'A', '0000-00-00', '00:00:00', 0, ''),
(6, 9, 12, '2016-06-17', '12:38:55', 'A', '2016-06-17', '12:42:52', 1, 'A'),
(7, 9, 13, '2016-06-17', '12:44:12', 'A', '0000-00-00', '00:00:00', 0, ''),
(8, 1, 14, '2016-06-17', '12:46:55', 'A', '0000-00-00', '00:00:00', 0, ''),
(9, 11, 13, '2016-06-17', '14:09:58', 'A', '2016-06-20', '19:11:43', 20, 'H'),
(10, 11, 12, '2016-06-17', '14:10:02', 'A', '0000-00-00', '00:00:00', 0, ''),
(11, 6, 5, '2016-06-17', '15:37:14', 'A', '0000-00-00', '00:00:00', 0, ''),
(12, 11, 19, '2016-06-20', '19:11:55', 'A', '0000-00-00', '00:00:00', 0, ''),
(13, 12, 12, '2016-06-20', '19:32:16', 'A', '0000-00-00', '00:00:00', 0, ''),
(14, 13, 21, '2016-06-20', '21:43:06', 'A', '2016-06-20', '21:43:59', 20, 'S');

-- --------------------------------------------------------

--
-- Table structure for table `ams_document_header`
--

CREATE TABLE IF NOT EXISTS `ams_document_header` (
  `document_header_id` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `header_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `active_status` enum('Y','N') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Y',
  PRIMARY KEY (`document_header_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=6 ;

--
-- Dumping data for table `ams_document_header`
--

INSERT INTO `ams_document_header` (`document_header_id`, `header_name`, `active_status`) VALUES
(1, 'Visa', 'Y'),
(2, 'DBS', 'Y'),
(3, 'MVA', 'Y'),
(5, 'maybo', 'Y');

-- --------------------------------------------------------

--
-- Table structure for table `ams_enquiry`
--

CREATE TABLE IF NOT EXISTS `ams_enquiry` (
  `enquiry_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `staff_id` int(10) unsigned NOT NULL,
  `staff_request_id` int(10) unsigned NOT NULL,
  `enquired_by` int(10) unsigned NOT NULL,
  `availability_confirmed_by_staff` enum('Y','N') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'N',
  `availability_confirmed_via` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `confirmed_by` enum('A','C','M','S') COLLATE utf8_unicode_ci NOT NULL COMMENT 'A=>Admin,C=>Co-ordinator,M=>Manager,S=>Staff himself/Herself',
  `agent_user_id` int(10) unsigned NOT NULL,
  `is_confirmed` enum('Y','N') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'N',
  PRIMARY KEY (`enquiry_id`),
  KEY `staff_request_id` (`staff_request_id`),
  KEY `agent_user_id` (`agent_user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `ams_global_setting`
--

CREATE TABLE IF NOT EXISTS `ams_global_setting` (
  `id` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `field_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `field_value` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `ams_global_setting`
--

INSERT INTO `ams_global_setting` (`id`, `field_name`, `field_value`) VALUES
(1, 'Cancel notification count', '5'),
(2, 'Pagination', '10');

-- --------------------------------------------------------

--
-- Table structure for table `ams_grade`
--

CREATE TABLE IF NOT EXISTS `ams_grade` (
  `grade_id` int(3) unsigned NOT NULL AUTO_INCREMENT,
  `grade_name` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `grade_active_status` enum('Y','N') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'N',
  PRIMARY KEY (`grade_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `ams_grade`
--

INSERT INTO `ams_grade` (`grade_id`, `grade_name`, `grade_active_status`) VALUES
(1, 'RGN', 'Y'),
(2, 'RMN', 'Y'),
(3, 'RNLD', 'Y');

-- --------------------------------------------------------

--
-- Table structure for table `ams_holiday`
--

CREATE TABLE IF NOT EXISTS `ams_holiday` (
  `holiday_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `staff_id` int(10) unsigned NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  PRIMARY KEY (`holiday_id`),
  KEY `staff_id` (`staff_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `ams_holiday`
--

INSERT INTO `ams_holiday` (`holiday_id`, `staff_id`, `start_date`, `end_date`) VALUES
(2, 14, '2016-06-23', '2016-06-27');

-- --------------------------------------------------------

--
-- Table structure for table `ams_hospital_registration`
--

CREATE TABLE IF NOT EXISTS `ams_hospital_registration` (
  `hospital_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `hospital_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `hospital_status` enum('A','I','S') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'I' COMMENT 'A=> Active, I => Inactive, S=> Suspended',
  PRIMARY KEY (`hospital_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=8 ;

--
-- Dumping data for table `ams_hospital_registration`
--

INSERT INTO `ams_hospital_registration` (`hospital_id`, `hospital_name`, `hospital_status`) VALUES
(1, 'Gr A', 'A'),
(2, 'Gr B', 'A'),
(3, 'Gr C', 'I'),
(4, 'Neuven Solutions', 'A'),
(5, 'HC ONE', 'A'),
(6, 'Four Seasons Health Care Limited', 'A'),
(7, 'AMRI Hospital', 'A');

-- --------------------------------------------------------

--
-- Table structure for table `ams_hospital_unit`
--

CREATE TABLE IF NOT EXISTS `ams_hospital_unit` (
  `hospital_unit_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `hospital_id` int(10) unsigned NOT NULL,
  `hospital_unit` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `address` text COLLATE utf8_unicode_ci NOT NULL,
  `local_area_id` int(5) unsigned NOT NULL,
  `email` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `contact_number` bigint(15) unsigned NOT NULL,
  `hospital_unit_active_status` enum('Y','N') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'N',
  PRIMARY KEY (`hospital_unit_id`),
  KEY `hospital_id` (`hospital_id`),
  KEY `local_area_id` (`local_area_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=9 ;

--
-- Dumping data for table `ams_hospital_unit`
--

INSERT INTO `ams_hospital_unit` (`hospital_unit_id`, `hospital_id`, `hospital_unit`, `address`, `local_area_id`, `email`, `contact_number`, `hospital_unit_active_status`) VALUES
(1, 1, 'A Unit 1', 'UK', 1, 'mail@mail.com', 111111, 'Y'),
(2, 1, 'A Unit 2', 'Uk', 2, 'mail@mail.com', 2222222222, 'Y'),
(3, 2, 'Man Hospi', 'UK', 3, 'mail@mail.com', 333333, 'Y'),
(4, 2, 'B Unit 2', 'UK', 2, 'mail@mail.com', 333333, 'Y'),
(5, 4, 'Wasthills', '11\r\nDunmail Drive', 4, 'wasthills@gmail.com', 7872859641, 'Y'),
(6, 7, 'ABC', 'ASDF', 1, 'asa@dsd.kl', 1234567890, 'Y'),
(7, 4, 'Cedavale', 'Nottingham', 5, 'cedar@gmail.com', 74258715752, 'Y'),
(8, 4, 'Whorlton Hall', 'Cumbria', 1, 'whorlton@gmail.co.uk', 12345, 'Y');

-- --------------------------------------------------------

--
-- Table structure for table `ams_job_type`
--

CREATE TABLE IF NOT EXISTS `ams_job_type` (
  `job_type_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `job_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `job_type_active_status` enum('Y','N') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'N',
  PRIMARY KEY (`job_type_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=6 ;

--
-- Dumping data for table `ams_job_type`
--

INSERT INTO `ams_job_type` (`job_type_id`, `job_type`, `job_type_active_status`) VALUES
(1, 'Nurse', 'Y'),
(2, 'Nurse-RGN', 'Y'),
(3, 'Nurse-RMN', 'Y'),
(4, 'Support worker', 'Y'),
(5, 'Health Care Assistant', 'Y');

-- --------------------------------------------------------

--
-- Table structure for table `ams_non_availability_of_staff`
--

CREATE TABLE IF NOT EXISTS `ams_non_availability_of_staff` (
  `non_availablility_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `staff_id` int(10) unsigned NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `already_booked` enum('Y','N') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'N',
  PRIMARY KEY (`non_availablility_id`),
  KEY `staff_id` (`staff_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=34 ;

--
-- Dumping data for table `ams_non_availability_of_staff`
--

INSERT INTO `ams_non_availability_of_staff` (`non_availablility_id`, `staff_id`, `start_date`, `end_date`, `start_time`, `end_time`, `already_booked`) VALUES
(1, 14, '2016-06-16', '2016-06-17', '06:00:00', '12:00:00', 'N'),
(3, 10, '2016-06-27', '2016-06-30', '09:00:00', '14:00:00', 'Y'),
(9, 10, '2016-06-16', '2016-06-17', '12:01:00', '17:00:00', 'Y'),
(11, 11, '2016-06-16', '2016-06-18', '13:00:00', '15:00:00', 'Y'),
(15, 12, '2016-06-15', '2016-06-15', '18:00:00', '22:00:00', 'Y'),
(19, 12, '2016-12-09', '2016-12-09', '06:00:00', '12:00:00', 'Y'),
(20, 12, '2016-06-16', '2016-06-17', '20:00:00', '08:00:00', 'Y'),
(21, 10, '2016-06-16', '2016-06-17', '20:00:00', '08:00:00', 'Y'),
(26, 14, '2016-12-09', '2016-12-09', '12:01:00', '17:00:00', 'Y'),
(29, 12, '2016-06-18', '2016-06-18', '07:00:00', '18:00:00', 'Y'),
(30, 5, '2016-06-15', '2016-06-15', '18:00:00', '22:00:00', 'Y'),
(31, 19, '2016-06-18', '2016-06-18', '07:00:00', '18:00:00', 'Y'),
(32, 12, '2016-06-22', '2016-06-23', '20:00:00', '08:00:00', 'Y'),
(33, 21, '2016-06-21', '2016-06-22', '20:00:00', '08:00:00', 'Y');

-- --------------------------------------------------------

--
-- Table structure for table `ams_pay_type`
--

CREATE TABLE IF NOT EXISTS `ams_pay_type` (
  `pay_type_id` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `pay_type` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `pay_type_active_status` enum('Y','N') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'N',
  PRIMARY KEY (`pay_type_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- Dumping data for table `ams_pay_type`
--

INSERT INTO `ams_pay_type` (`pay_type_id`, `pay_type`, `pay_type_active_status`) VALUES
(1, 'PAYE', 'Y'),
(2, 'ELIAS', 'Y'),
(3, 'LTD', 'Y'),
(4, 'Plus Income', 'Y');

-- --------------------------------------------------------

--
-- Table structure for table `ams_regular_non_availability_of_staff`
--

CREATE TABLE IF NOT EXISTS `ams_regular_non_availability_of_staff` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `non_availablility_id` bigint(20) unsigned NOT NULL,
  `date` date NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `already_booked` enum('Y','N') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'N',
  PRIMARY KEY (`id`),
  KEY `staff_id` (`non_availablility_id`),
  KEY `non_availablility_id` (`non_availablility_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=65 ;

--
-- Dumping data for table `ams_regular_non_availability_of_staff`
--

INSERT INTO `ams_regular_non_availability_of_staff` (`id`, `non_availablility_id`, `date`, `start_time`, `end_time`, `already_booked`) VALUES
(1, 1, '2016-06-16', '06:00:00', '12:00:00', 'N'),
(2, 1, '2016-06-17', '06:00:00', '12:00:00', 'N'),
(7, 3, '2016-06-27', '09:00:00', '14:00:00', 'Y'),
(8, 3, '2016-06-28', '09:00:00', '14:00:00', 'Y'),
(9, 3, '2016-06-29', '09:00:00', '14:00:00', 'Y'),
(10, 3, '2016-06-30', '09:00:00', '14:00:00', 'Y'),
(22, 9, '2016-06-16', '12:01:00', '17:00:00', 'Y'),
(23, 9, '2016-06-17', '12:01:00', '17:00:00', 'Y'),
(27, 11, '2016-06-16', '13:00:00', '15:00:00', 'Y'),
(28, 11, '2016-06-17', '13:00:00', '15:00:00', 'Y'),
(29, 11, '2016-06-18', '13:00:00', '15:00:00', 'Y'),
(35, 15, '2016-06-15', '18:00:00', '22:00:00', 'Y'),
(42, 19, '2016-12-09', '06:00:00', '12:00:00', 'Y'),
(43, 20, '2016-06-16', '20:00:00', '08:00:00', 'Y'),
(44, 20, '2016-06-17', '20:00:00', '08:00:00', 'Y'),
(45, 21, '2016-06-16', '20:00:00', '08:00:00', 'Y'),
(46, 21, '2016-06-17', '20:00:00', '08:00:00', 'Y'),
(55, 26, '2016-12-09', '12:01:00', '17:00:00', 'Y'),
(58, 29, '2016-06-18', '07:00:00', '18:00:00', 'Y'),
(59, 30, '2016-06-15', '18:00:00', '22:00:00', 'Y'),
(60, 31, '2016-06-18', '07:00:00', '18:00:00', 'Y'),
(61, 32, '2016-06-22', '20:00:00', '08:00:00', 'Y'),
(62, 32, '2016-06-23', '20:00:00', '08:00:00', 'Y'),
(63, 33, '2016-06-21', '20:00:00', '08:00:00', 'Y'),
(64, 33, '2016-06-22', '20:00:00', '08:00:00', 'Y');

-- --------------------------------------------------------

--
-- Table structure for table `ams_service_completed`
--

CREATE TABLE IF NOT EXISTS `ams_service_completed` (
  `service_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `staff_id` int(10) unsigned NOT NULL,
  `enquiry_id` int(10) unsigned NOT NULL,
  `hospital_unit_id` int(10) unsigned NOT NULL,
  `booking_id` int(11) unsigned NOT NULL,
  `date` date NOT NULL,
  `shift_start_time` time NOT NULL,
  `shift_end_time` time NOT NULL,
  `staff_category` int(3) unsigned NOT NULL,
  PRIMARY KEY (`service_id`),
  KEY `staff_id` (`staff_id`),
  KEY `enquiry_id` (`enquiry_id`),
  KEY `hospital_unit_id` (`hospital_unit_id`),
  KEY `booking_id` (`booking_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `ams_shift_enquiry_ack`
--

CREATE TABLE IF NOT EXISTS `ams_shift_enquiry_ack` (
  `enquiry_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `staff_id` int(10) unsigned NOT NULL,
  `staff_request_id` int(10) unsigned NOT NULL,
  `enquired_by` int(10) unsigned NOT NULL,
  `availability_confirmed_by_staff` enum('Y','N') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'N',
  `availability_confirmed_via` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `confirmed_by` enum('D','A','C','M','S','NA') COLLATE utf8_unicode_ci NOT NULL COMMENT 'D=> Director/Super visor,A=>Admin,C=>Co-ordinator,M=>Manager,S=>Staff himself/Herself, ''NA''=> Not applicable',
  `agent_user_id` int(10) unsigned NOT NULL,
  `is_confirmed` enum('Y','N') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'N',
  PRIMARY KEY (`enquiry_id`),
  KEY `staff_request_id` (`staff_request_id`),
  KEY `agent_user_id` (`agent_user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=37 ;

--
-- Dumping data for table `ams_shift_enquiry_ack`
--

INSERT INTO `ams_shift_enquiry_ack` (`enquiry_id`, `staff_id`, `staff_request_id`, `enquired_by`, `availability_confirmed_by_staff`, `availability_confirmed_via`, `confirmed_by`, `agent_user_id`, `is_confirmed`) VALUES
(2, 10, 3, 1, 'Y', 'By email', 'A', 1, 'N'),
(3, 11, 3, 1, 'Y', 'By email', 'A', 1, 'N'),
(4, 12, 3, 1, 'Y', 'Dashboard', 'S', 1, 'N'),
(5, 14, 3, 1, 'Y', 'By phone', 'A', 1, 'N'),
(8, 14, 5, 14, 'Y', 'Dashboard', 'S', 1, 'N'),
(9, 11, 1, 1, 'Y', 'By phone', 'A', 1, 'N'),
(10, 13, 1, 1, 'Y', 'By phone', 'A', 1, 'N'),
(11, 10, 1, 1, 'Y', 'By phone', 'A', 1, 'N'),
(12, 13, 5, 1, 'Y', 'By phone', 'A', 1, 'N'),
(13, 11, 5, 1, 'Y', 'By phone', 'A', 1, 'N'),
(14, 13, 4, 1, 'Y', 'By phone', 'A', 1, 'N'),
(16, 12, 6, 1, 'Y', 'By phone', 'A', 1, 'Y'),
(18, 13, 7, 1, 'Y', 'By phone', 'A', 1, 'Y'),
(19, 12, 8, 12, 'Y', 'Dashboard', 'S', 1, 'Y'),
(20, 12, 2, 1, 'Y', 'By phone', 'A', 1, 'Y'),
(21, 10, 8, 1, 'Y', 'By phone', 'A', 1, 'Y'),
(22, 12, 9, 1, 'Y', 'By phone', 'A', 1, 'Y'),
(23, 13, 9, 1, 'Y', 'By phone', 'A', 1, 'Y'),
(25, 14, 1, 14, 'Y', 'Dashboard', 'S', 1, 'Y'),
(26, 12, 11, 1, 'Y', 'By phone', 'A', 1, 'Y'),
(27, 13, 11, 1, 'Y', 'By phone', 'A', 1, 'Y'),
(28, 7, 5, 1, 'Y', 'By phone', 'A', 1, 'N'),
(29, 5, 6, 1, 'Y', 'By phone', 'A', 1, 'Y'),
(30, 10, 2, 10, 'Y', 'Dashboard', 'S', 0, 'N'),
(31, 19, 11, 20, 'Y', 'By phone', 'A', 20, 'Y'),
(32, 12, 12, 12, 'Y', 'Dashboard', 'S', 20, 'Y'),
(33, 21, 13, 21, 'Y', 'Dashboard', 'S', 20, 'Y'),
(35, 17, 13, 20, 'Y', 'By phone', 'A', 0, 'N'),
(36, 14, 13, 14, 'Y', 'Dashboard', 'S', 0, 'N');

-- --------------------------------------------------------

--
-- Table structure for table `ams_shift_management_for_hospital`
--

CREATE TABLE IF NOT EXISTS `ams_shift_management_for_hospital` (
  `staff_request_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `hospital_unit_id` int(10) unsigned NOT NULL,
  `ward_id` int(10) unsigned NOT NULL,
  `job_type_id` int(10) unsigned NOT NULL,
  `quantity` int(3) unsigned NOT NULL,
  `quantity_confirmed` int(3) unsigned NOT NULL,
  `shift_start_datetime` datetime NOT NULL,
  `shift_end_datetime` datetime NOT NULL,
  `requested_date` date NOT NULL,
  `requested_time` time NOT NULL,
  `requested_person` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `request_accepted_by` int(10) unsigned NOT NULL,
  `requested_person_mobile_number` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `notes` text COLLATE utf8_unicode_ci NOT NULL,
  `status` enum('A','C','R') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'A' COMMENT 'A=> Active, C => Confirmed, R=> Rejected',
  PRIMARY KEY (`staff_request_id`),
  KEY `hospital_unit_id` (`hospital_unit_id`),
  KEY `job_type_id` (`job_type_id`),
  KEY `request_accepted_by` (`request_accepted_by`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=17 ;

--
-- Dumping data for table `ams_shift_management_for_hospital`
--

INSERT INTO `ams_shift_management_for_hospital` (`staff_request_id`, `hospital_unit_id`, `ward_id`, `job_type_id`, `quantity`, `quantity_confirmed`, `shift_start_datetime`, `shift_end_datetime`, `requested_date`, `requested_time`, `requested_person`, `request_accepted_by`, `requested_person_mobile_number`, `notes`, `status`) VALUES
(1, 1, 1, 1, 3, 1, '2016-12-09 12:01:00', '2016-12-09 17:00:00', '2016-06-16', '04:00:00', 'Alex', 1, '111111', 'None', 'A'),
(2, 1, 2, 4, 5, 1, '2016-12-09 06:00:00', '2016-12-09 12:00:00', '2016-06-16', '04:00:00', 'Alex', 1, '111111', 'None', 'A'),
(3, 1, 3, 3, 2, 0, '2016-06-27 09:00:00', '2016-06-30 14:00:00', '2016-06-16', '04:00:00', 'Alex', 1, '111111', 'None', 'A'),
(4, 1, 1, 1, 1, 0, '2016-06-16 04:00:00', '2016-06-18 14:00:00', '2016-06-16', '04:00:00', 'Alex', 1, '111111', 'None', 'A'),
(5, 1, 1, 1, 1, 0, '2016-06-16 13:00:00', '2016-06-18 15:00:00', '2016-06-16', '07:00:00', 'Alex', 5, '546', 'None', 'A'),
(6, 5, 4, 5, 1, 1, '2016-06-15 18:00:00', '2016-06-15 22:00:00', '2016-06-15', '10:00:00', 'usaf', 11, '7872859641', '', 'A'),
(7, 5, 4, 1, 1, 1, '2016-06-16 20:00:00', '2016-06-17 08:00:00', '2016-06-16', '16:52:00', 'jan', 1, '7872859641', '', 'A'),
(8, 3, 4, 4, 1, 1, '2016-06-16 20:00:00', '2016-06-17 08:00:00', '2016-06-16', '18:20:00', 'jan', 1, '333333', 'Men need', 'A'),
(9, 7, 4, 4, 1, 1, '2016-06-21 20:00:00', '2016-06-22 08:00:00', '2016-06-17', '11:47:00', 'Jan', 1, '74258715752', '', 'A'),
(10, 8, 4, 3, 5, 0, '2016-06-17 20:00:00', '2016-06-18 08:00:00', '2016-06-17', '14:06:00', 'jan', 1, '12345', 'Men nurses', 'A'),
(11, 8, 4, 4, 2, 2, '2016-06-18 07:00:00', '2016-06-18 18:00:00', '2016-06-17', '14:06:00', 'jan', 1, '12345', 'Men nurses', 'A'),
(12, 3, 3, 4, 1, 1, '2016-06-22 20:00:00', '2016-06-23 08:00:00', '2016-06-20', '19:29:00', 'hz', 20, '333333', '', 'A'),
(13, 7, 4, 1, 1, 0, '2016-06-21 20:00:00', '2016-06-22 08:00:00', '2016-06-20', '21:31:00', 'jan', 20, '74258715752', '', 'A'),
(14, 5, 1, 1, 3, 0, '2016-07-16 12:00:00', '2016-07-17 20:00:00', '2016-06-22', '08:00:00', 'Alex', 20, '7872859641', 'None', 'A'),
(15, 5, 2, 3, 5, 0, '2016-07-18 09:00:00', '2016-07-21 17:00:00', '2016-06-22', '08:00:00', 'Alex', 20, '7872859641', 'None', 'A'),
(16, 5, 3, 2, 7, 0, '2016-07-20 10:00:00', '2016-07-25 18:00:00', '2016-06-22', '08:00:00', 'Alex', 20, '7872859641', 'None', 'A');

-- --------------------------------------------------------

--
-- Table structure for table `ams_staff_document`
--

CREATE TABLE IF NOT EXISTS `ams_staff_document` (
  `document_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `staff_id` int(10) unsigned NOT NULL,
  `document_header_id` int(5) unsigned NOT NULL,
  `document_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`document_id`),
  KEY `staff_id` (`staff_id`),
  KEY `document_header_id` (`document_header_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `ams_staff_document`
--

INSERT INTO `ams_staff_document` (`document_id`, `staff_id`, `document_header_id`, `document_name`) VALUES
(3, 5, 1, '1465988924-AMS - Menu.docx');

-- --------------------------------------------------------

--
-- Table structure for table `ams_staff_job_type_map`
--

CREATE TABLE IF NOT EXISTS `ams_staff_job_type_map` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `staff_id` int(10) unsigned NOT NULL,
  `job_type_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=157 ;

--
-- Dumping data for table `ams_staff_job_type_map`
--

INSERT INTO `ams_staff_job_type_map` (`id`, `staff_id`, `job_type_id`) VALUES
(12, 1, 4),
(13, 5, 1),
(14, 5, 2),
(15, 5, 3),
(16, 6, 1),
(17, 6, 2),
(19, 3, 4),
(21, 8, 4),
(22, 9, 1),
(23, 9, 2),
(24, 7, 4),
(25, 4, 4),
(29, 11, 1),
(30, 11, 2),
(91, 35, 1),
(92, 35, 2),
(93, 36, 1),
(94, 36, 2),
(96, 37, 1),
(97, 37, 3),
(98, 37, 4),
(99, 38, 1),
(100, 38, 2),
(101, 38, 3),
(102, 39, 2),
(103, 39, 3),
(104, 40, 2),
(105, 40, 3),
(106, 40, 4),
(107, 41, 1),
(108, 41, 2),
(109, 41, 5),
(110, 42, 4),
(111, 42, 5),
(112, 43, 1),
(113, 43, 4),
(114, 44, 3),
(115, 44, 4),
(116, 44, 5),
(117, 45, 2),
(118, 45, 3),
(119, 46, 1),
(120, 46, 3),
(121, 46, 4),
(122, 47, 3),
(123, 47, 4),
(124, 48, 1),
(125, 48, 2),
(126, 48, 3),
(127, 49, 4),
(128, 49, 5),
(129, 50, 4),
(130, 50, 5),
(131, 51, 1),
(132, 51, 2),
(133, 52, 2),
(134, 52, 3),
(135, 52, 4),
(136, 53, 3),
(137, 53, 4),
(138, 53, 5),
(139, 54, 2),
(140, 54, 3),
(141, 54, 4),
(142, 55, 1),
(143, 55, 2),
(144, 56, 3),
(145, 56, 4),
(146, 56, 5),
(147, 57, 2),
(148, 57, 3),
(149, 57, 4),
(150, 58, 3),
(151, 58, 4),
(152, 58, 5),
(153, 59, 4),
(154, 59, 5),
(155, 60, 2),
(156, 60, 3);

-- --------------------------------------------------------

--
-- Table structure for table `ams_staff_registration`
--

CREATE TABLE IF NOT EXISTS `ams_staff_registration` (
  `staff_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `start_date` date NOT NULL,
  `first_name` varchar(75) COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(75) COLLATE utf8_unicode_ci NOT NULL,
  `gender` enum('Male','Female') COLLATE utf8_unicode_ci NOT NULL,
  `date_of_birth` date NOT NULL,
  `ni_no` varchar(9) COLLATE utf8_unicode_ci NOT NULL,
  `nationality` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `passport_no` varchar(9) COLLATE utf8_unicode_ci NOT NULL,
  `passport_issue_date` date NOT NULL,
  `passport_expiry_date` date NOT NULL,
  `visa_type` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `visa_no` bigint(16) unsigned NOT NULL,
  `visa_issue_date` date NOT NULL,
  `visa_expiry_date` date NOT NULL,
  `pay_type_id` int(5) unsigned NOT NULL,
  `company_name` text COLLATE utf8_unicode_ci NOT NULL,
  `company_no` int(11) unsigned NOT NULL,
  `date_of_incorporation` date NOT NULL,
  `bank_details` text COLLATE utf8_unicode_ci NOT NULL,
  `sort_code` int(6) unsigned NOT NULL,
  `account_no` int(11) unsigned NOT NULL,
  `email` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `mobile_no` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `telephone` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `address_1` text COLLATE utf8_unicode_ci NOT NULL,
  `address_2` text COLLATE utf8_unicode_ci NOT NULL,
  `city` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `town` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `post_code` int(8) unsigned NOT NULL,
  `country` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `dbs_number` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `dbs_issue_date` date NOT NULL,
  `dbs_expiry` date NOT NULL,
  `mandatory_training_expiry_date` date NOT NULL,
  `mva_expiry_date` date NOT NULL,
  `maybo_training_expiry` date NOT NULL,
  `pin_number` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `pin_expiry_date` date NOT NULL,
  `max_allowed_hour` int(5) NOT NULL,
  `shift_confirmation_count` int(5) unsigned NOT NULL,
  `shift_cancellation_count` int(5) unsigned NOT NULL,
  `staff_status` enum('D','A','I','S','Ar') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'I' COMMENT 'D=>Draft, A=> Active, I => Inactive, S=> Suspended,Ar=>Archive',
  PRIMARY KEY (`staff_id`),
  KEY `pay_type_id` (`pay_type_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=61 ;

--
-- Dumping data for table `ams_staff_registration`
--

INSERT INTO `ams_staff_registration` (`staff_id`, `start_date`, `first_name`, `last_name`, `gender`, `date_of_birth`, `ni_no`, `nationality`, `passport_no`, `passport_issue_date`, `passport_expiry_date`, `visa_type`, `visa_no`, `visa_issue_date`, `visa_expiry_date`, `pay_type_id`, `company_name`, `company_no`, `date_of_incorporation`, `bank_details`, `sort_code`, `account_no`, `email`, `mobile_no`, `telephone`, `address_1`, `address_2`, `city`, `town`, `post_code`, `country`, `dbs_number`, `dbs_issue_date`, `dbs_expiry`, `mandatory_training_expiry_date`, `mva_expiry_date`, `maybo_training_expiry`, `pin_number`, `pin_expiry_date`, `max_allowed_hour`, `shift_confirmation_count`, `shift_cancellation_count`, `staff_status`) VALUES
(1, '2016-06-03', 'Paul', 'Duke', 'Male', '1985-06-05', '11111', 'UK', '11111', '2016-06-03', '2016-12-31', 'Work', 11111, '2016-06-30', '2017-06-15', 1, 'Test', 112121, '2017-06-15', 'Test', 1111, 1212121, 'admin@gmail.com', '4096', '4096', 'test', 'test', 'test', 'test', 11111, 'UK', '121212', '2016-06-03', '2016-06-30', '2016-06-30', '2016-06-30', '2016-06-30', '', '2016-06-30', 10, 0, 0, 'A'),
(3, '2016-06-15', 'Anita', 'Barry', 'Female', '1975-09-03', 'SC007949B', 'ZIMBABWEAN', '12345', '2016-06-15', '2016-07-14', 'Residence PermitRefugee Settlement', 0, '2008-02-12', '2018-02-12', 2, 'Anita Barry LTD', 1234, '2018-02-12', 'bar', 123456, 123456, 'anita@gmail.com', '123456769', '356456456', '92 Dale Lane', 'Appleton', 'Nottingham', 'Nottingham', 0, 'United Kingdom', 'A1254A', '2016-06-15', '2016-08-31', '2016-07-16', '2016-07-30', '2016-07-30', '', '2016-07-30', 30, 0, 0, 'A'),
(4, '2016-06-15', 'Moses', 'Madamombe', 'Male', '1952-05-15', 'SE635904A', 'Irish', 'PQ4582655', '2015-03-24', '2025-03-23', 'NA', 0, '2016-06-15', '2016-07-31', 2, 'Elias', 12345, '2016-07-31', 'bar', 852145, 3456354, 'gzollo2001@yahoo.com', '53634534', '3655356546', '2 Beech Grove', 'watson', 'Walton', 'Walton', 0, 'United Kingdom', '12345', '2016-06-06', '2016-07-14', '2016-07-30', '2016-07-27', '2016-06-13', '', '2016-06-25', 30, 0, 0, 'A'),
(5, '2016-06-15', 'Test', 'Test', 'Male', '1981-06-01', '111111A', 'German', 'qq11qq111', '2016-06-01', '2017-06-22', 'Test', 111111, '2016-05-03', '2021-06-09', 2, 'asd', 11, '2016-06-30', 'asd', 11111, 111111, 'staff1@gmail.com', '123323456', '25438232565', 'asd', 'asd', 'ree', 'asd', 1111, 'Germany', '42311425412', '2016-04-30', '2016-12-30', '2016-12-31', '2016-12-31', '2016-12-29', '', '2016-11-30', 120, 0, 0, 'A'),
(6, '0000-00-00', 'Idio', 'Chiran', 'Male', '1986-04-14', '1111', 'Uk', '11111', '0000-00-00', '0000-00-00', 'Work', 11111, '0000-00-00', '2017-01-31', 1, '', 0, '0000-00-00', '', 0, 0, '', '', '4096', '', '', '', '', 0, 'United Kingdom', '', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '', '0000-00-00', 0, 0, 0, 'I'),
(7, '0000-00-00', 'Royes', 'Sanda', 'Male', '1986-06-17', 'SH263321D', 'Sri lanka', '', '0000-00-00', '0000-00-00', '', 0, '0000-00-00', '2019-06-06', 3, '', 0, '2019-06-06', '', 0, 0, 'msand@gmail.com', '07432288762', '07432288762', '', '', '', '', 0, 'United Kingdom', '', '0000-00-00', '2018-06-20', '0000-00-00', '0000-00-00', '0000-00-00', '', '0000-00-00', 0, 0, 0, 'A'),
(8, '0000-00-00', 'Alpha', 'Alphaa', 'Male', '1963-06-19', 'SH123456B', 'Irish', 'PQ4582655', '0000-00-00', '0000-00-00', '', 0, '0000-00-00', '2016-06-17', 3, '', 0, '0000-00-00', '', 0, 0, 'alpha@yahoo.com', '07432288762', '07432288762', '2 Beech Grove', '', 'Walton', 'Walton', 0, 'United Kingdom', '', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '', '0000-00-00', 0, 0, 0, 'A'),
(9, '0000-00-00', 'Tony', 'Dukesdfsd', 'Male', '1994-06-01', '434d3d3dd', 'German', '', '0000-00-00', '0000-00-00', '', 0, '0000-00-00', '2023-06-07', 1, '', 0, '2023-06-07', '', 0, 0, 'aa@aa.qq', '', '25438232565', '', '', '', '', 0, 'United Kingdom', '', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '', '0000-00-00', 0, 0, 0, 'Ar'),
(11, '2016-06-17', 'Idio', 'abc', 'Male', '1978-06-01', '11111', 'Uk', '11111', '2016-06-02', '2018-06-27', 'Work', 11111, '2015-06-01', '2023-06-09', 2, 'Test', 112121, '2023-06-09', 'Test', 0, 0, 'idio.xxx@gmail.com', '11111', '11111', 'test', '', '', '', 0, 'United Kingdom', '', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '', '0000-00-00', 0, 0, 0, 'A'),
(35, '0000-00-00', 'Idio', 'bbb', 'Male', '1983-06-09', '11111', 'German', '', '0000-00-00', '0000-00-00', '', 0, '0000-00-00', '2032-06-03', 1, '', 0, '2032-06-03', '', 0, 0, 'idiobbb@gmail.com', '', '4096', '', '', '', '', 0, 'United Kingdom', '', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '', '0000-00-00', 0, 0, 0, 'A'),
(36, '2016-06-17', 'Idio', 'Duke', 'Male', '2001-06-01', '11111', 'UK', '', '0000-00-00', '0000-00-00', '', 0, '0000-00-00', '2016-06-17', 1, '', 0, '0000-00-00', '', 0, 0, 'idioccc@gmail.com', '', '4096', '', '', '', '', 0, 'United Kingdom', '', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '', '0000-00-00', 0, 0, 0, 'A'),
(37, '0000-00-00', 'Taku', 'mukoyi', 'Female', '1980-01-28', 'px756989b', 'zimbabwean', '', '0000-00-00', '0000-00-00', '', 0, '0000-00-00', '2022-06-01', 3, '', 0, '0000-00-00', '', 0, 0, 'takunda@iverscareservices.co.uk', '+447411207057', '+447411207057', '63 Kerridge drive', '', 'waarrington', 'waarrington', 0, 'United Kingdom', '', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '', '0000-00-00', 0, 0, 0, 'A'),
(38, '0000-00-00', 'fname one', 'lname one', 'Male', '1991-03-17', '111111A', 'UK', '', '0000-00-00', '0000-00-00', '', 0, '0000-00-00', '2017-02-16', 1, '', 0, '0000-00-00', '', 0, 0, 'tstaff1@gmail.com', '1234567890', '1234567890', '', '', '', '', 0, 'United Kingdom', '', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '', '0000-00-00', 0, 0, 0, 'A'),
(39, '0000-00-00', 'fname two', 'lname two', 'Female', '1990-06-10', '23456', 'Germany', '', '0000-00-00', '0000-00-00', '', 0, '0000-00-00', '2017-02-16', 1, '', 0, '0000-00-00', '', 0, 0, 'tstaff2@gmail.com', '2345678901', '2345678901', '', '', '', '', 0, 'United Kingdom', '', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '', '0000-00-00', 0, 0, 0, 'A'),
(40, '0000-00-00', 'fname three', 'lname three', 'Male', '1991-03-17', '7890', 'UK', '', '0000-00-00', '0000-00-00', '', 0, '0000-00-00', '2018-05-23', 1, '', 0, '0000-00-00', '', 0, 0, 'tstaff3@gmail.com', '1234567890', '1234567890', '', '', '', '', 0, 'United Kingdom', '', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '', '0000-00-00', 0, 0, 0, 'A'),
(41, '0000-00-00', 'fname four', 'lname four', 'Male', '1998-09-17', '7890', 'Germany', '', '0000-00-00', '0000-00-00', '', 0, '0000-00-00', '2018-05-23', 1, '', 0, '2018-05-23', '', 0, 0, 'tstaff4@gmail.com', '4567890', '4567890', '', '', '', '', 0, 'United Kingdom', '', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '', '0000-00-00', 0, 0, 0, 'A'),
(42, '0000-00-00', 'fname five', 'lname five', 'Male', '1995-11-29', '567890', 'UK', '', '0000-00-00', '0000-00-00', '', 0, '0000-00-00', '2017-06-23', 1, '', 0, '0000-00-00', '', 0, 0, 'tstaff5@gmail.com', '2345678901', '2345678901', '', '', '', '', 0, 'United Kingdom', '', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '', '0000-00-00', 0, 0, 0, 'A'),
(43, '0000-00-00', 'fname six', 'lname six', 'Female', '2004-02-12', '67890', 'UK', '', '0000-00-00', '0000-00-00', '', 0, '0000-00-00', '2019-01-17', 1, '', 0, '0000-00-00', '', 0, 0, 'tstaff6@gmail.com', '67890', '67890', '', '', '', '', 0, 'United Kingdom', '', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '', '0000-00-00', 0, 0, 0, 'A'),
(44, '0000-00-00', 'fname seven', 'lname seven', 'Male', '1998-09-17', '67890', 'UK', '', '0000-00-00', '0000-00-00', '', 0, '0000-00-00', '2018-06-07', 1, '', 0, '0000-00-00', '', 0, 0, 'tstaff7@gmail.com', '3456789012', '3456789012', '', '', '', '', 0, 'United Kingdom', '', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '', '0000-00-00', 0, 0, 0, 'A'),
(45, '0000-00-00', 'fname eight', 'lname eight', 'Male', '1998-09-17', '456789', 'Germany', '', '0000-00-00', '0000-00-00', '', 0, '0000-00-00', '2019-01-17', 1, '', 0, '0000-00-00', '', 0, 0, 'tstaff8@gmail.com', '567890', '567890', '', '', '', '', 0, 'United Kingdom', '', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '', '0000-00-00', 0, 0, 0, 'A'),
(46, '0000-00-00', 'fname nine', 'lname nine', 'Male', '1998-09-17', '7890', 'UK', '', '0000-00-00', '0000-00-00', '', 0, '0000-00-00', '2016-10-19', 1, '', 0, '0000-00-00', '', 0, 0, 'tstaff9@gmail.com', '3456789012', '3456789012', '', '', '', '', 0, 'United Kingdom', '', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '', '0000-00-00', 0, 0, 0, 'A'),
(47, '0000-00-00', 'fname ten', 'lname ten', 'Female', '1995-11-29', '67890', 'UK', '', '0000-00-00', '0000-00-00', '', 0, '0000-00-00', '2018-06-07', 1, '', 0, '0000-00-00', '', 0, 0, 'tstaff10@gmail.com', '567890', '567890', '', '', '', '', 0, 'United Kingdom', '', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '', '0000-00-00', 0, 0, 0, 'A'),
(48, '0000-00-00', 'fname eleven', 'lname eleven', 'Female', '2009-06-18', '547665', 'UK', '', '0000-00-00', '0000-00-00', '', 0, '0000-00-00', '2019-06-18', 1, '', 0, '0000-00-00', '', 0, 0, 'tstaff11@gmail.com', '5756867897689', '6576876876989', '', '', '', '', 0, 'United Kingdom', '', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '', '0000-00-00', 0, 0, 0, 'A'),
(49, '0000-00-00', 'fname twelve', 'lname twelve', 'Male', '1990-06-10', '67890', 'Germany', '', '0000-00-00', '0000-00-00', '', 0, '0000-00-00', '2020-06-30', 1, '', 0, '0000-00-00', '', 0, 0, 'tstaff12@gmail.com', '234566', '234566', '', '', '', '', 0, 'United Kingdom', '', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '', '0000-00-00', 0, 0, 0, 'A'),
(50, '0000-00-00', 'fname thirteen', 'lname thirteen', 'Male', '1990-06-10', '754676', 'UK', '', '0000-00-00', '0000-00-00', '', 0, '0000-00-00', '2018-05-23', 1, '', 0, '0000-00-00', '', 0, 0, 'tstaff13@gmail.com', '2345678901', '2345678901', '', '', '', '', 0, 'United Kingdom', '', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '', '0000-00-00', 0, 0, 0, 'A'),
(51, '0000-00-00', 'fname fourteen', 'lname fourteen', 'Female', '2009-04-08', '65654', 'UK', '', '0000-00-00', '0000-00-00', '', 0, '0000-00-00', '2019-06-19', 1, '', 0, '0000-00-00', '', 0, 0, 'tstaff14@gmail.com', '4567890', '4567890', '', '', '', '', 0, 'United Kingdom', '', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '', '0000-00-00', 0, 0, 0, 'A'),
(52, '0000-00-00', 'fname fifteen', 'lname fifteen', 'Female', '2004-02-12', '878568', 'Germany', '', '0000-00-00', '0000-00-00', '', 0, '0000-00-00', '2018-06-07', 1, '', 0, '0000-00-00', '', 0, 0, 'tstaff15@gmail.com', '243432543', '5435435435', '', '', '', '', 0, 'United Kingdom', '', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '', '0000-00-00', 0, 0, 0, 'A'),
(53, '0000-00-00', 'fname sixteen', 'lname sixteen', 'Male', '2016-06-24', '213234', 'UK', '', '0000-00-00', '0000-00-00', '', 0, '0000-00-00', '2018-05-23', 1, '', 0, '2018-05-23', '', 0, 0, 'tstaff16@gmail.com', '4567890', '4567890', '', '', '', '', 0, 'United Kingdom', '', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '', '0000-00-00', 0, 0, 0, 'A'),
(54, '0000-00-00', 'fname seventeen', 'lname seventeen', 'Female', '1998-09-17', '554757', 'Germany', '', '0000-00-00', '0000-00-00', '', 0, '0000-00-00', '2018-10-05', 1, '', 0, '0000-00-00', '', 0, 0, 'tstaff17@gmail.com', '67890', '67890', '', '', '', '', 0, 'United Kingdom', '', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '', '0000-00-00', 0, 0, 0, 'A'),
(55, '0000-00-00', 'fname eighteen', 'lname eighteen', 'Male', '1998-09-17', '56546', 'UK', '', '0000-00-00', '0000-00-00', '', 0, '0000-00-00', '2018-05-23', 1, '', 0, '0000-00-00', '', 0, 0, 'tstaff18@gmail.com', '4567890', '4567890', '', '', '', '', 0, 'United Kingdom', '', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '', '0000-00-00', 0, 0, 0, 'A'),
(56, '0000-00-00', 'fname nineteen', 'lname nineteen', 'Male', '2004-02-12', '87665', 'UK', '', '0000-00-00', '0000-00-00', '', 0, '0000-00-00', '2018-06-07', 1, '', 0, '2018-06-07', '', 0, 0, 'tstaff19@gmail.com', '567890', '567890', '', '', '', '', 0, 'United Kingdom', '', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '', '0000-00-00', 0, 0, 0, 'A'),
(57, '0000-00-00', 'fname twenty', 'lname twenty', 'Male', '2000-04-21', '543534', 'Germany', '', '0000-00-00', '0000-00-00', '', 0, '0000-00-00', '2017-02-16', 1, '', 0, '0000-00-00', '', 0, 0, 'tstaff20@gmail.com', '57568678', '5435435', '', '', '', '', 0, 'United Kingdom', '', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '', '0000-00-00', 0, 0, 0, 'A'),
(58, '0000-00-00', 'fname twentyone', 'lname twentyone', 'Female', '2012-06-08', '432424', 'UK', '', '0000-00-00', '0000-00-00', '', 0, '0000-00-00', '2017-06-23', 1, '', 0, '0000-00-00', '', 0, 0, 'tstaff21@gmail.com', '2345678901', '2345678901', '', '', '', '', 0, 'United Kingdom', '', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '', '0000-00-00', 0, 0, 0, 'A'),
(59, '0000-00-00', 'fname twentytwo', 'lname twentytwo', 'Male', '1990-06-10', '98797', 'UK', '', '0000-00-00', '0000-00-00', '', 0, '0000-00-00', '2017-02-16', 1, '', 0, '0000-00-00', '', 0, 0, 'tstaff22@gmail.com', '4567890', '4567890', '', '', '', '', 0, 'United Kingdom', '', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '', '0000-00-00', 0, 0, 0, 'A'),
(60, '0000-00-00', 'fname twentythree', 'lname twentythree', 'Male', '2016-06-09', '976686', 'Germany', '', '0000-00-00', '0000-00-00', '', 0, '0000-00-00', '2017-06-23', 1, '', 0, '0000-00-00', '', 0, 0, 'tstaff23@gmail.com', '57568678', '5435435', '', '', '', '', 0, 'United Kingdom', '', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '', '0000-00-00', 0, 0, 0, 'A');

-- --------------------------------------------------------

--
-- Table structure for table `ams_staff_registration_completed_training_map_table`
--

CREATE TABLE IF NOT EXISTS `ams_staff_registration_completed_training_map_table` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `staff_id` int(10) unsigned NOT NULL,
  `grade_id` int(3) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `staff_id` (`staff_id`),
  KEY `grade_id` (`grade_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `ams_staff_registration_preferred_work_area_map_table`
--

CREATE TABLE IF NOT EXISTS `ams_staff_registration_preferred_work_area_map_table` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `staff_id` int(11) unsigned NOT NULL,
  `work_area_id` int(5) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `staff_id` (`staff_id`),
  KEY `work_area_id` (`work_area_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=160 ;

--
-- Dumping data for table `ams_staff_registration_preferred_work_area_map_table`
--

INSERT INTO `ams_staff_registration_preferred_work_area_map_table` (`id`, `staff_id`, `work_area_id`) VALUES
(1, 4, 1),
(2, 4, 2),
(3, 4, 3),
(4, 3, 4),
(5, 3, 5),
(9, 1, 2),
(10, 1, 3),
(11, 1, 4),
(12, 1, 5),
(13, 5, 1),
(14, 5, 2),
(15, 5, 3),
(16, 6, 1),
(17, 6, 2),
(18, 7, 3),
(19, 7, 1),
(20, 7, 2),
(21, 7, 4),
(22, 7, 5),
(23, 7, 6),
(24, 8, 3),
(25, 9, 1),
(26, 9, 2),
(27, 9, 3),
(28, 4, 4),
(29, 4, 5),
(30, 4, 6),
(33, 11, 1),
(34, 11, 2),
(35, 11, 3),
(92, 35, 1),
(93, 35, 2),
(94, 35, 3),
(95, 35, 4),
(96, 36, 1),
(97, 36, 2),
(102, 3, 1),
(103, 3, 2),
(104, 3, 3),
(105, 3, 6),
(106, 37, 3),
(107, 38, 1),
(108, 38, 2),
(109, 39, 2),
(110, 39, 3),
(111, 39, 4),
(112, 40, 2),
(113, 40, 3),
(114, 41, 3),
(115, 41, 4),
(116, 42, 3),
(117, 42, 4),
(118, 42, 5),
(119, 43, 2),
(120, 43, 3),
(121, 43, 4),
(122, 44, 3),
(123, 44, 4),
(124, 45, 1),
(125, 45, 4),
(126, 46, 5),
(127, 46, 6),
(128, 47, 2),
(129, 47, 3),
(130, 47, 4),
(131, 48, 1),
(132, 48, 2),
(133, 49, 4),
(134, 49, 5),
(135, 50, 2),
(136, 50, 4),
(137, 50, 5),
(138, 51, 1),
(139, 51, 2),
(140, 52, 1),
(141, 52, 2),
(142, 53, 2),
(143, 53, 3),
(144, 53, 4),
(145, 54, 3),
(146, 54, 4),
(147, 55, 2),
(148, 55, 3),
(149, 56, 2),
(150, 56, 4),
(151, 56, 5),
(152, 57, 2),
(153, 57, 3),
(154, 58, 2),
(155, 58, 3),
(156, 59, 3),
(157, 59, 4),
(158, 60, 1),
(159, 60, 2);

-- --------------------------------------------------------

--
-- Table structure for table `ams_staff_request_required_training_map_table`
--

CREATE TABLE IF NOT EXISTS `ams_staff_request_required_training_map_table` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `request_id` int(10) unsigned NOT NULL,
  `grade_id` int(3) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `request_id` (`request_id`),
  KEY `grade_id` (`grade_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `ams_user`
--

CREATE TABLE IF NOT EXISTS `ams_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `first_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `gender` enum('Male','Female') COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `mobile` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `address` text COLLATE utf8_unicode_ci NOT NULL,
  `type` enum('D','A','M','C','S') COLLATE utf8_unicode_ci NOT NULL COMMENT 'D=>Director/Super Visor,A=> Admin, M => Manager,C=>coordinator, S=> Staff ',
  `staff_id` int(10) unsigned NOT NULL,
  `image` text COLLATE utf8_unicode_ci NOT NULL,
  `active_status` enum('Y','N') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'N',
  PRIMARY KEY (`id`),
  KEY `staff_id` (`staff_id`),
  KEY `type` (`type`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=23 ;

--
-- Dumping data for table `ams_user`
--

INSERT INTO `ams_user` (`id`, `first_name`, `last_name`, `gender`, `email`, `password`, `mobile`, `address`, `type`, `staff_id`, `image`, `active_status`) VALUES
(10, 'Paul', 'Duke', 'Male', 'admin@gmail.com', '202cb962ac59075b964b07152d234b70', '4096', 'test', 'S', 1, '1666-male.jpg', 'Y'),
(12, 'Anita', 'Barry', 'Female', 'anita@gmail.com', '202cb962ac59075b964b07152d234b70', '123456769', '92 Dale Lane', 'S', 3, '2043-female.png', 'Y'),
(13, 'Gideon', 'Zollo', 'Male', 'gzollo2001@yahoo.com', '202cb962ac59075b964b07152d234b70', '7432288762', '2 Beech Grove', 'S', 4, '1666-male.jpg', 'Y'),
(14, 'Test', 'Test', 'Male', 'staff1@gmail.com', '202cb962ac59075b964b07152d234b70', '123323456', 'asd', 'S', 5, '1465989047-1465988351-celebrity.jpg', 'Y'),
(15, 'Alpha', 'Alphaa', 'Male', 'alpha@yahoo.com', '202cb962ac59075b964b07152d234b70', '07432288762', '2 Beech Grove', 'S', 8, '1666-male.jpg', 'Y'),
(17, 'Idio', 'abc', 'Male', 'idio.xxx@gmail.com', '202cb962ac59075b964b07152d234b70', '11111', 'test', 'S', 11, '1666-male.jpg', 'Y'),
(18, 'Idio', 'Duke', 'Male', 'idioccc@gmail.com', '202cb962ac59075b964b07152d234b70', '', '', 'S', 36, '1666-male.jpg', 'Y'),
(19, 'Royes', 'Sanda', 'Male', 'msand@gmail.com', '202cb962ac59075b964b07152d234b70', '07432288762', '', 'S', 7, '1666-male.jpg', 'Y'),
(20, 'admin', 'admin', 'Male', 'admin', '202cb962ac59075b964b07152d234b70', '', '', 'A', 0, '', 'Y'),
(21, 'Taku', 'mukoyi', 'Female', 'takunda@iverscareservices.co.uk', '202cb962ac59075b964b07152d234b70', '+447411207057', '63 Kerridge drive', 'S', 37, '2043-female.png', 'Y'),
(22, 'dfgsd', 'dsfg', 'Male', 'dfsg@fg.hh', '202cb962ac59075b964b07152d234b70', '23423324', 'sdgsd', 'D', 0, '', 'Y');

-- --------------------------------------------------------

--
-- Table structure for table `ams_user_activity`
--

CREATE TABLE IF NOT EXISTS `ams_user_activity` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned DEFAULT NULL,
  `ip` varchar(20) NOT NULL,
  `time` datetime DEFAULT NULL,
  `details` text NOT NULL,
  `module_name` varchar(40) DEFAULT NULL,
  `activity` varchar(20) NOT NULL,
  `is_successful` enum('Y','N') NOT NULL DEFAULT 'Y',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `ams_ward`
--

CREATE TABLE IF NOT EXISTS `ams_ward` (
  `ward_id` int(6) unsigned NOT NULL AUTO_INCREMENT,
  `ward_name` varchar(50) NOT NULL,
  PRIMARY KEY (`ward_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `ams_ward`
--

INSERT INTO `ams_ward` (`ward_id`, `ward_name`) VALUES
(1, 'Cardiology'),
(2, 'Radiology'),
(3, 'Ward 1'),
(4, 'Not Applicable'),
(5, 'Ward 2');

-- --------------------------------------------------------

--
-- Table structure for table `ams_ward_hospital_unit_map`
--

CREATE TABLE IF NOT EXISTS `ams_ward_hospital_unit_map` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `hospital_unit_id` int(10) unsigned NOT NULL,
  `ward_id` int(6) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `hospital_unit_id` (`hospital_unit_id`,`ward_id`),
  KEY `ward_id` (`ward_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=18 ;

--
-- Dumping data for table `ams_ward_hospital_unit_map`
--

INSERT INTO `ams_ward_hospital_unit_map` (`id`, `hospital_unit_id`, `ward_id`) VALUES
(12, 1, 1),
(13, 1, 2),
(14, 1, 3),
(9, 3, 1),
(10, 3, 2),
(11, 3, 3),
(15, 5, 1),
(16, 5, 2),
(17, 5, 3),
(1, 6, 1),
(2, 6, 2),
(3, 6, 3),
(4, 7, 4),
(8, 8, 4);

-- --------------------------------------------------------

--
-- Table structure for table `ams_work_area`
--

CREATE TABLE IF NOT EXISTS `ams_work_area` (
  `work_area_id` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `area_name` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `area_active_status` enum('Y','N') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'N',
  PRIMARY KEY (`work_area_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=7 ;

--
-- Dumping data for table `ams_work_area`
--

INSERT INTO `ams_work_area` (`work_area_id`, `area_name`, `area_active_status`) VALUES
(1, 'Scotland', 'Y'),
(2, 'Liverpool', 'Y'),
(3, 'Manchester', 'Y'),
(4, 'Birmingham', 'Y'),
(5, 'Nottingham', 'Y'),
(6, 'Warrington', 'Y');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
