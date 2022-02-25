<?php
require_once 'header.php';
require_once 'navbar.php';
require_once 'left_navbar.php';


//deleting
if(isset($_POST['deleteContact'])){
    $id = $_POST['deleteContact'];
    $sql = "DELETE FROM contact WHERE id = '$id'";
    if($conn->query($sql)){
        $deleted = 'true';
    }
    else{
        $deleted = 'false';
    }
}


//fetching
$sql = "select * from contact";
if($result = $conn->query($sql)){
    if($result->num_rows > 0){
        while($row = $result->fetch_assoc()){
            $contact[] = $row;
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

            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-md-flex align-items-center mb-3">
                <div class="breadcrumb-title pr-3">Contact Us</div>
               
                <div class="ml-auto">
                    <!-- <div class="btn-group">
                        <button type="submit" class="btn btn-primary m-1" data-toggle="modal" data-target="#exampleModal5"><i class=" fadeIn animated bx bx-plus"></i></button>
                    </div> -->
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <?php
                        if($deleted == 'true'){
                            ?>
                                <div class="alert alert-primary">Contact Deleted Successfully !</div>
                            <?php
                        }
                        else if($deleted == 'false'){
                            ?>
                                <div class="alert alert-danger">Error Occured!</div> 
                            <?php
                        }
                    ?>
                <?php
                    if(isset($contact)){
                    $i=1;
                ?>
                <div class='table-responsive' style='margin-top:20px;margin-bottom:20px'>
                    <table class='table table-striped table-bordered text-center mb-0' id='table1'>
                        <thead class='thead-dark'>
                            <tr>
                                <th scope='col'>#</th>
                                <th scope='col'>Name</th>
                                <th scope='col'>Email</th>
                                <th scope='col'>Phone</th>
                                <th scope='col'>Actions</th>
                            </tr>
                        </thead>
                        <tbody id='showallusers'>
                            <form method='post'>
                            <?php
                                foreach($contact as $request){
                                    $name = $request['name'];
                                    $email = $request['email'];
                                    $phno = $request['phno'];
                                    $subject = $request['subject'];
                                    $message = $request['message'];
                                    ?>
                                        <tr>
                                            <td><?=$i?></td>
                                            <td><?=$request['name']?></td>
                                            <td>
                                                <?=$request['email']?>
                                            </td>
                                            <td>
                                                <?=$request['phno']?>
                                            </td>
                                            <td>
                                                <button type='button' class='btn btn-primary' onclick='setEditValue(`<?=$name?>`,`<?=$email?>`,`<?=$phno?>`,`<?=$subject?>`,`<?=$message?>`)' data-toggle='modal' data-target='#edit-modal'>
                                                    <i class='bi bi-eye'></i>
                                                </button>&nbsp;
                                                <button type='submit' name="deleteContact" class='btn btn-danger' value="<?=$request['id']?>">
                                                    <i class='bi bi-trash'></i>
                                                </button>
                                            </td>
                                        </tr>
                                    <?php
                                    $i++;
                                }
                            ?>
                            </form>
                        </tbody>
                    </table>
                </div>
                <?php
                    }
                    else{
                        ?>
                            <div class="alert alert-primary">No Contact Found!</div>
                        <?php
                    }
                ?>
                    
                </div>
            </div>
        </div>
    </div>
</div>

<div id="snackbar">Changes Saved Successfully</div>
<!-- EDIT MODAL -->
    <div class="modal fade" id="edit-modal">

        <div class="modal-dialog modal-lg" >

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">View Request</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div id="modal-body" style="padding: 20px">
                    <div class="form-row">
                        <input type="hidden" id="editId" />
                        <div class="form-group  col-md-6">
                            <label>Name</label>
                            <input class="form-control" type="text" id="Name" placeholder="Place" disabled>
                        </div>
                        <div class="form-group  col-md-6">
                            <label>Email</label>
                            <input class="form-control" type="text" id="Email" placeholder="Address" disabled>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group  col-md-6">
                            <label>Phone</label>
                            <input class="form-control" type="link" id="Phone" placeholder="Email" disabled>
                        </div>
                        <div class="form-group  col-md-6">
                            <label>Subject</label>
                            <input class="form-control" type="link" id="Subject" placeholder="Phone" disabled>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group  col-md-12">
                            <label>Message</label>
                            <textarea class="form-control" name="heading" rows="2" id="message" disabled></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="updateModal-close" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
<!-- END EDIT MODEL -->


<div id="snackbar"></div>

<?php
require_once 'js_links.php';
require_once 'footer.php';

?>

<script>

   
        function setEditValue(name,email,phone,subject,message)
        {
            $("#Name").val(name);
            $("#Email").val(email);
            $("#Phone").val(phone);
            $("#Subject").val(subject);
            $("#message").html(message);
        }
</script>