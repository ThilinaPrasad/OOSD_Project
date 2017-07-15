<?php require ("connection/dbConnection.php");?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<form method="post">
	<br>
    <Lable>Student ID</Lable><br>
    <input type="text" id="studentID" name="studentID" >
    <input type="submit" name="view" onclick="viewStudent();" value="View Student"><br>

</form>
<style>
		table {border-collapse: collapse;}
		td,th{border:1px solid black;padding: 10px;}
	</style>
</body>
</html>

<?php
    	if (isset($_POST['view'])){
    		
    		$studentID=$_POST['studentID'];
    		$sql = "SELECT * FROM student WHERE  indexNumber ='{$studentID}'";
    		$result=runQuery($sql);
    		 if (mysqli_num_rows($result) == 1) {
    		 		$query = "SELECT * FROM student WHERE indexNumber='$studentID'";
					$result_set=runQuery($query);
	
						if ($result_set) {
		
								$table = '<table>';
								$table .= '<tr><th>First Name</th><th>Last Name</th><th>Address</th><th>Birthday</th><th>Gender</th><th>Email</th><th>Telephone</th></tr>';
								while ($record=mysqli_fetch_assoc($result_set)) {
										$table .='<tr>';
										$table .='<td>'.$record['firstName'].'</td>';
										$table .='<td>'.$record['lastName'].'</td>';
										$table .='<td>'.$record['address'].'</td>';
										$table .='<td>'.$record['birthday'].'</td>';
										$table .='<td>'.$record['gender'].'</td>';
										$table .='<td>'.$record['email'].'</td>';
										$table .='<td>'.$record['telephone'].'</td>';
										$table .='</tr>';
								}
						$table .='</table>';
	}
	echo "<br></br>";
	echo $table;
    		 }
else{
    	echo "<script type='text/javascript'>alert('Invalid Password!');</script>";}
    	}
    ?>