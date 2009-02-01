<?php

class DateTimeTypeHandler extends TSqlMapTypeHandler
{
	/**
	 * Not implemented.
	 */
	public function getParameter($integer)
	{
		return date('Y-m-d H:i:s', $integer);
	}

	/**
	 * Not implemented.
	 */
	public function getResult($string)
	{
		if(intval($string) > 10000) //strtotime doesn't like unix epoc time.
			return intval($string);
		return strtotime($string);
	}

	/**
	 * Creates a new instance of DateTime
	 * @param array result data
	 * @return DateTime new instance
	 */
	public function createNewInstance($row=null)
	{
		return 0;
	}

}

?>