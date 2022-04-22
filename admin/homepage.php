<?php
require_once 'header.php';
require_once 'navbar.php';
require_once 'left_navbar.php';

if(isset($_POST['saveChanges'])){
    $mainHeading = $conn->real_escape_string($_POST['mainHeading']);
    $subHeading = $conn->real_escape_string($_POST['subHeading']);
    $whatWeDo = $conn->real_escape_string($_POST['whatWeDo']);
    $name = $conn->real_escape_string($_POST['Name']);
    $videoLink = $conn->real_escape_string($_POST['videoLink']);
    $facebookLink = $conn->real_escape_string($_POST['facebookLink']);
    $instagramLink = $conn->real_escape_string($_POST['instagramLink']);
    $youtubeLink = $conn->real_escape_string($_POST['youtubeLink']);
    $mission = $conn->real_escape_string($_POST['mission']);
    $vision = $conn->real_escape_string($_POST['vision']);
    $complaint = $conn->real_escape_string($_POST['complaint']);
    $sql = "UPDATE webconfig set mainHeading='$mainHeading', subHeading='$subHeading', name='$name' , videoLink='$videoLink' , whatWeDo='$whatWeDo',youtubeLink='$youtubeLink',facebookLink='$facebookLink' , instagramLink='$instagramLink',mission='$mission',vision = '$vision',complaint='$complaint' where id = 1";
    if($conn->query($sql)){
        $updated = 'true';
    }
    else{
        $updated = 'false';
    }
}

if(isset($_POST['addService'])){
    $name = $conn->real_escape_string($_POST['imageAlt']);
    $image =  uploadImage($_FILES);
    if($image!='err'){
        $sql = "INSERT INTO homepageslider(imageAlt,image) values('$name','uploads/$image')";
        if($conn->query($sql)){
            $added = 'true';
        }
        else{
            $added = 'false';
        }
    }
    else
    {
        $added = 'false';
    }
    
}

if(isset($_POST['deleteSlider'])){
    $id = $conn->real_escape_string($_POST['deleteSlider']);
    $path = $conn->real_escape_string($_POST['deletePath'.$id]);
    echo "Deleting $path";
    unlink("../".$path);
    $sql = "DELETE from homepageslider where id='$id'";
    if($conn->query($sql)){
        $updated = 'true';
    }
    else
    {
        $updated = 'false';
    }
}

$sql = "SELECT * FROM webconfig where id = 1";
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

    $sql = "SELECT * FROM homepageslider";
    if($result = $conn->query($sql)){
        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                $slider[] = $row;
            }
        }
        else{
            // echo "nothing";
        }
    }
    else{
        $error =  $conn->error;
    }

   

?>


