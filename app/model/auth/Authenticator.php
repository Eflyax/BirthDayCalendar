<?php

namespace Model;

use Kdyby;
use Nette;
use Nette\Security\Passwords;
use Nette\Utils\Strings;

/**
 * Class Authenticator
 * @package Model
 */
class Authenticator extends Nette\Object implements Nette\Security\IAuthenticator
{

	private $users;

    /**
     * @param Users $users
     */
	public function __construct(Users $users)
	{
		$this->users = $users;
    }

	/**
	 * @param array $credentials
	 *
	 * @return Nette\Security\Identity|Nette\Security\IIdentity
	 * @throws \Nette\Security\AuthenticationException
	 */
	public function authenticate(array $credentials)
	{
		list($email, $password) = $credentials;
		$password = $this->removeCapsLock($password);
		$user = $this->users->findOneBy(['email' => $email]);


		if (!$user) {
			throw new Nette\Security\AuthenticationException('Tento e-mail nebyl nalezen', self::IDENTITY_NOT_FOUND);
		} elseif (!Passwords::verify($password, $user->password)) {
			throw new Nette\Security\AuthenticationException('Špatné heslo', self::INVALID_CREDENTIAL);
		} elseif (Passwords::needsRehash($user->password)) {
			$user->password = Passwords::hash($password);
			$this->users->save($user);
		} else {

            $user_data = $this->getUserDataFromEntity($user);
            return new Nette\Security\Identity($user->getId(), $user->role, $user_data);
		}
	}

	/**
	 * Fixes caps lock accidentally turned on.
	 *
	 * @param $password
	 *
	 * @return mixed
	 */
	private function removeCapsLock($password)
	{
		return $password === Strings::upper($password) ? Strings::lower($password) : $password;
	}

    /**
     * @param $user
     * @return array
     */
    private function getUserDataFromEntity($user)
    {
        $user_data = [
            'email' => $user->email,
        ];
        return $user_data;
    }

}
