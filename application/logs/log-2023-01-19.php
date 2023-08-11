<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2023-01-19 06:22:08 --> Query error: Column 'user_id' cannot be null - Invalid query: INSERT INTO `recruiter_jobs` (`user_id`, `job_type`, `designation`, `qualification`, `passing_year`, `experience`, `salary_range`, `min`, `max`, `no_of_vaccancies`, `job_role`, `end_date`, `hiring_process`, `location`, `description`) VALUES (NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL)
ERROR - 2023-01-19 07:33:24 --> Query error: Column 'id' in where clause is ambiguous - Invalid query: SELECT `recruiter`.`name` as `rec_name`, `recruiter_jobs`.*
FROM `recruiter_jobs`
JOIN `recruiter` ON `recruiter`.`id` = `recruiter_jobs`.`user_id`
WHERE `id` = '2'
ERROR - 2023-01-19 07:34:04 --> Query error: Column 'id' in where clause is ambiguous - Invalid query: SELECT `recruiter_jobs`.*, `recruiter`.`name` as `rec_name`
FROM `recruiter_jobs`
JOIN `recruiter` ON `recruiter`.`id` = `recruiter_jobs`.`user_id`
WHERE `id` = '2'
ERROR - 2023-01-19 13:03:47 --> 404 Page Not Found: Api/user_profile_update
ERROR - 2023-01-19 13:25:34 --> 404 Page Not Found: Api/update_seeker_profile
