<?php  

$insert = false;
$update = false;
$delete = false;

$servername = "localhost";
$username = "root";
$password = "";
$database = "notes";


$conn = mysqli_connect($servername, $username, $password, $database);

if (!$conn){
    die("Sorry we failed to connect: ". mysqli_connect_error());
}

if(isset($_GET['delete'])){
  $sno = $_GET['delete'];
  $delete = true;
  $sql = "DELETE FROM `notes` WHERE `sno` = $sno";
  $result = mysqli_query($conn, $sql);
}
if ($_SERVER['REQUEST_METHOD'] == "POST"){
if (isset( $_POST['snoEdit'])){
  
    $sno = $_POST["snoEdit"];
    $person_name = $_POST["person_name"];
    $person_contact = $_POST["person_contact"];
    $email = $_POST["email"]; 
    $person_company = $_POST["person_company"];
    $purpose = $_POST["purpose"];
   
    

  $sql = "UPDATE `notes` SET `person_name` = '$person_name' , `person_contact` = '$person_contact', `email` = '$email', `person_company` = '$person_company',  `purpose` = '$purpose' WHERE `notes`.`sno` = $sno";
  $result = mysqli_query($conn, $sql);
  if($result){
    $update = true;
}
else{
    echo "We could not update the record successfully";
}
}
else{
    $person_name = $_POST["person_name"];
    $person_contact = $_POST["person_contact"];
    $email = $_POST["email"];
    $person_company = $_POST["person_company"];
    $purpose = $_POST["purpose"];

  
  $sql = "INSERT INTO notes (  `person_name`, `person_contact`, `email`, `person_company`, `purpose`) VALUES (  '$person_name',' $person_contact',' $email',' $person_company', '$purpose')";
  
  $result = mysqli_query($conn, $sql);

   
  if($result){ 
      $insert = true;
  }
  else{
      echo "TestThe record was not inserted successfully because of this error ---> ". mysqli_error($conn);
    } 
  }
}
?>

<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">


    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">


    <title>iNotes - Notes taking made easy</title>

</head>

