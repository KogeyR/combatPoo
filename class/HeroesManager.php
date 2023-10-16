<?php
class HeroesManager
{
    private $db;
    protected $imagePath;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function add(Hero $hero)
{
    $req = $this->db->prepare("INSERT INTO heroes (name, type) VALUES (:name, :type)");
    $req->bindValue(':name', $hero->getName());
    $req->bindValue(':type', $hero->getType());
    $req->execute();
    $hero->setId($this->db->lastInsertId());
}
    

    public function deleteHero(Hero $hero)
    {
        $name = $hero->getName();

        $stmt = $this->db->prepare("DELETE FROM heroes WHERE name =?");
        $stmt->execute([$name]);
    }

    public function findAllAlive()
    {
        $stmt = $this->db->query("SELECT * FROM heroes WHERE health_points > 0");

        $heroes = array();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $hero = new Hero($row);
            $heroes[] = $hero;
        }

        return $heroes;
    }

    public function findAllDead()
    {
        $stmt = $this->db->query("SELECT * FROM heroes WHERE health_points <= 0");

        $heroes = array();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) 
        {
            $hero = new Hero($row);
            $heroes[] = $hero;
        }

        return $heroes;
    }
    

    public function update(Hero $hero)
    {
        $id = $hero->getId();
        $healthPoint = $hero->getHealthPoint();
       

        $stmt = $this->db->prepare("UPDATE heroes SET health_points = ? WHERE id = ?");
        $stmt->execute([$healthPoint, $id]);
    }

    public function find($heroId)
{
    $stmt = $this->db->prepare("SELECT * FROM heroes WHERE id = ?");
    $stmt->execute([$heroId]);

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$row) {
        return null;
    }

    $type = $row['type'];
    $imagePath = $this->imagePath($type); 

    switch ($type) 
    {
        case 'Saiyan':
            $hero = new Saiyan(['name' => $row['name'], 'type' => 'Saiyan', 'imagePath' => $imagePath]);
            break;
        case 'Namek':
            $hero = new Namek(['name' => $row['name'], 'type' => 'Namek', 'imagePath' => $imagePath]);
            break;
        case 'Humain':
            $hero = new Humain(['name' => $row['name'], 'type' => 'Humain', 'imagePath' => $imagePath]);
            break;
        default:
            $hero = new Hero(['name' => $row['name'], 'type' => 'Hero', 'imagePath' => $imagePath]);
            break;
    }

    $hero->setId($row['id']);
    $hero->setHealthPoint($row['health_points']);

    return $hero;
}

    public function imagePath($type) 
    {
        switch ($type)
         {
            case 'Saiyan':
                return './style/image/avatar/saiyan.png';
            case 'Namek':
                return './style/image/avatar/namek.png';
            case 'Humain':
                return './style/image/avatar/humain.png';
            default:
                return './style/image/avatar/default.png';
        }
    }

    public function healAllHeroes($amount)
{
    $stmt = $this->db->prepare("UPDATE heroes SET health_points = LEAST(health_points + ?, 100)");
    $stmt->execute([$amount]);
}



}
 
