<?php

namespace App\Entity;

class Arme{

    // public $image;
    private $nom;
    private $description;
    private $degat;

    public static $tabArmes=[];
    

    public function __construct($nom,$description,$degat)
    {
        $this->nom=$nom;
        $this->description=$description;
        $this->degat=$degat;
        self::$tabArmes[]=$this;
    }

    public function getNom(){  return $this->nom; }
    public function getDescription(){  return $this->description; }
    public function getDegat(){  return $this->degat; }

    public function setNom($nom){   $this->nom=$nom; }
    public function setDescription($description){   $this->description=$description; }
    public function setDegat($degat){   $this->degat=$degat; }
        
    

    public static function creerArme(){
    $arme1=new Arme ("épée","Une superbe épée tranchante",10);
    $arme2=new Arme ("hache","Une superbe épée tranchante",10);
    $arme3=new Arme ("arc","Une superbe épée tranchante",10);
}

public static function getArmeParNom($nom){
foreach (self::$tabArmes as $arme) {
    if ( strtolower(str_replace("é","e",$arme->nom)) === $nom) {
        return $arme;
    }
}

}

}