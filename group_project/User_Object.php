<?php

class User_Object {
   private $first_name;
   private $middle_name;
   private $last_name;
   private $email;
   private $phone;
   private $password;


    public function __construct($first_name,$middle_name,$last_name,
                                $email,$phone,$password)
    {
      $this->first_name = $first_name;
      $this->middle_name = $middle_name;
      $this->last_name = $last_name;
      $this->email = $email;
      $this->phone = $phone;
      $this->password = $password;
    }

    public function get_first_name(){return $this->first_name;}
    public function get_middle_name(){return $this->middle_name;}
    public function get_last_name(){return $this->last_name;}
    public function get_email(){return $this->email;}
    public function get_phone_number(){return $this->phone;}
    public function get_password(){return $this->password;}

    public function set_first_name(string $first_name){$this->first_name = $first_name;}
    public function set_middle_name(string $middle_name){$this->middle_name = $middle_name;}
    public function set_last_name(string $last_name){$this->last_name = $last_name;}
    public function set_email(string $email){$this->email = $email;}
    public function set_phone_number(int $phone){$this->phone = $phone;}
    public function set_password(string $password){$this->password = $password;}

    public function __toString()
    {
        $mn = "";
        if($this->middle_name === null){
           $mn.="N/A";
        }else{
            $mn.=$this->middle_name;
        }
        $body=<<<EOBODY
        <em>Information</em><br>
        <b>First Name : </b>$this->first_name<br>
        <b>Middle Name : </b>$mn<br>
        <b>Last Name : </b>$this->last_name<br>
        <b>Email : </b>$this->email<br>
        <b>Phone number : </b>$this->phone<br>        
EOBODY;
        return $body;
    }

}