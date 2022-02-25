<?php
require_once 'lib/core.php';
$sql = 'SELECT * FROM webConfig where id = 1';
if ($result = $conn->query($sql)) {
    if ($result->num_rows > 0) {
        $webConfig = $result->fetch_assoc();
    } else {
        // echo "nothing";
    }
} else {
    $error = $conn->error;
}

$sql = 'SELECT * FROM services';
if ($result = $conn->query($sql)) {
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $services[] = $row;
        }
    } else {
        // echo "nothing";
    }
} else {
    $error = $conn->error;
}

$sql = 'SELECT * FROM benefits';
if ($result = $conn->query($sql)) {
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $benefits[] = $row;
        }
    } else {
        // echo "nothing";
    }
} else {
    $error = $conn->error;
}



$sql = 'SELECT * FROM whyUs';
if ($result = $conn->query($sql)) {
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $whyUs[] = $row;
        }
    } else {
        // echo "nothing";
    }
} else {
    $error = $conn->error;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $webConfig['Name'] ?></title>
    <link rel="stylesheet" href="assets/style.css">
    <link rel="shortcut icon" href="./assets/Home/Group 2.png">

    <!-- CSS only -->
<!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">  -->
<!-- JavaScript Bundle with Popper -->
<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.css" integrity="sha512-wR4oNhLBHf7smjy0K4oqzdWumd+r5/+6QO/vDda76MW5iug4PT7v86FoEkySIJft3XA0Ae6axhIvHrqwm793Nw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<?php
if (isset($_POST['contactSubmission'])) {
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $subject = $conn->real_escape_string($_POST['subject']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $message = $conn->real_escape_string($_POST['message']);
    $sql = "INSERT into contact(name,email,subject,phno,message) values('$name', '$email', '$subject', '$phone','$message')";
    if ($conn->query($sql)) {
        $submission = 'submitted';
    } else {
        $submission = 'false';
    }
}

if (isset($_POST['querySubmission'])) {
    $name = $conn->real_escape_string($_POST['queryName']);
    $email = $conn->real_escape_string($_POST['queryEmail']);
    $query = $conn->real_escape_string($_POST['query']);
    $message = $conn->real_escape_string($_POST['queryMessage']);
    $sql = "INSERT into queries(name,email,queries,message) values('$name', '$email', '$query','$message')";
    if ($conn->query($sql)) {
        $submission = 'submitted';
    } else {
        $submission = 'false';
    }
}
?>
<body>
    <!-- <div class="whole-page-wrapper">  -->
        <div class="whole-home-page-wrapper">
        <!-- <div class="home-page-first-section-bg">
            <img class="whatwedo-img-bg" src="assets/Home/blue2.png" alt="">
        </div>
        <div class="home-page-first-section-bg2">
            <img class="whatwedo-img-bg2" src="assets/Home/blue2.png" alt="">
        </div> -->
        <div class="what-we-do-wrapper-for-bg">
    <div class="navbar-for-home-page">
        <img src="./assets/Home/Group 5.png" class="img-responsive"> 
        <!-- <h1><?= $webConfig['Name'] ?></h1>  -->

        <button class="hamburger" id="hamburger" style="
    background: transparent;
    color: #fff;
    border: none;
    font-size:20px;
    padding: 20px 20px;
" >
            <i class="fas fa-bars"  ></i>
        </button>
        <div class="ul-and-btn-wrapper" id="ul-and-btn-wrapper">
            
            <ul>
                <a href="index.php"><li>Home</li></a> 
                <div class="line"></div>
                <a href="whatwedo.php"><li>What we do</li></a> 
                <div class="line"></div>
                <a href="pricing.php"><li>Pricing</li></a> 
            </ul>
            <div class="navbar-btn"> 
            <button class="login-btn-navbar" onclick="window.location.href='https://dev.savvy-srt.com/login'">Login</button>
                <button id="myBtn">Request for a Demo</button>
            </div>  
        </div>
    </div>
    
    <div class="home-page-header-section what-we-do-page">
        <div class="header-text-part">
        <h1><?= $webConfig['whatWeDo'] ?></h1>
        <p><?= $webConfig['whatWeDoSubHeading'] ?></p>
        
    </div>
    </div> 



<!-- ---------------new-section2 ends--------- -->





<!-- -------------new-section-3---- -->

    <div class="core-sevices-section" id="content">
    <div class="why-savvy-section">
        <h1>Savvy STR – Core Features</h1>
        <!-- <div class="savvy-bg">
            <img src="./assets/Home/Ellipse 531.svg" alt="">
        </div> -->
        <div class="savvy-border-line">
            <img src="assets/Home/Group 24.svg" alt="">
        </div>
        <div class="savvy-border-line2">
            <img src="assets/Home/Group 24.svg" alt="">
        </div>
        <div class="why-savvy-section-all-cards">

        
        <div class="why-section-cards new-navvy-cards">
        <?php if (isset($services)) {
            $i = 1;
            foreach ($services as $serve) { ?>
                            <div class="why-card why-card">
                                <img src="<?= $serve['icon'] ?>" alt="">
                                <h1><?= $serve['name'] ?></h1>
                            </div>
                        <?php $i++;}
        } ?>
           
        </div>
    </div>
    </div>
</div>

<!-- ------------new-section-3-ends -->
 
<div class="new-savvy-container what-we-do-new-savvy-container">
    <div class="why-savvy-section">
    <h1>Savvy STR Benefits</h1>
        
        <!-- <div class="savvy-bg">
            <img src="./assets/Home/Ellipse 531.svg" alt="">
        </div> -->
        <div class="savvy-border-line">
            <img src="assets/Home/Group 24.svg" alt="">
        </div>
        <div class="savvy-border-line2">
            <img src="assets/Home/Group 24.svg" alt="">
        </div>
        <!-- <div class="core-services-section">

            <?php 
            // if (isset($benefits)) {
            //     $i = 0;
            //     $cssName = ['first','second','third','fourth'];
            //     foreach ($benefits as $serve) { 
            ?>
                        <div class="core-card-<?=$cssName[$i]?>-row">

                            <div class="why-core">
                                <img src="" alt="">
                            </div>
                            <div class="why-card-text">
                                <h1><?=$serve['name']?> :</h1> <span><?=$serve['thought']?></span>
                            </div>
                        </div>
                        <br>
            <?php
            //     $i++;
            //     if($i<3)
            //         $i=0;
            //     }
            // } 
            ?>
        </div> -->
        
        <div class="why-savvy-section-all-cards">

        
        <div class="why-section-cards">
            <?php 
            if (isset($benefits)) {
                $i = 1;
                foreach ($benefits as $serve) { ?>
                            <div class="why-card why-card">
                                <h1 class="why-card-heading"> <a>.</a> <?= $serve['name'] ?></h1>
                                <p><?= $serve['thought'] ?></p>
                            </div>
                        <?php $i++;}
            } ?>
        </div>
    </div>
    </div>
</div>
         


    
    <div class="contact-part-home-page">
        <h1>Request for a demo</h1>
        <p>We are all ready to help you</p>
        <form method="post" >
            <div class="contact-form-container">
                <div class="first-input-row">

                    <div class="input-nameandsubject">
                        <input type="text" placeholder="Name" name="name" id="name" required>
                        <input type="text" placeholder="Subject" name="subject" id="subject" required>
                    </div>
                    <div class="input-emailandnumber">
                        <input type="email" placeholder="Email" name="email" id="email" required>
                        <input type="tel" placeholder="Phone Number" name="phone" id="phone" required>
                    </div>
                </div>
                <div class="input-message">
                    <textarea name="message" placeholder="Your Message" id="" cols="30" rows="10"></textarea>
                </div>
                <button type="submit" name="contactSubmission">Submit</button>
            </div>
        </form>
        <?php if ($submission == 'submitted') { ?>
                    <div id="snackbar" class="show">Request Submitted Successfully!
                        <img src='assets/Home/remove.png' id="removeIcon" onClick="document.getElementById('snackbar').classList.remove('show')" />
                    </div>
                <?php } ?>
        <div class="social-icons">
            <div class="social-line"></div>
            <ul>
                <?php
                if (!$webConfig['facebookLink'] == '') { ?>
                         <li><a href="<?= $webConfig[
                             'facebookLink'
                         ] ?>"><img src="assets/Home/facebook.png" alt=""></a></li>
                    <?php }
                if (!$webConfig['instagramLink'] == '') { ?>
                        <li><a href="<?= $webConfig[
                            'instagramLink'
                        ] ?>"><img src="assets/Home/instagram.png" alt=""></a></li>
                    <?php }
                if (!$webConfig['youtubeLink'] == '') { ?>
                        <li><a href="<?= $webConfig[
                            'youtubeLink'
                        ] ?>"><img src="assets/Home/youtube.png" alt=""></a></li>
                    <?php }
                if (!$webConfig['twitterLink'] == '') { ?>

                    <?php }
                ?>
                
            </ul>
            <div class="social-line"></div>
        </div>
    </div>
    </div>
    <div id="myModal" class="modal">

    <div class="STRENTAL-SECOND-SECTION">
        <div class="second-section-text-part">
            <div class="secons-section-line"></div>
            <h1>Let's Talk!</h1>
            <div class="secons-section-line"></div>
            <span class="close"> &times;</span>
        </div>
    <div class="contact-form-container">
        <form method="post" >
            <div class="first-input-row">

                <div class="input-nameandsubject">
                    <input type="text" placeholder="Name" name="queryName">
                    <!-- <input type="text" placeholder="Subject"> -->
                </div>
                <div class="input-emailandnumber">
                    <input type="email" placeholder="Email" name="queryEmail">
                    <!-- <input type="tel" placeholder="Phone Number"> -->
                </div>
            </div>
            <div class="first-input-row second-input-row">
                <input type="text" placeholder="Query" name="query">
            </div>
            <div class="input-message">
                <textarea name="queryMessage" placeholder="Your Message" id="" cols="30" rows="10"></textarea>
            </div>
            <button type="submit" name="querySubmission">Connect</button>
        </form>
    </div>  

</div>
    <script>

var modal = document.getElementById("myModal");


var btn = document.getElementById("myBtn");


var span = document.getElementsByClassName("close")[0];


btn.onclick = function() {
  modal.style.display = "block";
}
span.onclick = function() {
  modal.style.display = "none";
}
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}
</script>
  
    <!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>    
 <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js" integrity="sha512-XtmMtDEcNz2j7ekrtHvOVR4iwwaD6o/FUJe6+Zq+HgcCsk3kj4uSQQR8weQ2QVj1o0Pk6PwYLohm206ZzNfubg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="assets/main.js"></script>
</body>
</html>