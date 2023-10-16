<?php

class FightsManager {


    public function create_Monster($monster)
    {
        $monster = new Monster($monster);
        return $monster;
    }
    
    public function fight(Hero $hero, Monster $monster)
    {
        $history = [];
        while ($hero->getHealthPoint() > 0 && $monster->getHealthPoint() > 0) {
            $damage = $monster->hit($hero);
            $history[] =  $monster->getName().' a frappé le '. $hero->getName() .' et lui a infligé ' . $damage . ' points de vie';

            $damage = $hero->hit($monster);
            $history[] = $hero->getName() .' a frappé le '. $monster->getName() .' et lui a infligé ' . $damage . ' points de vie';

        }
        return $history;
    
}
}