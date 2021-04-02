<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Stage;
use App\Entity\Formation;
use App\Entity\Entreprise;
use App\Repository\StageRepository;
use App\Repository\FormationRepository;
use App\Repository\EntrepriseRepository;

class ProstagesController extends AbstractController
{
    /**
     * @Route("/", name="prostages_accueil")
     */
    public function index(): Response
    {
        return $this->render('prostages/index.html.twig');
    }
    /**
     * @Route("/entreprises", name="prostages_entreprises")
     */
    public function entreprise(EntrepriseRepository $repositoryEntreprise): Response
    {
      //On récupère les entreprises de la BD
      $entreprises = $repositoryEntreprise->findAll();
        return $this->render('prostages/entreprises.html.twig',
      [
        'entreprises'=>$entreprises
      ]
      );
    }
    /**
     * @Route("/formations", name="prostages_formations")
     */
    public function formation(FormationRepository $repositoryFormation): Response
    {
      //On récupère les formations de la BD
      $formations = $repositoryFormation->findAll();
        return $this->render('prostages/formations.html.twig',
      [
        'formations'=>$formations
      ]
    );
    }
    /**
     * @Route("/stages", name="prostages_stages")
     */
    public function stages(StageRepository $repositoryStage)
    {
      //On récupère les stages de la BD
      $stages = $repositoryStage->findAll();
        return $this->render('prostages/stages.html.twig',
      [
        'stages'=>$stages
      ]
    );
    }

    /**
     * @Route("/stages/{entreprise}", name="prostages_stagesParEntreprise")
     */
    public function stagesParEntreprise(StageRepository $repositoryStage, $entreprise): Response
    {
      //On récupère les stages de la BD correspondant à l'entreprise
      $stages = $repositoryStage->findByEntreprise($entreprise);
        return $this->render('prostages/stages.html.twig',
      [
        'stages'=>$stages
      ]
    );
    }

    /**
     * @Route("/stages/{formation}", name="prostages_stagesParFormation")
     */
    public function stagesParFormation(StageRepository $repositoryStage, $formation): Response
    {
      //On récupère les stages de la BD correspondant à l'entreprise
      $stages = $repositoryStage->findByFormation($formation);
        return $this->render('prostages/stages.html.twig',
      [
        'stages'=>$stages
      ]
    );
    }

    /**
     * @Route("/entreprises/{id}", name="prostages_entrepriseId", requirements={"id"="\d{1,4}"})
     */
    public function entrepriseId(Entreprise $entreprise): Response
    {
        return $this->render('prostages/entrepriseId.html.twig',
      [
        'entreprise' => $entreprise,
      ]);
    }
    /**
     * @Route("/formations/{id}", name="prostages_formationId", requirements={"id"="\d{1,4}"})
     */
    public function formationId(Formation $formation): Response
    {
        return $this->render('prostages/formationId.html.twig',
      [
        'formation' => $formation,
      ]);
    }
    /**
     * @Route("/stages/{id}", name="prostages_stageId", requirements={"id"="\d{1,4}"})
     */
    public function stageId(Stage $stage): Response
    {
        return $this->render('prostages/stageId.html.twig',
      [
        'stage' => $stage,
      ]);
    }
}
