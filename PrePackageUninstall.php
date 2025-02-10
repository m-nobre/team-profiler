<?php

$user_routes = file_get_contents(base_path('routes/web.php'));

$section_start = explode("/*TeamProfiler", $user_routes);
$section_end = explode("TeamProfiler*/", $section_start[1]);
$user_data = [$section_start[0], $section_end[1]];
$text = implode("\n", $user_data);
file_put_contents(base_path('routes/web.php'), $text.PHP_EOL);