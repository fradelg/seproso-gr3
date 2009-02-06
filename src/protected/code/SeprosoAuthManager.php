<?php
/**
 * Custom Authentication manager permits authentication using
 * a string token saved in the cookie.
 * SEPROSO doesn`t use this function due to database 'signon' required
 *
 * @author Grupo3 - ISO 2 - UVA
 */
class SeprosoAuthManager extends TAuthManager
{
	/**
	 * @const string signon token cookie name.
	 */
	const SignonCookieName = 'seproso-signon';
	
	/**
	 * Performs the real authentication work. Overrides and calls parent
	 * implementation. Trys to authenticate using token saved in cookie. 
	 * @param mixed parameter to be passed to OnAuthenticate event
	 */
	public function onAuthenticate($param)
	{
		parent::onAuthenticate($param);
		$currentUser = $this->Application->User; 
		if(!$currentUser || $currentUser->IsGuest)
			$this->authenticateFromCookie($param);
	}
	
	/**
	 * If the user is not set or is still a guest, try to authenticate the user
	 * using a string token saved in the cookie if any.
	 * @param mixed parameter to be passed to OnAuthenticate event 
	 */
	protected function authenticateFromCookie($param)
	{
		$cookie = $this->Request->Cookies[self::SignonCookieName];
		if(!is_null($cookie))
		{
			$daos = $this->getApplication()->getModule('daos');
			$userDao = $daos->getDao('UserDao');
			$user = $userDao->validateSignon($cookie->Value);
			if($user instanceof SeprosoUser)
				$this->updateCredential($user);
		}
	}
	
	/**
	 * Changes the user credentials.
	 * @param TUser new user details.
	 */
	public function updateCredential($user)
	{
		$user->IsGuest = false;
		$this->updateSessionUser($user);
		$this->Application->User = $user;		
	}
	
	/**
	 * Generate a token to be saved in the cookie for later authentication.
	 * @param SeprosoUser user details.
	 */
	public function rememberSignon($user)
	{
		$daos = $this->getApplication()->getModule('daos');
		$userDao = $daos->getDao('UserDao');
		$token = $userDao->createSignonToken($user);
		$cookie = new THttpCookie(self::SignonCookieName, $token);
		$cookie->Expire = strtotime('+1 month');
		$this->Response->Cookies[] = $cookie;
	}
	
	/**
	 * Logs out the user and delete the token from cookie.
	 */
	public function logout()
	{
		parent::logout();
		$cookie = new THttpCookie(self::SignonCookieName,'');
		$this->Response->Cookies[] = $cookie;
	}
}

?>