<?php 

    error_reporting(E_ALL); 
    ini_set('display_errors',1); 

    include('dbcon.php');
	
    $android = strpos($_SERVER['HTTP_USER_AGENT'], "Android");


    if( ($_SERVER['REQUEST_METHOD'] == 'POST') && isset($_POST['submit'])) || $android )
    {

        $user_id=$_POST['user_id'];
        $content=$_POST['content'];
        $grade=$_POST['grade'];

        if(empty($user_id)){
            $errMSG = "아이디를 입력하세요.";
        }
        else if(empty($content)){
            $errMSG = "내용을 입력하세요.";
        }
		else if(empty($grade)){
            $errMSG = "점수를 입력하세요.";
        }

        if(!isset($errMSG))
        {
            try{
                $stmt = $con->prepare('INSERT INTO review_honey_hr(user_id, content,grade) VALUES(:user_id, :content, :grade)');
                $stmt->bindParam(':user_id', $user_id);
                $stmt->bindParam(':content', $content);
                $stmt->bindParam(':grade', $grade);

                if($stmt->execute())
                {
                    $successMSG = "새로운 리뷰를 추가했습니다.";
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


<?php 
    if (isset($errMSG)) echo $errMSG;
    if (isset($successMSG)) echo $successMSG;

	$android = strpos($_SERVER['HTTP_USER_AGENT'], "Android");
   
    if( !$android )
    {
?>
    <html>
       <body>

            <form action="<?php $_PHP_SELF ?>" method="POST">
                User_id: <input type = "text" name = "user_id" />
                Content: <input type = "text" name = "content" />
                Grade: <input type = "text" name = "grade" />
                <input type = "submit" name = "submit" />
            </form>
       
       </body>
    </html>

<?php 
    }
?>