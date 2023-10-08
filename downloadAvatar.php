<?php
function downloadImage()
{
    $imageUrl = "https://cdn2.vectorstock.com/i/1000x1000/23/81/default-avatar-profile-icon-vector-18942381.jpg";

    // Use file_get_contents to fetch the image content
    $imageContent = file_get_contents($imageUrl);

    if ($imageContent === false) {
        echo "Failed to fetch the image.";
    } else {
        // Use file_put_contents to save the image content to a file
        $result = file_put_contents("avatar.jpg", $imageContent);

        if ($result !== false) {
            echo "Image saved successfully to image.jpg";
        } else {
            echo "Failed to save the image to image.jpg";
            var_dump(error_get_last());
        }
    }
}
