<?php 
    include("connection.php");

    if(isset($_POST["submit"])){
        $imageName = $_POST["imagename"];
        $fileName = $_FILES["image"]["name"];
        $tempName = $_FILES["image"]["tmp_name"];
        $folder = "img/". $fileName;

        $query = mysqli_query($conn, "INSERT INTO tb_upload (imagename, image) VALUES ( '$imageName','$fileName')");
        if(move_uploaded_file($tempName, $folder)){
            echo "<h2> File Uploaded Successfully <h2/>";
    }else{
          echo "<h2> File Upload Failed <h2/>";
    }
}
       
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form action="index.php" method="post" enctype="multipart/form-data">
        <label for="imagename">Name</label>
        <input type="text" name="imagename">
        <input type="file" name="image">
        <button type="submit" name="submit"> Submit</button>
    </form>
    <div>
        <?php
        $res = mysqli_query($conn, "SELECT * FROM tb_upload");
        $row = mysqli_fetch_array($res)
        ?>
        <?php echo $row['imagename'] ?>
        <img src="img/<?php echo $row['image']?>">
    </div>

    <div>
        <form action="index.php" method="post">
            <input type="text" name="search">
            <button type="submit" name="searchbtn"> Search</button>
        </form>
        <?php
            if(isset($_POST["searchbtn"])){
                $itemsearch = $_POST["search"];
        
                $sql = "SELECT * FROM tb_upload WHERE imagename LIKE '%$itemsearch%'";
        
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                // Output data for each matching row
                while($row = $result->fetch_assoc()) {
                    echo "Name: " . $row['imagename'] . "<br>";
                    echo  "<img src = img/". $row["image"].">";
                }
            } else {
                echo "No results found.";
            }
        }        
        
        ?>

    </div>
</body>

</html>