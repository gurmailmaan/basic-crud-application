<?php
$con = mysqli_connect("localhost", "gmaan1","gur@1303", "gmaan1_dmit2025");

?>



<html>

<head>
<style>
    /* body{
        display:flex;
        flex-wrap:wrap;
    }

    div{
        width: 260px;
        margin:10px;
    } */

</style>
</head>

<body>


<?php 
if(isset($_GET['id'])){
    $id = $_GET['id'];
}
$result = mysqli_query($con, "SELECT * FROM gallery_prep WHERE id = '$id'");

?>

<!-- Here we write the beginning of the while loop -->
<?php while ($row = mysqli_fetch_array($result)): ?>
    <h2><?php echo $row['title'] ?></h2>
<div><img src="display/<?php echo $row['filename'] ?>" alt=""><br> <?php echo $row['filename'] ?> <br><?php echo $row['description'] ?>
</div> 

<?php endwhile; ?>  


</body>
</html>