<?php
require_once 'config/autoload.php';
require_once 'config/db.php';

$heroesManager = new HeroesManager($db);




if (isset($_POST['name'], $_POST['type']) && !empty($_POST['name']) && !empty($_POST['type'])) {
    $heroName = htmlspecialchars($_POST['name']);
    $heroClass = $_POST['type'];

    $imagePath = '';

    switch ($heroClass)
     {
        case 'Saiyan':
            $imagePath = './style/image/avatar/saiyan.png';
            break;
        case 'Namek':
            $imagePath = './style/image/avatar/namek.png';
            break;
        case 'Humain':
            $imagePath = './style/image/avatar/humain.png';
            break;
        default:
            $imagePath = './style/image/avatar/default.png';
            break;
    }

    switch ($heroClass) 
    {
        case 'Saiyan':
            $hero = new Saiyan(['name' => $heroName, 'type' => 'Saiyan', 'imagePath' => $imagePath]);
            break;
        case 'Namek':
            $hero = new Namek(['name' => $heroName, 'type' => 'Namek', 'imagePath' => $imagePath]);
            break;
        case 'Humain':
            $hero = new Humain(['name' => $heroName, 'type' => 'Humain', 'imagePath' => $imagePath]);
            break;
        default:
            $hero = new Hero(['name' => $heroName, 'type' => 'Hero', 'imagePath' => $imagePath]);
            break;
    }

    $heroesManager->add($hero);
}

$heroes = $heroesManager->findAllAlive();
$deadHeroes = $heroesManager->findAllDead();
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['delete_hero_id'])) {
    $heroIdToDelete = $_POST['delete_hero_id'];
    $heroToDelete = $heroesManager->find($heroIdToDelete);
    
    if ($heroToDelete)
     {
        $heroesManager->deleteHero($heroToDelete);
        echo 'Héros supprimé!';
    } else {
        echo 'Impossible de trouver le héros à supprimer.';
    }
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['heal_all']))
     {
        $amountToHeal = 100; 
        $heroesManager->healAllHeroes($amountToHeal);
        echo 'Tous les héros ont été soignés!';
    }
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <title>FighterZ</title>
</head>
<body>
    
<img id="myVideo" src="style/image/background/bg_ss.png" alt="">

<header>

<nav class="navbar bg-dark navbar-dark">
            <div class="container-fluid">
        
      <form id="create" method="post" action="">
    <input class="form" type="text" name="name" id="name" required>
    <div class="btn-group">
        <select class="form-select bg-primary" name="type" aria-label="Default select example">
            <option selected>Choisir type</option>
            <option value="Saiyan">Saiyan</option>
            <option value="Humain">Humain</option>
            <option value="Namek">Namek</option>
        </select>
    </div>
    <button class="btn btn-warning" type="submit">Créer Personnage</button>
</form>
    </div>
  </div>
</nav> 

</header>

<div class="container text-dark">
    <p><h2>Liste Personnages vivants</h2></p>
    <ul class="character-list text-dark">
        <?php foreach ($heroes as $hero) : ?>   
            <div class="cardCP">
            <div class="imgBx">
            <img id="vegeta" src="<?= $heroesManager->imagePath($hero->getType()) ?>" alt="<?= $hero->getType() ?>">
            </div>
                <div class="contentBx d-flex flex-column align-items-center">
                    <h2><?= $hero->getName() ?></h2> 
                    <div class="w-50">
                        <div class="progress" role="progressbar" aria-label="Basic example" aria-valuenow="<?= $hero->getHealthPoint() ?>" aria-valuemin="0" aria-valuemax="100">
                            <div class="progress-bar bg-danger" style="width: <?= $hero->getHealthPoint() ?>%">HP: <?= $hero->getHealthPoint() ?></div>
                        </div>
                    </div>
                   
                    <div class='btnCP'>
                        <form method="get" action="fight.php">
                            <input type="hidden" name="hero_id" value="<?= $hero->getId() ?>">
                            <button type="submit" class="btn btn-warning">Choisir</button>
                        </form>
                        <form method="post" action="index.php" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce héros?');">
                            <input type="hidden" name="delete_hero_id" value="<?= $hero->getId() ?>">
                            <button type="submit" class="btn btn-danger">Supprimer</button>
                        </form>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </ul>
</div>


<div class="container text-dark">
    <p><h2>Liste Personnages Morts</h2></p>
    <ul class="character-list text-dark">
        <?php foreach ($deadHeroes as $hero) : ?>
            <div class="cardCP">
                 <div class="imgBx">
                <img id="vegeta" src="<?= $heroesManager->imagePath($hero->getType()) ?>" alt="<?= $hero->getType() ?>">
            </div>
                <div class="contentBx d-flex flex-column align-items-center">
                    <h2><?= $hero->getName() ?></h2> 
                    <div class=" w-50">
                        <div class="progress" role="progressbar" aria-label="Basic example" aria-valuenow="<?= $hero->getHealthPoint() ?>" aria-valuemin="0" aria-valuemax="100">
                            <div class="progress-bar bg-danger" style="width: <?= $hero->getHealthPoint() ?>%">HP:<?= $hero->getHealthPoint()?></div>
                        </div>
                    </div>
                
                    <div class='btnCP'>
                    <form method="post" action="index.php" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce héros?');">
                        <input type="hidden" name="delete_hero_id" value="<?= $hero->getId() ?>">
                        <button type="submit" class="btn btn-danger">Supprimer</button>
                    </form>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </ul>
</div>
<form method="post" action="index.php">
    <button type="submit" name="heal_all" class="btn btn-success">Soigner tous les héros</button>
</form>
</div>
</div>


</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
<script src="style/main.js"></script>
</html>

