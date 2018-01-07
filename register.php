<?php	
    include 'dbconnection.php';
    ini_set("session.gc_maxlifetime", 600);    
    session_start();
    unset($_SESSION['errors']);
    if(isset($_POST)){
        if (empty($_POST['UserName'])) {            
            $_SESSION['errors']['UserName'] = 'Username is missing';
        } 
		else {			
			if(!preg_match ("/^[a-zA-Z\d_]{3,}$/", $_POST['UserName']))							
					$_SESSION['errors']['UserName'] = 'Username must be at least 3 characters. Can contain only Latin characters, _ or digits.';	
		}	

        if (empty($_POST['Password'])) {
            $_SESSION['errors']['Password'] = 'Password is missing';
        }
		else{			
			if(!preg_match ("/^[a-zA-Z\d_]{3,}$/", $_POST['Password']))							
					$_SESSION['errors']['Password'] = 'Password must be at least 3 characters. Can contain only Latin characters, _ or digits.';	
		}		

        if (empty($_POST['PasswordConfirm'])) {
            $_SESSION['errors']['PasswordConfirm'] = 'Password Confirm is missing';
        }
        else{
            if($_POST['PasswordConfirm'] != $_POST['Password']){
                $_SESSION['errors']['PasswordConfirm'] = 'Password Confirm is not match Password';
            }            
        }

        if (empty($_POST['Email'])) {
            $_SESSION['errors']['Email'] = 'Email is missing';
        }
        else{			
            if(!preg_match ("/^[a-zA-Z\d_]{3,}@[a-zA-Z\d_]{1,}\.[a-zA-Z\d]{2,3}$/", $_POST['Email'])){
                $_SESSION['errors']['Email'] = 'Use email of type: Email@email.em. Can contain only Latin characters, _ or digits.';
            }
        }          
        if(isset($_SESSION['errors'])){
            if(count($_SESSION['errors']) > 0){
                if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&  strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {                
                    echo json_encode($_SESSION['errors']);
                    exit;
                 }                   
            }
        }
        else{      
			
            try {
                $dbh = new PDO('mysql:host='.$host.';dbname='.$DBname,  $DBlogin, $DBpass);
                $queryPDO = "select * from Users";
                $res = $dbh->query($queryPDO);

                $userName = htmlspecialchars($_POST['UserName'], ENT_QUOTES); 
                $userPass = htmlspecialchars($_POST['Password'], ENT_QUOTES);
                $userEmail = htmlspecialchars(trim($_POST['Email']), ENT_QUOTES);  

                $toInsert = true;
                if( $res->rowCount() > 0){ 
                    foreach ($dbh->query($queryPDO) as $row)
                    {       
                        if($userName == $row['UserName']){
                            $_SESSION['errors']['UserName'] = 'Username is taken';
                            $toInsert = false;
                            echo json_encode($_SESSION['errors']);
                            break;
                        }                       
                    }                 
                }
                if($toInsert == true){  
					$token = md5($userName . mt_rand(100000,999999));
					$message = '
					<html>
					<head>
					  <title>Confirmation</title>
					</head>
					<body>
					<table>
					<tr>
					  <p>Please follow this link to confirm registration on RSChat.ru</p>	
					</tr>
					<tr>
					  <p><a href="http://RSChat.ru:81/activate.php?username=' . $userName  . '&token=' .  $token . '" target="_blank"> 
					  RSChat.ru:81/activate.php?username=' . $userName . '&token=' . $token . '</a></p>						 	
					</tr>
					<tr>
					 <p>if this message is sent to you by mistake then just ignore it.</p>	
					</tr>
					</table>	
					</body>
					</html>
					';
					
					$headers = "MIME-Version: 1.0\r\n";
					$headers .= "Content-type: text/html; charset=utf-8\r\n";
                    if (mail($userEmail, "Confirmation", $message, $headers)) { 
						$_SESSION['mail'] = "To complete the registration, click on the link received by mail.";
						$data['mail'] = "Messege acepted for delivery"; 
					} else { 
						$data['mail'] = "Some error happen"; 
					}
                    $stml = $dbh->prepare("INSERT into Users (`UserName`, `Password`, `Email`, `Token`) VALUES (:UserName, :Pass, :Email, :Token)");                
                    $stml->bindParam(':UserName', $userName);
                    $stml->bindParam(':Pass', $userPass);
                    $stml->bindParam(':Email', $userEmail);
                    $stml->bindParam(':Token', $token);
					
                    $stml->execute();     
                    $data['status'] = 'Insert succesful';   
                    echo json_encode($data);
                }
                $dbh = null;
            } catch (PDOException $e) {
                print "Error!: " . $e->getMessage() . "<br/>";
                die();
            }
       }
    }
?>