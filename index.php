<!-- redirect -->
<?php
    include "php/config.php";
    $new_url = "";
    if(isset($_GET))
    {
        
        foreach ($_GET as $key => $val) {
           $u = mysqli_real_escape_string($conn, $key);
           $new_url = str_replace('/','',$u);
        }
        
        $sql = mysqli_query($conn, "SELECT full_url FROM url WHERE shorten_url = '{$new_url}'");
        if(mysqli_num_rows($sql) > 0)
        {
            $count_query = mysqli_query($conn, "UPDATE url SET clicks = clicks +1 WHERE shorten_url = '{$new_url}'");
            if($count_query)
            {
                $full_url = mysqli_fetch_assoc($sql);
                header("Location: ".$full_url['full_url']);
            }
        }
    }

?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- connecting fontAwesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.3/css/all.css" integrity="sha384-SZXxX4whJ79/gErwcOYf+zWLeJdY/qpuqC4cAa9rOGUstPomtqpuNWT9wdPEn2fk" crossorigin="anonymous">
    
    <!-- Custom StyleSheet link -->
    <link rel="stylesheet" href="style.css" type="text/css">

    <title>URL Shortener</title>
</head>
<body>
    
    <div class="container">
        <form action="#">
            <input type="text" name="full-url" placeholder="Enter or Paste URL" autocomplete="off" required>
            <i class="fas fa-paperclip"></i>
            <button>Shorten</button>
        </form>
        <?php
            $sql2 = mysqli_query($conn, "SELECT * FROM url ORDER BY id DESC");
            if(mysqli_num_rows($sql2) > 0){
        ?>
        <div class="count">
                <?php
                    $sql3 = mysqli_query($conn,"SELECT COUNT(*) FROM url");
                    $res = mysqli_fetch_assoc($sql3);

                    $sql4 = mysqli_query($conn, "SELECT clicks FROM url");
                    $clicked = 0;
                    while($c = mysqli_fetch_assoc($sql4)){
                        $clicked += $c['clicks'];
                    }

                ?>
            <span>Total Links: <span><?php echo end($res); ?></span> & Total Clicks: <span> <?php echo $clicked; ?> </span></span>
            <a href="php/delete.php?delete=all">Clear All</a>
        </div>
        <div class="urls-area">
            <div class="title">
                <li>Shorten URL</li>
                <li>original URL</li>
                <li>CLicks</li>
                <li>Action</li>
            </div>
        <?php
            while($row = mysqli_fetch_assoc($sql2))
            {
        ?>
            <div class="data">
                <li>
                    <a href="http://localhost/URL_Shortener/<?php echo $row['shorten_url']?>" target="_blank">
                        <?php 
                            if(strlen($row['shorten_url']) > 50){
                                echo 'localhost/URL_Shortener/'.substr($row['shorten_url'],0,50) . '...';
                            }else{
                                echo 'localhost/URL_Shortener/' . $row['shorten_url'] ;
                            }
                        ?>
                    </a>
                </li>
                <li>
                    <?php 
                        if(strlen($row['full_url']) > 65){
                            echo substr($row['full_url'],0,65) . '...';
                        }else{
                            echo $row['full_url'] ;
                        }
                    ?>
                </li>
                <li><?php echo $row['clicks'] ?></li>
                <li><a href="php/delete.php?id=<?php echo $row['shorten_url']?>">Delete</a></li>
            </div>
        <?php
            }
        }
        ?>
        </div>

    </div>

    <div class="blur-effect"></div>
    <div class="popup-box">
        <div class="info-box">You can edit your short link now but can't edit once you saved</div>
        <form action="#">
            <label>Edit your shorten URL</label>
            <input type="text" spellcheck="false" value="">
            <i class="far fa-copy"></i>
            <button>Save</button>
        </form>
    </div>

    <!-- JS Connection -->
    <script src="script.js"></script>

</body>
</html>