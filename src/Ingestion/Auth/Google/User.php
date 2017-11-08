<?php

namespace Ingestion\Auth\Google;

class User
{
	private $user;

	public function __construct($user)
	{
		$this->user = $user;
	}

	public function getDomain(): string
	{
		return $this->user->hd;
	}

	public function getFirstName(): string
	{
		return $this->user->givenName;
	}


	public function getLastName(): string
	{
		return $this->user->familyName;
	}

	public function getEmail(): string
	{
		return $this->user->email;
	}

	public function getId(): string
	{
		return $this->user->id;
	}

	public function getPhotoUrl(): string
	{
		return $this->user->picture;
	}

	public function getName(): string
	{
		return $this->user->name;
	}
}