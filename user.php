<?php 

class User 
{
    private $id;
    private $name;
    private $pass;
    private $pass_2;
    
    public function id()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function name()
    {
        return $this->name;
    }

    public function setName($name)
    {   
        $toLower = strtolower($name);
        $filter = filter_var($toLower, FILTER_SANITIZE_STRING);
        $this->name = $filter;
    }

    public function password()
    {
        return $this->pass;
    }

    public function setPassword($password)
    {
        $this->pass = $password;
    }

    public function password2()
    {
        return $this->pass_2;
    }

    public function setPassword2($pass_2)
    {
        $this->pass_2 = $pass_2;
    }

}