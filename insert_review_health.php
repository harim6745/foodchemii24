<?php 

    error_reporting(E_ALL); 
    ini_set('display_errors',1); 

    include('dbcon.php');


    $android = strpos($_SERVER['HTTP_USER_AGENT'], "Android");


    if( (($_SERVER['REQUEST_METHOD'] == 'POST') && isset($_POST['submit'])) || $android )
    {

        // 안드로이드 코드의 postParameters 변수에 적어준 이름을 가지고 값을 전달 받습니다.

        $prod_health_1=$_POST['prod_health_1'];
        $prod_health_2=$_POST['prod_health_2'];
		$prod_review=$_POST['prod_review'];
		$prod_grade=$_POST['prod_grade'];
		

        if(empty($prod_health_1)){
            $errMSG = "건강제품을 입력하세요.";
        }
        else if(empty($prod_health_2)){
            $errMSG = "건강제품을 입력하세요.";
        }
		else if(empty($prod_grade)){
            $errMSG = "평점을 입력하세요.";
        }

        if(!isset($errMSG)) // 모든 정보가 입력되었다면
        {
            try{
                // SQL문을 실행하여 데이터를 MySQL 서버의 person 테이블에 저장합니다. 
                $stmt = $con->prepare('INSERT INTO review_health(prod_health_1, prod_health_2,prod_review,prod_grade) VALUES(:prod_health_1, :prod_health_2, :prod_review, :prod_grade)');
                $stmt->bindParam(':prod_health_1', $prod_health_1);
                $stmt->bindParam(':prod_health_2', $prod_health_2);
				$stmt->bindParam(':prod_review', $prod_review);
                $stmt->bindParam(':prod_grade', $prod_grade);

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
                건강제품 1 : <input type = "text" name = "prod_health_1" />
                건강제품 2 : <input type = "text" name = "prod_health_2" />
				리뷰 작성 : <input type = "text" name = "prod_review" />
                평점 : <input type = "text" name = "prod_grade" />
                <input type = "submit" name = "submit" />
            </form>
       
       </body>
    </html>

<?php 
    }
?>