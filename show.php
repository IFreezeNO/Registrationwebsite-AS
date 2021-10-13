
<?php
  require('./config/connect.php');

  $id = $_GET['id'];
  if(empty($id)) {
    echo "Invalid id";
    exit;
  }

  // Check connection
  if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
  }

  if(!is_numeric($_GET['id'])) {
    echo "Invalid id";
    exit;
  }
 


  $sql = "SELECT *, DATEDIFF(date, CURDATE()) AS days FROM showtypes, allshows WHERE showtypes.showidtypes = allshows.showtype AND allshows.showid = $id";
  $result = $conn->query($sql);
  $row = $result -> fetch_array(MYSQLI_ASSOC);

  if(!isset($row['showid'])) {
    echo "Invalid id";
    exit;
  }
  if($row["days"] <= 0) {
    echo "The submissions for $row[showname] is closed";
    exit;
  }

  $currentPageUrl = 'https://' . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
  $currentPageUrlimage = 'https://' . $_SERVER["HTTP_HOST"] ;


?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8"/>
        <title>Austinshow - application for <?php echo $row["showname"] ?></title>
        <link rel="stylesheet" href="../sources/css/main.css">
        <link rel="stylesheet" href="../sources/css/form.css">
        
        <link rel="icon" href="../sources/images/logo.png"/>
        <script src="https://kit.fontawesome.com/e8547f3377.js" crossorigin="anonymous"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.16/dist/sweetalert2.all.min.js"></script>
        <meta name="viewport" content="width=device-width,initial-scale=1"/>
        <meta name="theme-color" content="#FF69FF"/>
        <meta name="description" content="<?php echo $row["smalldescription"] ?>" />

        <!-- Twitter Card data -->
        <meta name="twitter:card" content="summary">

        <!-- Open Graph data -->
        <meta property="og:title" content="Austinshow" />
        <meta property="og:type" content="article" />
        <meta property="og:url" content="<?php echo htmlspecialchars($currentPageUrl, ENT_QUOTES) ?>" />
        <meta property="og:image" content="<?php echo $currentPageUrlimage ?>/admin/images/<?php echo $row["showimage"] ?>" />
        <meta property="og:description" content="<?php echo $row["smalldescription"] ?>" />
        <meta name="twitter:creator" content="@GetOnAustinShow">
        <meta name="twitter:image" content="<?php echo $currentPageUrlimage ?>/admin/images/<?php echo $row["showimage"] ?>" />

        <?php if($row["containsImage"] == 1) { ?>
        <script>
            function readURL(input) {
            if (input.files && input.files[0]) {
        
                var reader = new FileReader();
        
                reader.onload = function(e) {
                $('.image-upload-wrap').hide();
        
                $('.file-upload-image').attr('src', e.target.result);
                $('.file-upload-content').show();
        
                $('.image-title').html(input.files[0].name);
                };
        
                reader.readAsDataURL(input.files[0]);
        
            } else {
                removeUpload();
            }
            }
        
            function removeUpload() {
            $('.file-upload-input').replaceWith($('.file-upload-input').clone());
            $('.file-upload-content').hide();
            $('.image-upload-wrap').show();
            }
            $('.image-upload-wrap').bind('dragover', function () {
                    $('.image-upload-wrap').addClass('image-dropping');
                });
                $('.image-upload-wrap').bind('dragleave', function () {
                    $('.image-upload-wrap').removeClass('image-dropping');
            });
        </script>
         <?php } ?>
    </head>

    <body>
        <header class="navbar">
            <span class="logo"><a href="/"><img src="../sources/images/logo.png" id="logo" draggable="false" alt="logo"></a></span>
        </header>
        
        <main id="page-container">
          <div id="content-wrap">
              <div class="container-apply">
                <h2>APPLICATION FOR <?php echo $row["showname"] ?></h2>
                <p><?php echo nl2br($row["description"]) ?></p>
                <hr />
                <form method="post" action="<?php echo $currentPageUrl ?>" enctype="multipart/form-data">
                    <input type="text"  name="username" maxlength="100" placeholder="Username" required>
                    
                    <input type="text" name="twitterurl" maxlength="70" placeholder="Twitter URL" required>
                                        
                    <textarea placeholder="Who are you and what makes you interesting?" maxlength="2000" rows="5" name="interesting" required></textarea>
                  
                    <textarea placeholder="Why are you interested in the guest?" rows="5" maxlength="2000" name="guest" required></textarea>
                    
                    <textarea placeholder="Anything else you think would be of interest?" maxlength="2000" rows="5" name="anythingelse" required></textarea>
                  <?php if($row["containsVideo"] == 1) { ?>
                    <input type="text" name="video" maxlength="100"  placeholder="Youtube Video" required>
                    <?php  } ?>

                    <?php if($row["containsImage"] == 1) { ?>
                    <div class="file-upload">
                        <button class="file-upload-btn" type="button" onclick="$('.file-upload-input').trigger( 'click' )">Add an image of yourself</button>
                        <div class="image-upload-wrap">
                          <input class="file-upload-input" type='file' name="image" onchange="readURL(this);" accept="image/*" required/>
                          <div class="drag-text">
                            <h3>Drag and drop a file or select add Image</h3>
                          </div>
                        </div>
                        <div class="file-upload-content">
                          <img class="file-upload-image" src="#" alt="your image" />
                          <div class="image-title-wrap">
                            <button type="button" onclick="removeUpload()" class="remove-image">Remove <span class="image-title">Uploaded Image</span></button>
                          </div>
                        </div>
                      </div>
                      <?php } ?>

                    <div class="container">
                        <ul class="ks-cboxtags">
                          <li><input type="checkbox" id="age" value="false" name="age"><label for="age">I am above the age of <?php echo $row["age"] ?></label></li>
                          <li><input type="checkbox" id="interviewed" value="false"  name="interviewed"><label for="interviewed">I have been interviewed by the Austinshow in the past</label></li>
                          <li><input type="checkbox" id="beenonshow" value="false" name="beenonshow"><label for="beenonshow">I have been on the Austinshow before</label></li>
                        </ul>
                      
                      </div>
                      <div class="h-captcha" data-sitekey="550c70b7-ec6a-4ba7-8720-09cc2e00a72e"></div>

                    <input type="submit" class="button" name="submit" value="Send application">
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
<script src='https://www.hcaptcha.com/1/api.js' async defer></script>



