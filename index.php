<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD App Using OOP MVC AJAX</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.11.3/datatables.min.css"/>
</head>
<body>

    <!-- Modal Insert User-->
    <div class="modal fade" id="insert-user-modal" role="dialog">
        <div class="modal-dialog">
        
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Add New User</h4>
            </div>
            <div class="modal-body">
            <form action="" method="post" id="user_form">
            <div class="form-group">
                <label for="fname">First Name</label>
                <input type="text" name="fname" class="form-control"  required>
            </div>
            <div class="form-group">
                <label for="lname">Last Name</label>
                <input type="text" name="lname" class="form-control"  required>
            </div>
            <div class="form-group">
                <label for="email">Email address:</label>
                <input type="email" name="email" class="form-control"  required>
            </div>
            <button type="submit" class="btn btn-default" id="insert">Submit</button>
            </form>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
        
        </div>
    </div>

    <!-- Modal  Edit User Details-->
    <div class="modal fade" id="edit-user-modal" role="dialog">
        <div class="modal-dialog">
        
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Update User Deails</h4>
            </div>
            <div class="modal-body">
            <form action="" method="post" id="edit_form">
            <input type="hidden" class="form-control" id="user_id" name="user_id" required>    
            <div class="form-group">
                <label for="fname">First Name</label>
                <input type="text" name="fname" class="form-control" id="fname" required>
            </div>
            <div class="form-group">
                <label for="lname">Last Name</label>
                <input type="text" name="lname" class="form-control" id="lname" required>
            </div>
            <div class="form-group">
                <label for="email">Email address:</label>
                <input type="email" name="email" class="form-control" id="email" required>
            </div>
            <button type="submit" class="btn btn-default" id="update">Update</button>
            </form>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
        
        </div>
    </div>


    <nav class=" navbar-inverse">
        <div class="container-fluid">
            <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#"><i class="fab fa-users"></i>MY SELF</a>
            </div>
            <div class="collapse navbar-collapse" id="myNavbar">
            <ul class="nav navbar-nav">
                <li class="active"><a href="#">Home</a></li>
                <li><a href="#">About Us</a></li>
                <li><a href="#">Services</a></li>
                <li><a href="#">Contact</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li><a href="#"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
                <li><a href="#"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
            </ul>
            </div>
        </div>
    </nav>
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="text-center">CRUD USING PHP OOP AJAX</h1>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-lg-6">
                <h4 class="mt-2 text-primary">All Users</h4>
            </div>
            <div class="col-lg-6">
                <button style="float:right;" type="button" class="btn btn-primary" data-toggle="modal" data-target="#insert-user-modal">Add User</button>
                <a href="action.php?export=excel" style="float:right; margin-right:5px;" type="button" class="btn btn-success">Export to Excel</a>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-lg-12" id="user_data">

            <h4>Loading...</h4>
                
            </div>
        </div>
    </div>
    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

    <!--Fontawsome 5-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous">

    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.11.3/datatables.min.js"></script>

    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <script>
        $(document).ready(function(){
            $('table').DataTable();

            showAllUsers();
            //SHOW USERS
            function showAllUsers(){
                $.ajax({
                    url:"action.php",
                    method:"POST",
                    data:{action:"view"},
                    success:function(phpresponse){
                        $("#user_data").html(phpresponse);
                        $('table').DataTable({
                            order:[0,'desc']
                        });
                        //console.log(phpresponse);
                    }
                });
            }
            //InSERT USER DATA
            $('#insert').click(function(e){
                if($('#user_form')[0].checkValidity()){
                    e.preventDefault();
                    $.ajax({
                        url:"action.php",
                        method:"POST",
                        data:$('#user_form').serialize()+"&action=insert",
                        success:function(phpresponse){
                            //console.log(phpresponse);
                            swal({
                                title:'User Added Successfully!',
                                type:'success',

                            });
                            $('#insert-user-modal').modal('hide');
                            $('#user_form')[0].reset();
                            showAllUsers();
                        }
                    });
                }
            });

            //EDIT USER DETAILS
            $("body").on("click", ".editbtn", function(e){
                e.preventDefault();
                edit_id = $(this).attr('id');
                $.ajax({
                    url:"action.php",
                    method:"POST",
                    data:{edit_id:edit_id},
                    success:function(phpresponse){
                        data = JSON.parse(phpresponse);
                        $('#user_id').val(data.id);
                        $('#fname').val(data.firstname);
                        $('#lname').val(data.lastname);
                        $('#email').val(data.email);

                        //console.log($data);
                    }
                })
            });

            //Update User Details
            $('#update').click(function(e){
                if($('#edit_form')[0].checkValidity()){
                    e.preventDefault();
                    $.ajax({
                        url:"action.php",
                        method:"POST",
                        data:$('#edit_form').serialize()+"&action=update",
                        success:function(phpresponse){
                            //console.log(phpresponse);
                            swal({
                                title:'User Update Successfully!',
                                type:'success',
                            });
                            $('#edit-user-modal').modal('hide');
                            $('#edit_form')[0].reset();
                            showAllUsers();
                        }
                    });
                }
            });

            //DELETE USER
            $("body").on("click", ".delbtn", function(e){
                e.preventDefault();
                del_id = $(this).attr('id');

                swal({
                    title: "Are you sure?",
                    text: "Once deleted, you will not be able to recover this imaginary file!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                    })
                    .then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            url:"action.php",
                            method:"POST",
                            data:{del_id:del_id},
                            success:function(phpresponse){
                                swal("Poof! Your imaginary file has been deleted!", {
                                    icon: "success",
                                });
                                showAllUsers();
                            }
                        });
                    }
                });
            });

            //EDIT USER DETAILS
            $("body").on("click", ".infobtn", function(e){
                e.preventDefault();
                info_id = $(this).attr('id');
                $.ajax({
                    url:"action.php",
                    method:"POST",
                    data:{info_id:info_id},
                    success:function(phpresponse){
                        data = JSON.parse(phpresponse);
                        swal(data.firstname+' '+data.lastname, data.email, "info");
                        //console.log(data);
                    }
                })
            });

        });
    </script>
</body>
</html>