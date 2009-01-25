<?php
/**
 * SeprosoUser class file.
 *
 * @author Wei Zhuo <weizhuo[at]gmail[dot]com>
 * @link http://www.pradosoft.com/
 * @copyright Copyright &copy; 2005-2006 PradoSoft
 * @license http://www.pradosoft.com/license/
 * @version $Id: SeprosoUser.php 1400 2006-09-09 03:13:44Z wei $
 * @package Demos
 */

// Include TUserManager.php file which defines TUser
Prado::using('System.Security.TUserManager');
Prado::using('System.Security.TUser');

/**
 * User class for Seproso application.
 *
 * @author Wei Zhuo <weizhuo[at]gmail[dot]com>
 * @version $Id: SeprosoUser.php 1400 2006-09-09 03:13:44Z wei $
 * @package Demos
 * @since 3.1
 */
class SeprosoUser extends TUser
{
	public $Password = '';
	public $Project = '';
	public $EmailAddress = '';
	
	/**
	 * @param string user email address
	 */
	public function setEmailAddress($value)
	{
		$this->EmailAddress = $value;
	}
	
	/**
	 * @return string user email address
	 */
	public function getEmailAddress()
	{
		return $this->EmailAddress;
	}
	
	/**
	 * @param string current working project
	 */
	public function setProject($pro)
	{
		$this->Project = $pro;
	}

	/**
	 * @return string current working project
	 */
	public function getProject()
	{
		return $this->Project;
	}
	
	/**
	 * @return boolean is there active project?
	 */
	public function hasProject()
	{
		return ($this->Project != null);
	}
}

?>