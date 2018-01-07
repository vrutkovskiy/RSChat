<?php	
    include 'dbconnection.php';
    ini_set("session.gc_maxlifetime", 600);    
    session_start();	
    unset($_SESSION['errors']);
    if(isset($_GET)){           
		
		try {
			
			$dbh = new PDO('mysql:host='.$host.';dbname='.$DBname,  $DBlogin, $DBpass);
			$queryPDO = "select * from Users";
			$res = $dbh->query($queryPDO);

			$userName = htmlspecialchars($_POST['UserName'], ENT_QUOTES); 
			$userPass = htmlspecialchars($_POST['Password'], ENT_QUOTES);
			$userEmail = htmlspecialchars(trim($_POST['Email']), ENT_QUOTES);  
			$_SESSION['token'] = md5($MDsalt + $userName);

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
				
				$stml = $dbh->prepare("INSERT into Users (`UserName`, `Password`, `Email`, `Token`) VALUES (:UserName, :Pass, :Email, :Token)");                
				$stml->bindParam(':UserName', $userName);
				$stml->bindParam(':Pass', $userPass);
				$stml->bindParam(':Email', $userEmail);
				$stml->bindParam(':Token', $_SESSION['token']);
				$stml->execute();     
				$data['status'] = 'insert succesful';   
				echo json_encode($data);
			}
			$dbh = null;
		} catch (PDOException $e) {
			print "Error!: " . $e->getMessage() . "<br/>";
			die();
		}
   }
   
?>