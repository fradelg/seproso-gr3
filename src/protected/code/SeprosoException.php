<?php

/**
 * SeprosoException class file.
 *
 * @author Grupo3 - ISO2 -UVA
 */

/**
 * Generic seproso application exception. 
 * Exception messages are saved in "exceptions.txt".
 */
class SeprosoException extends TException
{
	/**
	 * @return string path to the error message file
	 */
	protected function getErrorMessageFile()
	{
		return dirname(__FILE__).'/Exceptions.txt';
	}	
}

?>