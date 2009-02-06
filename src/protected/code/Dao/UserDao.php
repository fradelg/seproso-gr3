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
	 * @param string project name
	 * @return string user role in this project
	 */
	public function getRoleInProject($username, $project)
	{
		$sqlmap = $this->getSqlMap();
		$param['user'] = $username;
		$param['project'] = $project;
		return $sqlmap->queryForObject('GetRoleInProject', $param);
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
}

?>