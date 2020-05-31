-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 31, 2020 at 02:45 AM
-- Server version: 10.1.37-MariaDB
-- PHP Version: 7.3.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gameoverflow`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `description`, `image`) VALUES
(1, 'Action Games', 'action', 'Action games are just that games where the player is in control of and at the center of the action, which is mainly comprised of physical challenges players must overcome. Most early video games like Donkey Kong and Galaga fall into the action category.', 'img/categories/cat-1.jpg'),
(2, 'Action-adventure Games', 'action-adventure', 'Action-adventure games most frequently incorporate two game mechanics-game-long quests or obstacles that must be conquered using a tool or item collected, as well as an action element where the item(s) are used.', 'img/categories/cat-2.jpg'),
(3, 'Adventure Games', 'adventure', 'Adventure games are categorized by the style of gameplay, not the story or content. And while technology has given developers new options to explore storytelling in the genre, at a basic level, adventure games haven\'t evolved much from their text-based origins.', 'img/categories/cat-3.jpg'),
(4, 'Role-Playing Games', 'rpg', 'RPGs, mostly feature medieval or fantasy settings. This is due mainly to the origin of the genre, which can be traced back to Dungeons & Dragons and other pen and paper role-playing games. Still, hardcore RPGers don\'t discount sci-fi fantasy-themed RPGs like Mass Effect, Fallout, and Final Fantasy, which have helped put unique spins on the genre.', 'img/categories/cat-4.jpg'),
(5, 'Simulation Games', 'simulation', 'Games in the simulation genre have one thing in common, they\'re all designed to emulate real or fictional reality, to simulate a real situation or event.', 'img/categories/cat-5.jpg'),
(6, 'Strategy Games', 'strategy', 'With gameplay is based on traditional strategy board games, strategy games give players a godlike access to the world and its resources. These games require players to use carefully developed strategy and tactics to overcome challenges. More recently, these type of games have moved from turn-based systems to real-time gameplay in response to player feedback.', 'img/categories/cat-1.jpg'),
(7, 'Sports Games', 'sports', 'Sports games simulate sports like golf, football, basketball, baseball, and soccer. They can also include Olympic sports like skiing, and even pub sports like darts and pool. Opposing players in these games are often computer-controlled but can also take the form of live opponents.', 'img/categories/cat-2.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `developers`
--

CREATE TABLE `developers` (
  `id` bigint(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text,
  `website` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `developers`
--

INSERT INTO `developers` (`id`, `name`, `description`, `website`, `created_at`, `updated_at`) VALUES
(1, 'Valve', 'Developer, publisher and distributor', 'https://www.valvesoftware.com/', '2020-05-24 04:29:28', NULL),
(2, 'Epic Games', 'Developer, publisher, and distributor', 'https://www.epicgames.com', '2020-05-24 04:29:28', NULL),
(3, 'Ubisoft', 'Developer/publisher', 'https://www.ubisoft.com', '2020-05-24 04:29:29', NULL),
(4, 'Konami', 'Developer/publisher', 'https://www.konami.com/', '2020-05-25 19:25:39', NULL),
(5, 'Electronic Arts', 'Developer, publisher, and distributor', 'https://www.ea.com', '2020-05-25 19:27:34', NULL),
(6, 'Red Barrels', 'Developer', 'https://redbarrelsgames.com', '2020-05-25 19:27:34', NULL),
(7, 'Rockstar North', 'Developer, publisher', 'http://www.rockstarnorth.com', '2020-05-25 19:27:34', NULL),
(8, 'Blizzard Entertainment', 'Developer, publisher, and distributor', 'http://www.blizzard.com', '2020-05-25 19:27:34', NULL),
(9, 'Square Enix', 'Developer, publisher', 'http://www.square-enix.com', '2020-05-25 19:27:34', NULL),
(10, 'Platinum Games', 'Developer, publisher', 'https://www.platinumgames.com', '2020-05-25 19:27:34', NULL),
(11, 'Atlus', 'Developer, publisher', 'https://www.atlus.co.jp', '2020-05-25 19:27:34', NULL),
(12, 'ArenaNet', 'Developer, publisher', 'http://www.arena.net', '2020-05-25 19:27:34', NULL),
(13, 'Playdead ApS', 'Developer, publisher', 'http://www.playdead.com', '2020-05-25 19:27:34', NULL),
(14, 'Supergiant Games', 'Developer, publisher', 'http://www.supergiantgames.com', '2020-05-25 19:27:34', NULL),
(15, 'Hopoo Games', 'Developer, publisher', 'http://hopoogames.com', '2020-05-25 19:27:34', NULL),
(16, 'FromSoftware, Inc.', 'Developer, publisher', 'http://fromsoftware.jp', '2020-05-25 19:27:34', NULL),
(17, 'Relic Entertainment', 'Developer, publisher', 'https://www.relic.com', '2020-05-25 19:27:34', NULL),
(18, 'Slightly Mad Studios', 'Developer, publisher', 'http://www.slightlymadstudios.com', '2020-05-25 19:27:34', NULL),
(19, 'Rocksteady Studios', 'Developer, publisher', 'http://rocksteadyltd.com', '2020-05-25 19:27:34', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

CREATE TABLE `invoices` (
  `id` bigint(20) NOT NULL,
  `order_id` bigint(20) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `no` varchar(32) NOT NULL,
  `description` varchar(250) DEFAULT NULL,
  `due_date` datetime DEFAULT NULL COMMENT 'Jatuh tempo',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `invoices`
--

INSERT INTO `invoices` (`id`, `order_id`, `title`, `no`, `description`, `due_date`, `created_at`, `updated_at`) VALUES
(32, 217, 'Invoice untuk Order #217', 'INV-159077048', NULL, '2020-06-05 23:41:20', '2020-05-29 23:41:20', NULL),
(33, 218, 'Invoice untuk Order #218', 'GO-159077595', NULL, '2020-06-06 01:12:31', '2020-05-29 01:12:31', '2020-05-31 01:11:32'),
(34, 219, 'Invoice untuk Order #219', 'GO-159078801', NULL, '2020-06-06 04:33:35', '2020-06-29 04:33:35', '2020-05-31 01:11:45'),
(35, 220, 'Invoice untuk Order #220', 'GO-159086194', NULL, '2020-06-07 01:05:39', '2020-06-29 01:05:40', '2020-05-31 01:12:39'),
(36, 221, 'Invoice untuk Order #221', 'GO-159086900', NULL, '2020-06-07 03:03:20', '2020-05-31 03:03:21', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0. Awaiting payment, 1. Processing, 2. Completed, 3. Cancelled',
  `description` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `status`, `description`, `created_at`, `updated_at`) VALUES
(217, 17, 2, 'Fast', '2020-05-29 23:41:19', '2020-05-30 04:34:26'),
(218, 17, 2, '', '2020-05-29 00:00:00', '2020-05-31 04:26:27'),
(219, 4, 2, '', '2020-05-29 00:00:00', '2020-05-31 04:26:34'),
(220, 4, 2, 'Proses ya min!', '2020-05-29 00:00:00', '2020-05-31 04:26:41'),
(221, 4, 1, '', '2020-05-31 03:03:19', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` bigint(20) NOT NULL,
  `order_id` bigint(20) NOT NULL,
  `product_id` bigint(20) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `price`) VALUES
