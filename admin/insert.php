<?php

session_start();
if(!isset($_SESSION['your-random-session-sjfgetwrcvdjdzzz'])){
	header("Location:login.php?refer=insert");
}
	include("../includes/header.php");
?>
<h2>Insert</h2>
<!-- <form id="myform" name="myform" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
		<div class="form-group">
			<label for="alpha">Alpha:</label>
			<input type="text" name="alpha" class="form-control">
		</div>
		<div class="form-group">
			<label for="beta">Beta:</label>
			<textarea name="beta" class="form-control"></textarea>
		</div>
		<div class="form-group">
			<label for="submit">&nbsp;</label>
			<input type="submit" name="submit" class="btn btn-info" value="Submit">
		</div>



</form> -->
<?php
$con = mysqli_connect("localhost", "gmaan1","gur@1303", "gmaan1_dmit2025");

?>


<html>

<head>

</head>

<body>

<?php




$msg = "";
if(isset($_POST['mysubmit'])){
    // visualize an array's values
    // echo "<pre>";
    // print_r($_FILES['myfile']);
    // echo "</pre>";

    // Remember: All your uploaded file info is in the $_FILES array, NOT the $_POST array.

    // echo "<p>Upload: " . $_FILES['myfile']['name'] . "</p>";
    // echo "<p>Type: " . $_FILES['myfile']['type'] . "</p>";
    // echo "<p>Size: " . $_FILES['myfile']['size']/1024 . " KB</p>";
    // echo "<p>Temp File: " . $_FILES['myfile']['tmp_name']. "</p>";
    // echo "<p>Error: " . $_FILES['myfile']['error']. "</p>";


    $valid = 1; // our validation boolean; if 0, then do NOT upload
    $msg = ""; // our cumulative error message

    // TYPE
    if($_FILES['myfile']['type'] != "image/jpeg"){
        $valid = 0;
        $msg .= "<p>Not a JPG image</p>";
    }

    // SIZE: here is set artificially low. Should be about 8 MB
    // Also, make sure your file size limits are increased in Virtuemin
    if($_FILES['myfile']['size'] > (8000 * 1024)){ // units here are KB
        $valid = 0;
        $msg .= "<p>File is too large</p>";
    }



    // before we get to this, let's validate the file !!

    if($valid == 1){ // check if validation has passed.

        if(move_uploaded_file($_FILES['myfile']['tmp_name'], "../originals/". $_FILES['myfile']['name'])){

        $thisFile = "../originals/" . basename($_FILES['myfile']['name']);
            createSquareImageCopy($thisFile, "../thumbs/", 250);
            //createThumbnail($thisFile, "thumbs/", 250);
            createThumbnail($thisFile, "../display/", 1000);


            // Add to DB

            $title = $_POST['title'];// all form elements values (except for file), we get from $_POST
			$description = $_POST['description'];
            $filename =  $_FILES['myfile']['name'] ; 

            // do a DB INSERT ... and test, test, TEST ! Look in Filezilla and phpMyAdmin.
            
            mysqli_query($con, "INSERT INTO gallery_prep (title,description,filename) VALUES('$title','$description','$filename')") or die(mysqli_error($con));

            echo "<h3>Upload Successful</h3>";
        }else{
            echo "<h3>ERROR</h3>"; 
        }

    }

}

// custom function to create thumbnail images (copies of original); can be used for thumbnails (small copies) and display size as well.

function createThumbnail($file, $folder, $newwidth){

    list($width, $height) = getimagesize($file);
    $imgRatio = $width/$height;
    $newheight = $newwidth/ $imgRatio; 

    //echo "<p>$newwidth | $newheight";

    $thumb = imagecreatetruecolor($newwidth, $newheight);

    $source = imagecreatefromjpeg($file);

    imagecopyresampled($thumb, $source, 0,0,0,0, $newwidth, $newheight, $width, $height );
    $newFileName = $folder . basename($_FILES['myfile']['name']);
    imagejpeg($thumb, $newFileName, 80); 
    imagedestroy($thumb);
    imagedestroy($source);
}

function createSquareImageCopy($file, $folder, $newWidth){
   
    //echo "$filename, $folder, $newWidth";
    //exit();

    $thumb_width = $newWidth;
    $thumb_height = $newWidth;// tweak this for ratio

    list($width, $height) = getimagesize($file);

    $original_aspect = $width / $height;
    $thumb_aspect = $thumb_width / $thumb_height;

    if($original_aspect >= $thumb_aspect) {
       // If image is wider than thumbnail (in aspect ratio sense)
       $new_height = $thumb_height;
       $new_width = $width / ($height / $thumb_height);
    } else {
       // If the thumbnail is wider than the image
       $new_width = $thumb_width;
       $new_height = $height / ($width / $thumb_width);
    }

    $source = imagecreatefromjpeg($file);
    $thumb = imagecreatetruecolor($thumb_width, $thumb_height);

    // Resize and crop
    imagecopyresampled($thumb,
                       $source,0 - ($new_width - $thumb_width) / 2, // Center the image horizontally
                       0 - ($new_height - $thumb_height) / 2, // Center the image vertically
                       0, 0,
                       $new_width, $new_height,
                       $width, $height);
   
    $newFileName = $folder. "/" .basename($file);
    imagejpeg($thumb, $newFileName, 80);

    echo "<p><img src=\"$newFileName\" /></p>"; // if you want to see the image


}

?>





    <!-- You Must, Must, MUST add this enctype="multipart/form-data" if you are uploading -->
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data" class="ms-4">
        <input type="text" name="title" class="mb-4" placeholder="Title"> <br>
		<input type="text" name="description" class="mb-4" placeholder="Description"> <br>
        <input type="file" name="myfile" class="mb-4" > <br>
        <input type="submit" name="mysubmit">    

    </form>
    <?php
    if($msg){
        echo "<h3 style=\"color:red;\">$msg</h3>";
    }
    ?>
</body>
</html>
<?php
	include("../includes/footer.php");
?>