</html>
<?php


  if (isset($_POST['submit']) && isset($_POST['username']) && isset($_POST['twitterurl']) && isset($_POST['interesting']) && isset($_POST['guest']) && isset($_POST['anythingelse'])) {
    
    $username = $_POST['username'];
    $twitter = $_POST['twitterurl'];
    $interesting = $_POST['interesting'];
    $guest = $_POST['guest'];
    $anythingelse = $_POST['anythingelse'];
    $beenonshow = 0;
    $interviewed = 0;
    $age = 0;
    $youtube = "";
    $image = "";
    $ip = $_SERVER['REMOTE_ADDR'];
    $time = time();
    if(isset($_POST['video'])) {
    $youtube = $_POST['video'];
    }

    
    
    if(isset($_POST['beenonshow'])) {
      $beenonshow = 1;
    }
    if(isset($_POST['interviewed'])) {
      $interviewed = 1;
    }
    if(isset($_POST['age'])) {
      $age = 1;
    }

    $data = array(
      'secret' => "hCapthasecret",
      'response' => $_POST['h-captcha-response']
  );
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, "https://hcaptcha.com/siteverify");
  curl_setopt($ch, CURLOPT_POST, true);
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  $response = curl_exec($ch);
  $responseData = json_decode($response);
  if($responseData->success) {
      
    
         
    if($age == 1 ) {

      if($row['containsImage'] == 1) {


        // get details of the uploaded file
        $fileTmpPath = $_FILES['image']['tmp_name'];
        $fileName = $_FILES['image']['name'];
        $fileSize = $_FILES['image']['size'];
        $fileType = $_FILES['image']['type'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));
       
        // sanitize file-name
        $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
       
        // check if file has one of the following extensions
        $allowedfileExtensions = array('jpg', 'gif', 'png');
       
        if (in_array($fileExtension, $allowedfileExtensions))
        {
          // directory in which the uploaded file will be moved
          $uploadFileDir = './admin/images/';
          $dest_path = $uploadFileDir . $newFileName;
        }
          if(move_uploaded_file($fileTmpPath, $dest_path)) {}
       
           }  else {
             $newFileName = "";
           }

           
      $sqlinsert = "INSERT INTO applications (username, twitterurl, whyareyouinterested, anythingelse, whoareyou, age, ihavebeenontheshow, ipadresse, youtubevideo, images, ihavebeeninterviewed, showid, dateinserted) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)";
      $stmt= $conn->prepare($sqlinsert);
      $stmt->bind_param("sssssiisssiis", $username, $twitter, $guest, $anythingelse, $interesting, $age, $beenonshow, $ip , $youtube, $newFileName, $interviewed, $row['showid'], $time);
      $stmt->execute();
      
      echo "<script>Swal.fire({
        icon: 'success',
        title: 'APPLICATION SENT',
        text: 'We will reach out to you on twitter if we want you in the show. ', 
         footer: 'Make sure to open DMs for @GetOnAustinShow on twitter',
         timer: 15000,
         timerProgressBar: true,
      })</script>";
  
      
      sendDiscord($row["showname"], $twitter, $ip, $username, $guest, $anythingelse, $interesting);
  
    
  
    } else {
      echo "<script>Swal.fire({
        icon: 'error',
        title: 'You need to be 18+',
        timer: 3000,
        timerProgressBar: true,
      })</script>";
    }

  } else {
    echo "<script>Swal.fire({
      icon: 'error',
      title: 'You did not pass the Captcha puzzle',
      timer: 3000,
      timerProgressBar: true,
    })</script>";
  }



  



}
 