(85, 217, 1, 1, 150000),
(86, 218, 3, 1, 1180000),
(87, 218, 2, 2, 689000),
(88, 219, 2, 1, 689000),
(89, 220, 2, 2, 689000),
(90, 221, 3, 2, 1180000);

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` bigint(20) NOT NULL,
  `order_id` bigint(20) NOT NULL,
  `amount` bigint(20) NOT NULL,
  `bank_name` varchar(255) NOT NULL COMMENT 'Nama Bank',
  `bank_number` varchar(50) NOT NULL COMMENT 'No Rekening',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0 =PENDING, 1 => CONFIRMED',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `order_id`, `amount`, `bank_name`, `bank_number`, `status`, `created_at`, `updated_at`) VALUES
(2, 217, 150000, 'BCA', '0203018239', 1, '2020-05-29 23:41:20', '2020-05-30 02:19:09'),
(3, 218, 2558000, 'BCA', '2000582571', 1, '2020-05-29 01:12:31', '2020-05-31 04:27:04'),
(4, 219, 689000, 'MANDIRI', '1231234124123', 1, '2020-05-29 04:33:35', '2020-05-31 04:27:11'),
(5, 220, 1378000, 'BCA', '123124123123', 1, '2020-05-29 01:05:39', '2020-05-31 04:27:18'),
(6, 221, 2360000, 'BTN', '123121231454', 0, '2020-05-31 03:03:20', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) NOT NULL,
  `developer_id` bigint(20) NOT NULL,
  `code` varchar(50) NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `price` bigint(20) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `short_description` mediumtext,
  `description` text,
  `category_id` bigint(20) NOT NULL,
  `released_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `developer_id`, `code`, `title`, `slug`, `price`, `image`, `short_description`, `description`, `category_id`, `released_at`, `created_at`, `updated_at`) VALUES
