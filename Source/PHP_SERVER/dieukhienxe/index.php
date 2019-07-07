<?php
        include('lib/session.php');

        require "lib/header.php";
        
        include_once 'lib/db_connect.php';

        require "lib/user.php";

        require "lib/car.php";

        $error = "";

        //User table 
        if (isset($_POST['insert1'])) {

                if(isset($_POST['username1'])){
        
                        $username = $_POST['username1'];
                }
                if(isset($_POST['password1'])){
        
                        $password = $_POST['password1'];
                }
        
                $userObject = new User();
        
                // Registration
        
                if(!empty($username) && !empty($password)){
        
                        $hashed_password = $password;
                
                        $json_registration = $userObject->createNewRegisterUser($username, $hashed_password);
        
                        $error = json_encode($json_registration);
                }
        
        }
        else if (isset($_POST['delete1'])) {
            
                $userObject = new User();
            
                if(isset($_POST['username1'])){
            
                    $username = $_POST['username1'];
            
                    $json = $userObject->deleteUser($username);

                    $error = json_encode($json);
                }
        
        }
        else if (isset($_POST['edit1'])) {
        
                if(isset($_POST['id1']) && isset($_POST['password1'])) {
        
                    $id = $_POST['id1'];
        
                    $password = $_POST['password1'];
        
                    $userObject = new User();
        
                    $json = $userObject->updateUser($id, $password);

                    $error = json_encode($json);
        
                } 
                else {
        
                    $error = "Error. Please enter username and password";
                }
        
        }

        //Cars table
        $car_message = "";

        if (isset($_POST['carinsert'])) {

                if (isset($_POST['carname']) && isset($_POST['carstate'])) {

                        $carname = $_POST['carname'];

                        $carstate = $_POST['carstate'];

                        $carObject = new Car();

                        if (!empty($carname) && is_numeric($carstate))
                        {

                                $json = $carObject->createNewRegisterCar($carname, $carstate);

                                $car_message = json_encode($json);

                        }
                        else {

                                $car_message = "Error. Please enter carname and car status";

                        }
                }
                else 
                {
                        $car_message = "Error. Please enter carname and car status";
                }

        }
        else if (isset($_POST['cardelete'])) {

                if (isset($_POST['carid'])) {

                        $carid = $_POST['carid'];

                        $carObject = new Car();

                        $json = $carObject->deleteCar($carid);

                        $car_message = json_encode($json);

                }
                else {

                        $car_message = "Error delete car";

                }

        }
        else if (isset($_POST['caredit'])) {

                if (isset($_POST['carid']) && isset($_POST['carstate'])) {

                        $carid = $_POST['carid'];

                        $carstate = $_POST['carstate'];

                        if (is_numeric($carstate)) {

                                $carObject = new Car();

                                $json = $carObject->updateCar($carid, $carstate);

                                $car_message = json_encode($json);

                        }
                        else {
                                $car_message = "Error. State must be between 0 and 4";
                        }
                }
                else {

                        $car_message = "Error edit car";

                }

        }


        //Get table
        function get_Dbtable($table_name)
        {
                $db = new DbConnect();

                $db_table1 = "users";
                $db_table2 = "admin_user";

                if ($table_name == "admin")
                {
                        $query = "SELECT * FROM ".$db_table2;
                        $table_id = "admin";
                }
                else{
                        $query = "SELECT * FROM ".$db_table1;
                        $table_id = "user";
                }

                echo '
                <div class="table100 ver3 m-b-110" id="'.$table_id.'">
                <table data-vertable="ver3">
                        <thead>
                        <tr class="row100 head">
                                <th class="column100 column1">ID</th>
                                <th class="column100 column2">Username</th>
                                <th class="column100 column3">Password</th>
                        </tr>
                        </thead>
                        <tbody>';
                
                if ($result = mysqli_query($db->getDb(), $query))
                {
                        while ($row = $result->fetch_assoc())
                        {
                                $field1name = $row["id"];
                                $field2name = $row["user_name"];
                                $field3name = $row["user_password"];
                                echo '
                                <tr class="row100">
                                        <td class="column100" id="id1">'.$field1name.'</td>
                                        <td class="column100" id="username1">'.$field2name.'</td>
                                        <td class="column100" id="password1">'.$field3name.'</td>
                                </tr>';
                        }
                }
                echo '
                        </tbody>
                </table>
                </div>';
        }

        function get_Cars() {

                $db = new DbConnect();

                $query = "SELECT * FROM cars";

                echo '
                <div class="table100 ver3 m-b-110" id="car">
                <table data-vertable="ver3">
                        <thead>
                        <tr class="row100 head">
                                <th class="column100 column1">ID</th>
                                <th class="column100 column2">Carname</th>
                                <th class="column100 column3">Status</th>
                        </tr>
                        </thead>
                        <tbody>';
                
                if ($result = mysqli_query($db->getDb(), $query))
                {
                        while ($row = $result->fetch_assoc())
                        {
                                $field1name = $row["id"];
                                $field2name = $row["name"];
                                $field3name = $row["state"];
                                echo '
                                <tr class="row100">
                                        <td class="column100" id="carid">'.$field1name.'</td>
                                        <td class="column100" id="carname">'.$field2name.'</td>
                                        <td class="column100" id="carstate">'.$field3name.'</td>
                                </tr>';
                        }
                }
                echo '
                        </tbody>
                </table>
                </div>';
                
        }

        if (isset($_SESSION['error'])) {
                $error =$_SESSION['error'];
        }

        //HTML
