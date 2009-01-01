<?php
/**
 * SeprosoUserTypeHandler class file.
 *
 * @author Wei Zhuo <weizhuo[at]gmail[dot]com>
 * @link http://www.pradosoft.com/
 * @copyright Copyright &copy; 2005-2006 PradoSoft
 * @license http://www.pradosoft.com/license/
 * @version $Id: SeprosoUserTypeHandler.php 1578 2006-12-17 22:20:50Z wei $
 * @package Demos
 */

/**
 * SQLMap type handler for SeprosoUser.
 * The SeprosoUser requires an instance of IUserManager in constructor.
 *
 * @author Wei Zhuo <weizhuo[at]gmail[dot]com>
 * @version $Id: SeprosoUserTypeHandler.php 1578 2006-12-17 22:20:50Z wei $
 * @package Demos
 * @since 3.1
 */
class SeprosoUserTypeHandler extends TSqlMapTypeHandler
{
	/**
	 * Not implemented.
	 */
	public function getParameter($object)
	{
		throw new SeprosoException('Not implemented');
	}

	/**
	 * Not implemented.
	 */
	public function getResult($string)
	{
		throw new SeprosoException('Not implemented');
	}

	/**
	 * Creates a new instance of SeprosoUser
	 * @param array result data
	 * @return SeprosoUser new user instance
	 */
	public function createNewInstance($row=null)
	{
		$manager = Prado::getApplication()->getModule('users');
		if(is_null($manager))
			$manager = new UserManager();
		return new SeprosoUser($manager);
	}
}

?>