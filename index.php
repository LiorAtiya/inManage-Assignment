<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>inManange Social Media</title>
    <link rel="stylesheet" type="text/css" href="assets/css/styles.css">
</head>

<body>
    <img src="/inManage-Assignment/assets/images/inManageLogo.png" style="margin:auto; display:flex" alt="logo">
    <h1 class="main-title">Social Media</h1>
    <div class="tab-container">
        <div class="tabs">
            <a href="?tab=tab1" class='title-tab'>Feed</a>
            <a href="?tab=tab2" class='title-tab'>Posts of Birthday users</a>
            <a href="?tab=tab3" class='title-tab'>Summary Posts</a>
        </div>
        <div class="tab-content">
            <?php
            error_reporting(E_ALL);
            ini_set('display_errors', 1);

            // Determine which tab to display based on the 'tab' query parameter
            $tab = isset($_GET['tab']) ? $_GET['tab'] : 'tab1';

            if ($tab === 'tab1') {
                include('pages/feedPosts.php');
            } elseif ($tab === 'tab2') {
                include('pages/birthdayUsersPosts.php');
            } elseif ($tab === 'tab3') {
                include('pages/summaryPosts.php');
            }
            ?>
        </div>
    </div>

</body>

</html>