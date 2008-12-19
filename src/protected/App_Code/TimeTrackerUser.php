<?php
/**
 * TimeTrackerUser class file.
 *
 * @author Wei Zhuo <weizhuo[at]gmail[dot]com>
 * @link http://www.pradosoft.com/
 * @copyright Copyright &copy; 2005-2006 PradoSoft
 * @license http://www.pradosoft.com/license/
 * @version $Id: TimeTrackerUser.php 1400 2006-09-09 03:13:44Z wei $
 * @package Demos
 */

// Include TUserManager.php file which defines TUser
Prado::using('System.Security.TUserManager');
Prado::using('System.Security.TUser');

/**
 * User class for Time Tracker application.
 *
 * @author Wei Zhuo <weizhuo[at]gmail[dot]com>
 * @version $Id: TimeTrackerUser.php 1400 2006-09-09 03:13:44Z wei $
 * @package Demos
 * @since 3.1
 */
class TimeTrackerUser extends TUser
{
	private $_emailAddress;
	private $_project;
	
	/**
	 * @param string user email address
	 */
	public function setEmailAddress($value)
	{
		$this->_emailAddress = $value;
	}
	
	/**
	 * @return string user email address
	 */
	public function getEmailAddress()
	{
		return $this->_emailAddress;
	}
	
	/**
	 * @param string current working project
	 */
	public function setProject($pro)
	{
		$this->_project = $pro;
	}

	/**
	 * @return string current working project
	 */
	public function getProject()
	{
		return $this->_project;
	}
	
	/**
	 * @return boolean is there active project?
	 */
	public function hasProject()
	{
		return ($this->_project != null);
	}
}

?>