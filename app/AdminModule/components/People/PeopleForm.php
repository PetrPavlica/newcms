<?php

use Nette\Security\Passwords;
class PeopleForm extends Nette\Application\UI\Control
{
    private $peopleData;
    
    private $factory;
    private $passwords;        
    public $onPeopleFormSave;
    public $pozition = array(1=>'Super admin',
                             2=>'Admin');
    private $id=0;
    private $action = 'new';     
   
    public function __construct(Nette\Security\Passwords $passwords,App\Model\PeopleModel $peopleData,\App\Forms\FormFactory $factory)
    {
        $this->passwords = $passwords;
        $this->peopleData = $peopleData;
        $this->factory = $factory;
    }
    
    public function handlenext($id){
        $this->redirect('PeopleInfForm:edit!');
    }
    
    public function handleedit($id){
        $data_default = $this->peopleData->peopleById($id);
        $this['peopleForm']->setDefaults($data_default);
        $this->id = $id;
        $this->action = 'edit';
    }

    
    public function createComponentPeopleForm() 

    {
        $form = $this->factory->create();
        
        $form->addText('name','Jméno:')
                        ->setRequired('Zadejte jméno');
        
        $form->addSelect('pozition','Pozice:',$this->pozition)
                        ->setRequired('Zadejte pozici');
                
        $form->addText('phone','Telefon:')
                        ->setRequired('Zadejte telefon');
        
        $form->addText('email','Email:')
                        ->setRequired('Zadejte email');
        
        $form->addText('password','Heslo:')
                        ->setRequired('Zadejte heslo');
        
        
        $form->addText('date_start','Od:');
        $form->addHidden('id',$this->id);
        $form->addHidden('action',$this->action);
        
        $form->addSubmit('send', 'Uložit')
        ->setAttribute('class', 'btn btn-info btn-sm');   

       
        $form->onSuccess[] = [$this, 'processForm'];
        return $form;
    }

    public function processForm($form)
    {
             
        $data = $form->getValues(); 
        unset($data['action']);
        unset($data['people_id']);
        unset($data['date_start']);
        unset($data['driver_for']);
        if($form['action']->getValue() == 'new'){
           
         $data['password'] = $this->passwords->hash($form['password']->getValue());
         $this->peopleData->addUser($data);
         $save = $this->peopleData->addPeople($data);
            
        }
        else{
            $save = $this->peopleData->updatePeople($form['id']->getValue(),$data);
        }
        $this->onPeopleFormSave($save);
        
    }
    
    public function render(){
       $this->template->render(__DIR__ .'/peopleform.latte');
       //$this->template->render();`
    }
}

/** rozhrannĂ­ pro generovanou tovĂˇrniÄŤku */
interface IPeopleFormFactory
{
    /** @return \PeopleForm */
    function create(): PeopleForm;
}
