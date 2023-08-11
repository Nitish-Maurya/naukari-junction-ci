<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2023-01-20 06:45:21 --> Query error: Table 'developmentalpha_job_portal.user' doesn't exist - Invalid query: UPDATE `user` SET `ps` = 'a7b630d72fa01c899f5be34ebc9e8619'
WHERE `email` = 'malviya@gmail'
ERROR - 2023-01-20 06:45:56 --> Query error: Table 'developmentalpha_job_portal.User' doesn't exist - Invalid query: UPDATE `User` `type` SET `ps` = '74b3b02c0bb7d3a30f67882c3c64ff6a'
WHERE `email` = 'malviya@gmail'
ERROR - 2023-01-20 06:46:07 --> Query error: Table 'developmentalpha_job_portal.User' doesn't exist - Invalid query: UPDATE `User` SET `ps` = '3a2a03bc937e81a40d7f9933874cbfda'
WHERE `email` = 'malviya@gmail'
ERROR - 2023-01-20 09:29:49 --> Severity: Notice --> Undefined variable: resume /home/developmentalpha/public_html/job_portal/application/controllers/Api.php 3892
ERROR - 2023-01-20 09:40:05 --> Query error: Table 'developmentalpha_job_portal.User' doesn't exist - Invalid query: UPDATE `User` `Type` SET `ps` = 'edd77438f8e77de088ddd91cb7693af4'
WHERE `email` = 'malviya@gmail'
ERROR - 2023-01-20 10:08:42 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'WHERE `email` = ''' at line 2 - Invalid query: SELECT `email`
WHERE `email` = ''
ERROR - 2023-01-20 10:10:24 --> Severity: error --> Exception: Call to undefined method CI_Upload::error() /home/developmentalpha/public_html/job_portal/application/controllers/Api.php 3807
ERROR - 2023-01-20 10:10:35 --> Severity: error --> Exception: Call to undefined method CI_Upload::errors() /home/developmentalpha/public_html/job_portal/application/controllers/Api.php 3807
ERROR - 2023-01-20 10:10:36 --> Severity: error --> Exception: Call to undefined method CI_Upload::errors() /home/developmentalpha/public_html/job_portal/application/controllers/Api.php 3807
ERROR - 2023-01-20 10:45:28 --> 404 Page Not Found: Api/recruiter_profile
ERROR - 2023-01-20 10:46:33 --> 404 Page Not Found: Api/recruiter_profile
ERROR - 2023-01-20 10:48:21 --> 404 Page Not Found: Api/recruiter_profile
ERROR - 2023-01-20 10:48:41 --> Severity: Notice --> Undefined index: resume /home/developmentalpha/public_html/job_portal/application/controllers/Api.php 3850
ERROR - 2023-01-20 10:50:05 --> Severity: Notice --> Undefined index: resume /home/developmentalpha/public_html/job_portal/application/controllers/Api.php 3850
ERROR - 2023-01-20 10:52:07 --> Severity: Notice --> Undefined index: resume /home/developmentalpha/public_html/job_portal/application/controllers/Api.php 3850
ERROR - 2023-01-20 12:09:18 --> 404 Page Not Found: Api/forgot_password%20
ERROR - 2023-01-20 12:09:26 --> 404 Page Not Found: Api/forgot_password%20
ERROR - 2023-01-20 12:16:42 --> 404 Page Not Found: Api/forgot_password%20
ERROR - 2023-01-20 12:16:50 --> 404 Page Not Found: Api/forgot_password%20
ERROR - 2023-01-20 12:16:57 --> 404 Page Not Found: Api/forgot_password%20
ERROR - 2023-01-20 12:33:00 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '= '202'' at line 3 - Invalid query: SELECT *
FROM `job_post`
WHERE  = '202'
ERROR - 2023-01-20 12:33:42 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '= '202'' at line 3 - Invalid query: SELECT *
FROM `job_post`
WHERE  = '202'
ERROR - 2023-01-20 12:41:40 --> 404 Page Not Found: Api/forgot_password%20
ERROR - 2023-01-20 12:42:05 --> 404 Page Not Found: Api/forgot_password%20
ERROR - 2023-01-20 12:42:13 --> 404 Page Not Found: Api/forgot_password%20
ERROR - 2023-01-20 12:44:03 --> 404 Page Not Found: Api/forgot_password%20
ERROR - 2023-01-20 12:44:07 --> 404 Page Not Found: Api/forgot_password%20
ERROR - 2023-01-20 12:44:09 --> 404 Page Not Found: Api/forgot_password%20
ERROR - 2023-01-20 12:46:54 --> Query error: Column 'user_id' cannot be null - Invalid query: INSERT INTO `user_applied_job` (`user_id`, `job_id`) VALUES (NULL, NULL)
ERROR - 2023-01-20 13:19:57 --> Query error: Unknown column 'recruiter.name' in 'field list' - Invalid query: SELECT `recruiter_jobs`.*, `recruiter`.`name` as `rec_name`, `recruiter`.`company` as `company_name`
FROM `recruiter_jobs`
WHERE `user_id` = '68'
ERROR - 2023-01-20 13:24:15 --> Query error: Column 'user_id' in where clause is ambiguous - Invalid query: SELECT `recruiter_jobs`.*, `user_applied_job`.`user_id` as `applier_id`
FROM `recruiter_jobs`
JOIN `user_applied_job` ON `user_applied_job`.`id` = `recruiter_jobs`.`id`
WHERE `user_id` = '68'
ERROR - 2023-01-20 13:32:26 --> Query error: Column 'id' in where clause is ambiguous - Invalid query: SELECT `recruiter_jobs`.*, `recruiter`.`name` as `rec_name`, `recruiter`.`company` as `company_name`
FROM `recruiter_jobs`
JOIN `recruiter` ON `recruiter`.`id` = `recruiter_jobs`.`user_id`
WHERE `id` = '1'
ERROR - 2023-01-20 13:32:28 --> Query error: Column 'id' in where clause is ambiguous - Invalid query: SELECT `recruiter_jobs`.*, `recruiter`.`name` as `rec_name`, `recruiter`.`company` as `company_name`
FROM `recruiter_jobs`
JOIN `recruiter` ON `recruiter`.`id` = `recruiter_jobs`.`user_id`
WHERE `id` = '1'
ERROR - 2023-01-20 13:32:29 --> Query error: Column 'id' in where clause is ambiguous - Invalid query: SELECT `recruiter_jobs`.*, `recruiter`.`name` as `rec_name`, `recruiter`.`company` as `company_name`
FROM `recruiter_jobs`
JOIN `recruiter` ON `recruiter`.`id` = `recruiter_jobs`.`user_id`
WHERE `id` = '1'
ERROR - 2023-01-20 13:32:37 --> Query error: Column 'id' in where clause is ambiguous - Invalid query: SELECT `recruiter_jobs`.*, `recruiter`.`name` as `rec_name`, `recruiter`.`company` as `company_name`
FROM `recruiter_jobs`
JOIN `recruiter` ON `recruiter`.`id` = `recruiter_jobs`.`user_id`
WHERE `id` = '1'
ERROR - 2023-01-20 13:33:12 --> Query error: Column 'id' in where clause is ambiguous - Invalid query: SELECT `recruiter_jobs`.*, `recruiter`.`name` as `rec_name`, `recruiter`.`company` as `company_name`
FROM `recruiter_jobs`
JOIN `recruiter` ON `recruiter`.`id` = `recruiter_jobs`.`user_id`
WHERE `id` = '3'
