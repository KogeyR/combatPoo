<?php
require_once 'config/autoload.php';
require_once 'config/db.php';

if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET['hero_id'])) {
    $heroId = $_GET['hero_id'];


    $heroesManager = new HeroesManager($db);

    $hero = $heroesManager->find($heroId);

    
    $fightManager = new FightsManager();
    $monster = $fightManager->create_Monster('Cell');
    $fightResults = $fightManager->fight($hero, $monster);
    $heroesManager->update($hero);
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="style/style.css">
    <title>Combat</title>
</head>
<body>
    <img src="style/image/background/cellgame.jpg" alt="" class="background">
    <header>
<form method="get" action="index.php">
                <button type="submit" class="btn btn-warning">Choix Personnage</button>
            </form>
    </header>
    <div class="container">
    <ul class="character-list ">
        <?php if ($hero) : ?>
            <div class="cardCP">
                <div class="imgBx">
                <img id="vegeta" src="<?= $heroesManager->imagePath($hero->getType()) ?>" alt="<?= $hero->getType() ?>">
            </div>
                        <div class="contentBx d-flex flex-column align-items-center">
                            <h5 class="card-title"><?= $hero->getName() ?></h5>
    
                            <div class=" w-50">
                        <div class="progress" role="progressbar" aria-label="Basic example" aria-valuenow="<?= $hero->getHealthPoint() ?>" aria-valuemin="0" aria-valuemax="100">
                            <div class="progress-bar bg-danger" style="width: <?= $hero->getHealthPoint() ?>%">HP:<?= $hero->getHealthPoint()?></div>
                        </div>
                    </div>
                        </div>
                    </div>
        
                    <div class="cardCP">
                    <div class="imgBx">
                    <img id="vegeta" src="./style/image/avatar/cell.png">
                </div>
                        <div class="contentBx d-flex flex-column align-items-center">
                            <h5 class="card-title"><?= $monster->getName() ?></h5>
    
                            <div class=" w-50">
                        <div class="progress" role="progressbar" aria-label="Basic example" aria-valuenow="<?= $monster->getHealthPoint() ?>" aria-valuemin="0" aria-valuemax="100">
                            <div class="progress-bar bg-danger" style="width: <?= $monster->getHealthPoint() ?>%">HP:<?= $monster->getHealthPoint() ?></div>
                        </div>
                    </div>
                        </div>
                    </div>
              
            </div>
        <?php else : ?>
            <p>Aucun Personnage sélectionné.</p>
        <?php endif; ?>
    </div>
    <section class="container">
    <?php foreach ($fightResults as $key => $message) { ?>
    
        <div class="alert alert-item <?= $key % 2 ? 'alert-primary': 'alert-danger'  ?>" role="alert">
            <?= $message ?>
        </div>
    <?php } ?>
</section>
</body>
<script src="style/main.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
</html>
