<?php
/**
 * User Dao class file.
 *
 * @author Wei Zhuo <weizhuo[at]gmail[dot]com>
 * @link http://www.pradosoft.com/
 * @copyright Copyright &copy; 2005-2006 PradoSoft
 * @license http://www.pradosoft.com/license/
 * @version $Id: UserDao.php 1578 2006-12-17 22:20:50Z wei $
 * @package Demos
 */

/**
 * UserDao class list, create, find and delete users.
 * In addition, it can validate username and password, and update
 * the user roles. Furthermore, a unique new token can be generated,
 * this token can be used to perform persistent cookie login.
 *
 * @author Wei Zhuo <weizhuo[at]gmail[dot]com>
 * @version $Id: UserDao.php 1578 2006-12-17 22:20:50Z wei $
 * @package Demos
 * @since 3.1
 */
class UserDao extends BaseDao
{
	/**
	 * @param string username
	 * @return SeprosoUser find by user name, null if not found or disabled.
	 */
	public function getUserByName($username)
	{
		$sqlmap = $this->getSqlMap();
		return $sqlmap->queryForObject('GetUserByName', $username);
	}
	
	/**
	 * @param string username
	 * @return string project name
	 */
	public function getProject($username)
	{
		$sqlmap = $this->getSqlMap();
		return $sqlmap->queryForObject('GetProject', $username);
	}
	
	/**
	 * @param string Worker username
	 * @return Project name array list
	 */
	public function getProjectsByUser($username)
	{
		$sqlmap = $this->getSqlMap();
		return $sqlmap->queryForList('GetProjectsByUser', $username);
	}

	/**
	 * @param string username
	 * @return boolean true if username already exists, false otherwise.
	 */
	public function usernameExists($username)
	{
		$sqlmap = $this->getSqlMap();
		return $sqlmap->queryForObject('UsernameExists', $username);
	}

	/**
	 * @return array list of all enabled users.
	 */
	public function getAllUsers()
	{
		$sqlmap = $this->getSqlMap();
		return $sqlmap->queryForList('GetAllUsers');
	}

	/**
	 * @param SeprosoUser new user details.
	 * @param string new user password.
	 */
	public function addNewUser($user, $password)
	{
		$sqlmap = $this->getSqlMap();
		$param['user'] = $user;
		$param['password'] = $password;
		foreach ($user->getRoles() as $role)
			$param['role'] = $role;
		$sqlmap->insert('AddNewUser', $param);
	}

	/**
	 * @param string username to delete
	 */
	public function deleteUserByName($username)
	{
		$sqlmap = $this->getSqlMap();
		$sqlmap->delete('DeleteUserByName', $username);
	}

	/**
	 * Updates the user profile details, including user roles.
	 * @param SeprosoUser updated user details.
	 */
	public function updateUser($user)
	{
		$sqlmap = $this->getSqlMap();
		$param['user'] = $user;
		foreach ($user->getRoles() as $role)
			$param['role'] = $role;
		$sqlmap->update('UpdateUser', $param);
	}
	
	/**
	 * Updates user last working project
	 * @param user username
	 * @param project project name
	 */
	public function updateProject($user, $project)
	{
		$sqlmap = $this->getSqlMap();
		$param['user'] = $user;
		$param['project'] = $project;
		$sqlmap->update('UpdateCurrentProject', $param);
	}

	/**
	 * @param string username to be validated
	 * @param string matching password
	 * @return boolean true if the username and password matches.
	 */
	public function validateUser($username, $password)
	{
		$sqlmap = $this->getSqlMap();
		$param['username'] = $username;
		$param['password'] = $password;
		return $sqlmap->queryForObject('ValidateUser', $param);
	}

	/**
	 * @param string unique persistent session token
	 * @return SeprosoUser user details if valid token, null otherwise.
	 */
	public function validateSignon($token)
	{
		$sqlmap = $this->getSqlMap();
		$sqlmap->update('UpdateSignon', $token);
		return $sqlmap->queryForObject('ValidateAutoSignon', $token);
	}

	/**
	 * @param SeprosoUser user details to generate the token
	 * @return string unique persistent login token.
	 */
	public function createSignonToken($user)
	{
		$sqlmap = $this->getSqlMap();
		$param['username'] = $user->getName();
		$param['token'] = md5(microtime().$param['username']);
		$sqlmap->insert('RegisterAutoSignon', $param);
		return $param['token'];
	}

	/**
	 * @param SeprosoUser deletes all signon token for given user, null to delete all
	 * tokens.
	 */
	public function clearSignonTokens($user=null)
	{
		$sqlmap = $this->getSqlMap();
		if($user !== null)
			$sqlmap->delete('DeleteAutoSignon', $user->getName());
		else
			$sqlmap->delete('DeleteAllSignon');
	}

	/**
	 * @param SeprosoUser user details for updating the assigned roles.
	 */
	public function updateUserRoles($user)
	{
		$sqlmap = $this->getSqlMap();
		$sqlmap->delete('DeleteUserRoles', $user);
		foreach($user->getRoles() as $role)
		{
			$param['username'] = $user->getName();
			$param['role'] = $role;
			$sqlmap->update('AddUserRole', $param);
		}
	}
}

?>