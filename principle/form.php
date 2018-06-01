<?php
  session_start();
  if($_POST["check"]){
  	 if($_SESSION["check_pic"]==trim($_POST["check_pic"])){
	     echo "验证码输入正确";
      }else{
	     echo "验证码输入错误";
      }
  }
  else 1;

?>
<form action="" method="post">
   <img src="validate.php" /><br/>
   <input type=text name="check_pic"/> <br/>
   <input type="submit" value="提交" name="check"/>
</form>