<body>



    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit this Note</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form action="/pkc/index.php" method="POST">
                    <div class="modal-body">
                        <input type="hidden" name="snoEdit" id="snoEdit">
                        <div class="form-group">
                            <label for="person_name">Note person_name</label>
                            <input type="text" class="form-control" id="person_nameEdit" name="person_nameEdit"
                                aria-describedby="emailHelp">
                        </div>

                        <div class="form-group">
                            <label for=" person_contact">Note person_contact</label>
                            <textarea class="form-control" id="person_contactEdit" name="person_contactEdit"
                                rows="3"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="email">Note email</label>
                            <textarea class="form-control" id="emailEdit" name="emailEdit" rows="3"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="person_company">Note person_company</label>
                            <textarea class="form-control" id="person_companyEdit" name="person_companyEdit"
                                rows="3"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="purpose">Note purpose</label>
                            <textarea class="form-control" id="purposeEdit" name="purposeEdit" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer d-block mr-auto">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#"><img src="/pkc/logo.svg.png" height="28px" alt=""></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Contact Us</a>
                </li>

            </ul>
            <form class="form-inline my-2 my-lg-0">
                <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
            </form>
        </div>
    </nav>

    <?php
  if($insert){
    echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
    <strong>Success!</strong> Your note has been inserted successfully
    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
      <span aria-hidden='true'>x</span>
    </button>
  </div>";
  }
  ?>
    <?php
  if($delete){
    echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
    <strong>Success!</strong> Your note has been deleted successfully
    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
      <span aria-hidden='true'>×</span>
    </button>
  </div>";
  }
  ?>
    <?php
  if($update){
    echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
    <strong>Success!</strong> Your note has been updated successfully
    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
      <span aria-hidden='true'>×</span>
    </button>
  </div>";
  }
  ?>
    <div class="container my-4">
        <h2>Add a Note to iNotes</h2>
        <form action="/pkc/index.php" method="POST">
            <div class="form-group">
                <label for="sno">sno</label>
                <input type="text" class="form-control" id="sno" name="sno" aria-describedby="emailHelp">
            </div>
            <div class="form-group">
                <label for="Person_name">Person_name</label>
                <input type="text" class="form-control" id="person_name" name="person_name"
                    aria-describedby="emailHelp">
            </div>

            <div class="form-group">
                <label for="Person_contact">Person_contact</label>
                <textarea class="form-control" id="person_contact" name="person_contact" rows="3"></textarea>
            </div>
            <div class="form-group">
                <label for="email">email</label>
                <textarea class="form-control" id="email" name="email" rows="3"></textarea>
            </div>
            <div class="form-group">
                <label for="Person_company">Person_company</label>
                <textarea class="form-control" id="person_company" name="person_company" rows="3"></textarea>
            </div>
            <div class="form-group">
                <label for="purpose">Purpose</label>
                <textarea class="form-control" id="purpose" name="purpose" rows="3"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Add Note</button>
        </form>
    </div>

    <div class="container my-4">


        <table class="table" id="myTable">
            <thead>
                <tr>
                    <th scope="col">S.No</th>
                    <th scope="col">Person_name</th>
                    <th scope="col">Person_contact</th>
                    <th scope="col">email</th>
                    <th scope="col">Person_company</th>
                    <th scope="col">Purpose</th>
                </tr>
            </thead>
            <tbody>
                <?php 
          $sql = "SELECT * FROM `notes`";
          $result = mysqli_query($conn, $sql);
          $sno = 0;
          while($row = mysqli_fetch_assoc($result)){
            $sno = $sno + 1;
            echo "<tr>
            <th scope='row'>". $sno . "</th>
            <td>". $row['person_name'] . "</td>
            <td>". $row['person_contact'] . "</td>
            <td>". $row['email'] . "</td>
            <td>". $row['person_company'] . "</td>
            <td>". $row['purpose'] . "</td>
            <td> <button class='edit btn btn-sm btn-primary' id=".$row['sno'].">Edit</button> <button class='delete btn btn-sm btn-primary' id=d".$row['sno'].">Delete</button>  </td>
          </tr>";
        } 
          ?>
            </tbody>
        </table>
    </div>
    <hr>

    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
        integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
        integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous">
    </script>
    <script src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    <script>
    $(document).ready(function() {
        $('#myTable').DataTable();

    });
    </script>
    <script>
    edits = document.getElementsByClassName('edit');
    Array.from(edits).forEach((element) => {
        element.addEventListener("click", (e) => {
            console.log("edit ");
            tr = e.target.parentNode.parentNode;
            person_name = tr.getElementsByTagName("td")[0].innerText;
            person_contact = tr.getElementsByTagName("td")[1].innerText;
            email = tr.getElementsByTagName("td")[1].innerText;
            person_company = tr.getElementsByTagName("td")[1].innerText;
            purpose = tr.getElementsByTagName("td")[1].innerText;
            console.log(person_name, person_contact, person_gmail, person_company, purpose);
            person_nameEdit.value = person_name;
            person_contactEdit.value = person_contact;
            emailEdit.value = email;
            person_companyEdit.value = person_company;
            purposeEdit.value = purpose;



            snoEdit.value = e.target.id;
            console.log(e.target.id)
            $('#editModal').modal('toggle');
        })
    })

    deletes = document.getElementsByClassName('delete');
    Array.from(deletes).forEach((element) => {
        element.addEventListener("click", (e) => {
            console.log("edit ");
            sno = e.target.id.substr(1);

            if (confirm("Are you sure you want to delete this note!")) {
                console.log("yes");
                window.location = `/pkc/index.php?delete=${sno}`;

            } else {
                console.log("no");
            }
        })
    })
    </script>
</body>

</html>