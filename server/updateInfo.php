<?php 
	$db=mysql_connect("mysql.comp.polyu.edu.hk", "13104448d", "suling1234");
	mysql_select_db("13104448d");
	session_start();
	$name = $_POST["name"];
	$phone = $_POST["phonenum"];
	$address = $_POST["address"];
	$email = $_POST["email"];
	$org = $_POST["org"];
	$type = $_POST["type"];
	$sql="UPDATE Attendee SET Attendee_Name = '".$name."', Attendee_Phonenum = '".$phone."', Attendee_Address = '".$address."', Attendee_Email = '".$email."', Attendee_AffilicatedOrg = '".$org."', Attendee_Type = '".$type."' WHERE Attendee_ID = '".$_SESSION['uid']."'";
	$rs=mysql_query($sql);
	if($rs)
	{
		if(isset($_SESSION['admin']))
		{
			?>
				<script type="text/javascript">
					window.history.back(-1);
				</script>
			<?php
		}
		else
			header('location: ../user-home.php');
	}
		else echo "error";
?>