<?php
namespace App\Model;

use Nette;

class SignModel implements Nette\Security\IAuthenticator
{
	private $database;
	private $passwords;

	public function __construct(Nette\Database\Context $database, Nette\Security\Passwords $passwords)
	{
		$this->database = $database;
		$this->passwords = $passwords;
	}

	public function authenticate(array $credentials): Nette\Security\IIdentity
	{
		//[$email, $password] = $credentials;
                bdump($credentials);
		$row = $this->database->table('users')
			->where('email', $credentials[0])
			->fetch();

		if (!$row) {
			throw new Nette\Security\AuthenticationException('User not found.');
                        
		}

		if (!$this->passwords->verify($credentials[1], $row->password)) {
			throw new Nette\Security\AuthenticationException('Invalid password.');
		}
                
                

                
		return new Nette\Security\Identity(
			$row->id,
                        $row->role,
                        ['name' => $row->email]
                        );
                
	}
}
