
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



  $retrievelist = "SELECT * FROM showtypes";
  $results = $conn->query($retrievelist);


?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8"/>
        <title>Austinshow - adminpanel</title>
        <link rel="stylesheet" href="../sources/css/main.css">
        <link rel="stylesheet" href="../sources/css/form.css">
        
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
                <h2>Add shows to the database</h2>
                <hr />
                <form method="post" action="<?php echo $currentPageUrl ?>" >
                   <?php
                   echo "<select name='showtype' required>";
                   while($row = $results->fetch_assoc()) {
                        echo "<option value='" . $row['showidtypes'] . "'>" . $row['showname'] . "</option>";
                    }
                    echo "</select>";                 
                   ?>
                    
                    <input type="text" name="smalldescription" min="13" max="99" placeholder="Small description" required>

                    <input type="date" name="endingdate" min="13" max="99" placeholder="When will the show end?" required>

                    <textarea name="description" placeholder="Full description" required></textarea>


                   
                    <input type="submit" class="button" name="submit" value="Add show">
                  </form>
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

if (isset($_POST['submit'])) {

    $showtype = $_POST['showtype'];
    $sdescription = $_POST['smalldescription'];
    $ldescription = $_POST['description'];
    $endate = $_POST['endingdate'];

    

    
     
    
      $sql = "INSERT INTO allshows (showtype, description, smalldescription, date)
      VALUES ('$showtype', '$ldescription', '$sdescription', '$endate')";
    
    
        if ($conn->query($sql) === TRUE) {
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
                title: 'New show added to the database'
              })
        
              
        
            </script>";

            echo ' <meta http-equiv="refresh" content="3;url=addshows.php">';

      } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
      }
    
    }
  $conn->close();

?>