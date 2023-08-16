<?php

class FindPeopleForm extends Nette\Application\UI\Control
{
    private $peopleData;
    
    private $factory;
    public $onFindPeopleFormSave;
    public $pozition = array(1=>'Super admin',
                             2=>'Admin');
    private $id=0;
    private $action = 'find';     
   
    public function __construct(App\Model\PeopleModel $peopleData,\App\Forms\FormFactory $factory)
    {
        $this->peopleData = $peopleData;
        $this->factory = $factory;
    }

    public function createComponentFindPeopleForm() 

    {
        $form = $this->factory->create();
        $autocompleteInput = $form->addAutocomplete('nametest','nametest', function(string $query){
             $movies = ['Star Wars', 'Star Trek', 'Star Gate',];

            $matches = [];
            foreach ($movies as $movie) {
                if (strpos(strtolower($movie), strtolower($query)) !== false) {
                    $matches[] = $movie;
                }
            }
            return $matches;
            
        });
        $autocompleteInput->setAutocompleteMinLength(3);
        $form->addText('name','Jméno:')
                        ->setRequired('Zadejte jméno');
        
        $form->addSelect('pozition','Pozice:',$this->pozition)
                        ->setRequired('Zadejte pozici');
                
        $form->addText('phone','Telefon:')
                        ->setRequired('Zadejte telefon');
        
        $form->addText('email','Email:')
                        ->setRequired('Zadejte email');        
        
        $form->addText('date_start','Od:');
        $form->addHidden('id',$this->id);
        $form->addHidden('action',$this->action);
        
        $form->addSubmit('send', 'Uložit')
        ->setAttribute('class', 'btn btn-info btn-sm');   

       
        $form->onSuccess[] = [$this, 'processFindPeopleForm'];
        return $form;
    }

    public function processFindPeopleForm($form)
    {
             
        $data = $form->getValues(); 
        
        $this->onFindPeopleFormSave($save);
        
    }
    
    public function render(){
       $this->template->render(__DIR__ .'/findpeopleform.latte');
       //$this->template->render();`
    }
}

/** rozhrannĂ­ pro generovanou tovĂˇrniÄŤku */
interface IFindPeopleFormFactory
{
    /** @return \FindPeopleForm */
    function create(): FindPeopleForm;
}
