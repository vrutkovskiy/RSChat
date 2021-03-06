<?php	
    include 'dbconnection.php';
    
	try {
		$dbh = new PDO('mysql:host='.$host.';dbname='.$DBname,  $DBlogin, $DBpass);
		$queryPDO = "select Users.UserName, Recalls.Recall_text, Recalls.Time from Users 
						INNER JOIN Recalls on Users.Id_User = Recalls.Id_User
                        ORDER BY Recalls.Time DESC
                        LIMIT 10";
        $res = $dbh->query($queryPDO);
		
		$timeFormat = "Y-m-d H:i:s";
		$count = 0;
		if( $res->rowCount() > 0){ 
			foreach ($dbh->query($queryPDO) as $row)
			{       
				 $data[$count]['UserName'] = $row['UserName'];
				 $data[$count]['Recall_text'] = $row['Recall_text'];
				 $data[$count]['Time'] = date("Y-m-d H:i:s", $row['Time']);
				 $count++;
			}                 
		}		
		echo json_encode($data);
		$dbh = null;
		}
	catch (PDOException $e) {
		print "Error!: " . $e->getMessage() . "<br/>";
		die();
	}

 
?>