<?php
ob_start();
session_start();
	include('log-funcs/function.php');
if(!$_SESSION['employee_id'] and !$_SESSION['admin_id'] and !$_SESSION['access_lvl'] and !$_SESSION['username']){
    redirect("../index.php");
}
//
	$database = new database();
	$student  = new student();
    $user     = new user();
	$staff    = new staff();
	$message_handler  = new message_handler();
	
	//
	$user->user 	  = $_SESSION['employee_id'];
	$user->admin_id   = $_SESSION['admin_id'];
	$user->access_lvl = $_SESSION['access_lvl'];
	$user->username   = $_SESSION['username'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<script type="text/javascript" src="js/script.js"></script>
<script type="text/javascript">
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
</script>
<script type="text/javascript" src="js/jquery-1.9.1.js"></script>
<script type="text/javascript" src="js/jquery1.4.js"></script>
<script type="text/javascript">
//$( "#record tr:first input:radio" ).attr("checked", true);
//$("#record tr").find("tr:first").css( "font-style", "italic" );
$(document).ready(function(){
$('#record tr input:radio[name=user_id]:nth(0)').attr('checked',true);
    });
	
/*	window.onload = getTotal;
 function getTotal(){
	 
	 document.getElementById("totalCount").innerHTML = "<img src=\"icons/graph.gif\" ><br />Loading...";
	 var datatype = 'staff';
	 		$.ajax ({
			type:"POST",
			url:"log-funcs/fetchcount.php",
			data:{staff : staff},
			success:function(data, textStatus) {
				document.getElementById("totalCount").innerHTML = data;
				}
			});
	 
	 
	 }	*/
	
document.onmousedown=disableclick;
status="Right Click Disabled";
function disableclick(event){
 if(event.button==2)
   {
    window.location = 'index.php';
     return false;    
   }
}
function search_user(){	
	var searchtext = document.getElementById("search_bar").value;
	if(searchtext != "")
	{
		document.getElementById("search1").innerHTML = "<img src=\"icons/ajax_load2.gif\" > Searching...";
		$.ajax ({
			type:"POST",
			url:"log-funcs/user_search.php",
			data:{searchtext : searchtext},
			success:function(data, textStatus) {
				document.getElementById("search1").innerHTML = data;
				$('#record tr input:radio[name=user_id]:nth(0)').attr('checked',true);
				}
			});
	}else{
		window.location = 'users.php';
		}

	}
function MM_jumpMenuGo(objId,targ,restore){ //v9.0
  var selObj = null;  with (document) { 
  if (getElementById) selObj = getElementById(objId);
  if (selObj) eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0; }
}
</script>
</head>
<link href="style/style.css" type="text/css" rel="stylesheet"  />
<body>
<div id="wrapper">
<div id="Up_line">
<a href="index.php" title="Database"><div id="banna"></div></a>
            <table align="right">
		    <tr>
                <td><a href="logout.php?logout=1">Logout</a></td>
                <td><a href="settings.php">Settings</a></td>
                <td><a href="preference.php">preference</a></td>
                <td><a href="help.php">Help</a></td>

			</tr>
		 </table>
</div>
  <div id="header">
     <div id="control">
    </div>
     <div id="downTitle">
     <div id="nav">
       <ul>
         <li class="main_menu"><a href="index.php">Home</a></li>
         <li class="main_menu"><a href="students.php">Students</a></li>
         <li class="main_menu"><a href="manage.php">Manage school</a></li>
         <li class="main_menu"><a href="staff.php">Staff</a></li>  
          <li class="main_menu"><a href="check_result.php">Results</a></li>
         <li class="main_menu"><a href="archive.php">Archive</a></li>
       </ul>
       </div>
<div id="active_user" class="txt"><p align="right" id="dat">Logged In As <?php echo $user->getUser(); ?></p> 
          <p id="dat" align="right"><span style="float:left;" class="tt">Page Refreshed <strong><?php echo   date("l, M j, Y - h:i:s A"); ?></strong></span>
         <input type="button" value="Refresh" onclick="redirectTo('<?php echo $_SERVER['PHP_SELF'].'?q='.md5(rand(2,10)).'/refresh=refreshed'; ?>')" class="btn">           <select name="jumpMenu" id="jumpMenu" onchange="MM_jumpMenu('parent',this,0)">
             <option value="<?php echo $_SERVER['PHP_SELF'].'?q='.md5(rand(2,10)).'/refresh=refreshed' ?>">Auto Refresh</option>
             <option value="<?php echo $_SERVER['PHP_SELF'].'?q='.md5(rand(2,10)).'/refresh=refreshed'?>">Manuel</option>
           </select></p></div>
     </div>
  </div>
  <div id="moduleAttribute"></div>
  <div id="modules">
<!--Message Area -- START-->
<?php

if(isset($_GET['msg'])){
	
	echo '<div id="msg">
   <div id="icon"><img src="icons/infol.gif" /></div>
   <div id="message">
     <h2>Update Message</h2>
	 <p>User Created successful</p>
   </div>
  </div>';
	
	
	}


if(isset($_GET['token_create'])){
	$message_handler->message_token = $_GET['token_create']='create';

	
	echo '<div id="msg">
   <div id="icon"><img src="icons/infol.gif" /></div>
   <div id="message">
     <h2>Update Message</h2>
	 <p>Staff Added successful</p>
   </div>
  </div>';
	
	
	}
if(isset($_GET['token_delete'])){
	$message_handler->message_token = $_GET['token_delete']='delete';
	
	echo '<div id="msg">
   <div id="icon"><img src="icons/infol.gif" /></div>
   <div id="message">
     <h2>Update Message</h2>
	 <p>User deleted successful</p>
   </div>
  </div>';
	}
	
	if(isset($_GET['token_edit'])){
	$message_handler->message_token = $_GET['token_edit']='edited';

	
	echo '<div id="msg">
   <div id="icon"><img src="icons/infol.gif" /></div>
   <div id="message">
     <h2>Update Message</h2>
	 <p>User edited successful</p>
   </div>
  </div>';
	
	
	}
	
			if(isset($_GET['token_edt'])){
	$message_handler->message_token = $_GET['token_edt']='false';
	
	echo '<div id="msg">
   <div id="icon"><img src="icons/infol.gif" /></div>
   <div id="message">
     <h2>Information</h2>
	 <p>You have not made any changes to the current property sheet</p>
   </div>
  </div>';
	
	
	}



?>


<!--Message Area -- END-->


    <h3 id="title" style="border-bottom:solid 1px #999966;">Finance</h3>
        <p>&nbsp;</p>
    
	<form method="post" action="loadUser.php?jessionid=<?php echo md5(rand(2,10))?>&&event=trigger_action:student_database/">
	    <h4 id="title" style="border-bottom:solid 1px #999966; margin-left:20px;">Search</h4>
		<span>Select a class type to filter the data that is displayed in your results set.</span>
<table width="100%">
  <tr>
    <td width="109" height="51" align="right" class="txt">Search</td>
    <td width="443"><input type="text" name="studentName" id="search_bar" title="Search Bar"  autocomplete="off" placeholder="search" onkeyup="search_user()" /></td>
    <td width="12">&nbsp;</td>
    <td width="7">&nbsp;</td>
    <td width="414">&nbsp;</td>
    <td width="182">
    
<a style="cursor:pointer;" onclick="window.open('form_teachers_print.php','mywindow','width=1000,height=700,toolbar=no,left=200,top=10, location=no,scrollbars=yes,status=yes, screenX=100,screenY=100');"><img src="icons/b_print.png" alt="print" />Print Users</a>
    
    
    
    </td>
    <td width="131"><div id="totalCount">Total Users <?= $staff->getRowUsers(); ?> </div></td>
    </tr>
    </table>
  <p style="font-size:12px; border-bottom:dashed 1px #CC99FF;"><img src="icons/tip.gif" />By default, the search returns all matches beginning with the string you entered. To run an exact or case-sensitive match, double quote the search string. You can use the wildcard symbol (%) in a double quoted string.</p>  
<p id="desgn1"><span class="btn2"><input type="button" name="create" onclick="redirectTo('create_user.php')" value="Add Payment" style="float:right;" class="btn" /></span></p>
    <div id="search1">
    <p  id="desgn">
  
      <input type="button" name="go_button" id= "go_button" style="float:right;" value="Go" class="btn" onclick="MM_jumpMenuGo('jumpMenu2','parent',0)" />
        <select name="jumpMenu2" id="jumpMenu2" style="float:right; border:solid 1px #996;">
        <option value="users.php">--Action--</option>
        <option value="enable_users.php">Enable Users</option>
        <option value="disable_users.php">Disable Users</option>
      </select>
      
      <input type="submit" name="token" value="View" style="float:right;" class="btn" />
          <input type="submit" name="token" value="Delete" style="float:right;" class="btn" /> 

    <input type="submit" name="token" value="Edit" style="float:right;" class="btn" />
      </p>


    <table width="100%" border="1" id="record">
  <tr style="background:#999966;">
    <th width="46">Select</th>
    
    <th width="382">Students Name</th>
    <th width="304">Admission No</th>
    <th width="289">Fees Name</th>
    <th width="109">Amount</th>
    <th width="170">Date</th>
    </tr>
<!--Result set from database with pagination augument-->
    <td width="46">Select</td>
    <td width="382">Students Name</td>
    <td width="304">Admission No</td>
    <td width="289">Fees Name</td>
    <td width="109">Amount</td>
    <td width="170">Date</td>
    </tr>
  </table>
    <p  id="paginat"><input type="submit" name="token" value="View" style="float:right;" class="btn" />
    <input type="submit" name="token" value="Edit" style="float:right;" class="btn" />
    <input type="submit" name="token" value="Delete" style="float:right;" class="btn" /></p>
</form>

  </div>
</div>
 <div id="copy"><p align="center"> <p align="center">
   
  Copyright &copy; <?php echo date('Y'); ?> HiSCORE. All rights reserved<br />Unauthorized use of this site is prohibited and may be subject to civil and criminal prosecution. </p></p></div>

</body>
</html>