<?php
class User
{
  public $id;
  public $username;
  public $password;
  public $email;
  public $firstName;
  public $lastName;
  public $specification;
  public $year;
  public $facultyNumber;

  public function __construct($id, $username, $password, $email, $firstName, $lastName, $specification, $year, $facultyNumber)
  {
    $this->id = $id;
    $this->username = $username;
    $this->password = $password;
    $this->email = $email;
    $this->firstName = $firstName;
    $this->lastName = $lastName;
    $this->specification = $specification;
    $this->year = $year;
    $this->facultyNumber = $facultyNumber;
  }
}
