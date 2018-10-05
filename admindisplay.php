<?php 
// Include config file
require_once "db.php";
// Define variables and initialize with empty values
$monthname = $workingdays = $presentdays = $professional_tax = $incometax = $totalsalary = $totaldeduction = $netsalary = "";
$monthname_err = $workingdays_err = $presentdays_err = $professionaltax_err = $incometax_err = $totalsalary_err = $totaldeduction_err = $netsalary_err = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){
	$empid = $_REQUEST["empid"];
    if(empty($monthname_err) && empty($workingdays_err) && empty($presentdays_err) && empty($professionaltax_err) && empty($incometax_err) && empty($totalsalary_err) && empty($totaldeduction_err) && empty($netsalary_err)){
       $sql = "UPDATE employees SET monthname= '".$_REQUEST["monthname"]."', workingdays='".$_REQUEST["workingdays"]."', presentdays='".$_REQUEST["presentdays"]."', professional_tax='".$_REQUEST["professional_tax"]."', incometax='".$_REQUEST["incometax"]."', totalsalary='".$_REQUEST["totalsalary"]."', totaldeduction='".$_REQUEST["totaldeduction"]."', netsalary='".$_REQUEST["netsalary"]."' WHERE id= '".$empid."'";
	   if ($link->query($sql) === TRUE) {
                header("location: admindisplay.php?eid=".$empid."&view=update");
                exit();

	   } else {
		echo "Error updating record: " . $link->error;
		}

        }
         
        // Close statement
        mysqli_stmt_close($stmt);
 
}

