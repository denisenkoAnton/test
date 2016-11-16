<?
/**
 * TXT files finder script
 * @version 0.1.0
 * @author Anton Denisenko
*/
 
/**
* @var string $dir relative path to directory 
*/
$dir = './datafiles/';

try
{
	$txtFiles = txtFilesFinder($dir);
	$fileList = '<span>Founded ".txt" files</span><ul><li>'.implode('</li><li>',$txtFiles).'</li></ul>';
	echo $fileList;

}
catch(Exception $e)
{
	echo $e->getMessage();
}

/**
* function to find txt files in directory
* @param string  $path relative path to directory  
* @return mixed bool or array of txt files
*/
function txtFilesFinder($path)
{
	/**
	* @var string $regExp Regular expression to fin txt files 
	*/
	$regExp = '/\w+.txt/i';
	$files = scandir($path);
	if(!$files)
	{
		throw new Exception('Invalid path to diretory!');
		return false;
	}
	$txtFiles = array();
	foreach($files as $file)
	{
		if(preg_match($regExp, $file) && !is_dir($path.$file))
		{
			$txtFiles[] = $file;
		}
	}
	if(!$txtFiles)
	{
		throw new Exception('No txt files in diretory !');
		return false;
	}
	sort($txtFiles);
	return $txtFiles;
}
