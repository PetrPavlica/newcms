<?php

use App\Model\PeopleModel;
use Nette\Utils\Image;
use Nette\Security\Passwords;
class PeopleInfForm extends Nette\Application\UI\Control
{
    private $peopleData;
    
    private $factory;
    
    private $dir;
    private $passwords;        
    public $onPeopleInfSave;
    
    private $id;
            
    public function __construct(Nette\Security\Passwords $passwords,App\Model\PeopleModel $peopleData,\App\Forms\FormFactory $factory,$dir,$id)
    {
        $this->passwords = $passwords;
        $this->peopleData = $peopleData;
        $this->factory = $factory;
        $this->dir = $dir;
        $this->id = $id;
    }
    
    
    
    public function createComponentPeopleInfForm() 

    {
        $form = $this->factory->create();
               
        $form->addText('city','Mesto:');
         
        $form->addText('street','Ulice:');
          
        $form->addText('cp','Cp:');
        
        $form->addText('psc','Psc:');
        
        $form->addText('bank_number','Cislo uctu:');
        
        $form->addText('crp','Cislo rp:');
        
        $form->addUpload('photo','Photo:');
        
        $form->addHidden('id',$this->id);
        
        $form->addSubmit('send', 'Uložit')
        ->setAttribute('class', 'btn btn-info btn-sm');   

       
        $form->onSuccess[] = [$this, 'processForm'];
        return $form;
    }

    public function processForm($form)
    {
    
        
        $saveData = $form->getValues();
        unset($saveData['crp']);
        unset($saveData['photo']);
        unset($saveData['driver_op_front']);
        unset($saveData['driver_op_next']);
        $saveDataInf = $this->peopleData->addPeopleInf($saveData);
        $file = $form['photo']->getValue();
        if(!$file){
        $count = $this->peopleData->countName($form['name']->getValue());
        $file_ext=strtolower(mb_substr($file->getSanitizedName(), strrpos($file->getSanitizedName(), ".")));
        $file_name = $form['name']->getValue().$count.$file_ext;
    
        $path = $this->dir.'/images/origin/'.$file_name;
        $form['photo']->getValue()->move($path);
        
        $image_s = Image::fromFile($path);
        $image_s->resize(152,152);
        $path = $this->dir.'/img/152x152/'.$file_name;
        $image_s->save($path);
        }       
        $this->onPeopleInfSave($this, $saveDataInf);
        $this->presenter->redirect('People:people');

    }
    
    public function render(){
       $this->template->id = $this->id;  
       $this->template->render(__DIR__ .'/peopleinfform.latte');
       //$this->template->render();
    }
}

/** rozhrannĂ­ pro generovanou tovĂˇrniÄŤku */
interface IPeopleInfFormFactory
{
    /** @return \PeopleInfForm */
    function create($dir,$id): PeopleInfForm;
}
