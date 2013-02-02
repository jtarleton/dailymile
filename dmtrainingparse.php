<?php
 
require_once('PDOFactory.class.php');
 
$pdo = PDOFactory::PDOCreate('mysql://u:p@localhost/db');
 
$tablename = 'Dmruns';
 
$pdo->exec(sprintf('DELETE from %s', $tablename));
 
$i=0;
 
if (($handle = fopen(dirname(__FILE__)."/training.csv", "r")) !== FALSE)
{
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE)
    {
 
	    echo $i.' ';
 
 
 
 
 
        $stmt=$pdo->prepare(
        sprintf("INSERT INTO %s VALUES('',:field,:field2,:field3,:field4,:field5)" , $tablename)
        );
 
        $stmt->bindValue(':field',    date('Y-m-d', strtotime($data[0])) );
        $stmt->bindValue(':field2',        $data[1]);
        $stmt->bindValue(':field3',        $data[2]);
        $stmt->bindValue(':field4',        $data[3]);
        
        $stmt->bindValue(':field5',        $data[4]);
        
        $stmt->execute();
		$i++;
    }
    fclose($handle);
}
