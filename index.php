<?php
// Include config file

require_once "db.php";
 
// Define variables and initialize with empty values
$name = $address = $mobno = $email = $qualification = $dept = $subdept = $jobloc = $salary = $date_of_joining = "";
$name_err = $address_err = $mobno_err = $email_err = $qualification_err = $dept_err = $subdept_err = $jobloc_err = $salary_err = $doj_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate name
    $input_name = trim($_POST["name"]);
    if(empty($input_name)){
        $name_err = "Please enter a name.";
    } elseif(!filter_var($input_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $name_err = "Please enter a valid name.";
    } else{
        $name = $input_name;
    }
    
    // Validate address
    $input_address = trim($_POST["address"]);
    if(empty($input_address)){
        $address_err = "Please enter an address.";     
    } else{
        $address = $input_address;
    }

    // Validate Mobile
   $input_mobno = trim($_POST["mobno"]);
    if(empty($input_mobno)){
        $mobno_err = "Please enter an mobile no..";     
    } else{
        $input_mobno = $input_mobno;
    }

   $input_email = trim($_POST["email"]);
    if(empty($input_email)){
        $email_err = "Please enter an email..";     
    } else{
        $input_email = $input_email;
    }
	
   $input_qualification = trim($_POST["qualification"]);
    if(empty($input_qualification)){
        $qualification_err = "Please enter an qualification..";     
    } else{
        $input_qualification = $input_qualification;
    }
    
    // Validate Department
   $input_dept = trim($_POST["dept"]);
    if(empty($input_dept)){
        $dept_err = "Please enter an department..";     
    } else{
        $input_dept = $input_dept;
    }
	
    // Validate Sub Department
    $input_subdept = trim($_POST["subdept"]);
    /*if(empty($input_subdept){
        $subdept_err = "Please enter an sub department.";     
    } else{
        $input_subdept = $input_subdept;
    }  *  

    // Validate Job Locatin
    $input_jobloc = trim($_POST["jobloc"]);
    if(empty($input_jobloc){
        $joboc_err = "Please enter an job location.";     
    } else{
        $input_jobloc = $input_jobloc;
    }*/
    
    // Validate salary
    $input_salary = trim($_POST["salary"]);
    if(empty($input_salary)){
        $salary_err = "Please enter the salary amount.";     
    } elseif(!ctype_digit($input_salary)){
        $salary_err = "Please enter a positive integer value.";
    } else{
        $salary = $input_salary;
    }
    
    // Check input errors before inserting in database
    if(empty($name_err) && empty($address_err) && empty($mobno_err) && empty($email_err) && empty($qualification_err) && empty($dept_err) && empty($subdet_err) && empty($jobloc_err) && empty($salary_err) && empty($doj_err)){
        // Prepare an insert statement
        $sql = "INSERT INTO employees (name, address, mobno, email, qualification, dept, subdept, jobloc, salary, date_of_joining) 
		VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
 
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssisssssis", $param_name, $param_address, $param_mobno, $param_email, $param_qualification, $param_dept, $param_subdept, $param_jobloc, $param_salary, $param_date_of_joining);
	   // Set parameters
            $param_name = $name;
            $param_address = $address;
            $param_mobno = $_REQUEST["mobno"];
            $param_email = $_REQUEST["email"];
            $param_qualification = $_REQUEST["qualification"];
            $param_dept = $_REQUEST["dept"];
            $param_subdept = $_REQUEST["subdept"];
            $param_jobloc = $_REQUEST["jobloc"];
            $param_salary = $_REQUEST["salary"];
            $param_date_of_joining = $_REQUEST["date_of_joining"];


			
			
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records created successfully. Redirect to landing page
				$lastid = mysqli_insert_id($link);
                header("location: admindisplay.php?eid=".$lastid);
                exit();
            } else{
                echo "Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($link);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Employee Registration</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        .wrapper{
            width: 500px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h2>Fill Employee Information</h2>
                    </div>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group <?php echo (!empty($name_err)) ? 'has-error' : ''; ?>">
                            <label>Employee Name</label>
                            <input type="text" name="name" class="form-control" value="<?php echo $name; ?>">
                            <span class="help-block"><?php echo $name_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($address_err)) ? 'has-error' : ''; ?>">
                            <label>Address</label>
                            <textarea name="address" class="form-control"><?php echo $address; ?></textarea>
                            <span class="help-block"><?php echo $address_err;?></span>
                        </div>
						
                        <div class="form-group <?php echo (!empty($mobno_err)) ? 'has-error' : ''; ?>">
                            <label>Mobile No.</label>
                            <input type="text" name="mobno" class="form-control" value="<?php echo $mobno; ?>">
                            <span class="help-block"><?php echo $mobno_err;?></span>
                        </div>

                        <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                            <label>Email Id</label>
                            <input type="text" name="email" class="form-control" value="<?php echo $email; ?>">
                            <span class="help-block"><?php echo $email_err;?></span>
                        </div>

                        <div class="form-group <?php echo (!empty($qualification_err)) ? 'has-error' : ''; ?>">
                            <label>Qualification</label>
                            <input type="text" name="qualification" class="form-control" value="<?php echo $qualification; ?>">
                            <span class="help-block"><?php echo $qualification_err;?></span>
                        </div>

                        <div class="form-group <?php echo (!empty($dept_err)) ? 'has-error' : ''; ?>">
                            <label>Department</label>
                            <input type="text" name="dept" class="form-control" value="<?php echo $dept; ?>">
                            <span class="help-block"><?php echo $dept_err;?></span>
                        </div>

                        <div class="form-group <?php echo (!empty($subdept_err)) ? 'has-error' : ''; ?>">
                            <label>Sub Department</label>
                            <input type="text" name="subdept" class="form-control" value="<?php echo $subdept; ?>">
                            <span class="help-block"><?php echo $subdept_err;?></span>
                        </div>
						
                        <div class="form-group <?php echo (!empty($jobloc_err)) ? 'has-error' : ''; ?>">
                            <label>Job Location</label>
                            <input type="text" name="jobloc" class="form-control" value="<?php echo $jobloc; ?>">
                            <span class="help-block"><?php echo $jobloc_err;?></span>
                        </div>

                        <div class="form-group <?php echo (!empty($salary_err)) ? 'has-error' : ''; ?>">
                            <label>Salary</label>
                            <input type="text" name="salary" class="form-control" value="<?php echo $salary; ?>">
                            <span class="help-block"><?php echo $salary_err;?></span>
                        </div>
						
                        <div class="form-group <?php echo (!empty($doj_err)) ? 'has-error' : ''; ?>">
                            <label>Date of Joining</label>
                            <input type="text" name="date_of_joining" class="form-control" value="<?php echo $date_of_joining; ?>">
                            <span class="help-block"><?php echo $doj_err;?></span>
                        </div>						
						
						
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-default">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>