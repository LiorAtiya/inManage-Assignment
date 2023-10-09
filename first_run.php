<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'includes/initial_functions.php';

create_users_and_posts_tables();
insert_info_to_users_and_posts();
download_profile_image();
fill_birthday_column();
