<?php 

    error_reporting(E_ALL); 
    ini_set('display_errors',1); 

    include('dbcon.php');
	
	
	
	$android = strpos($_SERVER['HTTP_USER_AGENT'], "Android");


    if( (($_SERVER['REQUEST_METHOD'] == 'POST') && isset($_POST['submit']))||$android)
    {

        $user_id=$_POST['user_id'];
        $content=$_POST['content'];
		$grade=$_POST['grade'];

		
		//각각 아이디, 비밀번호, 비밀번호 확인, 성별, 나이 입력 안 됐을 경우

        if(empty($user_id)){
            $errMSG = "아이디를 입력하세요.";
        }
        else if(empty($content)){
            $errMSG = "내용을 입력하세요.";
        }
		else if(empty($grade)){
            $errMSG = "등급을 입력하세요.";
        }
		
		
        if(!isset($errMSG))
        {
            try{
				
				
				       $query = "insert into user (user_id,content,grade) values('$user_id','$content','$grade')";
				
			           $result = $con->query($query);
				
				   
				   
				   
				   
				           if($result)
                              {
                                 $successMSG = "새로운 리뷰가 등록되었습니다.";
                              }
				
				
				
				
                           else
                             {
                                $errMSG = "리뷰 추가 에러";
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
            user_id: <input type = "text" name = "user_id" />
            content: <input type = "content" name = "content" />
			grade: <input type = "grade" name = "grade />

           
            <input type = "submit" name = "submit" />
        </form>
   
   </body>
</html>

<?php 
    }
?>