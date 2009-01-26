<?php
/**
 * Login Page class file.
 *
 * @author Wei Zhuo <weizhuo[at]gmail[dot]com>
 * @link http://www.pradosoft.com/
 * @copyright Copyright &copy; 2005-2006 PradoSoft
 * @license http://www.pradosoft.com/license/
 * @version $Id: Login.php 1400 2006-09-09 03:13:44Z wei $
 * @package Demos
 */

/**
 * Login page class.
 * 
 * Validate the user credentials and redirect to requested page 
 * if successful.
 *
 * @author Wei Zhuo <weizhuo[at]gmail[dot]com>
 * @version $Id: Login.php 1400 2006-09-09 03:13:44Z wei $
 * @package Demos
 * @since 3.1
 */
class Login extends TPage
{
	/**
	 * Validates the username and password.
	 * @param TControl custom validator that created the event.
	 * @param TServerValidateEventParameter validation parameters. 
	 */
	public function validateUser($sender, $param)
	{
		$authManager = $this->Application->getModule('auth');
		if(!$authManager->login($this->username->Text, $this->password->Text))
			$param->IsValid=false;
	}
	
	/**
	 * Called when login is successful. Init session data
	 * @param TControl button control that created the event.
	 * @param TEventParameter event parameters.
	 */
	public function doLogin($sender, $param)
	{
		if($this->Page->IsValid)
		{
			$auth = $this->Application->getModule('auth');
			if($this->remember->Checked)
				$auth->rememberSignon($this->User);
			
			// Loads last project as current project
			$dao = $this->Application->Modules['daos']->getDao('UserDao');
			$project = $dao->getProject($this->User->Name);
			if ($project != NULL) $this->Session['project'] = $project;
			
			// Set user session view
			foreach ($this->User->Roles as $role)
				$this->Session['view'] = $role;

			// Redirect to requested page
			$this->Response->redirect($auth->getReturnUrl());
		}
	}
}

?>