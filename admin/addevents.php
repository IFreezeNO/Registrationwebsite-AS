
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
                <h2>Add showtypes to the database</h2>
                <hr />
                <form method="POST" action="<?php echo $currentPageUrl ?>" enctype="multipart/form-data">
                    <input type="text"  name="showname" placeholder="Showname" required>
                    
                    <input type="number" name="age" min="13" max="99" placeholder="Min. Age requirement" required>

                    <div class="file-upload">
                        <button class="file-upload-btn" type="button" onclick="$('.file-upload-input').trigger( 'click' )">Add an image of the showlogo</button>
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

                    <div class="container">
                        <ul class="ks-cboxtags">
                          <li><input type="checkbox" id="requirevideo" value="false"  name="requirevideo"><label for="requirevideo">This show require a video</label></li>
                          <li><input type="checkbox" id="requireimage" value="false" name="requireimage"><label for="requireimage">This show require an image</label></li>
                        </ul>
                      
                      </div>

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
    $image = 0;
    $video = 0;
    $showname = $_POST['showname'];
    $age = $_POST['age'];
    
    
    if(isset($_POST['requireimage'])) {
        $image = 1;
      }
      if(isset($_POST['requirevideo'])) {
        $video = 1;
      }
    
      if(!empty($image)) {
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
          $uploadFileDir = '../admin/images/';
          $dest_path = $uploadFileDir . $newFileName;
        }
          if(move_uploaded_file($fileTmpPath, $dest_path)) {}
       
           }  else {
             $newFileName = "";
           }
    
      $sql = "INSERT INTO showtypes (showname, showimage, age, containsVideo, containsImage)
      VALUES ('$showname', '$newFileName', '$age', '$video', '$image')";
    
    
        if ($conn->query($sql) === TRUE) {
            echo "<script>Swal.fire({
                icon: 'success',
                title: 'New showtype added to the database',
                text: 'The new showtype is now added into the database ', 
                 timer: 15000,
                 timerProgressBar: true,
              })</script>";
      } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
      }
    
    }
  $conn->close();

?>