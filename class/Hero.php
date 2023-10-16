<?php

class Hero
{
    private $id;
    private $type;
    private $name;
    private $health_point = 100;

    public function __construct(array $data)
    {
        if (isset($data['id'])) {

        $this->id = $data['id'];
    }
        if (isset($data['type']))
         {
        $this->type = $data['type'];
    }
        if (isset($data['name']))
         {
        $this->name = $data['name'];
    }
        if (isset($data['health_points'])) {
        $this->health_point = $data['health_points'];}

    }

    public function hit(Monster $monster)
    {
        $damage = rand(10,30);
        $monsterHealthPoint = $monster->getHealthPoint();
        $monster->setHealthPoint($monsterHealthPoint - $damage);
        return $damage;

    }
    
    public function getName()
    {
        return $this->name;
    }


    public function setName($name): self
    {
        $this->name = $name;

        return $this;
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

 
    public function getId()
    {
        return $this->id;
    }

    public function setId($id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getType()
    {
        return $this->type;
    }

    
    public function setType($type): self
    {
        $this->type = $type;

        return $this;
    }
}


