<?php
/**
 * Init Class
 * @final
 * @version 0.1.0
 * @author Anton Denisenko
 */
final class Init 
{

	/**
	 * Connect to database ,create table 'test', fill table 'test' random data
	 * @param string $host database host
	 * @param string $user database user
	 * @param string $pswd database password
	 * @param string $dbName database name
	 * @throws 'Could not connect to MySQL server', 'Unable to select database', Can't insert random data
	 * @author Anton Denisenko
	*/	
	public function __construct($host, $user, $pswd, $dbName)
	{
		$link = mysql_connect($host, $user, $pswd);
		if (!$link)
		{
			throw new Exception('Could not connect to MySQL server: ' . mysql_error());
		}
		if (!mysql_select_db($dbName))
		{
			throw new Exception('Unable to select database: ' . mysql_error());
		}
		$this->create();
		if(!$this->fill())
		{
			throw new Exception('Can\'t insert random data: ' . mysql_error());
		}
		
	}
	
	/**
	 * Fill table 'test' random data
	 * @access private
	 * @return bool Insert to table result
	 */	
	private function create()
	{
		$q = 'CREATE TABLE `test` (
        `id` int(11) NOT NULL auto_increment,
        `script_name` varchar(25) default NULL,
		`start_time` int(11) default NULL,
		`end_time` int(11) default NULL,
        `result` varchar(25) default NULL,
        PRIMARY KEY (`id`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8;';
		
		$result = mysql_query($q);
		return $result;
	}

	/**
	 * Create table 'test'
	 * @access private
	 * @return bool Create table result
	 */		
	private function fill()
	{
		$symbols =  array(
				"a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z", "0","1", "2", "3", "4", "5", "6", "7", "8", "9", "A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z"
				);
		$results =  array('normal', 'illegal', 'failed' ,'success');
		
		$scriptNameLength = rand(2,10);
		$scriptName="";
		
		for($i=1; $i <= $scriptNameLength; $i++) 
		{
			$num = mt_rand(0,61);
			$scriptName .= $symbols[$num];
		}		
		$scriptName = 'script_'.$scriptName.'.php';
		
		$startTime = time();
		$endTime = $startTime + mt_rand(1, 360);
		$result = $results[mt_rand(0,3)];
		$q = "INSERT INTO test (script_name, start_time, end_time,result) VALUES('$scriptName', $startTime, $endTime, '$result')";
		return mysql_query($q);
	}

	/**
	 * Get data from table 'test' where result is normal or success
	 * @access public
	 * @throws 'Can't get scripts data'
	 * @return mixed false or array
	 */		
	public function get()
	{
		$q = "SELECT * from test  where result='normal' or result='success' ORDER BY start_time DESC";
		$result = mysql_query($q);
		//var_dump($result);
		if(!$result)
		{
			throw new Exception('Can\'t get scripts data: ' . mysql_error());
			return false;
		}
		$data = array();
		while($row = mysql_fetch_assoc($result))
		{
			$data[] = $row;
		}
		return $data;
	}

}