<?php 

class Utils 
{
	private function __construct()
	{
	}
	
	static public function zebra($g)
	{
		return ($g % 2 !=0) ? 'odd' : 'even';
	}

	static public function printEntry(array $row, $g) 
	{ 
		?>
		<tr class="<?php echo self::zebra($g); ?>">

<td><?php echo $row['id']; ?></td>

<td><a href="<?php echo $row['url']; ?>">Link</a></td>

<td><?php echo date('m/d/Y', strtotime($row['at'])); ?></td>

<td><?php echo @$row['message']; ?></td>

<td><?php echo implode(' ', $row['comments']); ?></td>

<td><?php echo implode(' ', $row['likes']); ?></td>

<td><?php echo $row['location']['name']; ?></td>

<td><?php echo $row['user']['username']; ?></td>

<td><?php echo $row['user']['display_name']; ?></td>

<td><?php echo sprintf('<img src=""></img>',$row['user']['photo_url']); ?></td>

<td><a href="<?php echo $row['user']['url']; ?>">User Link</a></td>

<td><?php echo @$row['workout']['activity_type']; ?></td>

<td><?php echo sprintf('%s %s', @$row['workout']['distance']['value'], @$row['workout']['distance']['units']); ?></td>

<td><?php echo @$row['workout']['felt']; ?></td>

		</tr> 
		<?php
	}
}

/**
* DailyMileEntry
* 
*	A DailyMileEntry object represents an entry retrieved from the DailyMile API. 
*
*/
class DailyMileEntry 
{
	/**
	* __construct 
	*/
	public function __construct()
	{

	/* 

		TO DO...when James is really bored.

	*/

	}

	

}


/**
* DailyMileClient
*
* 	A DailyMileClient object represents a means for interacting with the DailyMile API.
*
*/
class DailyMileClient 
{

	static private $_singleton;

	/**
	* Allow only a single instance, for now.
	*/
	private function __construct()
	{ 
	}
	
	/**
	* getInstance
	*/
	static public function getInstance()
	{
		if(!isset(self::$_singleton)) 
		{
			self::$_singleton = new self;	
		}
		return self::$_singleton;	
	}

	/**
	* getRecentEntries
	*/
	public function getRecentEntries($userid)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_URL, sprintf('http://api.dailymile.com/people/%s/entries.json', $userid));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
		$out = curl_exec($ch);
		return json_decode(utf8_encode($out), true);
	}



	/* 

		TO DO...when James is really bored.

	*/

}
?>


<?php 

$userid = strip_tags(@$_GET['userid']);

?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
 
<title>Daily Mile Client</title>
<style type="text/css">
* { margin:0; padding:0}
body{
font-size:11px;
font-family: Verdana, Tahoma, sans-serif;
}
td { padding:15px; }
.odd { background-color:#F0F0F0; }
</style>
</head>
<body>
<div>
<form action="DailyMile.class.php" method="GET">

	<label for="userid">Daily Mile User</label>

	<input id="userid" name="userid" type="text"></input>

	<input type="submit" value="Go"></input>

</form>
<div>
<div>
<table style="border-collapse:collapse;table-layout:fixed; width:100%">

<?php

$rows =  DailyMileClient::getInstance()->getRecentEntries($userid);
$g=0;
if(!empty( $rows  )):

	foreach( $rows as $arr)

		foreach($arr as $r):

			Utils::printEntry($r, $g); $g++; 

				endforeach; ?>

<?php else: ?>

			<tr><td>Nada</td></tr>
<?php endif; ?>

</table>
</div>
</body>
</html>
