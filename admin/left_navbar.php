<?php

// //fetching
$sql = "SELECT * FROM webConfig where id = 1";
    if($result = $conn->query($sql)){
        if($result->num_rows > 0){
            $webConfig = $result->fetch_assoc();
        }
        else{
            // echo "nothing";
        }
    }
    else{
        $error =  $conn->error;
    }
?>
<div class="sidebar-wrapper" data-simplebar="true">
    <div class="sidebar-header">
        <div class="">
        </div>
        <div>
            <h4 class="logo-text"><?=$webConfig['Name']?> </h4>
        </div>
        <a href="javascript:;" class="toggle-btn ml-auto"> <i class="bx bx-menu"></i>
        </a>
    </div>
    <!--navigation-->
    <ul class="metismenu" id="menu">
        <li>
            <a href="homepage.php">
                <div class="parent-icon icon-color-3"><i class="fadeIn animated lni lni-write"></i>
                </div>
                <div class="menu-title">Home Page</div>
            </a>
        </li>
        <li>
            <a href="services.php">
                <div class="parent-icon icon-color-5"> <i class="fadeIn animated bx bx-clipboard"></i>
                </div>
                <div class="menu-title">Services</div>
            </a>
        </li>
        <li>
            <a href="whyus.php">
                <div class="parent-icon icon-color-8"> <i class="lni lni-caravan"></i>
                </div>
                <div class="menu-title">Why Savvy</div>
            </a>
        </li>
        <li>
            <a href="coreservices.php">
                <div class="parent-icon icon-color-7"> <i class="fadeIn animated bx bx-clipboard"></i>
                </div>
                <div class="menu-title">Core Services</div>
            </a>
        </li>
        <li>
            <a href="plans.php">
                <div class="parent-icon icon-color-2"> <i class="fadeIn animated bx bx-compass"></i>
                </div>
                <div class="menu-title">Business Plan</div>
            </a>
        </li>
        <li>
            <a href="benefits.php">
                <div class="parent-icon icon-color-18"> <i class="fadeIn animated lni lni-write"></i>
                </div>
                <div class="menu-title">STR Benefits</div>
            </a>
        </li>
         <li>
            <a href="testimonials.php">
                <div class="parent-icon icon-color-4"> <i class="lni lni-users"></i>
                </div>
                <div class="menu-title">Our Clients</div>
            </a>
        </li>

   
      
        <li>
            <a href="query.php">
                <div class="parent-icon icon-color-12"><i class="lni lni-question-circle"></i>
                </div>
                <div class="menu-title">Queries</div>
            </a>
        </li><li>
            <a href="contact.php">
                <div class="parent-icon icon-color-6"><i class="fadeIn animated lni lni-write"></i>
                </div>
                <div class="menu-title">Contact us</div>
            </a>
        </li>
    

    </ul>
</div>