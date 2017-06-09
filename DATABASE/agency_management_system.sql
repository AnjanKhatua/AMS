-- phpMyAdmin SQL Dump
-- version 4.0.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 29, 2016 at 04:55 PM
-- Server version: 5.6.14
-- PHP Version: 5.5.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `agency_management_system`
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
  `confirm_by_whom` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `cancellation_date` date NOT NULL,
  `cancellation_time` time NOT NULL,
  `cancel_by_whom` int(10) unsigned NOT NULL,
  `cancel_requested_by` enum('A','C','M','S','H') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'S' COMMENT 'A=>Admin,C=>Co-ordinator,M=>Manager,S=>Staff himself/Herself, H=>Hospital',
  PRIMARY KEY (`booking_id`),
  KEY `staff_id` (`staff_id`),
  KEY `staff_request_id` (`staff_request_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `ams_document_header`
--

CREATE TABLE IF NOT EXISTS `ams_document_header` (
  `document_header_id` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `header_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `active_status` enum('Y','N') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Y',
  PRIMARY KEY (`document_header_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `ams_enquiry`
--

CREATE TABLE IF NOT EXISTS `ams_enquiry` (
  `enquiry_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `ams_grade`
--

INSERT INTO `ams_grade` (`grade_id`, `grade_name`, `grade_active_status`) VALUES
(1, 'RNG', 'Y'),
(2, 'RMN', 'Y');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `ams_hospital_registration`
--

CREATE TABLE IF NOT EXISTS `ams_hospital_registration` (
  `hospital_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `hospital_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `hospital_status` enum('A','I','S') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'I' COMMENT 'A=> Active, I => Inactive, S=> Suspended',
  PRIMARY KEY (`hospital_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `ams_hospital_registration`
--

INSERT INTO `ams_hospital_registration` (`hospital_id`, `hospital_name`, `hospital_status`) VALUES
(1, 'SSKM Hospital', 'A'),
(2, 'AMRI Hospital', 'A'),
(3, 'AMRI Hospital', 'I');

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
  `contact_number` int(10) unsigned NOT NULL,
  `hospital_unit_active_status` enum('Y','N') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'N',
  PRIMARY KEY (`hospital_unit_id`),
  KEY `hospital_id` (`hospital_id`),
  KEY `local_area_id` (`local_area_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `ams_hospital_unit`
--

INSERT INTO `ams_hospital_unit` (`hospital_unit_id`, `hospital_id`, `hospital_unit`, `address`, `local_area_id`, `email`, `contact_number`, `hospital_unit_active_status`) VALUES
(1, 1, 'Main', 'Kolkata', 1, 'asa@dsd.kl', 1234567890, 'Y'),
(2, 2, 'Main', 'Kolkata', 1, 'xyz@gmail.com', 4294967295, 'Y');

-- --------------------------------------------------------

--
-- Table structure for table `ams_job_type`
--

CREATE TABLE IF NOT EXISTS `ams_job_type` (
  `job_type_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `job_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `job_type_active_status` enum('Y','N') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'N',
  PRIMARY KEY (`job_type_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `ams_job_type`
--

INSERT INTO `ams_job_type` (`job_type_id`, `job_type`, `job_type_active_status`) VALUES
(1, 'Nurse', 'Y');

-- --------------------------------------------------------

--
-- Table structure for table `ams_non_availability_of_staff`
--

CREATE TABLE IF NOT EXISTS `ams_non_availability_of_staff` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `staff_id` int(10) unsigned NOT NULL,
  `date` date NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `already_booked` enum('Y','N') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'N',
  `is_disabled` enum('Y','N') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'N' COMMENT 'This field is to resrict consecutive allocation',
  PRIMARY KEY (`id`),
  KEY `staff_id` (`staff_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `ams_pay_type`
--

CREATE TABLE IF NOT EXISTS `ams_pay_type` (
  `pay_type_id` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `pay_type` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `pay_type_active_status` enum('Y','N') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'N',
  PRIMARY KEY (`pay_type_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `ams_pay_type`
--

INSERT INTO `ams_pay_type` (`pay_type_id`, `pay_type`, `pay_type_active_status`) VALUES
(1, 'Cash', 'Y');

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
-- Table structure for table `ams_shift_management_for_hospital`
--

CREATE TABLE IF NOT EXISTS `ams_shift_management_for_hospital` (
  `staff_request_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `hospital_unit_id` int(10) unsigned NOT NULL,
  `job_type_id` int(10) unsigned NOT NULL,
  `quantity` int(3) unsigned NOT NULL,
  `date` date NOT NULL,
  `shift_start_time` time NOT NULL,
  `shift_end_time` time NOT NULL,
  `requested_date` date NOT NULL,
  `requested_time` time NOT NULL,
  `requested_person` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `request_accepted_by` int(10) unsigned NOT NULL,
  `requested_person_mobile_number` int(11) unsigned NOT NULL,
  PRIMARY KEY (`staff_request_id`),
  KEY `hospital_unit_id` (`hospital_unit_id`),
  KEY `job_type_id` (`job_type_id`),
  KEY `request_accepted_by` (`request_accepted_by`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

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
  `mobile_no` int(11) unsigned NOT NULL,
  `telephone` int(11) unsigned NOT NULL,
  `address` text COLLATE utf8_unicode_ci NOT NULL,
  `post_code` int(8) unsigned NOT NULL,
  `country` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `job_type_id` int(5) unsigned NOT NULL,
  `dbs_number` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `dbs_issue_date` date NOT NULL,
  `dbs_expiry` date NOT NULL,
  `mandatory_training_expiry_date` date NOT NULL,
  `mva_expiry_date` date NOT NULL,
  `maybo_training_expiry` date NOT NULL,
  `pin_expiry_date` date NOT NULL,
  `max_allowed_hour` int(5) NOT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `shift_confirmation_count` int(5) unsigned NOT NULL,
  `shift_cancellation_count` int(5) unsigned NOT NULL,
  `staff_status` enum('D','A','I','S','Ar') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'I' COMMENT 'D=>Draft, A=> Active, I => Inactive, S=> Suspended,Ar=>Archive',
  PRIMARY KEY (`staff_id`),
  KEY `pay_type_id` (`pay_type_id`),
  KEY `job_type_id` (`job_type_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=8 ;

--
-- Dumping data for table `ams_staff_registration`
--

INSERT INTO `ams_staff_registration` (`staff_id`, `start_date`, `first_name`, `last_name`, `gender`, `date_of_birth`, `ni_no`, `nationality`, `passport_no`, `passport_issue_date`, `passport_expiry_date`, `visa_type`, `visa_no`, `visa_issue_date`, `visa_expiry_date`, `pay_type_id`, `company_name`, `company_no`, `date_of_incorporation`, `bank_details`, `sort_code`, `account_no`, `email`, `mobile_no`, `telephone`, `address`, `post_code`, `country`, `job_type_id`, `dbs_number`, `dbs_issue_date`, `dbs_expiry`, `mandatory_training_expiry_date`, `mva_expiry_date`, `maybo_training_expiry`, `pin_expiry_date`, `max_allowed_hour`, `image`, `shift_confirmation_count`, `shift_cancellation_count`, `staff_status`) VALUES
(1, '2016-04-01', '', '', '', '0000-00-00', '', '', '', '0000-00-00', '0000-00-00', '', 0, '0000-00-00', '0000-00-00', 0, '', 0, '0000-00-00', '', 0, 0, '', 0, 0, '', 0, '', 0, '', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', 0, '', 0, 0, 'A'),
(4, '2016-04-01', 'tuhiran', 'Devbhuti', 'Male', '2016-04-01', '434d3d3dd', 'Indian', 'gfhjgkjhl', '2016-04-06', '2016-04-03', 'jhfgtvbnkm', 25444, '2016-04-07', '2016-04-30', 0, 'lkjbknm', 15814, '2016-04-06', 'kijloklklouhujh', 581414, 21242412, 'jugjhn@gmail.com', 4294967295, 4294967295, 'gcrdghvj45842??kiuhki', 0, 'ghvhybj', 0, '42311425412', '2016-04-01', '2016-04-13', '2016-04-14', '2016-04-13', '2016-04-20', '2016-04-01', 1215444, '', 0, 0, 'D'),
(6, '2016-04-07', 'tuhiran', 'Devbhuti', 'Female', '2016-04-01', '434d3d3dd', 'dfcsdfgg rd ttert e', 'gfhjgkjhl', '2016-04-01', '2016-04-01', 'cggdfgfdg', 25444, '2016-04-05', '2016-04-05', 1, 'dddd', 15814, '2016-04-04', 'ddd', 345345, 345345, 'jugjhn@gmail.com', 4294967295, 4294967295, 'dddd', 0, 'dfhgdfgh', 1, '42311425412', '2016-04-25', '2016-04-12', '2016-04-14', '2016-04-06', '2016-04-28', '2016-04-19', 456, '', 0, 0, 'A'),
(7, '2016-04-01', '', '', '', '2016-04-01', '', '', '', '2016-04-28', '2016-04-15', '', 0, '2016-04-27', '2016-04-13', 0, '', 0, '2016-04-06', '', 0, 0, '', 0, 0, '', 0, '', 0, '', '2016-04-26', '2016-04-26', '2016-04-08', '2016-04-15', '2016-04-28', '2016-04-20', 0, '', 0, 0, 'D');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

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
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `mobile` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `address` text COLLATE utf8_unicode_ci NOT NULL,
  `type` enum('A','M','C','S') COLLATE utf8_unicode_ci NOT NULL COMMENT 'A=> Admin, M => Manager,C=>coordinator, S=> Staff ',
  `staff_id` int(10) unsigned NOT NULL,
  `active_status` enum('Y','N') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'N',
  PRIMARY KEY (`id`),
  KEY `staff_id` (`staff_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `ams_user`
--

INSERT INTO `ams_user` (`id`, `first_name`, `last_name`, `email`, `password`, `mobile`, `address`, `type`, `staff_id`, `active_status`) VALUES
(1, 'Anjan', 'Khatua', 'idio.anjan@gmail.com', '202cb962ac59075b964b07152d234b70', '9153005583', 'Kolkata', 'A', 0, 'Y');

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
-- Table structure for table `ams_work_area`
--

CREATE TABLE IF NOT EXISTS `ams_work_area` (
  `work_area_id` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `area_name` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `area_active_status` enum('Y','N') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'N',
  PRIMARY KEY (`work_area_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `ams_work_area`
--

INSERT INTO `ams_work_area` (`work_area_id`, `area_name`, `area_active_status`) VALUES
(1, 'Kolkata, West Bengal, India', 'Y'),
(2, 'Baguiati, Kolkata, West Bengal, India', 'Y'),
(3, 'Midnapore', 'Y');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
