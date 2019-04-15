﻿<?php if(!isset($_SESSION)) 
    { 
        session_start(); 
    }  
require('conn.php'); 

?>
<html>
<head>
<title>roleManangement</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
* {
    box-sizing: border-box;
    font-family: Arial, Helvetica, sans-serif;
}

body {
  margin: 0;
  font-family: Arial, Helvetica, sans-serif;
}


.topnav {
    overflow: hidden;
    background-color: #333;
}

/* Style the topnav links */
.topnav a {
    float: left;
    display: block;
    color: #f2f2f2;
    text-align: center;
    padding: 14px 16px;
    text-decoration: none;
}

/* Change color on hover */
.topnav a:hover {
    background-color: #ddd;
    color: black;
}

/* Style the content */
.content {
    background-color: #ddd;
    padding: 10px;
    height: 200px; 
}
* {
    box-sizing: border-box;
}

body {
    margin: 0;
    
}

.grid-container {
  display: grid;
  grid-template-columns: auto auto auto auto auto auto auto auto;
  grid-gap: 10px;
  background-color: white;
  padding: 1px;
}
.grid-container > div {
  background-color: gainsboro;
  
  padding: 0px 0;
  
}
.item1 {
  grid-row: 1/4;
  
}
.item2 {
  grid-row: 1/4;
  
}
h1 {
    color: white;
     background-color:rgb(60, 60, 60)
}
table, th, td {
    border: 1px solid black;
</style>

</head>

<body>
<form>
<?php
if(isset($_SESSION["user"]) == true){
	$login="";
	if($_SESSION["isadmin"]==1){
		$login=$_SESSION["user"];
		
echo'<div class="topnav">';
  echo'<a href="home.php">Home</a>';
	  echo'<a href="User_List.php" >User Management</a>';
	     echo'<a href="Role_List.php" >Role Management</a>';
	    echo'<a href="Permission_List.php" >Permissions Management</a>';
	   echo'<a href="Role_Perm_List.php">Role-Permissions Assignment</a>';
	echo'<a href="User_Role_List.php">User-Role Assignment</a>';
	echo'<a href="Login_History.php">Login History</a>';
	  echo' <a href="login.php" >Logout</a>';
echo'</div>';

}
else
	Header('Location:login.php');
	}
else
	Header('Location:login.php');
?>

<div class="grid-container">
  <div class="item1" id="div1">
<div class="sidenav">
<h1> Role Management</h1>
<form>
<?php

$role="";
$desc="";
$rid=0;
if(isset($_SESSION["editRole"])==true ){
			$rid=$_SESSION["editRole"];
			$role=$_SESSION["role"];		
		    $desc=$_SESSION["description"];
}
if(isset($_SESSION["clear"])==true ){
			$role="";
			$desc="";
}
		?>
Role Name:<br>
  <input type=text  name="role" value="<?php echo $role; ?>" required><br>
 Description:<br>
<input type=text  name="desc" value="<?php echo $desc; ?>" required><br>
   <input type=submit id="save" value="save" name="save">
    <input type=submit id="clear" value="clear" name="clear">
	
	<?php
	$flagS=false;
	if($rid>0 && isset($_REQUEST["save"])==true ){
			$flag1=true;
		$flag2=true;
		$flagS=true;
		$u=0;
		$c=0;
		$r=$_REQUEST["role"];
		$des=$_REQUEST["desc"];
		$d=date("Y-m-d h:i:s");
		$sql = "SELECT * FROM users";
			$result = mysqli_query($conn, $sql);
			$recordsFound = mysqli_num_rows($result);					
			if ($recordsFound > 0){			
				while($row = mysqli_fetch_assoc($result)) {	
					 if($row["login"]==$login)
					 {
						 $u=$row["userid"];						 
					 }
				}	
			}	
		$sql="UPDATE roles SET name='$r', description='$des' WHERE roleid=$rid";
if ($conn->query($sql) === TRUE) {
    echo "<script>alert('role has been edited');</script>";
	Header('Location:Role_List.php');
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}			
		$usid=0;
		$_SESSION["editRole"]=null;	
	}
	if(!$flagS){
	if(isset($_REQUEST["save"])==true )
	{
		$flag1=true;
		$u=0;
		$r=$_REQUEST["role"];
		$des=$_REQUEST["desc"];
		$d=date("Y-m-d h:i:s");
		$sql = "SELECT * FROM users";
			$result = mysqli_query($conn, $sql);
			$recordsFound = mysqli_num_rows($result);					
			if ($recordsFound > 0){			
				while($row = mysqli_fetch_assoc($result)) {	
					 if($row["login"]==$login)
					 {
						 $u=$row["userid"];						
					 }
				}	
			}
				$s = "SELECT * FROM roles";
			$rslt = mysqli_query($conn, $s);
			$records = mysqli_num_rows($rslt);					
			if ($records > 0){			
				while($data = mysqli_fetch_assoc($rslt)) {	
					 if($data["name"]==$r)
					 {
						 $flag1=false;						
					 }
				}	
			}	
			if(!$flag1)
			{
				echo "<script>alert('role already exists');</script>";
			}
			else if($flag1==true){
		$sql = "INSERT INTO roles (name, description, createdby, createdon)
		VALUES ('$r','$des','$u','$d')";
if ($conn->query($sql) === TRUE) {
    echo "<script>alert('new role has been added');</script>";
	Header('Location:Role_List.php');
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}			
	}
	
	else
		Header('Location:Role.php');
	}
	}
?>
	
</form>
</div>
</div>
</div>
</form>
 </body>
</html>