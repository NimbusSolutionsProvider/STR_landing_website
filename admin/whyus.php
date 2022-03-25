
<?php


require_once 'header.php';
require_once 'navbar.php';
require_once 'left_navbar.php';


?>
<?php
    if(isset($_POST['editService'])){
        $id=$conn->real_escape_string($_POST['editService']);
        $name = $conn->real_escape_string($_POST['nameEdit']);
        $about = $conn->real_escape_string($_POST['aboutEdit']);
        $sql = "UPDATE whyus set name='$name',about = '$about'where id= '$id'";
        if($conn->query($sql)){
            $updated= 'true';
        }
        else{
            $updated= 'false';
        }
    }

    if(isset($_POST['deleteService'])){

        $id = $conn->real_escape_string($_POST['deleteService']);
        $path = $conn->real_escape_string($_POST['deletePath'.$id]);
        unlink("../".$path);
        $sql = "DELETE FROM whyus WHERE id= '$id'";
        if($conn->query($sql)){
            $updated = 'true';

        }
        else{
            $updated = 'false';
        }
    }

    if(isset($_POST['addService'])){
        $name = $conn->real_escape_string($_POST['name']);
        $about = $conn->real_escape_string($_POST['about']);
        $image =  uploadImage($_FILES);
        echo $image;
        if($image!='err'){
            $sql = "INSERT INTO whyus(name,icon,about) values('$name','uploads/$image','$about')";
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


    $sql = "SELECT * FROM whyus";
    if($result = $conn->query($sql)){
        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                $services[] = $row;
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
                <div class="breadcrumb-title pr-3">Why Savvy</div>
                <div class="pl-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="javascript:;"><i class='bx bx-home-alt'></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                
                            Why Savvy

                            </li>
                        </ol>
                    </nav>
                    
                </div>
                <div class="ml-auto">
                    <div class="btn-group">
                        <button title="" class="btn btn-primary" data-toggle="modal" data-target="#modal-default"><i class="fadeIn animated bx bx-list-plus"></i></button>
                    </div>
                </div>
                <!-- <div class="ml-auto">
                    <div class="btn-group">
                       <button type="submit" class="btn btn-primary m-1" data-toggle="modal" data-target="#modal4addbarber"><i class=" fadeIn animated bx bx-plus"></i></button>
                    </div>
                </div> -->
            </div>
            <div class="card">

                <div class="card-body">
                <?php
                        if($updated == 'true'){
                            ?>
                                <div class="alert alert-primary">Why Savvy updated Successfully !</div>
                            <?php
                        }
                        else if($updated == 'false'){
                            ?>
                                <div class="alert alert-danger">Error Occured!</div> 
                            <?php
                        } 
                        if($added == 'true'){
                            ?>
                                <div class="alert alert-primary">Why Savvy added Successfully !</div>
                            <?php
                        }
                        else if($added == 'false'){
                            ?>
                                <div class="alert alert-danger">Error Occured!</div> 
                            <?php
                        }

                    ?>
                <?php
                    if(isset($services)){
                    $i=1;
                ?>
                <div class='table-responsive' style='margin-top:20px;margin-bottom:20px'>
                    <table class='table table-striped table-bordered text-center mb-0' id='table1'>
                        <thead class='thead-dark'>
                            <tr>
                                <th scope='col'>#</th>
                                <th scope='col'>Name</th>
                                <th scope='col'>Icon</th>
                                <th scope='col'>About</th>
                                <th scope='col'>Actions</th>
                            </tr>
                        </thead>
                        <form method='post'>
                        <tbody id='showallusers'>
                            <?php
                                foreach($services as $service){
                                    $id = $service['id'];
                                    $icon = $service['icon'];
                                    $name = $service['name'];
                                    $about = $service['about'];
                                    ?>
                                    <tr>
                                        <td><?=$i?></td>
                                        <td><?=$service['name']?></td>
                                        <td>
                                            <img src='../<?=$service['icon']?>' style='height: 100px;' class='img-responsive'  />
                                            <input type='hidden' name='deletePath<?=$id?>' value="<?=$service['icon']?>">
                                        </td>
                                        <td><?=$service['about']?></td>
                                        <td><button type='button' class='btn btn-primary' onclick='setEditValue(`<?=$id?>`,`<?=$icon?>`,`<?=$name?>`,`<?=$about?>`)' data-toggle='modal' data-target='#edit-modal'><i class='bi bi-pencil'></i></button>&nbsp;<button type='submit' class='btn btn-danger' name="deleteService" value="<?=$id?>" ><i class='bi bi-trash'></i></button></td>
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
                            <div class="alert alert-primary">No Why Savvy Found!</div>
                        <?php
                    }
                ?>
                    
                </div>
            </div>
        </div>
    </div>
</div>

<!-- END PAGE CONTENT -->


<!-- ADD MODAL -->
    <div class="modal fade" id="modal-default">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Why Savvy</h5>
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
                                <label>Name</label>
                                <input class="form-control" type="text" id="name" name="name" placeholder="Name" >
                            </div>
                            <div class="form-group col-md-12">
                                <label>About</label>
                                <textarea class="form-control" name="about" rows="4"></textarea>
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


<!-- EDIT MODAL -->
    <div class="modal fade" id="edit-modal">

        <div class="modal-dialog modal-lg" >

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Update Why Savvy</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="post">
                    <div id="modal-body" style="padding: 20px">
                        <div class="form-row">
                            <!-- <div class="form-group  col-md-6" id="editImageButton">
                                    <label>Edit Image</label>
                                    <br>
                                    <button type="button" class="btn btn-primary" onclick="clickChooseFile('imageEdit')"><i class='bi bi-plus'></i></button>
                                    <input class="form-control" type="file" id="imageEdit" onchange="addTeamImage('teamPhotoEdit',event,'editImageButton')" style="display:none" placeholder="Image" >
                                
                            </div> -->
                            <div class="form-group  col-md-6">
                                <div id="teamPhotoEdit" style="margin-top:5px"></div>
                                
                            </div>
                        </div>
                            <div class="form-row">
                                <div class="form-group  col-md-12">
                                    <label>Name</label>
                                    <input class="form-control" type="text" id="nameEdit" name="nameEdit" placeholder="Name" >
                                    <input type="hidden"  />
                                </div>
                                <div class="form-group col-md-12">
                                    <label>About</label>
                                    <textarea class="form-control" name="aboutEdit" rows="4"></textarea>
                                </div>
                            </div>
                        <!-- </div> -->
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" id="editId" name="editService" >Update</button>
                        <button type="button" id="updateModal-close"  class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<!-- END EDIT MODEL -->




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
        
        function setEditValue(id,icon,name)
        {
            $("#teamPhotoEdit").html(`<a target="_blank" style='margin:10px' href='../${icon}'><img class="img-responsive shadow" style='height:200px;' src='../${icon}' /></a>`);
            $("#editId").val(id)
            $("#nameEdit").val(name);
           
        }

     

</script>
</style>
