<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>inManange Social Media</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>

<body>
    <?php
    ?>

    <h1 class="main-title">inManange Social Media</h1>
    <div class="tab-container">
        <div class="tabs">
            <a href="?tab=tab1" class='title-tab'>Feed</a>
            <a href="?tab=tab2" class='title-tab'>Posts of Birthday users</a>
            <a href="?tab=tab3" class='title-tab'>Summary Posts</a>
        </div>
        <div class="tab-content">
            <?php
            // Determine which tab to display based on the 'tab' query parameter
            $tab = isset($_GET['tab']) ? $_GET['tab'] : 'tab1';

            if ($tab === 'tab1') {
                include('feedPosts.php');
            } elseif ($tab === 'tab2') {
                include('birthdayUsersPosts.php');
            } elseif ($tab === 'tab3') {
                include('summaryPosts.php');
            }
            ?>
        </div>
    </div>
</body>

</html>