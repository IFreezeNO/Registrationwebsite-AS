
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

  $id = $_GET['id'];
  $marking = $_GET['status'];

  if(!is_numeric($id)) {
    echo "Invalid id";
    exit;
  }
  if(empty($id)) {
    echo "Invalid id";
    exit;
  }
  if(!isset($id)) {
    echo "Invalid id";
    exit;
  }

  $sql = "SELECT * FROM applications, showtypes, allshows where $id = applications.applicationID ";
  $result = $conn->query($sql);
  $row = $result -> fetch_array(MYSQLI_ASSOC);

  $appid = $row['applicationID'];

  if(empty($appid)) {
    echo "Invalid id";
    exit;
  }


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
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #dddddd;
}
#ip {
        filter: blur(7px);
        -webkit-filter: blur(7px);
      }
      #ip:hover {
        filter: blur(0px);
        -webkit-filter: blur(0px);
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
                    <h2>Application for <?php echo htmlspecialchars($row['showname'], ENT_QUOTES) ?></h2>
                                        <table>
                                                <tr>
                                                    <?php 
                                                      $image = htmlspecialchars($row["images"], ENT_QUOTES, 'UTF-8');
                                                      $video = htmlspecialchars($row['youtubevideo'], ENT_QUOTES, 'UTF-8');

                                                      if(htmlspecialchars($row["images"] == "")) {} else {
                                                    echo '<th>Image</th>';
                                                     }
                                                   
                                                      if(htmlspecialchars($row["youtubevideo"] == "")) {} else {
                                                    echo '<th>Video</th>';
                                                     }
                                                    ?>
                                                    <th>Username</th>
                                                    <th>Twitter</th>
                                                    <th>IP-adresse</th>
                                                    <th>Date</th>
                                                    <th>Been on show</th>
                                                    <th>Been interviewed</th>

                                                </tr>
                                                <tr>
                                                
                                                    <?php 
                                                    if(htmlspecialchars($row["images"] == "")) {} else {
                                                        echo '<td><img src="./images/'.$image.'"  height="200"></td>';
                                                    }
                                                    if(htmlspecialchars($row["youtubevideo"] == "")) {} else {
                                                        echo '<td><a href="'.$video.'" target="_blank">Youtube</a></td>';
                                                    }
                                                    ?>
                                                    

                                                    <td><?php echo htmlspecialchars($row["username"], ENT_QUOTES, 'UTF-8') ?></td>
                                                    <td><a href="https://twitter.com/<?php echo htmlspecialchars($row["twitterurl"], ENT_QUOTES, 'UTF-8') ?>" target="_blank"><?php echo htmlspecialchars($row["twitterurl"], ENT_QUOTES, 'UTF-8') ?></a></td>
                                                    <td><span id="ip"><?php echo htmlspecialchars($row["ipadresse"], ENT_QUOTES, 'UTF-8') ?></span></td>
                                                    <td><?php echo date('m/d/y H:i', $row["dateinserted"]) ?></td>
                                                    <td><?php if(htmlspecialchars($row["ihavebeenontheshow"] == 1)) { echo "✔️";} else { echo "❌";} ?></td>

                                                    <td><?php if(htmlspecialchars($row["ihavebeeninterviewed"] == 1)) { echo "✔️";} else { echo "❌";} ?></td>

                                                </tr>
                                          </table>

                                          <h4>Who are you and what makes you interesting ? </h4>
                                            <p><?php echo nl2br(htmlspecialchars($row["whoareyou"], ENT_QUOTES, 'UTF-8')) ?></p>            

                                          <h4>Why are you interested in the guest? </h4>
                                          <p><?php echo nl2br(htmlspecialchars($row["whyareyouinterested"], ENT_QUOTES, 'UTF-8')) ?></p>            

                                          <h4>Anything else you think would be of interest? </h4>
                                          <p><?php echo nl2br(htmlspecialchars($row["anythingelse"], ENT_QUOTES, 'UTF-8')) ?></p>            


                           </div>

              <br />
              <div class="container-apply">
                    <h2>Actions</h2>
                                        
                                               <center>
                                                    <?php 
                                                    $appid = $row['applicationID'];
                                                    if($row["isRead"] == 0) 
                                                    { echo '<a href="showapplication.php?id='.$appid.'&status=1" class="button">Mark as read</a>';}
                                                    else 
                                                    { echo '<a href="showapplication.php?id='.$appid.'&status=2" class="button">Mark as unread</a>';}
                                                    ?>
                                                    
                                                    <a href="showapplication.php?id=<?php echo $row['applicationID'] ?>&status=3" class="redbutton">Delete application</a>
                                                </center>
                                        
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


if($marking) {
    if($marking == 1) {
  $insertmarking = "UPDATE applications SET isRead = 1 WHERE  $id = applications.applicationID";
} else if($marking == 2){
  $insertmarking = "UPDATE applications SET isRead = 0 WHERE  $id = applications.applicationID";
}
else if($marking == 3){
    $insertmarking = "DELETE FROM applications WHERE  $id = applications.applicationID";
      if($image == "") {} else {
        unlink(dirname(__FILE__). "/images/". $image);
       }
  }

if ($conn->query($insertmarking) === TRUE) {
    echo "<script>Swal.fire({
        icon: 'success',
        title: 'Updated',
        text: 'This application is now updated', 
         timer: 3000,
         timerProgressBar: true,
      })
</script>";
echo ' <meta http-equiv="refresh" content="3;url=allapplications.php?showid='.$row['showid'].'">';


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