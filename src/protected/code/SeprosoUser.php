<?php
/**
 * SeprosoUser class file.
 *
 * @author Grupo3 - ISO2 -UVA
 * @version 1.0
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
}

?>