-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Host: mysql5047.site4now.net
-- Generation Time: Jun 27, 2022 at 12:26 PM
-- Server version: 5.7.33-log
-- PHP Version: 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_a7d59c_embat`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_profile`
--

CREATE TABLE `admin_profile` (
  `admin_id` varchar(255) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `middlename` varchar(255) DEFAULT NULL,
  `lastname` varchar(255) NOT NULL,
  `photo` varchar(255) NOT NULL,
  `position` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `contact_number` varchar(13) DEFAULT NULL,
  `address` text,
  `gender` varchar(10) DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `place_bday` varchar(255) DEFAULT NULL,
  `civil_status` varchar(100) DEFAULT NULL,
  `create_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin_profile`
--

INSERT INTO `admin_profile` (`admin_id`, `firstname`, `middlename`, `lastname`, `photo`, `position`, `email`, `contact_number`, `address`, `gender`, `birthdate`, `place_bday`, `civil_status`, `create_date`) VALUES
('1', 'Juan', 'o', 'Dela Cruz', 'default.png', 'superadmin', 'admin@gmail.com', '09123456789', '2', 'male', '1999-11-09', '2', '', '2021-11-01'),
('29', 'Dexter', '', 'Montero', 'Dice 4.png', 'administrator', 'dexter.montero.09@gmail.com', '09123456789', '', 'Male', '1999-01-19', '', NULL, '2022-02-09');

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `id` int(11) NOT NULL,
  `user_id` varchar(100) NOT NULL,
  `c_fullname` varchar(150) NOT NULL,
  `pet_name` varchar(255) DEFAULT NULL,
  `date` date NOT NULL,
  `timeslot` varchar(255) NOT NULL,
  `service_id` varchar(255) NOT NULL,
  `veterinarian` varchar(150) DEFAULT NULL,
  `branch_id` varchar(150) NOT NULL,
  `payment_status` varchar(10) NOT NULL DEFAULT 'unpaid',
  `status` varchar(100) DEFAULT NULL,
  `vid_status` varchar(2) NOT NULL DEFAULT '0',
  `shows` varchar(2) NOT NULL DEFAULT '0',
  `review` varchar(2) NOT NULL DEFAULT '0',
  `archive_status` varchar(2) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Table structure for table `archive`
--

CREATE TABLE `archive` (
  `archive_id` int(11) NOT NULL,
  `id` varchar(100) NOT NULL,
  `user_id` varchar(100) NOT NULL,
  `category` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Table structure for table `audit_logs`
--

CREATE TABLE `audit_logs` (
  `id` int(11) NOT NULL,
  `login_id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `activity` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Table structure for table `billing`
--

CREATE TABLE `billing` (
  `bill_id` int(11) NOT NULL,
  `ukayra_id` varchar(255) NOT NULL,
  `paymogo_id` varchar(255) NOT NULL,
  `appointment_id` varchar(150) NOT NULL,
  `services` varchar(255) NOT NULL,
  `category` varchar(150) NOT NULL,
  `description` text NOT NULL,
  `branch_id` varchar(150) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `date` date DEFAULT NULL,
  `time` time DEFAULT NULL,
  `mode_of_payment` varchar(150) NOT NULL,
  `amount` bigint(150) NOT NULL,
  `status` varchar(100) DEFAULT NULL,
  `archive_status` varchar(2) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Table structure for table `blogs`
--

CREATE TABLE `blogs` (
  `blog_id` int(11) NOT NULL,
  `author` varchar(100) NOT NULL,
  `blog_photo` varchar(255) NOT NULL,
  `blog_title` varchar(255) NOT NULL,
  `blog_description` text NOT NULL,
  `blog_date` date NOT NULL,
  `blog_time` time NOT NULL,
  `status` varchar(2) NOT NULL DEFAULT '0',
  `archive_status` varchar(2) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `blogs`
--

INSERT INTO `blogs` (`blog_id`, `author`, `blog_photo`, `blog_title`, `blog_description`, `blog_date`, `blog_time`, `status`, `archive_status`) VALUES
(4, '2', 'blog-1.jpg', 'Never Use Your Hand as a Toy', 'It will be acceptable for your kitten to scratch and bite your hand. Instead, always use a cat teaser toy. A shoestring, on the other hand, can keep a kitten occupied for hours.', '2021-12-13', '04:29:43', '1', '0'),
(5, '2', 'testing.png', 'Clip Your Kitten\'s Claws', 'When they are tired or asleep, clip them every two weeks. Your cat will probably love being groomed and petted after being accustomed to regular clippings. You can learn how to clip claws safely from your veterinarian, or you can find instructions in most cat-care manuals. Claws that are well-clipped can avoid scratching skin and furniture, as well as getting trapped on carpets.', '2021-12-14', '03:31:10', '1', '0'),
(6, '2', 'testing2.png', 'Brush your kitten on a regular basis', 'If they have longer hair, brush them every day. Cat brushes come in a variety of styles that may be found in pet stores. Brushing your cat makes them feel clean, which is vital to them. Brushing will also help to lessen the risk of allergies in your home.\r\n', '2021-12-14', '04:31:52', '1', '0'),
(7, '2', 'cute yes.PNG', 'test', 'test', '2022-05-15', '17:51:27', '0', '0');

-- --------------------------------------------------------

--
-- Table structure for table `branch`
--

CREATE TABLE `branch` (
  `branch_id` int(11) NOT NULL,
  `name` varchar(150) DEFAULT NULL,
  `address` text,
  `status` varchar(2) NOT NULL DEFAULT '0',
  `archive_status` varchar(2) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `branch`
--

INSERT INTO `branch` (`branch_id`, `name`, `address`, `status`, `archive_status`) VALUES
(1, 'Holy Spirit', 'Holy Spirit Commonwealth', '1', '0'),
(13, 'adssddsasad', 'asdassaddsa', '1', '1'),
(15, 'Visayas', 'Visayas Ave', '1', '0'),
(16, 'VISAYAS AVE.', 'VISAYAS AVE.', '1', '1'),
(18, 'Branch Name', 'Branch Address', '1', '0');

-- --------------------------------------------------------

--
-- Table structure for table `calendar_events`
--

CREATE TABLE `calendar_events` (
  `id` int(11) NOT NULL,
  `to_client` varchar(100) NOT NULL,
  `token` varchar(150) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `start_event` datetime NOT NULL,
  `end_event` datetime NOT NULL,
  `archive_status` varchar(2) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Table structure for table `diagnosis_records`
--

CREATE TABLE `diagnosis_records` (
  `id` int(11) NOT NULL,
  `pet_id` varchar(150) NOT NULL,
  `user_id` varchar(150) NOT NULL,
  `diagnosis` text NOT NULL,
  `additional_notes` text NOT NULL,
  `date` date NOT NULL,
  `archive_status` varchar(2) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `invoice`
--

CREATE TABLE `invoice` (
  `invoice_id` int(11) NOT NULL,
  `invoice_ref` varchar(150) NOT NULL,
  `appointment_id` varchar(150) NOT NULL,
  `user_id` varchar(150) NOT NULL,
  `fullname` varchar(150) NOT NULL,
  `petname` varchar(150) NOT NULL,
  `service_title` varchar(150) NOT NULL,
  `branch_name` varchar(150) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `service_cost` bigint(115) NOT NULL,
  `payment_status` varchar(100) NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Table structure for table `login_tbl`
--

CREATE TABLE `login_tbl` (
  `uid` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `roles` varchar(255) NOT NULL,
  `code` varchar(150) NOT NULL,
  `verification` varchar(100) NOT NULL DEFAULT 'inactive',
  `privilege` int(11) NOT NULL DEFAULT '0',
  `archive_status` varchar(2) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `login_tbl`
--

INSERT INTO `login_tbl` (`uid`, `email`, `password`, `roles`, `code`, `verification`, `privilege`, `archive_status`) VALUES
(1, 'admin@gmail.com', '+uhXIHk=', 'superadmin', 'wqeqwe_QZJb', 'active', 1, '0'),
(2, 'veterinarian@gmail.com', '+uhXIHk=', 'veterinarian', 'ewwe_QZJa', 'active', 0, '0');

-- --------------------------------------------------------

--
-- Table structure for table `notification`
--

CREATE TABLE `notification` (
  `notify_id` int(11) NOT NULL,
  `id` varchar(150) DEFAULT NULL,
  `sender` varchar(150) DEFAULT NULL,
  `receiver` varchar(150) DEFAULT NULL,
  `category` varchar(150) DEFAULT NULL,
  `services` varchar(150) DEFAULT NULL,
  `icon` varchar(120) DEFAULT NULL,
  `url` text,
  `title` varchar(120) DEFAULT NULL,
  `activity` text,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `status` varchar(2) NOT NULL DEFAULT '0',
  `archive_status` varchar(2) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Table structure for table `pet_profile`
--

CREATE TABLE `pet_profile` (
  `pet_id` int(11) NOT NULL,
  `user_id` varchar(100) NOT NULL,
  `pet_photo` varchar(255) NOT NULL DEFAULT 'default.png',
  `pet_name` varchar(100) DEFAULT NULL,
  `pet_type` varchar(100) DEFAULT NULL,
  `pet_breed` varchar(100) DEFAULT NULL,
  `pet_weight` varchar(100) DEFAULT NULL,
  `pet_height` varchar(100) DEFAULT NULL,
  `pet_birthdate` date DEFAULT NULL,
  `pet_vaccination` varchar(100) DEFAULT NULL,
  `pet_blood_type` varchar(100) DEFAULT NULL,
  `pet_medical_status` varchar(100) DEFAULT NULL,
  `archive_status` varchar(2) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Table structure for table `pet_treatment_records`
--

CREATE TABLE `pet_treatment_records` (
  `treatment_id` int(11) NOT NULL,
  `pet_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date` date DEFAULT NULL,
  `treatment` varchar(255) DEFAULT NULL,
  `f_procedure` varchar(255) DEFAULT NULL,
  `n_procedure` varchar(255) DEFAULT NULL,
  `service_cost` bigint(20) DEFAULT NULL,
  `payment` bigint(20) DEFAULT NULL,
  `balance` bigint(20) DEFAULT NULL,
  `status` varchar(100) DEFAULT 'ongoing',
  `archive_status` varchar(2) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `prescription_records`
--

CREATE TABLE `prescription_records` (
  `prescription_id` int(11) NOT NULL,
  `pet_id` varchar(100) NOT NULL,
  `user_id` varchar(100) NOT NULL,
  `prescription_name` varchar(150) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `veterinarian` varchar(100) NOT NULL,
  `date` date NOT NULL,
  `archive_status` varchar(2) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `review_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `appointment_id` int(11) NOT NULL,
  `review_service` varchar(100) NOT NULL,
  `review_description` text NOT NULL,
  `status` varchar(2) NOT NULL DEFAULT '0',
  `archive_status` varchar(2) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `service_id` int(11) NOT NULL,
  `branch_id` varchar(150) NOT NULL,
  `service_title` varchar(255) NOT NULL,
  `service_description` text NOT NULL,
  `service_cost` bigint(255) NOT NULL,
  `service_photo` varchar(255) NOT NULL,
  `vet_request` varchar(255) DEFAULT NULL,
  `status` varchar(2) NOT NULL DEFAULT '0',
  `archive_status` varchar(2) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`service_id`, `branch_id`, `service_title`, `service_description`, `service_cost`, `service_photo`, `vet_request`, `status`, `archive_status`) VALUES
(1, 'all', 'Spay & Neuter (Kapon)', 'This service involves surgery to prevent reproduction that will help your dog and cat to reduce the population of fur babies.', 1000, 'spay_and_neuter.jpg', '', '1', '0'),
(2, 'all', 'Deworming', 'Deworming is the process of expelling intestinal worms or parasitic worms from the body by administering an anthelmintic medicine/drug. In more simple terms, it is a medicated process to kill worms', 200, 'complete_blood_count.jpg', '', '1', '0'),
(3, 'all', 'Confinement', 'commonly after surgery vet may require confinement to thoroughly examine the patientâ€™s condition<br />\n<br />\nâ€¢ 2000 overnight confinement<br />\nâ€¢ 1000 9:00 am â€“ 4:00 pm<br />\n<br />\n<span class=\"text-danger\">*</span> Professional fee starts at 35', 2000, 'anti_fee.jpg', '', '1', '1'),
(4, 'all', 'Pregnancy Test', 'This clinic also offers pregnancy tests for your dog and cat to determine if you\'re now a fur grandparent!', 500, 'pregnacy_test.jpg', '', '1', '1'),
(6, '5', 'Pet Dental Check-Up', 'This service involves teeth evaluation and check for possible  developing dental problems to your pets.', 700, 'check_up.jpg', '', '1', '1'),
(7, 'all', 'VACCINATION', 'Vaccines - Keeping your pets\' vaccines up to date will keep them and your family secure from acquiring hazards to your health.<br /><br />\nAnti-rabies (300) - The best way to prevent rabies is to vaccinate your pet on schedule, strengthen them against a threat and keep the neighborhood hearty.<br /><br />\nPneumonia Vaccine (500) - A prophylactic immunization intended to protect your fur babies from the Bordetella bacteria, which is frequently responsible for kennel cough.<br /><br />\n*Based on the danger of exposure, severity of disease, or transmissibility to humans, core vaccinations are deemed essential for all dogs and cats.<br /><br />\nDogs - parvo, distemper, respiratory disease (Adenovirus Type 2), canine hepatitis (Adenovirus Type 1), parainfluenza, 2-leptospirosis and corona virus.<br /><br />\nCats - Feline panleukopenia, Feline herpesvirus, Feline calicivirus, Feline leukemia, Chlamydophila felis, Bordetella bronchiseptica.<br /><br />\nThese are the vaccination promos that we can avail after consulting our vets;', 500, 'vaccination_animals.jpg', NULL, '1', '0'),
(11, 'all', 'Other Services', 'Medicines used to treat flea and tick infestations in dogs, can be both taken as oral and topical as your veterinarian prescribed.<br />\nâ€¢ Nexgard - starting at 650<br />\nâ€¢ Bravecto - starting at 1500<br />\nSurgical service â€“ Elective and emergency procedures such as tooth extraction, spay and neuter, and any internal procedures (Price will depend on severity and condition of the process and only to be conducted after a consultation).<br />\n<b>Confinement</b><br />\ncommonly after surgery vet may require confinement to thoroughly examine the patientâ€™s condition<br />\nâ€¢ 2000 overnight confinement<br />\nâ€¢ 1000 9:00 am â€“ 4:00 pm<br />\n<span class=\"text-danger\">*</span> Professional fee starts at 35', 250, '11_cadd3574d2307f887128aefbb5534910.jpg', NULL, '1', '1'),
(12, 'all', 'asd', 'asdas', 1232, 'asd_cadd3574d2307f887128aefbb5534910.jpg', NULL, '1', '1'),
(13, '1', 'asddaasd', 'asdasdasdasdasdasd', 2000, 'asddaasd_275004593_499788075102988_589712622665686360_n.jpg', NULL, '1', '1'),
(14, '', 'Test Service', 'Test Service', 100, 'Test Service_1646890715398.jpg', 'Dexter Montero', '0', '1'),
(15, '', 'asddaasd', 'adsdsadasdsa', 50000, 'asddaasd_275004593_499788075102988_589712622665686360_n.jpg', 'Dexter Montero', '0', '1'),
(16, '', 'asddaasd', 'adsdsadasdsa', 50000, 'asddaasd_275004593_499788075102988_589712622665686360_n.jpg', 'Dexter Montero', '0', '1'),
(17, '', 'gsadg', 'sdgg', 1200, 'gsadg_joe-caione-qO-PIF84Vxg-unsplash.jpg', 'Dexter Montero', '0', '1'),
(18, '', 'gsadg', 'sdgg', 1200, 'gsadg_joe-caione-qO-PIF84Vxg-unsplash.jpg', 'Dexter Montero', '0', '0'),
(19, '15', 'Pregnancy test', 'The blood test detects pregnancy in the the pregnant dog by measuring levels of a hormone called relaxin.', 1000, 'Pregnancy test_Pregnancytest.jpg', NULL, '1', '0'),
(20, '1', 'PREGNANCY TEST', 'The blood test detects pregnancy in the the pregnant dog by measuring levels of a hormone called relaxin. This hormone is produced by the developing placenta following implantation of the embryo, and can be detected in the blood in most pregnant females as early as 22-27 days post-breeding.', 1500, 'PREGNANCY TEST_Koala.jpg', NULL, '1', '1'),
(21, '1', 'Service Title', 'Service Description', 1200, 'Service Title_VAW.jpg', NULL, '1', '0');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_login_attempts`
--

CREATE TABLE `tbl_login_attempts` (
  `id` int(11) NOT NULL,
  `ip_address` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `counter` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Table structure for table `time_schedule`
--

CREATE TABLE `time_schedule` (
  `time_id` int(11) NOT NULL,
  `branch_id` varchar(150) NOT NULL,
  `time` time NOT NULL,
  `status` varchar(2) NOT NULL DEFAULT '0',
  `archive_status` varchar(2) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `time_schedule`
--

INSERT INTO `time_schedule` (`time_id`, `branch_id`, `time`, `status`, `archive_status`) VALUES
(5, '1', '09:00:00', '1', '0'),
(7, '1', '11:00:00', '1', '0'),
(8, '1', '13:00:00', '1', '0'),
(9, '1', '14:00:00', '1', '0'),
(10, '1', '15:00:00', '1', '0'),
(12, '1', '17:00:00', '1', '0'),
(13, '1', '18:00:00', '1', '0'),
(14, '1', '10:00:00', '1', '0'),
(15, '1', '16:00:00', '1', '0');

-- --------------------------------------------------------

--
-- Table structure for table `token`
--

CREATE TABLE `token` (
  `id` int(11) NOT NULL,
  `access_token` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `token`
--

INSERT INTO `token` (`id`, `access_token`) VALUES
(17, '{\"access_token\":\"eyJhbGciOiJIUzUxMiIsInYiOiIyLjAiLCJraWQiOiJmNTVjMTY4Mi01NmQzLTQwMDktYjJmYi0zYWJmMzZkMzk3NDYifQ.eyJ2ZXIiOjcsImF1aWQiOiJiOGVmOGYxMGQ0MjgwYmRmNjJiODEwZjU0Y2U3MzNhMiIsImNvZGUiOiJyUzVQR2VTSVREX3A1S1YyYnEwUW9LWjlBNy0yYl94V3ciLCJpc3MiOiJ6bTpjaWQ6T3BzVzA2NzVUOUNsUEVjeUdJblJYZyIsImdubyI6MCwidHlwZSI6MCwidGlkIjowLCJhdWQiOiJodHRwczovL29hdXRoLnpvb20udXMiLCJ1aWQiOiJwNUtWMmJxMFFvS1o5QTctMmJfeFd3IiwibmJmIjoxNjUyNjIyMDg5LCJleHAiOjE2NTI2MjU2ODksImlhdCI6MTY1MjYyMjA4OSwiYWlkIjoiSEpNZ2RiaE5TQkNKeFA0SExHeTRydyIsImp0aSI6ImY5ODMyZTQ5LTVlMGEtNGY0ZC1hODc3LTY2ZGJlYzUwYTkxZCJ9.KTWxSDxnFSZpufn86LfRdJRqYFahfbImPBt1D6_0erVnZl3SPykkTABE-AGvQbZy1EnIS--sU23_08daK5NhYQ\",\"token_type\":\"bearer\",\"refresh_token\":\"eyJhbGciOiJIUzUxMiIsInYiOiIyLjAiLCJraWQiOiI3MjVkYjQzMS1kOGIyLTQ1YjgtYWMzMi1mNzk2ZDI3Mjk0ZTgifQ.eyJ2ZXIiOjcsImF1aWQiOiJiOGVmOGYxMGQ0MjgwYmRmNjJiODEwZjU0Y2U3MzNhMiIsImNvZGUiOiJyUzVQR2VTSVREX3A1S1YyYnEwUW9LWjlBNy0yYl94V3ciLCJpc3MiOiJ6bTpjaWQ6T3BzVzA2NzVUOUNsUEVjeUdJblJYZyIsImdubyI6MCwidHlwZSI6MSwidGlkIjowLCJhdWQiOiJodHRwczovL29hdXRoLnpvb20udXMiLCJ1aWQiOiJwNUtWMmJxMFFvS1o5QTctMmJfeFd3IiwibmJmIjoxNjUyNjIyMDg5LCJleHAiOjIxMjU2NjIwODksImlhdCI6MTY1MjYyMjA4OSwiYWlkIjoiSEpNZ2RiaE5TQkNKeFA0SExHeTRydyIsImp0aSI6Ijg5MDU3MjQ5LWQzZGEtNGJkMS1hZjg5LThkZjRmZTQwNzdhMiJ9.-w9_4nI5zimdaBRPB_oIZQOJ0BVhnxVs2A5BTRIFJouXAmPQ7L2uPA-6PvDbdrrnUqbr2svQg1aQYb3zVZbFGA\",\"expires_in\":3599,\"scope\":\"meeting:master meeting:read:admin meeting:write:admin\"}');

-- --------------------------------------------------------

--
-- Table structure for table `user_profile`
--

CREATE TABLE `user_profile` (
  `profile_id` int(11) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `photo` varchar(255) NOT NULL DEFAULT 'default.png',
  `firstname` varchar(150) DEFAULT NULL,
  `middlename` varchar(150) DEFAULT NULL,
  `lastname` varchar(150) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `contact_number` varchar(13) DEFAULT NULL,
  `address` text,
  `gender` varchar(10) DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `place_bday` varchar(255) DEFAULT NULL,
  `civil_status` varchar(100) DEFAULT NULL,
  `guardian` varchar(255) DEFAULT NULL,
  `position` varchar(100) NOT NULL DEFAULT 'client',
  `file_documents` varchar(255) DEFAULT NULL,
  `upload_file` varchar(255) DEFAULT NULL,
  `id_type` varchar(255) DEFAULT NULL,
  `create_date` date DEFAULT NULL,
  `archive_status` varchar(2) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Table structure for table `vet_profile`
--

CREATE TABLE `vet_profile` (
  `vet_id` varchar(11) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `middlename` varchar(255) DEFAULT NULL,
  `lastname` varchar(255) NOT NULL,
  `photo` varchar(255) NOT NULL,
  `position` varchar(255) NOT NULL DEFAULT 'veterinarian',
  `branch_id` varchar(150) NOT NULL,
  `email` varchar(255) NOT NULL,
  `contact_number` varchar(13) DEFAULT NULL,
  `address` text,
  `gender` varchar(10) DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `place_bday` varchar(255) DEFAULT NULL,
  `civil_status` varchar(100) DEFAULT NULL,
  `create_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `vet_profile`
--

INSERT INTO `vet_profile` (`vet_id`, `firstname`, `middlename`, `lastname`, `photo`, `position`, `branch_id`, `email`, `contact_number`, `address`, `gender`, `birthdate`, `place_bday`, `civil_status`, `create_date`) VALUES
('2', 'Dexter', 'c', 'Montero', 'default.png', 'veterinarian', '1', 'veterinarian@gmail.com', '09123456789', 'b', 'male', '1999-11-09', 'a', NULL, '2021-11-01');

-- --------------------------------------------------------

--
-- Table structure for table `visitors`
--

CREATE TABLE `visitors` (
  `id` int(11) NOT NULL,
  `ip_address` varchar(255) NOT NULL,
  `date` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Table structure for table `zoom_meeting`
--

CREATE TABLE `zoom_meeting` (
  `id` int(11) NOT NULL,
  `login_id` varchar(255) NOT NULL,
  `to_client` varchar(100) DEFAULT NULL,
  `topic` varchar(255) DEFAULT NULL,
  `meeting_id` varchar(255) DEFAULT NULL,
  `link` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `time` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_profile`
--
ALTER TABLE `admin_profile`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `archive`
--
ALTER TABLE `archive`
  ADD PRIMARY KEY (`archive_id`);

--
-- Indexes for table `audit_logs`
--
ALTER TABLE `audit_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `billing`
--
ALTER TABLE `billing`
  ADD PRIMARY KEY (`bill_id`);

--
-- Indexes for table `blogs`
--
ALTER TABLE `blogs`
  ADD PRIMARY KEY (`blog_id`);

--
-- Indexes for table `branch`
--
ALTER TABLE `branch`
  ADD PRIMARY KEY (`branch_id`);

--
-- Indexes for table `calendar_events`
--
ALTER TABLE `calendar_events`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `diagnosis_records`
--
ALTER TABLE `diagnosis_records`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `invoice`
--
ALTER TABLE `invoice`
  ADD PRIMARY KEY (`invoice_id`);

--
-- Indexes for table `login_tbl`
--
ALTER TABLE `login_tbl`
  ADD PRIMARY KEY (`uid`);

--
-- Indexes for table `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`notify_id`);

--
-- Indexes for table `pet_profile`
--
ALTER TABLE `pet_profile`
  ADD PRIMARY KEY (`pet_id`);

--
-- Indexes for table `pet_treatment_records`
--
ALTER TABLE `pet_treatment_records`
  ADD PRIMARY KEY (`treatment_id`);

--
-- Indexes for table `prescription_records`
--
ALTER TABLE `prescription_records`
  ADD PRIMARY KEY (`prescription_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`review_id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`service_id`);

--
-- Indexes for table `tbl_login_attempts`
--
ALTER TABLE `tbl_login_attempts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `time_schedule`
--
ALTER TABLE `time_schedule`
  ADD PRIMARY KEY (`time_id`);

--
-- Indexes for table `token`
--
ALTER TABLE `token`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_profile`
--
ALTER TABLE `user_profile`
  ADD PRIMARY KEY (`profile_id`);

--
-- Indexes for table `vet_profile`
--
ALTER TABLE `vet_profile`
  ADD PRIMARY KEY (`vet_id`);

--
-- Indexes for table `visitors`
--
ALTER TABLE `visitors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `zoom_meeting`
--
ALTER TABLE `zoom_meeting`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `archive`
--
ALTER TABLE `archive`
  MODIFY `archive_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `audit_logs`
--
ALTER TABLE `audit_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `billing`
--
ALTER TABLE `billing`
  MODIFY `bill_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `blogs`
--
ALTER TABLE `blogs`
  MODIFY `blog_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `branch`
--
ALTER TABLE `branch`
  MODIFY `branch_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `calendar_events`
--
ALTER TABLE `calendar_events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `diagnosis_records`
--
ALTER TABLE `diagnosis_records`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `invoice`
--
ALTER TABLE `invoice`
  MODIFY `invoice_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `login_tbl`
--
ALTER TABLE `login_tbl`
  MODIFY `uid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `notification`
--
ALTER TABLE `notification`
  MODIFY `notify_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `pet_profile`
--
ALTER TABLE `pet_profile`
  MODIFY `pet_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `pet_treatment_records`
--
ALTER TABLE `pet_treatment_records`
  MODIFY `treatment_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prescription_records`
--
ALTER TABLE `prescription_records`
  MODIFY `prescription_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `review_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `service_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `tbl_login_attempts`
--
ALTER TABLE `tbl_login_attempts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `time_schedule`
--
ALTER TABLE `time_schedule`
  MODIFY `time_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `token`
--
ALTER TABLE `token`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `user_profile`
--
ALTER TABLE `user_profile`
  MODIFY `profile_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `visitors`
--
ALTER TABLE `visitors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `zoom_meeting`
--
ALTER TABLE `zoom_meeting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