function sendDiscord($showname, $twitter, $ip, $username, $guest, $anythingelse, $interesting) {
  $url = "https://discord.com/api/webhooks/*************/********************";

  $timestamp = date("Y-m-d H:i:s");

  $hookObject = json_encode([ // Discord Embed Message
    'username'   => "Austinshow" , 
    'avatar_url' => "https://pbs.twimg.com/profile_images/1270614623557832705/mZjQF8Sp_400x400.jpg",
    "embeds" => [
        /*
         * Our first embed
         */
        [
            "title" => "New submission for $showname",
            
            // The type of your embed, will ALWAYS be "rich"
            "type" => "rich",
            
            /* A timestamp to be displayed below the embed, IE for when an an article was posted
             * This must be formatted as ISO8601
             */
            "timestamp" => "$timestamp",
            
            // The integer color to be used on the left side of the embed
            "color" => hexdec( "391c45" ),
            
            // Footer object
            "footer" => [
                "text" => "New submission for Austinshow"
            ],
            // Author object
            "author" => [
                "name" => "Check out the submission",
                "url" => "https://twitter.com/getonaustinshow"
            ],
            // Field array of objects
            "fields" => [
                [
                    "name" => "Username",
                    "value" => "$username",
                    "inline" => true
                ],
                [
                    "name" => "Twitter",
                    "value" => "$twitter",
                    "inline" => true
                ],
                [
                    "name" => "IP",
                    "value" => "$ip",
                    "inline" => true
                ]
            ]
        ]
    ]

], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );
  
  $headers = [ 'Content-Type: application/json; charset=utf-8' ];
  $POST = [ 'username' => 'Testing BOT', 'content' => 'Testing message' ];
  
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_POST, true);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $hookObject);
  $response   = curl_exec($ch);

}
  




$result -> free_result();
$conn -> close();


?>