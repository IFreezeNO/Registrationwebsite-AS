
<?php session_start(); /* Starts the session */
if(!isset($_SESSION['UserData']['Username'])){
header("location:login.php");
exit;
}
?>
<?php
  require('../config/connect.php');

  // Check connection
  if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
  }

  $sql = "SELECT * FROM showtypes ORDER BY showidtypes DESC";
  $result = $conn->query($sql);
  $result2 = $conn->query($sql);

$delete =  $_GET['delete'];
$id =  $_GET['id'];



?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8"/>
        <title>Austinshow - adminpanel</title>
        <link rel="stylesheet" href="../sources/css/main.css">
        <link rel="stylesheet" href="../sources/css/form.css">
        <link rel="stylesheet" href="../sources/css/contents.css">

        <link rel="icon" href="../sources/images/logo.png"/>
        <script src="https://kit.fontawesome.com/e8547f3377.js" crossorigin="anonymous"></script>
        <script class="jsbin" src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.16/dist/sweetalert2.all.min.js"></script>
        <meta name="viewport" content="width=device-width,initial-scale=1"/>
        <meta name="theme-color" content="#FF69FF"/>
        <style>
.navbar ul {
  list-style-type: none;
  margin: 0;
  padding: 0;
  overflow: hidden;
  background-color: #000;
  border-bottom: solid #FF69FF 3px;

}

.navbar li {
  float: left;
}

.navbar li a {
  display: block;
  color: white;
  text-align: center;
  padding: 14px 16px;
  text-decoration: none;
}

.navbar li a:hover {
  background-color: #111;
}
table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #dddddd;
}
</style>
    </head>

    <body>
        <header class="navbar">
        <span class="logo"><a href="/"><img src="../sources/images/logo.png" id="logo" draggable="false" alt="logo"></a></span>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="shows.php">Applications</a></li>
            <li><a href="addshows.php">Add shows</a></li>
            <li><a href="showtypes.php">Add Showtypes</a></li>
            <li><a href="logout.php">Log out</a></li>
    </ul>
        </header>
        
        <main id="page-container">
          <div id="content-wrap">
              <div class="container-apply">
                    <h2>Showtypes</h2>
                    <a href="addevents.php" class="button">Add a new showtype</a>
                    <br /> <br />
                                        <table>
                                                <tr>
                                                    <th>Image</th>
                                                    <th>Showname</th>
                                                    <th>Age</th>
                                                    <th>Video</th>
                                                    <th>Image</th>
                                                    <th>Actions</th>
                                                </tr>
                                               <?php if ($result->num_rows > 0) {
                                                    // output data of each row
                                                    while($row = $result->fetch_assoc()) {
                                                                                                 
                                                ?>
                                                <tr>
                                                    <td><img src="images/<?php echo $row["showimage"] ?>" width="150"></td>
                                                    <td><?php echo $row["showname"] ?></td>
                                                    <td><?php echo $row["age"] ?></td>
                                                    <td><?php if(htmlspecialchars($row["containsVideo"] == 1)) { echo "✔️";} else { echo "❌";} ?></td>
                                                    <td><?php if(htmlspecialchars($row["containsImage"] == 1)) { echo "✔️";} else { echo "❌";} ?></td>

                                                    <td><a href="showtypes.php?id=<?php echo $row['showidtypes'] ?>&delete=1" class="redbutton">Delete</a></td>
                                                </tr>
                                                <?php 
                                                      } 
                                                    } 
                                                  ?>
                                          </table>
                                        

                
              </div>

                </div>
            </div>
          </div>
        </main>


<footer class="footer">
    <div class="footer-container">
        <div class="logo">
            <img src="../sources/images/logo.png" id="logo" draggable="false" alt="logo">
            </div>
        <div class="links">
            <h3>Links</h3>
        <p> <a href="https://discord.com/invite/austin" target="_blank" rel="noreferrer"><i class="fab fa-discord"></i> Discord</a></p>
        <p> <a href="https://twitter.com/getonaustinshow" target="_blank" rel="noreferrer"><i class="fab fa-twitter-square"></i> Twitter</a></p>
        <p> <a href="https://www.twitch.tv/austinshow" target="_blank" rel="noreferrer"><i class="fab fa-twitch"></i> Twitch</a></p>

        </div>
      </div>

</footer>
</body>



</html>
<?php

if($delete == 1) {  
    if(!is_numeric($_GET['id'])) {
      echo "Invalid id";
      exit;
    }
    $sqlimage = "SELECT * FROM showtypes WHERE $id = showidtypes";
    $results = $conn->query($sqlimage);
    $img = $results -> fetch_array(MYSQLI_ASSOC);
  
    $image = $img['showimage'];

    $insertmarking = "DELETE FROM showtypes WHERE  $id = showtypes.showidtypes";   
        unlink(dirname(__FILE__). "/images/". $image);
      
if ($conn->query($insertmarking) === TRUE) {
    echo "
    <script>
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
          toast.addEventListener('mouseenter', Swal.stopTimer)
          toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
      })
      
      Toast.fire({
        icon: 'success',
        title: 'The entries and show has been deleted from the database '
      })

      

    </script>";
echo ' <meta http-equiv="refresh" content="3;url=showtypes.php">';


} else {
    echo "<script>Swal.fire({
        icon: 'error',
        title: $conn->error,
        timer: 3000,
        timerProgressBar: true,
      })</script>";
}



}
  $conn->close();

?>