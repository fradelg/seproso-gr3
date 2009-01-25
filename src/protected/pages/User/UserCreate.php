<?php
/**
 * UserCreate page class file.
 *
 * @author Wei Zhuo <weizhuo[at]gmail[dot]com>
 * @link http://www.pradosoft.com/
 * @copyright Copyright &copy; 2005-2006 PradoSoft
 * @license http://www.pradosoft.com/license/
 * @version $Id: UserCreate.php 1400 2006-09-09 03:13:44Z wei $
 * @package Demos
 */

/**
 * Create new user wizard page class. Validate that the usernames are unique and
 * set the new user credentials as the current application credentials.
 * 
 * If logged in as admin, the user role can be change during creation.
 *
 * @author Wei Zhuo <weizhuo[at]gmail[dot]com>
 * @version $Id: UserCreate.php 1400 2006-09-09 03:13:44Z wei $
 * @package Demos
 * @since 3.1
 */
class UserCreate extends TPage
{
	protected function getUserDao()
	{
		return $this->Application->Modules['daos']->getDao('UserDao');
	}
	
	protected function getWorkerDao()
	{
		return $this->Application->Modules['daos']->getDao('WorkerDao');
	}
	
	/**
	 * Sets the default new user roles, default role is set in config.xml
	 */
	public function onLoad($param)
	{
		if(!$this->IsPostBack)
		{
			$this->role->DataSource = $this->getRoles();
			$this->role->dataBind();
		}
	}
	
	protected function getYear()
	{
		$date = getdate();
		return $date['year'];
	}
	
	public function getRoles()
	{ 
		$roles = array();
		$roles['admin'] = "Administrador";
		$roles['personal'] = "Jefe de personal";
		$roles['manager'] = "Jefe de proyecto";
		foreach ($this->getWorkerDao()->getAllRoles() as $role){ 
			if ($role != 'Jefe de proyecto')
				$roles[$role] = $role;
		}
		return $roles;
	}
	
	/**
	 * Verify that the username is not taken.
	 * @param TControl custom validator that created the event.
	 * @param TServerValidateEventParameter validation parameters.
	 */
	public function checkUsername($sender, $param)
	{
		if($this->getUserDao()->usernameExists($this->username->Text))
		{
			$param->IsValid = false;
			$sender->ErrorMessage =	"Ese nombre ya existe, utilice '{$this->username->Text}01'";
		}
	}
	
	/**
	 * Create a new user if all data entered are valid.
	 * @param TControl button control that created the event.
	 * @param TEventParameter event parameters.
	 */
	public function createNewUser($sender, $param)
	{
		if($this->IsValid)
		{
			// configure the user
			$newUser = new SeprosoUser($this->User->Manager);
			$newUser->EmailAddress = $this->email->Text;
			$newUser->Name = $this->username->Text;
			$newUser->IsGuest = false;
			if ($this->role->SelectedValue == 'admin' ||
				$this->role->SelectedValue == 'manager' ||
				$this->role->SelectedValue == 'personal')
				$newUser->Roles = $this->role->SelectedValue;
			else
				$newUser->Roles = 'developer';
				
	
			// save the user
			$this->getUserDao()->addNewUser($newUser, $this->password->Text);
			
			if ($this->role->SelectedValue == 'admin' ||
				$this->role->SelectedValue == 'personal')
				return;
				
			// configure the worker
			$newWorker = new WorkerRecord();
			$newWorker->UserID = $this->username->Text;
			$newWorker->RoleID = $this->role->SelectedItem->Text;
			$newWorker->Name = $this->name->Text;
			$newWorker->Surname = $this->surname->Text;
			$newWorker->BirthDate = $this->birthDate->TimeStamp;
			
			// save the worker
			$this->getWorkerDao()->addNewWorker($newWorker);
		}
	}
}

?>