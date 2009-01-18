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
	/**
	 * Sets the default new user roles, default role is set in config.xml
	 */
	public function onLoad($param)
	{
		if(!$this->IsPostBack)
		{
			$this->role->DataSource = $this->getUserDao()->getAllRoles();;
			$this->role->dataBind();
		}
	}
	
	protected function getUserDao()
	{
		return $this->Application->Modules['daos']->getDao('UserDao');
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
	 * The default user roles are obtained from "config.xml". The new user
	 * details is saved to the database and the new credentials are used as the
	 * application user. The user is redirected to the requested page.
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
			switch ($this->role->SelectedValue){
				case 1:	$newUser->Roles = 'manager'; break;
				case 8:	$newUser->Roles = 'personal'; break;
				default:$newUser->Roles = 'developer'; break;
			}
	
			// save the user
			$this->getUserDao()->addNewUser($newUser, $this->password->Text);
			
			// configure the worker
			$newWorker = new WorkerRecord();
			$newWorker->UserID = $this->username->Text;
			$newWorker->RoleID = $this->role->SelectedValue;
			$newWorker->Name = $this->name->Text;
			$newWorker->Surname = $this->surname->Text;
			$newWorker->BirthDate = $this->birthDate->TimeStamp;
			
			// save the worker
			$this->getUserDao()->addNewWorker($newWorker);
		}
	}
}

?>