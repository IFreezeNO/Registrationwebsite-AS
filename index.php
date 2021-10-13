
<?php
  require('./config/connect.php');

  // Check connection
  if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
  }

  
  $sql = "SELECT *, DATEDIFF(date, CURDATE()) AS days FROM showtypes, allshows WHERE showtypes.showidtypes = allshows.showtype ORDER BY date";
  $result = $conn->query($sql);
  $result2 = $conn->query($sql);

  $currentPageUrl = 'http://' . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8"/>
        <title>Austinshow - Home</title>
        <link rel="stylesheet" href="../sources/css/main.css">
        <link rel="stylesheet" href="../sources/css/contents.css">
        
        <link rel="icon" href="../sources/images/logo.png"/>
        <script src="https://kit.fontawesome.com/e8547f3377.js" crossorigin="anonymous"></script>
        <meta name="viewport" content="width=device-width,initial-scale=1"/>
        <meta name="theme-color" content="#FF69FF"/>
        <meta name="description" content="Official Recruitment website for The Austin Show. " />

        <!-- Twitter Card data -->
        <meta name="twitter:card" content="summary">

        <!-- Open Graph data -->
        <meta property="og:title" content="Austinshow" />
        <meta property="og:type" content="article" />
        <meta property="og:url" content="<?php echo htmlspecialchars($currentPageUrl, ENT_QUOTES) ?>" />
        <meta property="og:description" content="Official Recruitment website for The Austin Show." />
        <meta name="twitter:creator" content="@GetOnAustinShow">

    </head>
    <body>
        <header class="navbar">
            <span class="logo"><a href="/"><img src="../sources/images/logo.png" id="logo" draggable="false" alt="logo"></a></span>
        </header>
        
        <main id="page-container">
          <div id="content-wrap">
              <div class="container">
                <div class="new-container">
                    <h2>OPEN APPLICATIONS</h2>
                    <?php 

                    if ($result->num_rows > 0) {
                        // output data of each row
                        while($row = $result->fetch_assoc()) {

                            if($row["days"] > 0) {
                            
                    ?>
                    <div class="content"  onclick="location.href='show.php?id=<?php echo $row['showid'] ?>';" onmouseover="" style="cursor: pointer;"> 
                    <div class="flex-content">
                                    <div class="flex-image">
                        <img src="admin/images/<?php echo $row["showimage"] ?>" draggable="false" id="logocontent" alt="<?php echo $row["smalldescription"] ?>" >
                        </div>
                        <div class="flex-text">

                        <h3><?php echo $row["showname"] ?></h3>
                        <span id="age" title="you need to be <?php echo $row['age'] ?>+ to apply for this show"><?php echo $row["age"] ?>+</span>
                        <?php if( $row["days"] > 1) { 
                            echo '<span id="date" title="This application will be closed in '.$row["days"].' days">'.$row["days"].' days left</span>';}
                        else {
                            echo '<span id="date" title="This application will be closed in '.$row["days"].' day ?> days">'.$row["days"].' day left</span>';
                        }
                        ?>
                        <p><?php echo $row["smalldescription"] ?></p>
                    </div></div>
                    </div>
                    <?php 
                      } 
                    }
                    } 
                    ?>
                </div>
                <div class="past-container">
                    <h2>PAST APPLICATIONS</h2>
                  <?php 

                    if ($result->num_rows > 0) {
                        // output data of each row
                        while($row = $result2->fetch_assoc()) {   
                            if($row["days"] <= 0) {
                    ?>
                    <div class="content-expired">
                                <div class="flex-content">
                                    <div class="flex-image">
                                          <img src="admin/images/<?php echo $row["showimage"] ?>" class="expiredimage" id="logocontent" alt="<?php echo $row["smalldescription"] ?>">
                                        </div>
                                        <div class="flex-text">
                                            <h3><?php echo $row["showname"] ?></h3>
                                            <span id="age" title="you need to be <?php echo $row["age"] ?>+ to apply for this show"><?php echo $row["age"] ?>+</span>
                                            <span id="date" title="This show is expired">Expired</span>
                                            <p><?php echo $row["smalldescription"] ?></p>
                                        </div>
                        </div>
                    </div>
                    <?php 
                            }
                    }
                    }
                    $conn->close();
                    ?>



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