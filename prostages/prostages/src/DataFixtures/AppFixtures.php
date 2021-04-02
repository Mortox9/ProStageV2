<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Entreprise;
use App\Entity\Formation;
use App\Entity\Stage;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

        //Création d'un générateur de données Faker
        $faker = \Faker\Factory::create('fr_FR');
/*************************** CREATION ENTREPRISES ***************************/
        $nbEntreprises = $faker->numberBetween($min = 14, $max = 30);                                             //Nombre d'entreprises à créer

        //Créer $nbEntreprises:
        for($j=0; $j < $nbEntreprises; $j++)
        {
          $entreprise = new Entreprise();                                                                         //Créer un nouveau tuple "Entreprise"
          $entreprise->setNom($faker->company($maxNbChars = 150, $indexSize = 2));                                //Rempli l'attribut nom du tuple "Entreprise"
          $entreprise->setAdresse($faker->address($maxNbChars = 150, $indexSize = 2));                            //Rempli l'attribut adresse du tuple "Entreprise"
          $entreprise->setMilieu($faker->jobTitle($maxNbChars = 150, $indexSize = 2));                            //Rempli l'attribut milieu du tuple "Entreprise"
          $entreprise->setTelephone($faker->regexify('0[0-9]\.[0-9][0-9]\.[0-9][0-9]\.[0-9][0-9]\.[0-9][0-9]'));  //Rempli téléphone du tuple "Entreprise"
          $entreprise->setPhoto($faker->imageUrl($width = 640, $height = 480));                                   //Rempli l'attribu photo avec l'url d'une photo du tuple "Entreprise"
          $entreprises[]=$entreprise;                                                                             //Ajoute l'entreprise dans le tableau d'entreprises
          $manager->persist($entreprise);                                                                         //Persiste l'entreprise
        }

/*************************** CREATION FORMATIONS ***************************/
        $nbFormations = $faker->numberBetween($min = 8, $max = 14);                                               //Nombre de formations à créer

        //Créer $nbFormations:
        for($i=0; $i < $nbFormations; $i++)
        {
          $formation = new Formation();                                                                           //Créer un nouveau tuple "Formation"
          $formation->setIntitule($faker->realText($maxNbChars = 150, $indexSize = 2));                           //Rempli l'attribut intitule du tuple "Formation"
          $formation->setNiveau($faker->realText($maxNbChars = 150, $indexSize = 2));                             //Rempli l'attribut niveau du tuple "Formation"
          $formation->setVille($faker->city($maxNbChars = 150, $indexSize = 2));                                  //Rempli l'attribut ville du tuple "Formation"
          $formation->setDescription($faker->realText($maxNbChars = 244, $indexSize = 2));                        //Rempli l'attribut description du tuple "Formation"
          $tabFormations[] = $formation;                                                                          //Ajoute la formation dans le tableau de formations
          $manager->persist($formation);                                                                          //Persiste la formation

          /*************************** CREATION STAGES ***************************/
          $nbStages = $faker->numberBetween($min = $nbFormations*2, $max = $nbEntreprises*2);                     //Nombre de stages à créer en fonction du nombre de formations et d'entreprises

          //Créer $nbStages
          for($k=0; $k < $nbStages; $k++)
          {
            $stage = new Stage();                                                                                 //Créer un nouveau tuple "Stage"
            $stage->setIntitule($faker->realText($maxNbChars = 150, $indexSize = 2));                             //Rempli l'attribut intitule du tuple "Stage"
            $stage->setDescription($faker->realText($maxNbChars = 480, $indexSize = 2));                          //Rempli l'attribut description du tuple "Stage"
            $stage->setDateDebut($faker->dateTime($min = 'now', $timezone = null));                               //Rempli l'attribut dateDebut du tuple "Stage"
            $stage->setDuree($faker->numberBetween($min= 1, $max = 12).' mois');                                  //Rempli l'attribut duree du tuple "Stage"
            $stage->setCompetencesRequises($faker->realText($maxNbChars = 288, $indexSize = 2));                  //Rempli l'attribut competencesRequises du tuple "Stage"
            $stage->setExperienceRequise($faker->realText($maxNbChars = 288, $indexSize = 2));                    //Rempli l'attribut experienceRequise du tuple "Stage"

            $numEntreprise = $faker->numberBetween($min = 0, $max = $nbEntreprises-1);                            //On prend une entreprise au hasard
            $stage->setEntreprise($entreprises[$numEntreprise]);                                                  //On lie l'entreprise au stage
            $entreprises[$numEntreprise]->addStage($stage);                                                       //On lie le stage à l'entreprise
            $tabStages[] = $stage;                                                                                //Ajoute le stage dans le tableau de stages

            $manager->persist($entreprises[$numEntreprise]);                                                      //Persiste l'entreprise modifiée
            $manager->persist($stage);                                                                            //Persiste le stage
          }
        }
        //Pour chaque stage, on le lie à une formations
        foreach ($tabStages as $stage)
        {
          $nbFormations = $faker->numberBetween($min = 1, $max = count($tabFormations));                          //On prend un nombre de formation au hasard
          $formations=$faker->randomElements($tabFormations, $count = $nbFormations);                             //On prend des formations au hasard
          foreach ($formations as $formation) {
            $stage->setFormation($formation);                                                                     //On lie la formation au stage
            $formation->addStage($stage);                                                                         //On lie le stage à la formation
            $manager->persist($stage);                                                                            //On persiste le stage
            $manager->persist($formation);                                                                        //On persiste la formation modifiée
          }
        }

        $manager->flush();  //Envoie dans la BD
    }
}
