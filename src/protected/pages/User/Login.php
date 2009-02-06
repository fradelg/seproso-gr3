<?php
/**
 * Login Page class file.
 *
 * @author Grupo2 - ISO 2 - UVA
 * @link http://jair.lab.fi.uva.es/~fradelg/fray/seproso/
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
			$dao = $this->Application->Modules['daos']->getDao('UserDao');
			
			// Set project session data for managers or developers
			if ($this->User->IsInRole('manager') || $this->User->IsInRole('developer')){
				$projects = $dao->getProjectsByUser($this->User->Name);
				if ($projects != NULL) $this->Session['project'] = current($projects);
			}

			// Set user view session data
			$this->Session['managing'] = false;
			if ($this->User->IsInRole('manager') && $projects != NULL){
				$role = $dao->getRoleInProject($this->User->Name, $this->Session['project']);
				if ($role === 'Jefe de proyecto'){ 
					$this->Session['view'] = 'manager';
					$this->Session['managing'] = true;
				} else 
					$this->Session['view'] = 'developer';
			} else
				$this->Session['view'] = current($this->User->Roles);
			

			// Redirect to requested page
			$url = $this->Service->constructUrl($this->Service->DefaultPage);
			$this->Response->redirect($url);
		}
	}
}

?>