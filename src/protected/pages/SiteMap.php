<?php
/**
 * SiteMap template class file.
 *
 * @author Wei Zhuo <weizhuo[at]gmail[dot]com>
 * @link http://www.pradosoft.com/
 * @copyright Copyright &copy; 2005-2006 PradoSoft
 * @license http://www.pradosoft.com/license/
 * @version $Id: SiteMap.php 1400 2006-09-09 03:13:44Z wei $
 * @package Demos
 */

/**
 * SiteMap menu is rendered depending on user roles.
 *
 * @author Wei Zhuo <weizhuo[at]gmail[dot]com>
 * @version $Id: SiteMap.php 1400 2006-09-09 03:13:44Z wei $
 * @package Demos
 * @since 3.1
 */
class SiteMap extends TTemplateControl
{
	/** 
	 * Check actual view type to show user operations
	 * @param view view type
	 * @return boolean is visible?
	 */
	public function isViewType($view)
	{
		if ($this->User->getIsGuest()) return false;
		return $this->Session['view'] === $view;
	}
	
	/**
	 * Change current view for manager to developer view
	 * @param $sender TButton
	 * @param $param User clic
	 */
	public function changeToDeveloperView($sender, $param)
	{
		$this->Session['view'] = 'developer';
		$url = $this->Service->constructUrl('User.Home');
		$this->Response->redirect($url);
	}
	
	/**
	 * Change current view for manager to propertly manager view
	 * @param $sender TButton
	 * @param $param User click
	 */
	public function changeToManagerView($sender, $param)
	{
		$this->Session['view'] = 'manager';
		$url = $this->Service->constructUrl('User.Home');
		$this->Response->redirect($url);
	}
	
	/**
	 * Sets the active menu item using css class.
	 */
	public function onPreRender($param)
	{
		parent::onPreRender($param);
		
		$page = explode('.',$this->Request->ServiceParameter);
		$active = null;
		switch($page[count($page)-1])
		{
			case 'UserList':
			case 'UserCreate':
				$active = $this->UserAdminMenu;
				break;
			case 'ProjectList':
			case 'ProjectCreate':
				$active = $this->ProjAdminMenu;
				break;
			case 'Configuration':
				$active = $this->ConfMenu;
				break;
			case 'Phases':
			case 'Activities':
			case 'Workers':
				$active = $this->ProjectMenu;
				break;
			case 'MonitorAct':
				$active = $this->ActManagementMenu;
				break;
			case 'ReportList':
				$active = $this->ReportManagerMenu;
				break;
			case 'WorkRegister':
				$active = $this->ActRegisterMenu;
				break;
			case 'WorkRegisters':
			case 'Summary':
				$active = $this->ReportDeveloperMenu;
				break;
			case 'Holidays':
				$active = $this->HolidaysMenu;
				break;
			case 'Worker':
				$active = $this->ReportWorkerMenu;
				break;
			default:
				$active = $this->ReportWorkersMenu;
				break;
		}
		
		// add 'active' string to place holder body.
		if(!is_null($active))
			$active->Controls[] = 'active';
	}
}

?>