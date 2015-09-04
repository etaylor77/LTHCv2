<?php
require('dbconnect.php');
$computerid = $_REQUEST['computerid'];

// Query for CPU, Memory, and Bandwidth usage

$sql = $pdo->prepare("SELECT cpu, mem, datain, dataout,
		date(lastupdate) AS date
	FROM h_computerstatshourly WHERE eventdate > DATE_ADD(NOW(), INTERVAL -60 DAY) AND computerid = :computerid order by lastupdate asc");
$sql->execute(array('computerid' => $computerid));
//$result = mysqli_query($conn,$sql);

$date = array(); $date['name'] = 'Date';
$cpu['name'] = 'CPU';
$mem['name'] = 'Memory';
$datain['name'] = 'Bandwidth Inbound';
$dataout['name'] = 'Bandwidth Outbound';

//while($row = mysqli_fetch_array($result)) {
foreach($sql as $row) {
	$date['data'][] = $row['date'];
	$cpu['data'][] = $row['cpu'];
	$mem['data'][] = $row['mem'];
	$datain['data'][] = $row['datain'];
	$dataout['data'][] = $row['dataout'];
	}

$rslt = array();
	array_push($rslt, $date);
	array_push($rslt, $cpu);
	array_push($rslt, $mem);
	array_push($rslt, $datain);
	array_push($rslt, $dataout);
	print json_encode($rslt, JSON_NUMERIC_CHECK);
?>