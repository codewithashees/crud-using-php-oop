<?php
require_once "db.php";
$db = new Database();

function test_input($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if(isset($_POST['action']) AND $_POST['action']=='view'){
    $output = "";
    $data = $db->read();
    if($db->totalRowCount()>0){
        $output .= '
            <table class="table table-sm table-striped table-bordered">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Firstname</th>
                    <th>Lastname</th>
                    <th>Email</th>
                    <th style="width:150px">Action</th>
                </tr>
                </thead>
                <tbody>
        ';
        foreach($data as $row){
            $output .= '
            <tr>
                <td>'.$row['id'].'</td>
                <td>'.$row['firstname'].'</td>
                <td>'.$row['lastname'].'</td>
                <td>'.$row['email'].'</td>
                <td>
                    <a href="#" class="btn btn-info infobtn" id="'.$row['id'].'" role="button"><i class="fas fa-info"></i></a>
                    <a href="#" class="btn btn-warning editbtn" id="'.$row['id'].'" role="button" data-toggle="modal" data-target="#edit-user-modal"><i class="fas fa-edit"></i></a>
                    <a href="#" class="btn btn-danger delbtn" id="'.$row['id'].'" role="button"><i class="fas fa-trash-alt"></i></a>
                </td>
            </tr>
            ';
        }
        $output .= '</tbody></table>';
        echo $output;
    }else{
        echo "No data found...";
    }
}

//INSERT USER ACTION
if(isset($_POST['action']) && $_POST['action'] == "insert"){
    $fname = test_input($_POST['fname']);
    $lname = test_input($_POST['lname']);
    $email = test_input($_POST['email']);
    $db->insert($fname,$lname,$email);
}

//EDIT ACTION
if(isset($_POST['edit_id'])){
    $edit_id = $_POST['edit_id'];
    $data = $db->getUserById($edit_id);
    echo json_encode($data);

}

//UPDATE USER DETAILS
if(isset($_POST['action']) && $_POST['action'] == 'update'){
    $fname = test_input($_POST['fname']);
    $lname = test_input($_POST['lname']);
    $email = test_input($_POST['email']);
    $id = test_input($_POST['user_id']);
    $db->update($fname,$lname,$email,$id);
}

//DELETE USER
if(isset($_POST['del_id'])){
    $del_id = $_POST['del_id'];
    echo $del_id;
    $db->delete($del_id);

}

//SHOW USER INFO
if(isset($_POST['info_id'])){
    $info_id = $_POST['info_id'];
    $data = $db->getUserById($info_id);
    echo json_encode($data);

}

//Export User data in Excel
if(isset($_GET['export']) && $_GET['export'] == 'excel'){
    header("Content-Type: application/xls");
    header("Content-Disposition: attachment; filename=users.xls");
    header("Pragma: no-cache");
    header("Expires: 0");

    $data = $db->read();

    echo '<table border="1">';
    echo '<tr><th>ID</th><th>First Name</th><th>Last Name</th><th>Email</th></tr>';
    foreach($data as $row){
        echo '<tr>
                <td>'.$row['id'].'</td>
                <td>'.$row['firstname'].'</td>
                <td>'.$row['lastname'].'</td>
                <td>'.$row['email'].'</td>
              </tr>';
    }
    echo '</table>';
}

?>
