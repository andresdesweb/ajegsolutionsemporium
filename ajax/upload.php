<?php
$src = $_FILES['image']['tmp_name'];
$filename = $_FILES['image']['name'];
$output_dir = "img/".$filename;
if (move_uploaded_file($src, $output_dir )) {
        //echo "Success! Image uploaded! File: ".$filename;
} else{
    //echo "Error! Image upload failed! File: ".$filename;
};
//echo "<br>";
?>