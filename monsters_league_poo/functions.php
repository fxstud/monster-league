<?php

function getMonsters(){

    $hostname = 'localhost';
    $username = 'root';
    $password = '';
    $database = 'monster';

    
   
    // on tente de s'éxécuter dans le bloc try

    try{

    $bdd = new PDO('mysql:host='. $hostname .';dbname='. $database.';charset=utf8', $username,  $password , array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

    }
    
    // l'erreur d'authentification est traitée et gérée dans ce bloc

    catch(PDOException $e){
    
    echo '<h1>Une erreur s\'est produite</h1><pre>', $e->getMessage() ,'</pre>';

    // mort du processus si erreur il y a
    die();
   
    }


    $monsters = array(

        1 => array('name' => 'Domovoï','strength' =>  30,'life' => 300,'type' => 'water'),
        2 => array('name' => 'Wendigos','strength' => 100,'life' => 450,'type' => 'earth'),
        3 => array('name' => 'Thunderbird','strength' => 400,'life' => 500,'type' => 'air' ),
        4 => array('name' => 'Sirrush','strength' => 250,'life' => 1500,'type' => 'fire')
        );

    $req = $bdd->query('SELECT * FROM monsters');

    foreach($req->fetch() as $monsters){

        return $monsters;
    }



    


    /*
    return [
        [
            'name' => 'Domovoï',
            'strength' => 30,
            'life' => 300,
            'type' => 'water'
        ],
        [
            'name' => 'Wendigos',
            'strength' => 100,
            'life' => 450,
            'type' => 'earth'
        ],
        [
            'name' => 'Thunderbird',
            'strength' => 400,
            'life' => 500,
            'type' => 'air'
        ],
        [
            'name' => 'Sirrush',
            'strength' => 250,
            'life' => 1500,
            'type' => 'fire'
        ],
    ]; */
}


// on crée la fonction d'ajout de monstre

 function add($name,$strength,$life,$type){

     getMonsters();  // appel à la fonction getMonsters
  
     // préparation de la requête pour insérer une nouvelle entrée avec des marqueurs ? car il s'agit d'une préparation qui précède l'éxécution qui elle contiendra des valeurs

     $add = $bdd->prepare('INSERT INTO monsters(name , strength, life, type) VALUES(?,?,?,?)');
    //on execute la requete SQL
     
     $add = $bdd->execute(array(
    'name' => $name,
    'strength' => $strength,
    'life' => $life,
    'type' => $type,
    ));   
}

// on crée la fonction de suppression de monstre

function del($name,$strength,$life,$type){

     getMonsters();  // appel à la fonction getMonsters

     $add = $bdd->prepare('DELETE from monsters WHERE name =\' ?\'');
     
     $add = $bdd->execute(array(
    'name' => $name,
    'strength' => $strength,
    'life' => $life,
    'type' => $type,
    ));   
}


/**
 * Our complex fighting algorithm!
 *
 * @return array With keys winning_ship, losing_ship & used_jedi_powers
 */
function fight(array $firstMonster, array $secondMonster)
{
    $firstMonsterLife = $firstMonster['life'];
    $secondMonsterLife = $secondMonster['life'];

    while ($firstMonsterLife > 0 && $secondMonsterLife > 0) {
        $firstMonsterLife = $firstMonsterLife - $secondMonster['strength'];
        $secondMonsterLife = $secondMonsterLife - $firstMonster['strength'];
    }

    if ($firstMonsterLife <= 0 && $secondMonsterLife <= 0) {
        $winner = null;
        $looser = null;
    } elseif ($firstMonsterLife <= 0) {
        $winner = $secondMonster;
        $looser = $firstMonster;
    } else {
        $winner = $firstMonster;
        $looser = $secondMonster;
    }

    return array(
        'winner' => $winner,
        'looser' => $looser,
    );
}