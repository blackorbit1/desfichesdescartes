<?php
try{
    $bdd = new PDO('mysql:host=db719518578.db.1and1.com;dbname=db719518578;charset=utf8', 'dbo747737637', 'Securitemaximale_123');
    //$bdd = new PDO('mysql:host=localhost;dbname=desfichesdescartes;charset=utf8', 'root', 'root');
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}
?>