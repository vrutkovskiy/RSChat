<?php	
    include 'dbconnection.php';
    ini_set("session.gc_maxlifetime", 600);    
    session_start();
	if(isset($_GET)){		
		try {			
			$dbh = new PDO('mysql:host='.$host.';dbname='.$DBname,  $DBlogin, $DBpass);
			$queryPDO = "select * from Users";
			$res = $dbh->query($queryPDO);					

			foreach ($dbh->query($queryPDO) as $row){       
				if($_GET['username'] == $row['UserName']){
					$logMatch = true;
					if($_GET['token'] == $row['Token']){
						$_SESSION['User'] = $row;
						$token = true;
						break;	
					}   
				}          
            }      
			if($token){
				$data['UserName'] = $_GET['username'];
				$data['ConfirmSuccess'] = true;
				$stml = $dbh->prepare("UPDATE Users set `Activation`= '1' where Id_User = :UserId");  
                    $stml->bindParam(':UserId', $_SESSION['User']['Id_User']);                  
					
                    $stml->execute();  
					$data['status'] = 'Insert succesful'; 
				echo json_encode($data);
				return;
			}
			else{
				$_SESSION['errors']['Token'] = 'Wrong token';
			}
			if($logMatch == false){
				$_SESSION['errors']['Login'] = 'Wrong login';
			}
			echo json_encode($_SESSION['errors']);
			$dbh = null;
		} catch (PDOException $e) {
			print "Error!: " . $e->getMessage() . "<br/>";
			die();
		}
	}			
?>