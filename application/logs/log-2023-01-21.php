<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2023-01-21 07:34:20 --> 404 Page Not Found: Api/resent_otp
ERROR - 2023-01-21 07:34:25 --> Query error: Unknown column 'mobile' in 'where clause' - Invalid query: UPDATE `seeker` SET `otp` = 8759
WHERE `mobile` = '7894561234'
ERROR - 2023-01-21 07:38:40 --> 404 Page Not Found: Api/change_password
ERROR - 2023-01-21 07:38:45 --> Severity: Notice --> Undefined variable: otp /home/developmentalpha/public_html/job_portal/application/controllers/Api.php 4005
ERROR - 2023-01-21 07:51:25 --> Severity: Notice --> Undefined variable: mobile /home/developmentalpha/public_html/job_portal/application/controllers/Api.php 4017
ERROR - 2023-01-21 07:51:25 --> Severity: Notice --> Undefined variable: table /home/developmentalpha/public_html/job_portal/application/controllers/Api.php 4017
ERROR - 2023-01-21 07:51:25 --> Severity: Notice --> Undefined variable: password /home/developmentalpha/public_html/job_portal/application/controllers/Api.php 4017
ERROR - 2023-01-21 07:51:25 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at /home/developmentalpha/public_html/job_portal/system/core/Exceptions.php:271) /home/developmentalpha/public_html/job_portal/system/core/Common.php 570
ERROR - 2023-01-21 08:01:54 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near ''keyskills' at line 3 - Invalid query: SELECT *
FROM `seeker`
WHERE FIND_IN_SET('flutter', 'keyskills
ERROR - 2023-01-21 10:19:24 --> Severity: Notice --> Undefined variable: data /home/developmentalpha/public_html/job_portal/application/controllers/Api.php 73
ERROR - 2023-01-21 12:57:15 --> Query error: Column 'location' in where clause is ambiguous - Invalid query: SELECT `recruiter_jobs`.*, `recruiter`.`name` as `rec_name`, `recruiter`.`company` as `company_name`
FROM `recruiter_jobs`
JOIN `recruiter` ON `recruiter`.`id` = `recruiter_jobs`.`user_id`
WHERE `location` IN('Indore')
ERROR - 2023-01-21 12:57:23 --> Query error: Column 'location' in where clause is ambiguous - Invalid query: SELECT `recruiter_jobs`.*, `recruiter`.`name` as `rec_name`, `recruiter`.`company` as `company_name`
FROM `recruiter_jobs`
JOIN `recruiter` ON `recruiter`.`id` = `recruiter_jobs`.`user_id`
WHERE `location` IN('indore')
ERROR - 2023-01-21 12:58:46 --> Query error: Column 'location' in where clause is ambiguous - Invalid query: SELECT `recruiter_jobs`.*, `recruiter`.`name` as `rec_name`, `recruiter`.`company` as `company_name`
FROM `recruiter_jobs`
JOIN `recruiter` ON `recruiter`.`id` = `recruiter_jobs`.`user_id`
WHERE `location` IN('indore')
ERROR - 2023-01-21 16:43:20 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '= 'dsource@gmail.com'' at line 3 - Invalid query: SELECT *
FROM `recruiter`
WHERE  = 'dsource@gmail.com'
