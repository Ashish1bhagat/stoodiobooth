-- phpMyAdmin SQL Dump
-- version 4.0.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 21, 2014 at 12:37 PM
-- Server version: 5.5.24-log
-- PHP Version: 5.4.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `studio`
--

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE IF NOT EXISTS `events` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `title` varchar(200) NOT NULL,
  `description` text,
  `hashtag` varchar(50) DEFAULT NULL,
  `image` varchar(200) DEFAULT NULL,
  `twitter` varchar(20) DEFAULT NULL,
  `get_tweets` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=26 ;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `title`, `description`, `hashtag`, `image`, `twitter`, `get_tweets`) VALUES
(24, 'New Event', 'test description', 'fun', '20140214120029_160.png', 'event', 1),
(25, 'Sunset Photos', 'Collection of sunset photos test', 'sunset', '20140217082100_5785406487_67ac8f15e3_o.jpg', 'freebeer', 1);

-- --------------------------------------------------------

--
-- Table structure for table `event_photos`
--

CREATE TABLE IF NOT EXISTS `event_photos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `eid` int(11) NOT NULL,
  `photo` varchar(200) NOT NULL,
  `caption` mediumtext,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=70 ;

--
-- Dumping data for table `event_photos`
--

INSERT INTO `event_photos` (`id`, `eid`, `photo`, `caption`) VALUES
(24, 25, 'acfffd6e9a1211e3ba150e6285b91557_8.jpg', '#sunset#skyporn#igers #instagood #iphonesia #love#greatshot #beautiful#instagramersgallery #follow#followme'),
(25, 25, 'eebbf50a996311e3b56112c8cf378460_8.jpg', 'Thanks'),
(26, 25, 'bc88038a9a1211e3a3ff123101ff3f78_8.jpg', '#meetmecredits #nyc #nyfw #cute #love #kahode #japan #howeawards #garlicger #girls #friend #fourseasons #school #sunset #bonanzakhaoyai #angela #angelaloveaffbarry #aff #aff_taksaorn #paris #iseeyouinmydreams #taiwan #tokyo #taksaorn #richydcaballes @aff_taksaorn @bonanzakhaoyai'),
(27, 25, '2dea36ac9a0d11e3b08512b3751c95c6_8.jpg', '#fun #instagramers #TagsForLikes #food #smile #pretty #followme #nature #lol #dog #hair #onedirection #sunset #swag #throwbackthursday #instagood #beach #statigram #friends #hot #funny #blue #life #art #instahub #photo #cool #pink #bestoftheday #clouds'),
(28, 25, '0519607a9a1411e38f8812791ae4623c_8.jpg', 'ä»Šæ—¥ã‚‚ç„¡äº‹ã«æ—¥ãŒæ²ˆã‚€ ã¾ãŸæ˜Žæ—¥é ‘å¼µã‚Šã¾ã—ã‚‡ãƒ¼\\r\\n#è‹«å°ç‰§ãƒ•ã‚§ãƒªãƒ¼ã‚¿ãƒ¼ãƒŸãƒŠãƒ«\\r\\n#å¤•ç„¼ã‘#å¤•æ—¥#å¤•é™½#sunset #sky #sun #æ—¥ãŒé•·ããªã£ãŸ#æ˜¥ã‚ˆæ¥ã„'),
(29, 25, 'ed4cb0449a1511e3a98f0ea8daf3f523_8.jpg', 'Beautiful trip home to Denmark #thailand #kohsamui #fly #home #livetergodt #loveit #sunset #good #lifestyle #trip #fedthans'),
(30, 25, 'd6dad2fe9a0c11e394e312cc6335db0c_8.jpg', 'Wow guys. 1000 followers! Thank you all for your love and support!'),
(31, 25, '0e51018c9a1611e3984b12c331d64df6_8.jpg', '#sunset #pomelo'),
(32, 25, 'f9b0006c9a1411e3a6700a6ec22b36e0_8.jpg', 'There will always be a blue sky, a blue sky waiting tomorrow full of hopeâ˜€ #sunset #bluesky #tomorrow #clouds #life #thursday #hale'),
(33, 24, '70da1a509a1611e3a8c912d80cc6bccf_8.jpg', 'Canim canimmmm #love #TagsForLikes @TagsForLikes #instagood #me #like #follow #cute #photooftheday #tbt #followme #tagsforlikes #girl #beautiful #happy #picoftheday #instadaily #food #swag #amazing #tflers #fashion #igers #fun #summer #instalike #bestoftheday #smile #like4like #friends #instamood'),
(34, 24, '39c6c144991711e3adca0e50b5ae6e66_8.jpg', 'To eat is a necessity, but to eat intelligently is an art - La Rochefoucald'),
(35, 24, '5b0e10a09a1611e3b35a125adb7eab4a_8.jpg', '#weather #instaweather #instaweatherpro  #sky #outdoors #nature #world #love #followme #follow #beautiful #instagood #fun #cool #like #life #nice #happy #colorful #photooftheday #amazing #rocky #rocky4 #nowplaying #movie #japan #day #winter #cold #jp'),
(36, 24, '6dca85f29a1611e3844a0e336c21aa60_8.jpg', '#weather #instaweather #instaweatherpro  #sky #outdoors #nature #world #love #followme #follow #beautiful #instagood #fun #cool #like #life #nice #happy #colorful #photooftheday #amazing #duquedecaxias #brazil #day #summer #clear #morning #br'),
(37, 24, '682c71329a1611e3ad1b121481e60c34_8.jpg', 'Abenteurer Kultur! #fun#Bonn#brotfabrik#theatre#theater#loveit#friends#fun#ladies#smile#Fashion#style#theater#dmausbildung#tagsForlike#likeforlike#followforfollow#tfl#lfl#fff#t4l#Photooftheday#instapic#instagood'),
(38, 24, '3979a59e9a1611e383b412fe1a71ea71_8.jpg', 'Bradley Cooper though.ðŸ˜ #BradleyCooper'),
(39, 24, '6eb0d6ce9a1611e39b390e6c57e6fb13_8.jpg', 'Eso es el Amor - angeblich\\r\\n#friend #friends #fun #TagsForLikes #funny #love #instagood #igers #friendship #party #chill #happy #cute #photooftheday #live #forever #smile #bff #bf #gf #best #bestfriend #lovethem #bestfriends #goodfriends #besties #awesome #memories #goodtimes #goodtime'),
(40, 24, '4e42a2e69a1611e38329129895db65ff_8.jpg', '@Instag_app #love #instagood #me #like #follow #photooftheday #cute #tbt #tagsforlikes #followme #beautiful #girl #igers #instadaily #picoftheday #happy #smile #summer #fun #food #friends #like4like #instalike #amazing #bestoftheday #swag #tflers #fashion #instamood'),
(41, 24, '9fdbce8e9a1611e388e812d767576a00_8.jpg', 'Funtimes with my best! #bestfriend #gorgeous #fun #gorgeous #glam #fab #gay #gaynl #gayboys #gayglam #gaylife #dutchgay #instagay #instafab #fashion #fashionlovers #instafashion #burberry #tan #tangay #faketan #smile #followme #love'),
(42, 24, '59425d1c9a1611e3b5380add44b2d0a4_8.jpg', 'Faves'),
(43, 24, '54f77602927311e393790a2aba0db6c1_8.jpg', 'ðŸƒðŸ‘ˆðŸƒðŸ‘ˆ'),
(44, 24, 'c20d4c4e9a1611e3ab161243c66c91b3_8.jpg', 'On the way to Berlin with dan, 2 days ago :3 #Berlin #fun #missit #bus #germanexchange #trip'),
(45, 24, '704994c89a0f11e3919e124f792e77d9_8.jpg', 'Ucus saatini beklemenin en guzel yolu Enver Aysever okumak vaktin nasil gectigini anlamazsin bile :) #enveraysever'),
(46, 24, '621992569a1711e38ee5126a534df162_8.jpg', '#love #TagsForLikes @TagsForLikes #instagood #me #like #follow #cute #photooftheday #tbt #followme #tagsforlikes #girl #beautiful #happy #picoftheday #instadaily #food #swag #amazing #tflers #fashion #igers #fun #summer #instalike #bestoftheday #smile #like4like #friends #instamood'),
(47, 24, '78e568269a1611e394da12766a112465_7.jpg', 'my cousinâ™¡â™¥ #cool #selca #fun #lol #throwback #family #girls #baby #cute'),
(48, 24, '276219769a1711e381dd1273149d0f6d_8.jpg', 'Today\\''s P.E was a lot of funðŸ’—\\r\\n#school #highschool #fun #good'),
(49, 24, '343870509a1711e3ab1b0a2a798555c5_8.jpg', '#me#fun#mumbai#sealink#iphoneclick#bandstand#sea'),
(50, 24, '9c2f2c369a0c11e3903e1230df506265_8.jpg', '#friend #friends #fun #TagsForLikes #funny #love #instagood #igers #friendship #party #chill #happy #cute #photooftheday #live #forever #smile #bff #bf #gf #best #bestfriend #lovethem #bestfriends #goodfriends #besties #awesome #memories #goodtimes #goodtime'),
(55, 25, '1b2b1f38996b11e39538122a842d7441_8.jpg', 'ðŸ˜ðŸ˜'),
(56, 25, '2871c7289a2911e3903e1230df506265_8.jpg', ''),
(57, 25, 'a71dcc0c9a2911e3a5ea0a7cffb7c5e1_8.jpg', 'On the beach'),
(58, 25, '9d0d7bcc9a2911e38fee0eec16a001d9_8.jpg', '#sunset #sunrise #sun #TagsForLikes #TFLers #pretty #beautiful #red #orange #pink #sky #skyporn #cloudporn #nature #clouds #horizon #photooftheday #instagood #gorgeous #warm #view #night #morning #silhouette #instasky #all_sunsets'),
(59, 25, '31364f729a2a11e3813412641a6a3562_8.jpg', '#sunset_hub #sunset_pics #sunsetlovers #sunsets #sunsethunter #sunsetporn #sunsetkings #sunset_madnes #sunset_lovers #sunset_universe #sunset_madness_ #sunset_captures_ #sunsetsnipers #sunsetoftheday #sunset_specialist #sunset_united #sunsetsniper #sunset_madness #sunset_stream #sunset #sunset_contestpick #sunset_rv #loves_sunset #supersunset #cool_sunshotz #tgif_sunset #my_sunset'),
(60, 25, '4165f4749a2a11e397580a396403f9f8_8.jpg', '#sunset\\r\\n#skies\\r\\n#blue #orange #yellow #red #sky\\r\\n#bestclick'),
(61, 25, 'ed8fd094983111e3843212a88509fb30_8.jpg', '#summer  #friends #lol  #iphoneonly  #picstitchÂ  #my #hair #dog Â #sunset #nature #sun  #beach #pretty #cat  #artÂ #instagramhub  #igdaily  #likebackÂ  #10likes #100likes #50likes  #30likes #40likes #60likes #textgram\\r\\n\\r\\n#family #instago #igaddict #awesome #girls'),
(62, 25, '6e127eb69a2a11e38f2712c106be2b5a_8.jpg', '#fun #instagramers #food #smile #pretty #followme #nature #lol #dog #hair #onedirection #sunset #swag #throwbackthursday #instagood #beach #statigram #friends #hot #funny #blue #life #art #instahub #photo #cool #pink #bestoftheday #clouds #lomoallin1'),
(63, 25, '09d2e25e9a2c11e3a36f129657a7eedf_8.jpg', 'Langit sore di Kulon Progo :) #beautiful #sunset #westprog #today'),
(64, 25, 'cc7f36969a2b11e3a9f8126315c18a6f_8.jpg', 'Lets say good bye today !! #sunset #jj #jj_sunsetlovers #bestnatureshot #we_r_maldivians #beauty #beautiful #amazing #mothernature #lovely #sky #skyviewers #all_shots #photooftheday #tagsforlikes #statigram #igdaily #igers #followme #followback #follow #followforfollow #instapic #natural #webstagram'),
(65, 25, 'd0521e0a9a2b11e3b0540ee34114bbed_8.jpg', '|| RIVER ||'),
(66, 24, '03fe80c89a2b11e38b2812cb779e5d54_8.jpg', '#love #TagsForLikes @TagsForLikes #instagood #me #like #follow #cute #photooftheday #tbt #followme #tagsforlikes #girl #beautiful #happy #picoftheday #instadaily #food #swag #amazing #tflers #fashion #igers #fun #summer #instalike #bestoftheday #smile #like4like #friends #instamood'),
(67, 24, '3b52f45e9a2c11e3878a121cc321c01d_8.jpg', '#smokelab #hookah #ÐºÐ°Ð»ÑŒÑÐ½ #Ð¾Ð¼ÑÐº #Ð´Ñ‹Ð¼ #shisha #arthookah #starbuzz #tangiers #nakhla #kaya #mya #girls #kaloudlotus #fun #420 #xbox #followme #khalilmamoon #Ñ‚ÑŽÐ¼ÐµÐ½ÑŒ #photo\\r\\nÐÐ°Ñˆ Ð¢ÐµÐ»ÐµÑ„Ð¾Ð½: (3812) 382579\\r\\nÐÐ°ÑˆÑ‹ ÐÐ´Ñ€ÐµÑÐ°: \\r\\nÐŸÑ€Ð¾ÑÐ¿ÐµÐºÑ‚ ÐšÑƒÐ»ÑŒÑ‚ÑƒÑ€Ñ‹ Ð´. 6.\\r\\n10 Ð›ÐµÑ‚ ÐžÐºÑ‚ÑÐ±Ñ€Ñ Ð´. 113\\r\\nÐ ÐµÑˆÐ¸Ð»Ð¸ ÑÐ´ÐµÐ»Ð°Ñ‚ÑŒ Ð½ÐµÐ±Ð¾Ð»ÑŒÑˆÑƒÑŽ Ñ„Ð¾Ñ‚Ð¾ÑÐµÑÑÐ¸ÑŽ.'),
(68, 24, '63a724489a2c11e3bf70122d16cbb6a3_8.jpg', 'Switzerlanddddd! #tbt #missyou #fun #sadtimes @naejaz'),
(69, 24, 'c3402e1699de11e3ae701205090394ff_8.jpg', 'It\\''s been and cold and crazy weekðŸ˜˜\\r\\n\\r\\nLolðŸ˜');

-- --------------------------------------------------------

--
-- Table structure for table `event_tweets`
--

CREATE TABLE IF NOT EXISTS `event_tweets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tweet_id` int(25) NOT NULL,
  `tweet` varchar(2000) NOT NULL,
  `user` varchar(100) NOT NULL,
  `picture` varchar(250) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `event_tweets`
--

INSERT INTO `event_tweets` (`id`, `tweet_id`, `tweet`, `user`, `picture`) VALUES
(1, 2147483647, 'Fancy visiting a @HookyBrewery pub for food +  drink being paid for it AND giving feedback ? Thought so contact @silentcustomer #freebeer', 'Hooky pubman', 'http://pbs.twimg.com/profile_images/3147793879/e531fece7cfd4d5aecc5f73d57beff40_normal.jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `login_attempts`
--

CREATE TABLE IF NOT EXISTS `login_attempts` (
  `user_id` int(11) NOT NULL,
  `time` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `login_attempts`
--

INSERT INTO `login_attempts` (`user_id`, `time`) VALUES
(2, '1391589396');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` char(128) NOT NULL,
  `salt` char(128) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `salt`) VALUES
(1, 'test_user', 'test@example.com', '00807432eae173f652f2064bdca1b61b290b52d40e429a7d295d76a71084aa96c0233b82f1feac45529e0726559645acaed6f3ae58a286b9f075916ebf66cacc', 'f9aab579fc1b41ed0c44fe4ecdbfcdb4cb99b9023abb241a6db833288f4eea3c02f76e0d35204a8695077dcf81932aa59006423976224be0390395bae152d4ef'),
(2, 'admin', 'admin@studiobooth.com', '3b5de026287e9edd79ee636ec8487023f69b40687256f5da5e524f78e5f34da951e5c9c17972006680048fca68e0af18b282329243f6fb5f994cd327dfdf9ab1', '5be71cbaee82798ca3967815001d61d5c180a6f1dd6f75c6bcf8c19cb424433bc271992b4312e6a8530c90a627ed78ccab96982a0021094f36c414dcc8c23c46');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
