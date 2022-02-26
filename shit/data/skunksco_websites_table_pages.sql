
INSERT INTO `pages` (`site_id`, `uuid`, `slug`, `page_name`, `logo_txt`, `seq`, `session_resets`, `title`, `hddr_template`, `body_template`, `footer_template`, `style`, `styles_added`, `status`, `updated`, `created`) VALUES
(8, 'page-e8ebbd-6353d5-d2fcab-adc601-1fbba4-f6ac0f', 'index', 'index.php', '', 80, 'NA', 'k8s DevOps', 'hddr.html', '_index_.html', 'footer.html', 'NA', '', 1, '2021-10-14 06:20:41', '2021-09-10 11:27:40'),
(8, 'page-256dd2-5c2a6e-f6680d-d8b686-9ca793-1bbfc9', 'pwaInstruct', 'pwaInstruct.php', '', 51, 'NA', 'k8s DevOps', 'hddr.html', 'singleAccordion.html', 'footer.html', 'NA', '<style>\r\n  #sidebar > section\r\n  {\r\n    margin:0 0 0 0;\r\n  }\r\n  ul.divided li\r\n  {\r\n    border-top:none;\r\n    margin:0;\r\n  }\r\n  #sidebar {\r\n    padding-top: 2em;\r\n  }\r\n  #sidebar > section, #sidebar > article \r\n  {\r\n    padding:2em 0 0 0;\r\n  }\r\n</style>', 1, '2021-10-15 07:24:32', '2021-09-17 12:07:21'),
(8, 'page-d7c47c-7b85ee-f16d88-85d1e0-0a89b0-3be45f', 'switch', 'switch.php', '', 52, 'na', 'k8s Switch', 'hddr.html', 'switch.html', 'footer.html', 'NA', '<style>\r\n  #copyright{\r\n    border-top:none;\r\n  }\r\n  #features, #main, #header {\r\n    padding: 2em 0;\r\n  }\r\n}\r\n</style>', 1, '2021-10-01 08:04:15', '2021-09-28 07:35:41'),
(8, 'page-3a5caf-68f276-10c5ca-9b174a-5c430a-4805b1', 'showEntity', 'showEntity.php', '', 2, 'NA', 'List Entities', 'hddr.html', 'listEntities.html', 'footer.html', 'NA', '<style>\r\n  #copyright{\r\n    border-top:none;\r\n  }\r\n  #features, #main, #header {\r\n    padding: 2em 0;\r\n  }\r\n}\r\n</style>', 1, '2021-10-13 07:57:15', '2021-10-01 06:59:35'),
(8, 'page-85ee2b-6adf2b-5b7c68-929071-ef67c3-4222cf', 'listEntityTypes', 'listEntityTypes.php', '', 0, 'NA', 'List Entities', 'hddr.html', 'listEntities.html', 'footer.html', 'NA', '<style>\r\n  #copyright{\r\n    border-top:none;\r\n  }\r\n  #features, #main, #header {\r\n    padding: 2em 0;\r\n  }\r\n}\r\n</style>', 1, '2021-10-13 07:47:03', '2021-10-13 07:47:03'),
(8, 'page-40c2ca-e823d4-a8a1b9-2ec270-267003-8839e1', 'showEntitiesForType', 'showEntitiesForType.php', '', 1, 'NA', 'List Entities', 'hddr.html', 'listEntities.html', 'footer.html', 'NA', '<style>\r\n  #copyright{\r\n    border-top:none;\r\n  }\r\n  #features, #main, #header {\r\n    padding: 2em 0;\r\n  }\r\n}\r\n</style>', 1, '2021-10-13 08:06:58', '2021-10-13 07:55:30');



