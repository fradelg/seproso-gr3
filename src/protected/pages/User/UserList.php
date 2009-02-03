<?php
/**
 * UserList page class file.
 *
 * @author Wei Zhuo <weizhuo[at]gmail[dot]com>
 * @link http://www.pradosoft.com/
 * @copyright Copyright &copy; 2005-2006 PradoSoft
 * @license http://www.pradosoft.com/license/
 * @version $Id: UserList.php 1400 2006-09-09 03:13:44Z wei $
 * @package Demos
 */

/**
 * List all users in a repeater.
 *
 * @author Wei Zhuo <weizhuo[at]gmail[dot]com>
 * @version $Id: UserList.php 1400 2006-09-09 03:13:44Z wei $
 * @package Demos
 * @since 3.1
 */
class UserList extends TPage
{
	protected function getUserDao()
	{
		return $this->Application->Modules['daos']->getDao('UserDao');
	}
	
	protected function getWorkerDao()
	{
		return $this->Application->Modules['daos']->getDao('WorkerDao');
	}
	
	protected function getYear()
	{
		$date = getdate();
		return $date['year'];
	}
	
	/**
	 * Load all the users and display them in a repeater.
	 */
	function onLoad($param)
	{
		if(!$this->IsPostBack) $this->showList();
	}
	
	protected function showList()
	{
		$this->list->DataSource = $this->getWorkerDao()->getAllWorkers();
		$this->list->dataBind(); 	
	}
	
	public function editEntryItem($sender, $param)
	{
		$this->list->EditItemIndex = $param->Item->ItemIndex;
		$this->showList();
	}
	
	public function refreshEntryList()
	{
		$this->list->EditItemIndex = -1;
		$this->showList();
	}
			
	public function updateEntryItem($sender, $param)
	{		
		if(!$this->Page->IsValid)
			return;
			
		$item = $param->Item;
		$id = $this->list->DataKeys[$item->ItemIndex];

		$worker = new WorkerRecord;
		$worker->UserID = $id;
		$worker->RoleID = $param->Item->role->SelectedValue;
		$worker->Name = $param->Item->name->Text;
		$worker->Surname = $param->Item->surname->Text;
		$worker->BirthDate = $param->Item->date->TimeStamp;	
		$this->getWorkerDao()->updateWorker($worker);
		
		$user = new SeprosoUser($this->User->Manager);
		$user->Name = $id;
		$user->Password = $param->Item->password->Text;
		$user->EmailAddress = $param->Item->email->Text;
		if ($param->Item->role->SelectedItem->Text == 'Jefe de proyecto')
			$user->Roles = "manager";
		else if ($param->Item->role->SelectedItem->Text == 'Jefe de personal')
			$user->Roles = "personal";
		else
			$user->Roles = "developer";
		$this->getUserDao()->updateUser($user);
		
			
		// update table
		$this->refreshEntryList();
	}

	public function deleteEntryItem($sender, $param)
	{
		$id = $this->list->DataKeys[$param->Item->ItemIndex];
		if (!$this->getWorkerDao()->workerHasProject($id))
			$this->getWorkerDao()->deleteWorker($id);
		else
			$this->views->ActiveViewIndex = 1;
		$this->refreshEntryList($sender, $param);
	}
	
	public function EntryItemCreated($sender, $param)
	{
		if($param->Item->ItemType == 'EditItem' && $param->Item->DataItem)
		{
			$param->Item->role->DataSource = 
				$this->getRoles($param->Item->DataItem->RoleID);	
			$param->Item->role->dataBind();
			$param->Item->role->SelectedValue = $param->Item->DataItem->RoleID;
		}
	}
	
	public function getRoles($minRole){
		$roles = array();
		$greaterRoles = $this->getWorkerDao()->getGreaterRoles($minRole);
		foreach ($greaterRoles as $role) 
			$roles[$role] = $role; 
		return $roles;
	}
}

?>