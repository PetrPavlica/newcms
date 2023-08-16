<?php

namespace App\Model;

class PeopleModel extends BaseModel{
    
    public function allPeople() {
       return $this->database->table('people');
    }
    
     public function addUser($data){
        return $this->database->table('users')->insert($data);
    }
    
    public function addPeople($data){
        return $this->database->table('people')->insert($data);
    }
    
    public function allPeopleActive() {
       return $this->database->table('people')->where('active',1);
   }
   
   public function peopleSelector(){
        return $this->database->table('people')->fetchPairs('id','name');
   }
}
