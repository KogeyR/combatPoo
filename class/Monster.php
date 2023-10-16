<?php

class Monster
{ 
    private $name;
    private $health_point;

    public function __construct($name)
    {
        $this->name = $name;
        $this->health_point = 100;
    }

    public function hit(Hero $hero)
    {
        $damage = rand(10,40);
        $heroHealthPoint = $hero->getHealthPoint();
        $hero->setHealthPoint($heroHealthPoint - $damage);
        return $damage;

    }
    
    public function getName()
    {
        return $this->name;
    }


    public function setName($name): self
    {
        $this->name = $name;

        return $name;
    }

   
    public function getHealthPoint()
    {
        return $this->health_point;
    }


    public function setHealthPoint($health_point): self
    {
        $this->health_point = $health_point;

        return $this;
    }


    
}

