<?php
	include 'dbconnection.php';
    ini_set("session.gc_maxlifetime", 600);  
	session_start();
	unset($_SESSION['errors']);
	if(isset($_POST)){
        if (empty($_POST['Login'])) {
            $_SESSION['errors']['Login'] = 'Login is missing';
        }       

        if (empty($_POST['Pass'])) {
            $_SESSION['errors']['Pass'] = 'Password is missing';
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

                $log = htmlspecialchars($_POST['Login'], ENT_QUOTES); 
                $pass = htmlspecialchars($_POST['Pass'], ENT_QUOTES);
                $logMatch = false;
                $passMatch = false;				

             	foreach ($dbh->query($queryPDO) as $row)
                {       
                    if($log == $row['UserName']){
                    	$logMatch = true;
                    	if($pass == $row['Password']){
                            $_SESSION['User'] = $row;
                    		$passMatch = true;
                			break;	
                    	}   
                    }          
                }        
                if($passMatch){
                	$data['UserName'] = $log;
					$data['LoginSuccess'] = 'Successful';
                	echo json_encode($data);
					return;
              	}
              	else{
              		$_SESSION['errors']['Pass'] = 'Wrong password';
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