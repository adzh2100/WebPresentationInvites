<?php
class User
{
  public $id;
  public $username;
  public $password;
  public $email;
  public $firstName;
  public $lastName;
  public $role;
  public $facultyNumber;

  public function __construct($id, $username, $password, $email, $firstName, $lastName, $role, $facultyNumber)
  {
    $this->id = $id;
    $this->username = $username;
    $this->password = $password;
    $this->email = $email;
    $this->firstName = $firstName;
    $this->lastName = $lastName;
    $this->role = $role;
    $this->facultyNumber = $facultyNumber;
  }
}