INSERT INTO `page_elements` (`page_id`, `seq`, `conditional`, `position_name`, `element_type`, `element_text`, `created`, `updated`, `status`) VALUES
(24, 1, 0, 'menu', 1, '<!--softSubMenus-->\r\n<li><a href=\"pwaInstruct.php\">Get App on phone</a></li>\r\n\r\n\r\n\r\n', '2021-09-15 09:19:13', '2021-10-11 06:32:51', 1),
( 24, 4, 1, 'randpicno', 1, 'rand|\r\n10~19', '2021-09-17 11:19:57', '2021-09-21 11:57:27', 1),
( 24, 100, 0, 'footText', 1, 'Production-Grade Kubernetes, also known as <b>K8s</b>, is an open-source system for automating deployment, scaling, and management of containerized applications.\r\n<br><br>\r\nSettings allow for <b>orchestration</b> of these containers - I.e. Assigning various parameters such as ~Numbers of containers~ , automating ~scaling and resources~.', '2021-09-20 13:06:01', '2021-09-20 13:23:32', 1),
( 24, 2, 0, 'pictureHeader', 1, '<h2><strong>&nbsp;k8s&nbsp;</strong> DevOps <strong>!</strong></h2>', '2021-09-21 11:58:13', '2021-09-21 11:58:13', 1),
( 24, 6, 0, 'pictureFooter', 1, '<header>\r\n  <h3>\r\n    Steering Your Tech Ship \r\n  </h3>\r\n</header>\r\n<p>\r\n  Kubernetes <b>is Greek for </b>Helmsman\r\n</p>', '2021-09-21 12:00:34', '2021-09-21 12:00:34', 1),
( 24, 8, 0, 'footTextHeader', 1, '<h2><strong>Container Orchestration</strong></h2>', '2021-09-21 12:03:03', '2021-09-21 12:03:03', 1),
( 24, 12, 0, 'postsHeading', 1, '<h2><strong>Last 3 Comments</strong></h2>', '2021-09-21 12:15:09', '2021-09-21 12:15:09', 1),
( 25, 99, 0, 'scriptAdded', 10, '<script>\r\nvar acc = document.getElementsByClassName(\"accordion\");\r\nvar i;\r\n\r\nfor (i = 0; i < acc.length; i++) {\r\n  acc[i].addEventListener(\"click\", function() {\r\n    this.classList.toggle(\"active\");\r\n    var panel = this.nextElementSibling;\r\n    if (panel.style.display === \"block\") {\r\n      panel.style.display = \"none\";\r\n    } else {\r\n      panel.style.display = \"block\";\r\n    }\r\n  });\r\n}\r\n</script>', '2021-09-20 07:00:57', '2021-09-20 12:34:09', 1),
( 25, 12, 0, 'accordion', 1, '<button class=\"accordion\">Android</button>\r\n<div class=\"panel\">\r\n  <p>This works on all Android devices 4+.</p>\r\n  <p><b>&nbsp;&nbsp;Installing</b>\r\n  <ol>\r\n     <li>On your Android device, open Chrome <b>Chrome</b>.</li>\r\n     <li>Go to <b>k8s.skunks.co</b> as website. </li>\r\n     <li>Tap <b>Add to home screen</b> from <b> &equiv; </b>.</li>\r\n     <li>Follow the onscreen instructions to install.</li>\r\n     <li>There should be an <b>app</b> on your desktop.</li>\r\n  </ol>\r\n</div>\r\n<button class=\"accordion\">iPhone or iPad</button>\r\n<div class=\"panel\">\r\n  <p>This works on most Apple devices.</p>\r\n  <p><b>&nbsp;&nbsp;Installing</b>\r\n  <ol>\r\n     <li>On your device, open <b>Safari</b></li>\r\n     <li>Go to k8s.skunks.co as website. </li>\r\n     <li>Tap Add to home screen (from <b>Share</b>).</li>\r\n     <li> Follow the onscreen instructions to install.</li>\r\n     <li>There should be an <b>app</b> on your desktop.</li>\r\n  </ol>\r\n</div>', '2021-09-20 06:58:33', '2021-09-20 17:12:28', 1),
( 25, 2, 0, 'menu', 1, '<li><a href=\"index.php\">Home</a></li>\r\n<!--softSubMenus-->\r\n<li><a href=\"pwaInstruct.php\">Get App on phone</a></li>\r\n\r\n\r\n\r\n', '2021-09-20 12:52:27', '2021-10-17 10:13:50', 1),
( 25, 100, 0, 'footText', 1, 'Production-Grade Kubernetes, also known as <b>K8s</b>, is an open-source system for automating deployment, scaling, and management of containerized applications.\r\n<br><br>\r\nSettings allow for <b>orchestration</b> of these containers - I.e. Assigning various parameters such as ~Numbers of containers~ , automating ~scaling and resources~.', '2021-09-20 13:04:16', '2021-09-20 13:25:52', 1),
( 25, 6, 0, 'heading', 1, 'Make this an <strong>App</strong>!', '2021-09-20 13:40:05', '2021-09-20 13:42:24', 1),
( 25, 8, 0, 'footTextHeader', 1, '<h2><strong>Container Orchestration</strong></h2>', '2021-09-21 12:09:52', '2021-09-21 12:09:52', 1),
( 25, 12, 0, 'postsHeading', 1, '<h2><b>Comments from you</b>!</h2>', '2021-09-21 12:15:51', '2021-10-14 12:46:38', 1),
( 25, 12, 1, 'postsDetailCondition', 1, 'arrayLimitedOutput|messagesArray|3|\r\n<article class=\"box excerpt\">\r\n  <header>\r\n     <span class=\"date\">\r\n        <!--monthYearPosted-->\r\n     </span>\r\n     <h3>\r\n        <a href=\"#\"><!--headingPosted--></a>\r\n     </h3>\r\n  </header>\r\n     <p>\r\n       <!--msgPosted-->\r\n    </p>\r\n</article>', '2021-09-21 12:33:19', '2021-10-14 12:18:45', 0),
( 26, 2, 0, 'menu', 1, '<li><a href=\"index.php\">Home</a></li>\r\n<!--softSubMenus-->', '2021-09-28 08:16:55', '2021-10-11 07:41:37', 1),
( 27, 20, 0, 'heading', 1, '<h2><strong>&nbsp;k8s&nbsp;</strong>Entities<strong> Classification </strong></h2>', '2021-10-11 06:39:57', '2021-10-11 06:46:14', 1),
( 27, 99, 0, 'scriptAdded', 10, '<script>\r\nvar acc = document.getElementsByClassName(\"accordion\");\r\nvar i;\r\n\r\nfor (i = 0; i < acc.length; i++) {\r\n  acc[i].addEventListener(\"click\", function() {\r\n    this.classList.toggle(\"active\");\r\n    var panel = this.nextElementSibling;\r\n    if (panel.style.display === \"block\") {\r\n      panel.style.display = \"none\";\r\n    } else {\r\n      panel.style.display = \"block\";\r\n    }\r\n  });\r\n}\r\n</script>', '2021-10-11 10:19:02', '2021-10-11 10:19:02', 1),
( 27, 0, 0, 'menu', 1, '<li><a href=\"index.php\">Home</a></li>\r\n<!--softSubMenus-->\r\n<li><a href=\"pwaInstruct.php/fcats\">Get app On phone</a></li>', '2021-10-01 08:08:25', '2021-10-11 10:53:20', 1),
( 27, 60, 0, 'pictureFooter', 1, '<header>\r\n  <h3>\r\n    Steering Your Tech Ship \r\n  </h3>\r\n</header>\r\n<p>\r\n  Kubernetes <b>is Greek for </b>Helmsman\r\n</p>', '2021-10-11 06:40:45', '2021-10-11 06:44:04', 1),
( 27, 80, 0, 'footTextHeader', 1, '<h2><strong>Container Orchestration</strong></h2>', '2021-10-11 06:41:16', '2021-10-11 06:44:12', 1),
( 27, 100, 0, 'footText', 1, 'Production-Grade Kubernetes, also known as <b>K8s</b>, is an open-source system for automating deployment, scaling, and management of containerized applications.\r\n<br><br>\r\nSettings allow for <b>orchestration</b> of these containers - I.e. Assigning various parameters such as ~Numbers of containers~ , automating ~scaling and resources~.', '2021-10-11 06:57:11', '2021-10-11 06:57:11', 1),
( 27, 10, 1, 'postsDetailCondition', 1, 'arrayLimitedOutput|messagesArray|3|\r\n<article class=\"box excerpt\">\r\n  <header>\r\n     <span class=\"date\">\r\n        <!--monthYearPosted-->\r\n     </span>\r\n     <h3>\r\n        <a href=\"#\"><!--headingPosted--></a>\r\n     </h3>\r\n  </header>\r\n     <p>\r\n       <!--msgPosted-->\r\n    </p>\r\n</article>', '2021-10-11 07:24:19', '2021-10-15 07:39:36', 0),
( 27, 12, 0, 'postsHeading', 1, '<h2><strong>Last 3 Comments</strong></h2>', '2021-10-11 07:25:43', '2021-10-11 07:25:43', 1),
( 28, 0, 0, 'menu', 1, '<li><a href=\"index.php\">Home</a></li>\r\n<!--softSubMenus-->\r\n<li><a href=\"pwaInstruct.php/fcats\">Get app On phone</a></li>', '2021-10-13 07:48:04', '2021-10-13 07:48:04', 1),
( 28, 10, 1, 'postsDetailCondition', 1, 'arrayLimitedOutput|messagesArray|3|\r\n<article class=\"box excerpt\">\r\n  <header>\r\n     <span class=\"date\">\r\n        <!--monthYearPosted-->\r\n     </span>\r\n     <h3>\r\n        <a href=\"#\"><!--headingPosted--></a>\r\n     </h3>\r\n  </header>\r\n     <p>\r\n       <!--msgPosted-->\r\n    </p>\r\n</article>', '2021-10-13 07:48:14', '2021-10-15 07:37:42', 0),
( 28, 12, 0, 'postsHeading', 1, '<h2><strong>Last 3 Comments</strong></h2>', '2021-10-13 07:48:28', '2021-10-13 07:48:28', 1),
( 28, 20, 0, 'heading', 1, '<h2><strong>&nbsp;k8s&nbsp;</strong>Entities<strong> Classification </strong></h2>', '2021-10-13 07:48:47', '2021-10-13 07:48:47', 1),
( 28, 60, 0, 'pictureFooter', 1, '<header>\r\n  <h3>\r\n    Steering Your Tech Ship \r\n  </h3>\r\n</header>\r\n<p>\r\n  Kubernetes <b>is Greek for </b>Helmsman\r\n</p>', '2021-10-13 07:48:58', '2021-10-13 07:48:58', 1),
( 28, 80, 0, 'footTextHeader', 1, '<h2><strong>Container Orchestration</strong></h2>', '2021-10-13 07:49:07', '2021-10-13 07:49:07', 1),
( 28, 99, 0, 'scriptAdded', 10, '<script>\r\nvar acc = document.getElementsByClassName(\"accordion\");\r\nvar i;\r\n\r\nfor (i = 0; i < acc.length; i++) {\r\n  acc[i].addEventListener(\"click\", function() {\r\n    this.classList.toggle(\"active\");\r\n    var panel = this.nextElementSibling;\r\n    if (panel.style.display === \"block\") {\r\n      panel.style.display = \"none\";\r\n    } else {\r\n      panel.style.display = \"block\";\r\n    }\r\n  });\r\n}\r\n</script>', '2021-10-13 07:49:17', '2021-10-13 07:49:17', 1),
( 28, 100, 0, 'footText', 1, 'Production-Grade Kubernetes, also known as <b>K8s</b>, is an open-source system for automating deployment, scaling, and management of containerized applications.\r\n<br><br>\r\nSettings allow for <b>orchestration</b> of these containers - I.e. Assigning various parameters such as ~Numbers of containers~ , automating ~scaling and resources~.', '2021-10-13 07:49:29', '2021-10-13 07:49:29', 1),
( 29, 0, 0, 'menu', 1, '<li><a href=\"index.php\">Home</a></li>\r\n<!--softSubMenus-->\r\n<li><a href=\"pwaInstruct.php/fcats\">Get app On phone</a></li>', '2021-10-13 08:08:03', '2021-10-13 08:08:03', 1),
( 29, 10, 1, 'postsDetailCondition', 1, '<article class=\"box excerpt\">\r\n  <header>\r\n     <span class=\"date\">\r\n        <!--monthYearPosted-->\r\n     </span>\r\n     <h3>\r\n        <a href=\"#\"><!--headingPosted--></a>\r\n     </h3>\r\n  </header>\r\n     <p>\r\n       <!--msgPosted-->\r\n    </p>\r\n</article>', '2021-10-13 08:08:13', '2021-10-14 12:15:03', 0),
( 29, 12, 0, 'postsHeading', 1, '<h2><strong>Comments</strong></h2>', '2021-10-13 08:08:22', '2021-10-15 07:43:35', 1),
( 29, 20, 0, 'heading', 1, '<h2><strong>&nbsp;k8s&nbsp;</strong>Entities of type::<strong>###entityType###</strong></h2>', '2021-10-13 08:08:32', '2021-10-14 08:46:26', 1),
( 29, 60, 0, 'pictureFooter', 1, '<header>\r\n  <h3>\r\n    Steering Your Tech Ship \r\n  </h3>\r\n</header>\r\n<p>\r\n  Kubernetes <b>is Greek for </b>Helmsman\r\n</p>', '2021-10-13 08:08:51', '2021-10-13 08:08:51', 1),
( 29, 80, 0, 'footTextHeader', 1, '<h2><strong>Container Orchestration</strong></h2>', '2021-10-13 08:09:04', '2021-10-13 08:09:04', 1),
( 29, 99, 0, 'scriptAdded', 10, '<script>\r\nvar acc = document.getElementsByClassName(\"accordion\");\r\nvar i;\r\n\r\nfor (i = 0; i < acc.length; i++) {\r\n  acc[i].addEventListener(\"click\", function() {\r\n    this.classList.toggle(\"active\");\r\n    var panel = this.nextElementSibling;\r\n    if (panel.style.display === \"block\") {\r\n      panel.style.display = \"none\";\r\n    } else {\r\n      panel.style.display = \"block\";\r\n    }\r\n  });\r\n}\r\n</script>', '2021-10-13 08:09:13', '2021-10-13 08:09:13', 1),
( 29, 100, 0, 'footText', 1, 'Production-Grade Kubernetes, also known as <b>K8s</b>, is an open-source system for automating deployment, scaling, and management of containerized applications.\r\n<br><br>\r\nSettings allow for <b>orchestration</b> of these containers - I.e. Assigning various parameters such as ~Numbers of containers~ , automating ~scaling and resources~.', '2021-10-13 08:09:23', '2021-10-13 08:09:23', 1);
COMMIT;