<div class="page-wrapper">
    <!--page-content-wrapper-->
    <div class="page-content-wrapper">
        <div class="page-content">

            
            <div class="page-breadcrumb d-none d-md-flex align-items-center mb-3">
                <div class="breadcrumb-title pr-3">Home Page </div>
                <div class="pl-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="javascript:;"><i class='bx bx-home-alt'></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                
                               Pages

                            </li>
                        </ol>
                    </nav>
                    
                </div>
                
                
            </div>
                    <?php
                        if(isset($changesSaved) || isset($saveChanges))
                        {
                            ?>
                                <div class="alert alert-primary">Changes Saved Successfully</div>
                            <?php
                        }
                    ?>
            <div class="card">
                <div class="card-body">
                <?php
                        if($updated == 'true'){
                            ?>
                                <div class="alert alert-primary">Changes saved Successfully !</div>
                            <?php
                        }
                        else if($updated == 'false'){
                            ?>
                                <div class="alert alert-danger">Error Occured!</div> 
                            <?php
                        } 
                        if($added == 'true'){
                            ?>
                                <div class="alert alert-primary">Changes added Successfully !</div>
                            <?php
                        }
                        else if($added == 'false'){
                            ?>
                                <div class="alert alert-danger">Error Occured!</div> 
                            <?php
                        }

                    ?>
                     <form method="post">
                     <div class="container">
                     <!-- <h3>Why Us</h3> -->
                            <div class="row" style="margin-top:10px">
                                <br>
                                <div class="col-lg-6">
                                    <label>Name</label>
                                    <input type="text" class="form-control" name="Name" value="<?=$webConfig['Name']?>" />
                                </div>
                                <div class="col-lg-6">
                                    <label>Video Link</label>
                                    <input type="text" class="form-control" name="videoLink" value="<?=$webConfig['videoLink']?>" />
                                </div>
                            </div>
                            <div class="row" style="margin-top:10px">
                                <div class="col-lg-12">
                                    <label>Heading</label>
                                    <textarea class="form-control" name="mainHeading" rows="2"><?=$webConfig['mainHeading']?></textarea>
                                </div>
                            </div>
                            <div class="row" style="margin-top:10px">
                                <div class="col-lg-12">
                                    <label>Sub Heading</label>
                                    <textarea class="form-control" name="subHeading" rows="2"><?=$webConfig['subHeading']?></textarea>
                                </div>
                            </div> 
                            <div class="row" style="margin-top:10px">
                                <div class="col-lg-12">
                                    <label>What We Do</label>
                                    <textarea class="form-control" name="whatWeDo" rows="4"><?=$webConfig['whatWeDo']?></textarea>
                                </div>
                            </div>
                            <div class="row" style="margin-top:10px">
                                <br>
                                <div class="col-lg-6">
                                    <label>Mission</label>
                                    <textarea class="form-control" name="mission" rows="4"><?=$webConfig['mission']?></textarea>
                                </div>
                                <div class="col-lg-6">
                                    <label>Vision</label>
                                    <textarea class="form-control" name="vision" rows="4"><?=$webConfig['vision']?></textarea>
                                </div>
                            </div>
                            <div class="row" style="margin-top:10px">
                                <div class="col-lg-12">
                                    <label>Be Compliant</label>
                                    <textarea class="form-control" name="complaint" rows="4"><?=$webConfig['complaint']?></textarea>
                                </div>
                            </div>
                            <div class="row" style="margin-top:10px">
                                <br>
                                <div class="col-lg-6">
                                    <label>Facebook Link</label>
                                    <input type="text" class="form-control" name="facebookLink" value="<?=$webConfig['facebookLink']?>" />
                                </div>
                                <div class="col-lg-6">
                                    <label>Instagram Link</label>
                                    <input type="text" class="form-control" name="instagramLink" value="<?=$webConfig['instagramLink']?>" />
                                </div>
                            </div>
                            <div class="row" style="margin-top:10px">
                                <br>
                                <div class="col-lg-6">
                                    <label>Youtube Link</label>
                                    <input type="text" class="form-control" name="youtubeLink" value="<?=$webConfig['youtubeLink']?>" />
                                </div>
                                <!-- <div class="col-lg-6">
                                    <label>Twitter Link</label>
                                    <input type="text" class="form-control" name="videoLink" value="<?=$webConfig['twitterLink']?>" />
                                </div> -->
                            </div>
                            
                            <button class="btn btn-primary" style="margin:10px" type="submit" name="saveChanges">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                     <form method="post">
                     <div class="container">
                        <h3>Slider</h3>
                        <div class="ml-auto">
                            <div class="btn-group">
                                <button title="" type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-default"><i class="fadeIn animated bx bx-list-plus"></i></button>
                            </div>
                        </div>
                <?php
                    if(isset($slider)){
                    $i=1;
                ?>
                <div class='table-responsive' style='margin-top:20px;margin-bottom:20px'>
                    <table class='table table-striped table-bordered text-center mb-0' id='table1'>
                        <thead class='thead-dark'>
                            <tr>
                                <th scope='col'>#</th>
                                <th scope='col'>Image</th>
                                <th scope='col'>Actions</th>
                            </tr>
                        </thead>
                        <form method='post'>
                        <tbody id='showallusers'>
                            <?php
                                foreach($slider as $image){
                                    ?>
                                        <tr>
                                            <td><?=$i?></td>
                                            <td><img src='../<?=$image['image']?>' style='height: 100px;' class='img-responsive'  />
                                            <input type='hidden' name='deletePath<?=$image['id']?>' value="<?=$image['image']?>">
                                            </td>
                                            <td>
                                               <button type='submit' class='btn btn-danger' name="deleteSlider" value="<?=$image['id']?>" >
                                                    <i class='bi bi-trash'></i>
                                                </button>
                                            </td>
                                        </tr>
                                    <?php
                                    $i++;
                                }
                            ?>
                        </tbody>
                        </form>
                    </table>
                </div>
                <?php
                    }
                    else{
                        ?>
                            <div class="alert alert-primary">No Images Found!</div>
                        <?php
                    }
                ?>
                    
                        </div>
                    </form>
                </div>
            </div>
           
           

        </div>
    </div>
</div>

<!-- ADD MODAL -->
<div class="modal fade" id="modal-default">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Slider</h5>
                    <button type="button" class="close" data-dismiss="modal" onclick="deleteBlob('teamPhoto','addImageButton')" aria-label="Close"> <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="post" enctype="multipart/form-data">
                <div id="modal-body" style="padding: 20px">
                    <div class="form-row">
                        <div class="form-group  col-md-6" id="addImageButton">
                            <label>Add Image</label>
                            <br>
                            <button type="button" class="btn btn-primary" onclick="clickChooseFile('image')"><i class='bi bi-plus'></i></button>
                            <input class="form-control" type="file" id="image" onchange="addTeamImage('teamPhoto',event,'addImageButton')" style="display:none" placeholder="Image" name="images">
                            
                        </div>
                        <div class="form-group  col-md-6">
                            <div id="teamPhoto" style="margin-top:5px"></div>
                        </div>
                    </div>
                        <div class="form-row">
                            <div class="form-group  col-md-12">
                                <label>Image Alt</label>
                                <input class="form-control" type="text" id="name" name="imageAlt" placeholder="Alt" >
                            </div>
                        </div>
                    <!-- </div> -->
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" name="addService">Add</button>
                    <button type="button" id="Addmodal-close" class="btn btn-secondary" onclick="deleteBlob('teamPhoto','addImageButton')"  data-dismiss="modal">Close</button>
                </div>
                </form>
            </div>
        </div>
    </div>
<!-- END ADD MODEL -->

<?php
require_once 'js_links.php';
require_once 'footer.php';

?>

<script>
     function clickChooseFile(id)
        {
            $("#"+id).click();
        }
        function addTeamImage(divId,event,buttonId)
        {
            // console.log("divId",divId);
            eve =  event;
            var url = URL.createObjectURL(event.target.files[0]);
            $("#"+divId).show();
            $("#"+divId).html(`<a target="_blank" style='margin:10px' href='${url}'><img class="img-responsive" style='height:200px;' src='${url}' /></a>`); 
            $("#"+buttonId).hide();
        }
        function deleteBlob(divId,buttonId)
        {
            $("#"+divId).hide();
            $("#"+buttonId).show();
        }
        
</script>
</style>
