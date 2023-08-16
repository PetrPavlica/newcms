<?php

namespace App\AdminModule\Presenters;

class PeoplePresenter extends BasePresenter{
    
    /** @var \IPeopleFactory @inject */
    public $peopleControl;
    
    /** @var \IPeopleFormFactory @inject */
    public $peopleFormControl;
    
    /** @var \IFindPeopleFormFactory @inject */
    public $findPeopleFormControl;
    
    /** @var \IPeopleInfFormFactory @inject */
    public $peopleInfFormControl;
    
    protected function createComponentPeople(): \PeopleComponent {
        
        $component = $this->peopleControl->create();
        
        return $component;
    }
    
    protected function createComponentPeopleForm(): \PeopleForm {
        
        $component = $this->peopleFormControl->create($this->getParameter('wwwDir'));
        $component->onPeopleFormSave[] = function ($data) {
                    $this->redirect('People:peopleinf',$data['id']);
		};
        return $component;
    }
    
    protected function createComponentFindPeopleForm(): \FindPeopleForm {
        
        $component = $this->findPeopleFormControl->create();
        $component->onFindPeopleFormSave[] = function ($data) {
                    $this->redirect('People:peoplefinded',$data['ids'],$data['find']);
		};
        return $component;
    }
    
    protected function createComponentPeopleInfForm(): \PeopleInfForm {
        
        $component = $this->peopleInfFormControl->create($this->getParameter('wwwDir'),$this->getParameter('id'));
        return $component;
    }
    
        public function renderDriver($id,$day,$make):void{

        }
        
        public function renderPeopleInf($id):void{
        
        
    }
}