?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.js"></script>
    <style type="text/css">
        .wrapper{
            width: 650px;
            margin: 0 auto;
        }
        .page-header h2{
            margin-top: 0;
        }
        table tr td:last-child a{
            margin-right: 15px;
        }
		.back{
			margin-left:15px;
		}
    </style>
    <script type="text/javascript">
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();
			$("#incometax").change(function() {
		//$totaldeduction = $professional_tax + $incometax;
        var professional_tax = $('input[name="professional_tax"]').val();
        var incometax = $('input[name="incometax"]').val();
        var totaldeduction = Number(professional_tax) + Number(incometax);
        $('#totaldeduction').val(totaldeduction);
		});

		$("#netsalary").click(function() { 
			var workingdays = $('input[name="workingdays"]').val();
			var presentdays = $('input[name="presentdays"]').val();
			var totalsalary = $('input[name="totalsalary"]').val();
			var totaldeduction = $('input[name="totaldeduction"]').val();
			
			
			if(workingdays == presentdays)
			{
				var netsalarypaid = Number(totalsalary) - Number(totaldeduction);
				$('#netsalary').val(netsalarypaid);
			}
			else {
				var perdaysalary =  Number(totalsalary) / Number(workingdays);
				perdaysalary = Math.round(perdaysalary);
				var totalsalformonth = Number(perdaysalary) * Number(presentdays);
				$('#netsalary').val(totalsalformonth);
			}
		});
		
		
        });
    </script>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header clearfix">
						<?php if(empty($_REQUEST["view"])) { ?>
                        <h2 class="pull-left">Employee Details</h2>
						<?php } else { ?>
                        <h2 class="pull-left">Salary Details</h2>
						<?php } $pid = $_REQUEST['eid']; ?>
						<!--<a href="index.php?pid="<?php //echo $pid; ?> class="back btn btn-success pull-right">Back</a>-->

                        <a href="index.php" class="btn btn-success pull-right">Add New Employee</a>&nbsp;

                    </div>
                    <?php
                    
                    // Attempt select query execution
                    $sql = "SELECT * FROM employees WHERE id = '".$_GET['eid']."'";
                    if($result = mysqli_query($link, $sql)){
                        if(mysqli_num_rows($result) > 0){
                            echo "<table class='table table-bordered table-striped'>";
							while($row = mysqli_fetch_array($result)){
									
                                        echo "<tr><td>Empoyee Id</td><td>" . $row['id'] . "</td></tr>";
                                        echo "<tr><td>Empoyee Name</td><td>" . $row['name'] . "</td></tr>";
                                        echo "<tr><td>Address</td><td>" . $row['address'] . "</td></tr>";
                                        echo "<tr><td>Mobile No.</td><td>" . $row['mobno'] . "</td></tr>";
                                        echo "<tr><td>Email Id</td><td>" . $row['email'] . "</td></tr>";
                                        echo "<tr><td>Qualification</td><td>" . $row['qualification'] . "</td></tr>";
                                        echo "<tr><td>Department</td><td>" . $row['dept'] . "</td></tr>";
                                        echo "<tr><td>Sub Deartment</td><td>" . $row['subdept'] . "</td></tr>";
                                        echo "<tr><td>Job Location</td><td>" . $row['jobloc'] . "</td></tr>";
                                        echo "<tr><td>Salary</td><td>" . $row['salary'] . "</td></tr>";
                                        echo "<tr><td>Date of Joining</td><td>" . $row['date_of_joining'] . "</td></tr>";
										if(!empty($_REQUEST["view"]))
										{
											echo "<tr><td>Month Name</td><td>" . $row['monthname'] . "</td></tr>";
											echo "<tr><td>Working days</td><td>" . $row['workingdays'] . "</td></tr>";
											echo "<tr><td>Present Days</td><td>" . $row['presentdays'] . "</td></tr>";
											echo "<tr><td>Professional Tax</td><td>" . $row['professional_tax'] . "</td></tr>";
											echo "<tr><td>Income Tax</td><td>" . $row['incometax'] . "</td></tr>";
											echo "<tr><td>Total Salary</td><td>" . $row['totalsalary'] . "</td></tr>";
											echo "<tr><td>Total Deduction</td><td>" . $row['totaldeduction'] . "</td></tr>";
											echo "<tr><td>Net Salary Paid</td><td>" . $row['netsalary'] . "</td></tr>";
										}
							   }
                                echo "</tbody>";                            
                            echo "</table>";
                            // Free result set
                            mysqli_free_result($result);
                        } else{
                            echo "<p class='lead'><em>No records were found.</em></p>";
                        }
                    } else{
                        echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
                    }
 
                    // Close connection
                    mysqli_close($link);
                    ?>
                </div>
            </div>        
        </div>
    </div>
	
	
	<!-- Admin Part Form-->
	<?php if(empty($_GET["view"])) { ?>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group <?php echo (!empty($monthname_err)) ? 'has-error' : ''; ?>">
                            <label>Month Name</label>
                            <input type="text" name="monthname" id="monthname" class="form-control" value="<?php echo $monthname; ?>">
                            <span class="help-block"><?php echo $monthname_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($workingdays_err)) ? 'has-error' : ''; ?>">
                            <label>Total Working days</label>
                            <input type="text" name="workingdays" id="workingdays" class="form-control" value="<?php echo $workingdays; ?>">
							<span class="help-block"><?php echo $workingdays_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($presentdays_err)) ? 'has-error' : ''; ?>">
                            <label>Total Present Days</label>
                            <input type="text" name="presentdays" id="presentdays" class="form-control" value="<?php echo $presentdays; ?>">
                            <span class="help-block"><?php echo $presentdays_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($professionaltax_err)) ? 'has-error' : ''; ?>">
                            <label>Professional Tax</label>
                            <input type="text" name="professional_tax" id="professional_tax" class="form-control" value="<?php echo $professional_tax; ?>">
                            <span class="help-block"><?php echo $professionaltax_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($incometax_err)) ? 'has-error' : ''; ?>">
                            <label>Income Tax</label>
                            <input type="text" name="incometax" id="incometax" class="form-control" value="<?php echo $incometax; ?>">
                            <span class="help-block"><?php echo $incometax_err;?></span>
                        </div>
						
                       <div class="form-group <?php echo (!empty($totalsalary_err)) ? 'has-error' : ''; ?>">
                            <label>Total Salary</label>
                            <input type="text" name="totalsalary" id="totalsalary" class="form-control" value="<?php echo $totalsalary; ?>">
                            <span class="help-block"><?php echo $totalsalary_err;?></span>
                        </div>
						<?php 
						//$totaldeduction = $professional_tax + $incometax;
						?>
                        <div class="form-group <?php echo (!empty($totaldeduction_err)) ? 'has-error' : ''; ?>">
                            <label>Total Deduction</label>
                            <input type="text" name="totaldeduction" id="totaldeduction" class="form-control" value="0">
                            <span class="help-block"><?php echo $totaldeduction_err;?></span>
                        </div>
						
                        <div class="form-group <?php echo (!empty($netsalary_err)) ? 'has-error' : ''; ?>">
                            <label>Net Salary Paid</label>
                            <input type="text" name="netsalary" id="netsalary" class="form-control" value="<?php echo $netsalary; ?>">
                            <span class="help-block"><?php echo $netsalary_err;?></span>
                        </div>
						
                        <input type="hidden" name="empid" value="<?php echo $_GET["eid"];?>">
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-default">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
	<?php } ?>	
</body>
</html>