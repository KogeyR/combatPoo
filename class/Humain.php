<?php

class Humain extends Hero
{
    
    
    public function __construct(array $data)
    {
        parent::__construct($data);
    }

    public function specialAttack(Monster $monster)
    {
        $damage = rand(20, 30);
        $monsterHealthPoint = $monster->getHealthPoint();
        $monster->setHealthPoint($monsterHealthPoint - $damage);
        return $damage;
    }
 

}