(1, 1, 'CSGO', 'Counter-Strike: Global Offensive', 'csgo', 150000, 'https://steamcdn-a.akamaihd.net/steam/subs/54029/capsule_616x353.jpg', 'Counter-Strike: Global Offensive (CS: GO) expands upon the team-based action gameplay that it pioneered when it was launched 19 years ago. CS: GO features new maps, characters, weapons, and game modes, and delivers updated versions of the classic CS content (de_dust2, etc.).', 'Counter-Strike: Global Offensive (CS: GO) expands upon the team-based action gameplay that it pioneered when it was launched 19 years ago.\r\n\r\nCS: GO features new maps, characters, weapons, and game modes, and delivers updated versions of the classic CS content (de_dust2, etc.).\r\n\r\n\"Counter-Strike took the gaming industry by surprise when the unlikely MOD became the most played online PC action game in the world almost immediately after its release in August 1999,\" said Doug Lombardi at Valve. \"For the past 12 years, it has continued to be one of the most-played games in the world, headline competitive gaming tournaments and selling over 25 million units worldwide across the franchise. CS: GO promises to expand on CS\' award-winning gameplay and deliver it to gamers on the PC as well as the next gen consoles and the Mac.\"', 4, '2012-08-21 00:00:00', '2020-05-24 04:40:43', NULL),
(2, 3, 'ASSASSIN-CREED-ODYSSEY', 'Assassin&#039;s Creed&reg; Odyssey', 'assassin-creed-odyssey', 689000, 'https://steamcdn-a.akamaihd.net/steam/apps/812140/ss_16fc551879ac299dca68839da90f89d9e624db48.600x338.jpg', 'Choose your fate in Assassin&#039;s Creed&reg; Odyssey. From outcast to living legend, embark on an odyssey to uncover the secrets of your past and change the fate of Ancient Greece.', 'Choose your fate in Assassin&#039;s Creed&reg; Odyssey.\r\nFrom outcast to living legend, embark on an odyssey to uncover the secrets of your past and change the fate of Ancient Greece.\r\n\r\nTRAVEL TO ANCIENT GREECE\r\nFrom lush vibrant forests to volcanic islands and bustling cities, start a journey of exploration and encounters in a war torn world shaped by gods and men.\r\n\r\nFORGE YOUR LEGEND\r\nYour decisions will impact how your odyssey unfolds. Play through multiple endings thanks to the new dialogue system and the choices you make. Customize your gear, ship, and special abilities to become a legend.\r\n\r\nFIGHT ON A NEW SCALE\r\nDemonstrate your warrior\'s abilities in large scale epic battles between Athens and Sparta featuring hundreds of soldiers, or ram and cleave your way through entire fleets in naval battles across the Aegean Sea.\r\n\r\nGAZE IN WONDER\r\nExperience the action in a whole new light with Tobii Eye Tracking. The Extended View feature gives you a broader perspective of the environment, and the Dynamic Light and Sun Effects immerse you in the sandy dunes according to where you set your sights. Tagging, aiming and locking on your targets becomes a lot more natural when you can do it by looking at them. Let your vision lead the way and enhance your gameplay.\r\nVisit the Tobii website to check the list of compatible devices.\r\n-----\r\nAdditional notes:\r\nEye tracking features available with Tobii Eye Tracking.', 2, '2018-10-06 00:00:00', '2020-05-24 23:24:27', NULL),
(3, 5, 'BF-V', 'Battlefield V', 'bf-v', 1180000, 'https://media.contentapi.ea.com/content/dam/bf/common/year2-fpo.adapt.1456w.', 'Welcome to the best way to join Battlefield™ V. Experience WW2 as you’ve never seen it before, including a host of rewards: all weapons and vehicles across year one of the Battlefield V Tides of War Chapters and the most popular weapon and vehicle skins. Plus, customize your Company with two Epic soldier outfits! Stand out on the battlefield, and in the middle of a firefight.', 'The Battlefield V Year 2 Edition arms you with the base game and its vast arsenal, together with a catch-up of all weapons and vehicles rewarded across year one of the Battlefield V Tides of War Chapters (Chapter 1 to 4). On top of that, you’ll get to customize your Company with two Epic soldier outfits and stand out on the battlefield with the most popular weapon and vehicle skins rewarded during the year.\r\n\r\nLet’s break it down. Below is the content of the Battlefield V Year 2 Edition.\r\n\r\nBattlefield V base game: WW2 as you’ve never seen it before. Deploy into all-out war multiplayer and experience gripping single-player War Stories.\r\nIn addition to all the base game weapons, vehicles, and outfits, you’ll also get these Tides of War rewards from year one:\r\n\r\n17 Primary Weapons: Powerful firearms you missed during Tides of War await, including the Boys AT Rifle, MAB 38, ZK-383, and many more.\r\n4 Vehicles: Pilot heavy machinery including the Archer tank destroyer and three other vehicles rewarded during the year.\r\n2 Epic Soldier Outfits: Fight with flair with the Double Down and Baron von Zorn uniforms.\r\n10 Weapon Skins: Adorn your arsenal with Epic skins like the Napalm and White Tiger.\r\n4 Vehicle Skins: Give vehicles like the Stug IV and Spitfire Mk VB paint jobs of the Epic kind.', 1, '2018-11-15 00:00:00', '2020-05-25 19:43:37', NULL),
(4, 5, 'FF-2', 'Feeding Frenzy 2', 'ff-2', 0, 'https://media.contentapi.ea.com/content/dam/gin/images/2017/11/feeding-frenzy-2-ss-3.jpg.adapt.crop16x9.818p.jpg', 'The feeding frenzy begins again! Swim and swerve through underwater worlds, chow down on smaller fish, and chomp your way to ocean supremacy. But watch out: boatloads of pesky predators are looking to make lunch out of you.', 'Hook some wild power-ups\r\nGet an advantage over your prey with Shrink Shrooms, Looney Lures and more.\r\n\r\nPlay as seven different fish\r\nSlip into the fins of a butterflyfish, a great white shark and more as you nosh your way through\r\nthe deep.\r\n\r\nSplash through two different modes\r\nGet your fins wet in Adventure mode, or test your skills in the time-limited Time Attack! mode.\r\n\r\nSurvive 60 stunning levels\r\nFrom sandy shoal to open ocean, ride the tide through coral reefs and sunken ships while\r\nenjoying a steady diet of delicious fish. Discover a mysterious intruder threatening your ocean\r\nhome, and eat your way to the top of the food chain to defeat it.', 3, '2016-02-06 00:00:00', '2020-05-25 19:53:03', NULL),
(5, 5, 'fe', 'Fe', 'fe_', 370000, 'https://media.contentapi.ea.com/content/dam/ea/Fe/fe-screenshot-homepage-1-16x9.jpg.adapt.crop16x9.1455w.jpg', 'Become Fe and discover a world that you will never want to leave.\r\n\r\nRun, climb, and glide your way through a dark Nordic forest to explore its living, breathing world – one filled with secrets, legends, and mystical creatures.', 'SPEAK THE LANGUAGE OF THE FOREST\r\nMaster a diverse array of cries to befriend every animal or plant and have them help you on your journey. Each having uniquely distinct attributes, abilities and behaviors that will help you to unlock and traverse new areas of the forest. \r\n\r\nDISCOVER A WORLD WORTH EXPLORING\r\nEmbarking on your voyage, you’ll find everything is connected, and nothing is what it first seems. Secret places, hidden artifacts, old ruins, shortcuts, and powers makes exploring endlessly fun.\r\n\r\nUNCOVER THE MYSTERIES OF NATURE\r\nUnravel the secrets of the menacing Silent Ones on your journey through the forest, aiding fantastical creatures in handcrafted short stories while learning the secret of Fe’s origin.\r\n\r\nENJOY UNPARALLELED FREEDOM OF EXPLORATION\r\nEffortlessly traverse the entire forest. Gracefully glide from tree to tree. Use stealth and agility to evade danger, observe nature, and hide in the shadows. Ascend the treetops to plan your next move.\r\n\r\nGO UP AGAINST THE SILENT ONES\r\nWhile the forest is an astounding place, the Silent Ones are threatening this magical world\'s harmony. To make it a home again, you must stop them.', 3, '2018-02-16 00:00:00', '2020-05-25 19:59:12', NULL),
(6, 4, 'mgsv-tpp', 'Metal Gear Solid V: The Phantom Pain', 'mgsvtpp', 235000, 'https://steamcdn-a.akamaihd.net/steam/apps/287700/header.jpg?t=1581382198', 'The Soviet invasion of Afghanistan has brought a new edge to the Cold War, and in 1984, a one-eyed man with a prosthetic arm appears in the country. Those who know him call him Snake; the legendary mercenary who was once swept from the stage of history and left in a coma by American private intelligence network Cipher. Snake is accompanied by Ocelot, an old friend who saved him from attack when he finally awoke.', 'Konami Digital Entertainment continues forth the ‘METAL GEAR SOLID V Experience’ with the latest chapter, METAL GEAR SOLID V: The Phantom Pain. Ushering in a new era for the franchise with cutting-edge technology powered by the Fox Engine, MGSV: The Phantom Pain will provide players a first-rate gaming experience as they are offered tactical freedom to carry out open-world missions.\r\n\r\nNine years after the events of MGSV: GROUND ZEROES and the fall of Mother Base, Snake a.k.a. Big Boss, awakens from a nine year coma. The year is 1984. The Cold War serves as the backdrop as nuclear weapons continue to shape a global crisis. Driven by revenge, Snake establishes a new private army and returns to the battlefield in pursuit of the shadow group, XOF.\r\n\r\nThe METAL GEAR SOLID team continues to ambitiously explore mature themes such as the psychology of warfare and the atrocities that result from those that engage in its vicious cycle. One of the most anticipated games of the year with its open-world design, photorealistic visual fidelity and feature-rich game design, MGSV: The Phantom Pain will leave its mark as one of the hallmarks in the gaming industry for its cinematic storytelling, heavy themes, and immersive tactical gameplay.\r\n\r\nKey Features:\r\n- Open-World game design allowing players ultimate freedom on how to approach missions and overall game progression\r\n- Fox Engine delivers photorealistic graphics, thoughtful game design and true new-generation game production quality\r\n- Online connectivity that carries the experience beyond the consoles to other devices to augment the overall functionality and access to the game.', 6, '2015-09-01 00:00:00', '2020-05-25 20:21:56', NULL),
(7, 4, 'mgsv-gz', 'Metal Gear Solid V: Ground Zeroes', 'mgsvgz', 200000, 'https://steamcdn-a.akamaihd.net/steam/apps/311340/header.jpg?t=1581382125', 'World-renowned Kojima Productions showcases another masterpiece in the Metal Gear Solid franchise with Metal Gear Solid V: Ground Zeroes. Metal Gear Solid V: Ground Zeroes is the first segment of the ‘Metal Gear Solid V Experience’ and prologue to the larger second segment, Metal Gear Solid V: The Phantom Pain launching thereafter.', 'MGSV: GZ gives core fans the opportunity to get a taste of the world-class production’s unparalleled visual presentation and gameplay before the release of the main game. It also provides an opportunity for gamers who have never played a Kojima Productions game, and veterans alike, to gain familiarity with the radical new game design and unparalleled style of presentation.\r\n\r\n\r\nThe critically acclaimed Metal Gear Solid franchise has entertained fans for decades and revolutionized the gaming industry. Kojima Productions once again raises the bar with the FOX Engine offering incredible graphic fidelity and the introduction of open world game design in the Metal Gear Solid universe. This is the experience that core gamers have been waiting for.\r\n\r\n\r\nKey Features:\r\n\r\n• THE POWER OF FOX ENGINE – Ground Zeroes showcases Kojima Productions’ stunning FOX Engine, a true next-generation game engine which revolutionizes the Metal Gear Solid experience.\r\n\r\n• INTRODUCTION TO OPEN WORLD DESIGN – The first Metal Gear Solid title to offer open world gameplay. Ground Zeroes offers total freedom of play: how missions are undertaken is entirely down to the user.\r\n\r\n• UNRESTRICTED STEALTH – Imagine classic Metal Gear gameplay but with no restrictions or boundaries. Players use intelligence and cerebral strategy to sneak their way through entire missions, or go in all guns blazing. Each will have different effects on game consequences and advancement.\r\n\r\n• MULTIPLE MISSIONS AND TASKS –Ground Zeroes boasts a central story mode and Side-Ops missions ranging from tactical action, aerial assaults and “covert” missions that will be sure to surprise.\r\n\r\n• REDESIGNED INTERFACE – Ground Zeroes users will benefit from a clean in-game HUD that shows the minimal amount of on-screen data to give a more intense gaming experience.', 6, '2014-03-20 00:00:00', '2020-05-25 20:26:06', NULL),
(8, 3, 'hawx', 'Tom Clancy\'s H.A.W.X', 'hawx', 62000, 'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/apps/21900/a7848e80665419cf67e76b9c24603c0f3b69a44f.jpg', 'Tom Clancy\'s HAWX puts you behind the throttle, in the fighter pilot\'s seat. As a member of the elite HAWX squadron, you\'ll find yourself manning cutting-edge aircraft, training on all the newest weapons, and carrying out dangerous top-secret missions set against the backdrop of a chaotic future, where private military companies (PMCs) are constantly putting your skills to the test and forcing you to defend your reputation as one of the top military pilots on Earth.', 'Shifting International Dynamics: The Hazards of PMC Warfare\r\nSet between Tom Clancy\'s Ghost Recon Advanced Warfighter 2 and Tom Clancy\'s EndWar from the popular Ghost series, Tom Clancy\'s HAWX takes place in a world where warfare is constantly evolving--a time when state-sponsored militaries lack the funds and personnel to modernize their forces and elite, private mercenary groups have grown in size and scope to pick up the slack.\r\nThe Reykjavik Accords of 2012 defined the role of these PMCs in combat, and they made it fully legal for these groups to purchase from the international armaments market, leading to a shift in the structure of global military power. Over time, you\'ll do battle on the front lines of both sides as this shift reveals high-stakes arms threats and a terrifying glimpse of the future.\r\n\r\nHAWX: The Elite, High Altitude Warfare eXperimental Squadron\r\nYou\'ll begin the game as former U.S. Air Force Pilot David Crinshaw, assigned to provide air support for the well-known Ghost Recon team. You and your fellow HAWX pilots are some of the most highly-trained specialists in the world. Based out of Langley Air Force Base in Virginia, you\'re tasked with everything from testing secret and experimental aircraft weapon systems to carrying out combat and recon missions, training other top pilots, and attempting to capture enemy technologies.\r\n\r\nWith the rise of the PMCs, your unique skills in higher demand than ever before. And with 49 playable planes available in game, plus additional planes available to some pilots through pre-order bonuses or VIP memberships, there\'s no shortage of sleek, fast, deadly aircraft at your disposal as you put your skills to use.\r\n\r\nAn Iconic, Enhanced Reality System to Help You Deliver Results\r\nWhen you\'re in the midst of a firefight, E.R.S. in-game technology can help anyone survive, if you know how to take advantage of it. Featuring incoming missile detection, an anti-crash system, damage assessment, a tactical map, and weapons trajectory control, E.R.S. even allows you to issue orders to your squadron and other units, much like the iconic Cross-Com system in other Tom Clancy games. When you\'re getting started, you can ease into the rigors of flight and gain confidence by using a special assistance mode that offers support through the E.R.S. This mode can be switched off at any time, deactivating safety features and allowing you to perform advanced maneuvers.\r\n\r\nCutting-Edge Realism and Innovative Multi-Player Modes\r\nWhether you\'re in a classic F15 Fighting Falcon or a new-generation Gripen, the controls and flight graphics are designed to keep you on your toes. And the game\'s photo-realistic environments have been created using detailed satellite data. When you pull back on the throttle to jet all over the world, you\'ll experience this authentic world from a variety of viewpoints.\r\n\r\nGame play options aren\'t limited either, with the campaign featuring solo and multiplayer options with seamless jump in/jump out functionality, and a PVP mode where players can challenge each other to dog-fights for bragging rights, earning experience points and cash, and unlocking additional weapons.', 5, '2009-03-18 00:00:00', '2020-05-25 20:35:51', NULL),
(9, 3, 'hawx-2', 'Tom Clancy\'s H.A.W.X. 2', 'hawx2', 80000, 'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/apps/48160/dc4b24167aa2d3ad95dea4c5b15cb71db3335d51.jpg', 'Aerial warfare has evolved. So have you. As a member of the ultra-secret HAWX 2 squadron, you are one of the chosen few. One of the truly elite. You will use finely honed reflexes, bleeding-edge technology and ultra-sophisticated aircraft – their existence denied by many governments – to dominate the skies. You will do so by mastering every nuance of the world’s finest combat aircraft. You will slip into enemy territory undetected, deliver a crippling blow and escape before he can summon a response. You will use your superior technology to decimate the enemy from afar, then draw him in close for a pulse-pounding dogfight. You will do all this with professionalism, skill and consummate lethality. Because you are a member of HAWX 2. And you are one of the finest military aviators the world has ever known.', 'Synopsis\r\nThis is the moment you\'ve been waiting and training for your whole life - you are at the controls of the most technologically advanced aircraft on the planet. Your palms are slick with sweat, but you won\'t lose your grip, because the mission depends on you staying cool and in control. You have been chosen for this job and it\'s up to you as an elite aerial soldier to protect life as you know it.\r\n\r\nThis highly anticipated sequel to Tom Clancy\'s H.A.W.X. lands you in the cockpit of the world\'s most technologically advanced fighter jet. Become an elite aerial soldier as you complete adrenaline-pumping airborne missions high above the Earth. Will you be able to soar with the best? You will take off into an explosive environment where you are in control of the world\'s most powerful and technologically advanced aircraft. Pilot these elite aerial machines in intense heart-racing airborne missions.\r\n\r\nKey Features:\r\nEnlist as an elite aerial soldier in control of the world\'s most technologically advanced aircraft\r\nUse cutting-edge technology in amazing airborne attacks\r\nComplete adrenaline-pumping missions high above the ground\r\nDirectly inspired by Tom Clancy\'s books\r\nSequel to the renowned Tom Clancy\'s H.A.W.X.', 5, '2010-02-09 00:00:00', '2020-05-25 20:41:09', NULL),
(10, 2, 'shadow-complex', 'Shadow Complex Remastered', 'shadow-complex-re', 115000, 'https://steamcdn-a.akamaihd.net/steam/apps/385560/header.jpg?t=1470279978', 'ChAIR’s fresh twist on classic side-scrolling design with modern gameplay is amplified in Shadow Complex Remastered. 10+ hrs of exploration and fast-paced combat from award-winning original game, updated with graphical enhancements, dynamic melee take-downs, and new Master Challenges.\r\nALL REVIEWS:', 'Powered by Unreal Engine technology, the “modern and masterful side-scroller” Shadow Complex became an instant classic when initially released in 2009, exclusively for Xbox 360. The fan favorite won more than 50 Game of the Year and Editor’s Choice Awards and was one of the most popular console games of the year. Shadow Complex Remastered features all the great content from the original game updated with exciting new enhancements and achievements to support its debut on Steam.\r\n\r\nGiant Bomb - \"5 out of 5 Stars - Amazing from start to finish!\"\r\nIGN - \"The classic, exploration-heavy gameplay is a winner.\"\r\nGameSpot - \"An incredible adventure that won\'t be forgotten.\"\r\nWorthplaying - \"A love letter to Super Metroid\"\r\n\r\nGame Play Overview:\r\nChAIR’s fresh twist on classic side-scrolling design with modern, cutting-edge gameplay is amplified in Shadow Complex Remastered, featuring all the content from the award-winning original game, updated with graphical enhancements, all-new dynamic melee take-downs, and additional Achievements and Master Challenges.\r\nThrough 10+ hours of exploration and fast-paced combat, you’ll discover game-altering power-ups to overcome obstacles, thwart legions of enemies, and delve further into a mysterious and challenging, non-linear game world.\r\n\r\nCore Game Play Elements:\r\n- Original single-player experience inspired by classic non-linear exploration side-scrolling genre\r\n- Open world design that evolves as the player explores and progresses through the game\r\n- Huge, mysterious game world populated with legions of enemies, challenges, and jaw-dropping boss battles\r\n- Dozens of unique game-altering power-ups and more than 100 additional items and enhancements to discover\r\n- Intense game play infused with a compelling action-thriller storyline\r\n- Incredible graphics with robust physics, made possible by Epic Games’ Unreal Engine 3\r\n- Bonus Proving Grounds game mode provides side-challenges to help players become the ultimate Shadow Complex master\r\n\r\nUpdated Features:\r\n- Up-rezzed characters, enemies, environments, and interface\r\n- Updated lighting, post-processing, and visual effects\r\n- New contextual melee take-downs\r\n- New Achievements and Master Challenges\r\n- Supports keyboard/mouse and PC controller with customizable controller and key bindings, and up to 4K resolution support\r\n\r\nStory Synopsis:\r\nShadow Complex propels lost hiker Jason Fleming into the hollows of government conspiracy, dark political motives, and military upheaval. When Jason and his girlfriend Claire accidentally stumble upon a rogue paramilitary group called The Restoration, it soon becomes clear that the faction’s intent is to set in motion a chain of events that will cause America to collapse into a new civil war. Along the way, Jason acquires many high-tech “toys” The Restoration is developing, and eventually becomes a super-powered engine of destruction.', 1, '2016-05-03 00:00:00', '2020-05-25 21:19:25', NULL),
(11, 7, 'gta-v', 'Grand Theft Auto V', 'grand-theft-auto-v', 290000, 'https://steamcdn-a.akamaihd.net/steam/apps/271590/header.jpg?t=1586539531', '<p>Grand Theft Auto V for PC offers players the option to explore the award-winning world of Los Santos and Blaine County in resolutions of up to 4k and beyond, as well as the chance to experience the game running at 60 frames per second.<br></p>', '<p>When a young street hustler, a retired bank robber and a terrifying psychopath find themselves entangled with some of the most frightening and deranged elements of the criminal underworld, the U.S. government and the entertainment industry, they must pull off a series of dangerous heists to survive in a ruthless city in which they can trust nobody, least of all each other.<br style=\"padding: 0px; margin: 0px;\"><br style=\"padding: 0px; margin: 0px;\">Grand Theft Auto V for PC offers players the option to explore the award-winning world of Los Santos and Blaine County in resolutions of up to 4k and beyond, as well as the chance to experience the game running at 60 frames per second.<br style=\"padding: 0px; margin: 0px;\"><br style=\"padding: 0px; margin: 0px;\">The game offers players a huge range of PC-specific customization options, including over 25 separate configurable settings for texture quality, shaders, tessellation, anti-aliasing and more, as well as support and extensive customization for mouse and keyboard controls. Additional options include a population density slider to control car and pedestrian traffic, as well as dual and triple monitor support, 3D compatibility, and plug-and-play controller support.<br style=\"padding: 0px; margin: 0px;\"><br style=\"padding: 0px; margin: 0px;\">Grand Theft Auto V for PC also includes Grand Theft Auto Online, with support for 30 players and two spectators. Grand Theft Auto Online for PC will include all existing gameplay upgrades and Rockstar-created content released since the launch of Grand Theft Auto Online, including Heists and Adversary modes.<br style=\"padding: 0px; margin: 0px;\"><br style=\"padding: 0px; margin: 0px;\">The PC version of Grand Theft Auto V and Grand Theft Auto Online features First Person Mode, giving players the chance to explore the incredibly detailed world of Los Santos and Blaine County in an entirely new way.<br style=\"padding: 0px; margin: 0px;\"><br style=\"padding: 0px; margin: 0px;\">Grand Theft Auto V for PC also brings the debut of the Rockstar Editor, a powerful suite of creative tools to quickly and easily capture, edit and share game footage from within Grand Theft Auto V and Grand Theft Auto Online. The Rockstar Editor’s Director Mode allows players the ability to stage their own scenes using prominent story characters, pedestrians, and even animals to bring their vision to life. Along with advanced camera manipulation and editing effects including fast and slow motion, and an array of camera filters, players can add their own music using songs from GTAV radio stations, or dynamically control the intensity of the game’s score. Completed videos can be uploaded directly from the Rockstar Editor to YouTube and the Rockstar Games Social Club for easy sharing.<br style=\"padding: 0px; margin: 0px;\"><br style=\"padding: 0px; margin: 0px;\">Soundtrack artists The Alchemist and Oh No return as hosts of the new radio station, The Lab FM. The station features new and exclusive music from the production duo based on and inspired by the game’s original soundtrack. Collaborating guest artists include Earl Sweatshirt, Freddie Gibbs, Little Dragon, Killer Mike, Sam Herring from Future Islands, and more. Players can also discover Los Santos and Blaine County while enjoying their own music through Self Radio, a new radio station that will host player-created custom soundtracks.<br style=\"padding: 0px; margin: 0px;\"><br style=\"padding: 0px; margin: 0px;\">Special access content requires Rockstar Games Social Club account. Visit&nbsp;<a href=\"https://steamcommunity.com/linkfilter/?url=http://rockstargames.com/v/bonuscontent\" target=\"_blank\" rel=\"noopener\" style=\"padding: 0px; margin: 0px;\">http://rockstargames.com/v/bonuscontent</a>&nbsp;for details.<br></p>', 1, '2015-04-14 00:00:00', '2020-05-31 05:45:44', '2020-05-31 05:48:14'),
(12, 3, 'far-cry-5', 'Far Cry&reg; 5', 'far-cry-5', 689000, 'https://steamcdn-a.akamaihd.net/steam/apps/552520/header.jpg?t=1575655495', '<p>Welcome to Hope County, Montana, home to a fanatical doomsday cult known as Eden’s Gate. Stand up to cult leader Joseph Seed &amp; his siblings, the Heralds, to spark the fires of resistance &amp; liberate the besieged community.<br></p>', '<p>Far Cry comes to America in the latest installment of the award-winning franchise.<br style=\"padding: 0px; margin: 0px;\"><br style=\"padding: 0px; margin: 0px;\">Welcome to Hope County, Montana, land of the free and the brave but also home to a fanatical doomsday cult known as Eden’s Gate. Stand up to cult leader Joseph Seed, and his siblings, the Heralds, to spark the fires of resistance and liberate the besieged community.<br style=\"padding: 0px; margin: 0px;\"><br style=\"padding: 0px; margin: 0px;\"><b>FIGHT AGAINST A DEADLY CULT</b><br style=\"padding: 0px; margin: 0px;\">Free Hope County in solo or two-player co-op. Recruit Guns and Fangs for hire to help defeat the cult.<br style=\"padding: 0px; margin: 0px;\"><br style=\"padding: 0px; margin: 0px;\"><b>A WORLD THAT HITS BACK</b><br style=\"padding: 0px; margin: 0px;\">Wreak havoc on the cult and its members but beware of the wrath of Joseph Seed and his followers.<br style=\"padding: 0px; margin: 0px;\"><br style=\"padding: 0px; margin: 0px;\"><b>CARVE YOUR OWN PATH</b><br style=\"padding: 0px; margin: 0px;\">Build your character and choose your adventure in the largest customizable Far Cry game ever!<br style=\"padding: 0px; margin: 0px;\"><br style=\"padding: 0px; margin: 0px;\"><b>DYNAMIC TOYS</b><br style=\"padding: 0px; margin: 0px;\">Take control of iconic muscle cars, ATV\'s, planes and a lot more to engage the cult forces in epic fights.<br style=\"padding: 0px; margin: 0px;\"><br style=\"padding: 0px; margin: 0px;\"><b>RE-DEFINED STEALTH MECHANICS</b><br style=\"padding: 0px; margin: 0px;\">Enhance your gameplay with eye tracking. Tag enemies by looking at them to increase your stealth skills and help your teammates spot threats.<br style=\"padding: 0px; margin: 0px;\">Compatible with all Tobii Eye Tracking gaming devices.<br style=\"padding: 0px; margin: 0px;\"><br style=\"padding: 0px; margin: 0px;\"><b>Additional notes:</b><br style=\"padding: 0px; margin: 0px;\">Eye tracking features available with Tobii Eye Tracking.<br></p>', 2, '2018-03-27 00:00:00', '2020-05-31 05:54:55', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `product_codes`
--

CREATE TABLE `product_codes` (
  `id` bigint(20) NOT NULL,
  `product_id` bigint(20) NOT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0 => Available, 1 => Redeemed',
  `activation_code` varchar(50) NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product_codes`
--

INSERT INTO `product_codes` (`id`, `product_id`, `user_id`, `status`, `activation_code`, `created_at`, `updated_at`) VALUES
(1, 1, 17, 1, 'ABCD-EFGH-IJKL-1234', '2020-05-29 05:07:15', '2020-05-30 23:52:41'),
(2, 1, NULL, 0, 'DCAS-KASD-DAAA-1423', '2020-05-29 05:09:08', NULL),
(3, 1, NULL, 0, 'DCAS-KASD-DAAA-5123', '2020-05-29 05:09:08', NULL),
(4, 1, NULL, 0, 'DCAS-KASD-DAAA-1423', '2020-05-29 05:09:08', NULL),
(5, 1, NULL, 0, 'DCAS-KASD-DAAA-5125', '2020-05-29 05:09:08', NULL),
(6, 1, NULL, 0, 'DCAS-KASD-DAAA-6252', '2020-05-29 05:09:08', NULL),
(7, 1, NULL, 0, 'DCAS-KASD-DAAA-1992', '2020-05-29 05:09:08', NULL),
(8, 1, NULL, 0, 'DCAS-KASD-DAAA-1983', '2020-05-29 05:09:08', NULL),
(9, 1, NULL, 0, 'DCAS-KASD-DAAA-3516', '2020-05-29 05:09:08', NULL),
(10, 1, NULL, 0, 'DCAS-KASD-DAAA-6221', '2020-05-29 05:09:09', NULL),
(11, 2, 17, 1, 'BFVB-BFVB-BFVB-3152', '2020-05-29 05:10:12', '2020-05-31 04:32:47'),
(12, 2, 17, 1, 'BFVB-BFVB-BFVB-1234', '2020-05-29 05:10:12', '2020-05-31 04:32:54'),
(13, 2, 4, 0, 'BFVB-BFVB-BFVB-5555', '2020-05-29 05:10:13', '2020-05-31 04:35:31'),
(14, 2, 4, 0, 'BFVB-BFVB-BFVB-1231', '2020-05-29 05:10:13', '2020-05-31 04:35:45'),
(15, 2, 4, 0, 'BFVB-BFVB-BFVB-1212', '2020-05-29 05:10:13', '2020-05-31 04:35:51'),
(16, 2, NULL, 0, 'BFVB-BFVB-BFVB-1313', '2020-05-29 05:10:13', NULL),
(17, 2, NULL, 0, 'BFVB-BFVB-BFVB-8523', '2020-05-29 05:10:13', NULL),
(18, 2, NULL, 0, 'BFVB-BFVB-BFVB-8383', '2020-05-29 05:10:13', NULL),
(19, 2, NULL, 0, 'BFVB-BFVB-BFVB-8129', '2020-05-29 05:10:13', NULL),
(20, 2, NULL, 0, 'BFVB-BFVB-BFVB-5725', '2020-05-29 05:10:14', NULL),
(21, 2, NULL, 0, 'BFVB-BFVB-BFVB-6387', '2020-05-29 05:10:14', NULL),
(22, 2, NULL, 0, 'BFVB-BFVB-BFVB-8736', '2020-05-29 05:10:14', NULL),
(23, 3, 17, 1, 'A555-4445-2313-ABCD', '2020-05-29 05:12:43', '2020-05-31 04:30:33'),
(24, 3, 4, 0, 'A555-4445-2313-1231', '2020-05-29 05:12:43', '2020-05-31 04:36:12'),
(25, 3, 4, 0, 'A555-4445-2313-WA21', '2020-05-29 05:12:43', '2020-05-31 04:36:18'),
(26, 3, NULL, 0, 'A555-4445-2313-A131', '2020-05-29 05:12:43', NULL),
(27, 3, NULL, 0, 'A555-4445-2313-AD12', '2020-05-29 05:12:43', NULL),
(28, 3, NULL, 0, 'A555-4445-2313-AC13', '2020-05-29 05:12:43', NULL),
(29, 3, NULL, 0, 'A555-4445-2313-AS2S', '2020-05-29 05:12:43', NULL),
(30, 3, NULL, 0, 'VH23-CF70-45OC-19RM', '2020-05-31 04:53:24', NULL),
(31, 10, NULL, 0, 'PT83-RR61-92EZ-18OR', '2020-05-31 04:53:24', NULL),
(32, 3, NULL, 0, 'RL99-XZ05-96JK-92ZV', '2020-05-31 04:53:24', NULL),
(33, 3, NULL, 0, 'ST65-BN22-77PE-27RA', '2020-05-31 04:53:24', NULL),
(34, 6, NULL, 0, 'DC15-RO40-59BE-31RG', '2020-05-31 04:53:24', NULL),
(35, 2, NULL, 0, 'BG52-RH75-33RN-42EW', '2020-05-31 04:53:24', NULL),
(36, 8, NULL, 0, 'XE96-UW55-96LT-73NH', '2020-05-31 04:53:24', NULL),
(37, 3, NULL, 0, 'OC80-KH18-19WB-40SO', '2020-05-31 04:53:24', NULL),
(38, 4, NULL, 0, 'AQ58-XN10-85PO-21KG', '2020-05-31 04:53:24', NULL),
(39, 7, NULL, 0, 'XC65-XJ17-75VP-81ZM', '2020-05-31 04:53:24', NULL),
(40, 4, NULL, 0, 'EP64-LG20-94ST-20SJ', '2020-05-31 04:54:12', NULL),
(41, 2, NULL, 0, 'PP80-LK01-70WR-21MB', '2020-05-31 04:54:13', NULL),
(42, 7, NULL, 0, 'ZU72-PX30-79EN-58FA', '2020-05-31 04:54:13', NULL),
(43, 6, NULL, 0, 'WW05-LD66-52DN-10ZL', '2020-05-31 04:54:13', NULL),
(44, 5, NULL, 0, 'NQ53-CJ19-64BQ-07RH', '2020-05-31 04:54:13', NULL),
(45, 5, NULL, 0, 'DD89-JI85-13IG-03JH', '2020-05-31 04:54:13', NULL),
(46, 6, NULL, 0, 'LM18-CG81-87MT-59OC', '2020-05-31 04:54:13', NULL),
(47, 8, NULL, 0, 'TF15-VI29-31WU-63OV', '2020-05-31 04:54:13', NULL),
(48, 4, NULL, 0, 'WV77-UW98-46LK-63FP', '2020-05-31 04:54:13', NULL),
(49, 8, NULL, 0, 'AY18-VQ89-49QA-10NE', '2020-05-31 04:54:14', NULL),
(50, 2, NULL, 0, 'GF76-EU79-13TQ-99CB', '2020-05-31 04:54:14', NULL),
(51, 9, NULL, 0, 'KB81-UX66-89VP-98PZ', '2020-05-31 04:54:14', NULL),
(52, 9, NULL, 0, 'KG96-YI09-57SV-15QB', '2020-05-31 04:54:14', NULL),
(53, 6, NULL, 0, 'PQ83-NF54-20SG-44IB', '2020-05-31 04:54:14', NULL),
(54, 5, NULL, 0, 'NR47-CQ41-75TY-07CJ', '2020-05-31 04:54:14', NULL),
(55, 1, NULL, 0, 'UO44-AE70-55CI-61AM', '2020-05-31 04:54:14', NULL),
(56, 6, NULL, 0, 'PK15-AO63-41VP-16BU', '2020-05-31 04:54:14', NULL),
(57, 1, NULL, 0, 'LZ97-ZF26-40OC-79QG', '2020-05-31 04:54:14', NULL),
(58, 1, NULL, 0, 'GW63-XC20-01XV-89NO', '2020-05-31 04:54:14', NULL),
(59, 9, NULL, 0, 'UR70-AM34-26IJ-29GO', '2020-05-31 04:54:15', NULL),
(60, 6, NULL, 0, 'SJ82-ZH05-99QJ-58TA', '2020-05-31 04:54:15', NULL),
(61, 8, NULL, 0, 'UE11-OT54-72TS-86DO', '2020-05-31 04:54:15', NULL),
(62, 10, NULL, 0, 'GA38-ED73-33EE-99ZU', '2020-05-31 04:54:15', NULL),
(63, 7, NULL, 0, 'KM82-WB20-91TM-03XG', '2020-05-31 04:54:15', NULL),
(64, 7, NULL, 0, 'IT18-MX58-66EN-49AZ', '2020-05-31 04:54:15', NULL),
(65, 7, NULL, 0, 'YA15-OI58-86QN-31PV', '2020-05-31 04:54:15', NULL),
(66, 9, NULL, 0, 'PO95-TB09-19VK-97OT', '2020-05-31 04:54:15', NULL),
(67, 4, NULL, 0, 'VC54-BO87-31UC-63QN', '2020-05-31 04:54:15', NULL),
(68, 10, NULL, 0, 'GS18-IS34-84FK-35VT', '2020-05-31 04:54:15', NULL),
(69, 8, NULL, 0, 'QS65-NB76-04VP-14EQ', '2020-05-31 04:54:15', NULL),
(70, 5, NULL, 0, 'HL49-WN45-79IH-48RP', '2020-05-31 04:54:15', NULL),
(71, 2, NULL, 0, 'JX65-OG21-50ZE-93BY', '2020-05-31 04:54:16', NULL),
(72, 2, NULL, 0, 'RI13-QW21-73AM-40AO', '2020-05-31 04:54:16', NULL),
(73, 7, NULL, 0, 'IV34-VX37-79FZ-28QO', '2020-05-31 04:54:16', NULL),
(74, 7, NULL, 0, 'MD25-CI75-04JO-39RZ', '2020-05-31 04:54:16', NULL),
(75, 6, NULL, 0, 'IJ48-AO69-88FN-39TP', '2020-05-31 04:54:16', NULL),
(76, 6, NULL, 0, 'TJ49-JB33-55OY-80FB', '2020-05-31 04:54:16', NULL),
(77, 1, NULL, 0, 'VQ33-DL62-99ZC-90EZ', '2020-05-31 04:54:16', NULL),
(78, 2, NULL, 0, 'XL95-YM67-93AW-05KO', '2020-05-31 04:54:16', NULL),
(79, 8, NULL, 0, 'GI69-IU83-17MS-59ZQ', '2020-05-31 04:54:16', NULL),
(80, 8, NULL, 0, 'AZ73-KO60-29XP-96QA', '2020-05-31 04:54:16', NULL),
(81, 3, NULL, 0, 'PC53-SB34-21EX-02HV', '2020-05-31 04:54:16', NULL),
(82, 9, NULL, 0, 'FB91-BN53-89ZR-94VU', '2020-05-31 04:54:16', NULL),
(83, 9, NULL, 0, 'DZ06-GH52-20FJ-02UB', '2020-05-31 04:54:16', NULL),
(84, 7, NULL, 0, 'XA97-QL27-31FF-82LL', '2020-05-31 04:54:17', NULL),
(85, 3, NULL, 0, 'UI63-SR86-08RO-49XF', '2020-05-31 04:54:17', NULL),
(86, 6, NULL, 0, 'SU27-BS57-33SG-11ZO', '2020-05-31 04:54:17', NULL),
(87, 6, NULL, 0, 'TL23-DQ72-63LO-63KN', '2020-05-31 04:54:17', NULL),
(88, 3, NULL, 0, 'HG29-GE05-84LG-08GU', '2020-05-31 04:54:17', NULL),
(89, 10, NULL, 0, 'ET91-JJ53-38JJ-52LG', '2020-05-31 04:54:17', NULL),
(90, 11, NULL, 0, 'GE53-FI82-76LM-89SY', '2020-05-31 05:45:45', '2020-05-31 05:51:28'),
(91, 12, NULL, 0, 'JR82-HF01-19JD-53TP', '2020-05-31 05:54:55', NULL),
(92, 12, NULL, 0, 'EO00-XN71-15NA-15OL', '2020-05-31 05:54:55', NULL),
(93, 12, NULL, 0, 'ZR87-HL77-48OI-03SM', '2020-05-31 05:54:55', NULL),
(94, 12, NULL, 0, 'RU10-VE64-19HQ-89RR', '2020-05-31 05:54:55', NULL),
(95, 12, NULL, 0, 'NR53-RW03-34VA-56CN', '2020-05-31 05:54:55', NULL),
(96, 12, NULL, 0, 'WJ95-NG07-20JZ-32EK', '2020-05-31 05:54:55', NULL),
(97, 12, NULL, 0, 'US00-WH43-28BI-59VS', '2020-05-31 05:54:55', NULL),
(98, 12, NULL, 0, 'SM16-IM72-66EQ-22UG', '2020-05-31 05:54:55', NULL),
(99, 12, NULL, 0, 'UT71-KZ66-29TU-23YR', '2020-05-31 05:54:55', NULL),
(100, 12, NULL, 0, 'VH37-NG21-04PH-67RL', '2020-05-31 05:54:55', NULL),
(101, 12, NULL, 0, 'LK76-DU02-86ZF-94UC', '2020-05-31 05:54:55', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) NOT NULL,
  `role` tinyint(4) NOT NULL DEFAULT '2' COMMENT '1 => Admin, 2 => User',
  `name` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `role`, `name`, `email`, `password`, `created_at`, `updated_at`) VALUES
(1, 1, 'Gameoverflow', 'admin@game-overflow.test', '202cb962ac59075b964b07152d234b70', '2020-05-23 04:09:45', NULL),
(2, 2, 'test2', 'test2@gmail.com', '202cb962ac59075b964b07152d234b70', '2020-05-23 04:09:57', NULL),
(3, 2, 'test3', 'd@gmail.com', '202cb962ac59075b964b07152d234b70', '2020-05-23 06:41:45', NULL),
(4, 2, 'Gilang', 'g@g.com', '202cb962ac59075b964b07152d234b70', '2020-05-23 18:20:47', NULL),
(5, 2, 'test Yafie', 'y@y.com', '202cb962ac59075b964b07152d234b70', '2020-05-23 19:33:30', '2020-05-31 07:43:50'),
(17, 2, 'evaleries', 'e@e.com', '202cb962ac59075b964b07152d234b70', '2020-05-29 01:04:33', '2020-05-31 07:44:12');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `developers`
--
ALTER TABLE `developers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payments_orders_id_fk` (`order_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `developer_id` (`developer_id`);

--
-- Indexes for table `product_codes`
--
ALTER TABLE `product_codes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `product_codes_ibfk_2` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `developers`
--
ALTER TABLE `developers`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `invoices`
--
ALTER TABLE `invoices`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=222;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `product_codes`
--
ALTER TABLE `product_codes`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=113;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `invoices`
--
ALTER TABLE `invoices`
  ADD CONSTRAINT `invoices_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`);

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_orders_id_fk` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`),
  ADD CONSTRAINT `products_ibfk_2` FOREIGN KEY (`developer_id`) REFERENCES `developers` (`id`);

--
-- Constraints for table `product_codes`
--
ALTER TABLE `product_codes`
  ADD CONSTRAINT `product_codes_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `product_codes_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
