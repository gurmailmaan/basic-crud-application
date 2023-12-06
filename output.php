<?php
$con = mysqli_connect("localhost", "gmaan1","gur@1303", "gmaan1_dmit2025");

?>


<html>

<head>
<style>
    body{
        display:flex;
        flex-wrap:wrap;
    }

    div{
        width: 260px;
        margin:10px;
    }

</style>
</head>

<body>


<?php $result = mysqli_query($con, "SELECT * FROM gallery_prep"); ?>

<!-- Here we write the beginning of the while loop -->
<?php while ($row = mysqli_fetch_array($result)): ?>
<div><a href="detail.php?id=<?php echo $row['id']?>"> <img src="thumbs/<?php echo $row['filename'] ?>" alt=""> <br><?php echo $row['title'] ?></a></div>

<?php endwhile; ?>  


</body>
</html>