?>
            <!--// top-bar -->
            <div class="container-fluid">
                <!-- User Table -->
                <div class="outer-w3-agile col-xl mt-3">

                        <h4 class="tittle-w3-agileits mb-4">User List</h4>

                        <?php get_Dbtable("user"); ?>

                        <form action="index.php" method="POST">
                                <div class="container-edit">
                                        <!-- Edit Text -->
                                        <div class="container-edittext">
                                                <ul class="top-icons-agileits-w3layouts float-left container">   
                                                        <div class="row">
                                                                <input  id="inputId1" name="id1" type="hidden">
                                                                <li class="nav-item col-xs-6">
                                                                        <input class="form-control" id="inputUsername1" style="width:auto" name="username1" placeholder="Username" type="text">  
                                                                </li>
                                                                <li class="nav-item col-xs-6">
                                                                        <input class="form-control" id="inputPassword1" style="width:auto" name="password1" placeholder="Password" type="text">  
                                                                </li>
                                                        </div>
                                                </ul> 
                                        
                                        </div>
                                        <!-- //Edit Text -->

                                        <!-- Button -->
                                        <div class="container-button">
                                                        <ul class="top-icons-agileits-w3layouts float-right">   
                                                        <li class="nav-item">
                                                                <input type="submit" class="btn btn-info" name="insert1" value="Insert">
                                                        </li>
                                                        <li class="nav-item">
                                                                <input type="submit" class="btn btn-info" name="delete1" value="Delete">
                                                        </li>
                                                        <li class="nav-item">
                                                                <input type="submit" class="btn btn-info" name="edit1" value="Edit">
                                                        </li>
                                                </ul> 
                                        </div>
                                        <!-- //Button -->
                                </div>
                        </form>
                        <div class="error-rev"><?php echo $error; ?></div>
                </div>
                <!--// User Table -->

                <!-- Cars Table -->
                <div class="outer-w3-agile col-xl mt-3">

                        <h4 class="tittle-w3-agileits mb-4">Cars List</h4>

                        <?php get_Cars(); ?>

                        <form action="index.php" method="POST">
                                <div class="container-edit">
                                        <!-- Edit Text -->
                                        <div class="container-edittext">
                                                <ul class="top-icons-agileits-w3layouts float-left container">   
                                                        <div class="row">
                                                                <li class="nav-item col-sm-2">
                                                                        <input class="form-control" id="inputcarid" style="background-color:white !important;" name="carid" placeholder="ID" type="text" readonly>  
                                                                </li>
                                                                <li class="nav-item col-sm-5">
                                                                        <input class="form-control" id="inputcarname" name="carname" placeholder="Car name" type="text">  
                                                                </li>
                                                                <li class="nav-item col-sm-5">
                                                                        <input class="form-control" id="inputcarstate" name="carstate" placeholder="Car status" type="text">  
                                                                </li>
                                                        </div>
                                                </ul> 
                                        
                                        </div>
                                        <!-- //Edit Text -->

                                        <!-- Button -->
                                        <div class="container-button">
                                                        <ul class="top-icons-agileits-w3layouts float-right">   
                                                        <li class="nav-item">
                                                                <input type="submit" class="btn btn-info" name="carinsert" value="Insert">
                                                        </li>
                                                        <li class="nav-item">
                                                                <input type="submit" class="btn btn-info" name="cardelete" value="Delete">
                                                        </li>
                                                        <li class="nav-item">
                                                                <input type="submit" class="btn btn-info" name="caredit" value="Edit">
                                                        </li>
                                                </ul> 
                                        </div>
                                        <!-- //Button -->
                                </div>
                        </form>
                        <div class="error-rev"><?php echo $car_message; ?></div>
                </div>
                <!--// Cars Table -->                

                <!-- AdminUser Table -->
                <div class="outer-w3-agile col-xl mt-3">

                        <h4 class="tittle-w3-agileits mb-4">Admin List</h4>

                        <?php get_Dbtable("admin"); ?>

                </div>
                <!--// AdminUser Table -->

                <!-- Calender --
                <div class="outer-w3-agile col-xl mt-3">
                        <h4 class="tittle-w3-agileits mb-4">Multi range Calender</h4>
                        <div class="multi-select-calender"></div>
                        <div class="box"></div>
                </div>
                --// Calender -->
            </div>
        
<?php require "lib/footer.php"; ?>