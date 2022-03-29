<?php
require_once 'header.php';
require_once 'navbar.php';
require_once 'left_navbar.php';

if(isset($_POST['editPlan'])){
    $id = $_POST['editPlan'];
    $name = $conn->real_escape_string($_POST['nameEdit']);
    $price = $conn->real_escape_string($_POST['priceEdit']);
    $benefits = $conn->real_escape_string($_POST['benefitsEdit']);
    $sql = "UPDATE priceplan SET name = '$name' , price = '$price',benefits='$benefits' WHERE id = '$id'";
    if($conn->query($sql)){
        $updated='true';
    }
    else{
        $updated='false';
    }
}
if(isset($_POST['addPlan'])){
    $name = $conn->real_escape_string($_POST['name']);
    $price = $conn->real_escape_string($_POST['price']);
    $benefits = $conn->real_escape_string($_POST['benefits']);
    $sql = "INSERT INTO priceplan( name, price, benefits) VALUES ('$name','$price','$benefits')";
    if($conn->query($sql)){
        $added='true';
    }
    else{
        $added='false';
    }
}

if(isset($_POST['deletePlan'])){
    $id = $_POST['deletePlan'];
    $sql = "DELETE FROM priceplan WHERE id = '$id'";
    if($conn->query($sql)){
        $updated = 'true';
    }
    else{
        $updated = 'false';
    }
}


$sql = "SELECT * FROM priceplan";
    if($result = $conn->query($sql)){
        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                $plans[] = $row;
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
                <div class="breadcrumb-title pr-3">Business Plans</div>
                <div class="pl-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="javascript:;"><i class='bx bx-home-alt'></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                
                               Business Plan 

                            </li>
                        </ol>
                    </nav>
                    
                </div>
                <div class="ml-auto">
                    <div class="btn-group">
                        <button title="" class="btn btn-primary" data-toggle="modal" data-target="#modal-default"><i class="fadeIn animated bx bx-list-plus"></i></button>
                    </div>
                </div>
                
            </div>
            <div class="card">

            <div class="card-body">
                    <?php
                        if($updated == 'true'){
                            ?>
                                <div class="alert alert-primary">Plan updated Successfully !</div>
                            <?php
                        }
                        else if($updated == 'false'){
                            ?>
                                <div class="alert alert-danger">Error Occured!</div> 
                            <?php
                        } 
                        if($added == 'true'){
                            ?>
                                <div class="alert alert-primary">Plan added Successfully !</div>
                            <?php
                        }
                        else if($added == 'false'){
                            ?>
                                <div class="alert alert-danger">Error Occured!</div> 
                            <?php
                        }

                    ?>
                <?php
                    if(isset($plans)){
                    $i=1;
                ?>
                <div class='table-responsive' style='margin-top:20px;margin-bottom:20px'>
                    <table class='table table-striped table-bordered text-center mb-0' id='table1'>
                        <thead class='thead-dark'>
                            <tr>
                                <th scope='col'>#</th>
                                <th scope='col'>Name</th>
                                <th scope='col'>Price</th>
                                <th scope='col'>Benefits</th>
                                <th scope='col'>Actions</th>
                            </tr>
                        </thead>
                        <tbody id='showallusers'>
                            <form method='post'>
                            <?php
                                foreach($plans as $plan){
                                    $id = $plan['id'];
                                    $name = $plan['name'];
                                    $price = $plan['price'];
                                    $benefits = $plan['benefits'];
                                    ?>
                                    <tr>
                                        <td><?=$i?></td>
                                        <td><?=$plan['name']?></td>
                                        <td>
                                            <?=$plan['price']?>
                                        </td>
                                        <td>
                                            <?=$plan['benefits']?>
                                        </td>
                                        <td>
                                            <button type='button' class='btn btn-primary' onclick='setEditValue(`<?=$id?>`,`<?=$name?>`,`<?=$price?>`,`<?=$benefits?>`)' data-toggle='modal' data-target='#edit-modal'>
                                                <i class='bi bi-pencil'></i>
                                            </button>&nbsp;
                                            <button type='submit' name="deletePlan" class='btn btn-danger' value="<?=$id?>">
                                                <i class='bi bi-trash'></i>
                                            </button></td>
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
                            <div class="alert alert-primary">No Plans Found!</div>
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
                    <h5 class="modal-title">Add Business Plan </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="post" >
                <div id="modal-body" style="padding: 20px">
                        <div class="form-row">
                            <div class="form-group  col-md-12">
                                <label>Name</label>
                                <input class="form-control" type="text" id="name" name="name" placeholder="Name" >
                            </div>
                            <div class="form-group  col-md-12">
                                <label>Price</label>
                                <input class="form-control" type="text" id="price" name="price" placeholder="Price" >
                            </div>
                            <div class="form-group  col-md-12">
                                <label>Benefits</label>
                                <input class="form-control" type="text" id="benefits" name="benefits" placeholder="Price" >
                            </div>
                        </div>
                    <!-- </div> -->
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" name="addPlan" >Add</button>
                    <button type="button" id="Addmodal-close" class="btn btn-secondary" data-dismiss="modal">Close</button>
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
                    <h5 class="modal-title">Update Business Plan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="post" >
                    <div id="modal-body" style="padding: 20px">
                            <div class="form-row">
                                <div class="form-group  col-md-12">
                                    <label>Name</label>
                                    <input class="form-control" type="text" id="nameEdit" name="nameEdit" placeholder="Name" >
                                    <input type="hidden" id="editId" />
                                </div>
                                <div class="form-group  col-md-12">
                                    <label>Price</label>
                                    <input class="form-control" type="text" id="priceEdit" name="priceEdit" placeholder="Price" >
                                </div>
                                <div class="form-group  col-md-12">
                                    <label>Benefits</label>
                                    <input class="form-control" type="text" id="benefitsEdit" name="benefitsEdit"  placeholder="Benefits" >
                                </div>
                            </div>
                        <!-- </div> -->
                    </div>
                    <div class="modal-footer">
                        <button type="submit" name="editPlan" class="btn btn-primary" id="editPlan">Update</button>
                        <button type="button" id="updateModal-close" class="btn btn-secondary" data-dismiss="modal">Close</button>
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
    
    
        function setEditValue(id,name,price,benefits)
        {
            $("#editPlan").val(id)
            $("#nameEdit").val(name);
            $("#priceEdit").val(price);
            $("#benefitsEdit").val(benefits);
        }
        

</script>
</style>
