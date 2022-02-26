
-- --------------------------------------------------------

--
-- Table structure for table `wish`
--

CREATE TABLE `wish` (
  `id` int(11) NOT NULL,
  `count` tinyint(4) NOT NULL DEFAULT '0',
  `slug` varchar(100) NOT NULL,
  `called` varchar(150) NOT NULL,
  `last_log` json NOT NULL,
  `status` tinyint(4) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `wish`
--

INSERT INTO `wish` (`id`, `count`, `slug`, `called`, `last_log`, `status`, `created`, `updated`) VALUES
(2, 9, 'createUser-Tokens-Error', 'user/create/user', '{\"call\": \"user/create/user\", \"slug\": \"createUser-Tokens-Error\", \"inputs\": {\"uri\": \"user/create/user\", \"json\": {\"email\": \"skunks247@gmail.com\", \"userid\": \"pjnAuto\"}, \"bearer\": \"D{6HZu0,<)}LvABsk~)@rn)md>4Rhj}p\\\"\", \"header\": {\"api-key\": \"add1106a49ee4f1c5b6297cc1bf9a46a\"}}, \"tokens\": {\"status\": 401, \"user_id\": \"2\", \"usageToken\": 401, \"401DlException\": 55}, \"response\": {\"status\": 401, \"security\": {\"status\": 401, \"user_id\": \"2\", \"usageToken\": 401, \"401DlException\": 55}, \"401-TokensError\": 195}}', 1, '2021-04-26 08:13:09', '2021-07-24 07:31:36');
