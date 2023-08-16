<?php

class PeopleComponent extends Nette\Application\UI\Control
{
    private $peopleData;
    
    public function __construct(App\Model\PeopleModel $peopleData)
    {
        $this->peopleData = $peopleData;
    }
    
    public function render():void{
        
        $allPeople = $this->peopleData->allPeople();
        $this->template->allPeople = $allPeople;
        $this->template->render(__DIR__ .'/allpeople.latte');
    }
}

/** creator */
interface IPeopleFactory
{
    /** @return \PeopleComponent */
    function create(): PeopleComponent;
}

