<?php
/**
 * Logout class file.
 *
 * @author Grupo3 - ISO2 -UVA
 * @version 1.0
 */

class Logout extends TPage
{
	/**
	 * Logs out the current user and redirect to default page.
	 */
	function onLoad($param)
	{
		$this->Application->getModule('auth')->logout();
		$url = $this->Service->constructUrl($this->Service->DefaultPage);
		$this->Response->redirect($url);		
	}
}

?>