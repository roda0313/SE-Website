<?php

if (isset($_GET['function']))
{
	switch($_GET['function'])
	{
		case "submitStudentForm":
			return submitStudentForm();
		case "submitEmployeeForm":
			return submitEmployeeForm();
		default:
			return "An error occurred";
	}
}

function submitStudentForm()
{
	
}

function submitEmployeeForm()
{
	
}

?>