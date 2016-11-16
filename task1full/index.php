<?php
require_once('config.php');
require_once('models/ClassInit.php');

try
{
	/**
	* @var object $init Construct method will create table test and fill it random data 
	*/
	$init = new Init(DBHOST, DBUSER, DBPASS, DBNAME);
	
	/**
	* @var array $data Get data from table test with result normal or success 
	*/	
	$data = $init->get();

	/**
	* @var string $result Contain template whith empty html table 
	*/		
	$result = file_get_contents('template/table.html');

	/**
	* @var string $tbody Body of html table 
	*/		
	$tbody = '';
	//Fill table
	foreach ($data as $v)
	{
		$tbody .= '<tr>'
					.'<td>' . $v['script_name'] .'</td>' 
					.'<td>' . date('d-M-Y H:i:s', (int)$v['start_time']) .'</td>'
					.'<td>' . date('d-M-Y H:i:s', (int)$v['end_time']).'</td>'
					.'<td>' . $v['result'] .'</td>'
				. '</tr>';
	}
	$result = preg_replace('/{TBODY}/',$tbody,$result); //add filled body of table to template
	echo $result;
	
}
catch(Exception $e)
{
	if(DEBUG)
	{
		echo $e->getMessage();
	}	
}