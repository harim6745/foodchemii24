<?php 

    error_reporting(E_ALL); 
    ini_set('display_errors',1); 

    include('dbcon.php');
	
	
	
	$android = strpos($_SERVER['HTTP_USER_AGENT'], "Android");


    if( (($_SERVER['REQUEST_METHOD'] == 'POST') && isset($_POST['submit']))||$android)
    {

        $user_id=$_POST['id'];
        $user_pw=$_POST['password'];
		$pwc=$_POST['pwc'];
        $user_sex=$_POST['sex'];
		$user_age=$_POST['age'];
		
		//각각 아이디, 비밀번호, 비밀번호 확인, 성별, 나이 입력 안 됐을 경우

        if(empty($user_id)){
            $errMSG = "아이디를 입력하세요.";
        }
        else if(empty($user_pw)){
            $errMSG = "비밀번호를 입력하세요.";
        }
		else if(empty($pwc)){
            $errMSG = "비밀번호 확인을 입력하세요.";
        }
		else if(empty($user_sex)){
            $errMSG = "성별을 입력하세요.";
        }
		else if(empty($user_age)){
            $errMSG = "나이를 입력하세요.";
        }
		
		if($user_pw != $pwc)
	        {
		      echo ("<script> alert ('비밀번호 확인이 맞지않습니다. 다시 입력해주세요.')
		      history.go(-1)
		      </script>"
		     );		
		    exit;
	        }
        
		
		
        if(!isset($errMSG))
        {
            try{
				
				
				       $query = "insert into user (id,password,sex,age) values('$user_id','$user_pw','$user_sex','$user_age')";
				
			           $result = $con->query($query);
				
				   
				   
				   
				   
				           if($result)
                              {
                                 $successMSG = "새로운 사용자를 추가했습니다.";
                              }
				
				
				
				
                           else
                             {
                                $errMSG = "사용자 추가 에러";
                             }
				     
					 
			

            } catch(PDOException $e) {
                die("Database error: " . $e->getMessage()); 
            }
        }

    }
	
		
?>

<html>
   <body>
        <?php 
        if (isset($errMSG)) echo $errMSG;
        if (isset($successMSG)) echo $successMSG;
		
		$android = strpos($_SERVER['HTTP_USER_AGENT'], "Android");
		
		if( !$android )
    {
        ?>
        
        <form action="<?php $_PHP_SELF ?>" method="POST">
            id: <input type = "text" name = "id" />
            password: <input type = "password" name = "password" />
			password check: <input type = "password" name = "pwc" />
            sex: <input type = "text" name = "sex" />
			age: <input type = "text" name = "age" />
           
            <input type = "submit" name = "submit" />
        </form>
   
   </body>
</html>

<?php 
    }
?>