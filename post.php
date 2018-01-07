<?php
	include 'dbconnection.php'; 
	session_start();
    unset($_SESSION['errors']);
    if(isset($_POST)){			
        if ($_POST['toPost'] == ''){
            $_SESSION['errors']['toPost'] = 'Type some text';
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
                $dbh = new PDO('mysql:host='.$host.';dbname='.$DBname, $DBlogin, $DBpass);               
               
                $toPost = htmlspecialchars($_POST['toPost'], ENT_QUOTES);  

                $date = time();		                	 	
                    
                $stml = $dbh->prepare("INSERT into Recalls (`Id_User`, `Recall_text`, `Time`) VALUES (".$_SESSION['User']['Id_User'].", '".$toPost."', '".$date."')");                
                $stml->bindParam(':Recall_text', $toPost);
                $stml->execute();     
                $data['status'] = 'insert succesful';   
                echo json_encode($data);
                
                $dbh = null;
            } catch (PDOException $e) {
                print "Error!: " . $e->getMessage() . "<br/>";
                die();
            }
       }
    }
?>