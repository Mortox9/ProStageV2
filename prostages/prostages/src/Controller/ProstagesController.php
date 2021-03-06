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
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ObjectManager;
use App\Form\StageType;
use App\Form\EntrepriseType;

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
     * @Route("/stages/ajouter", name="prostages_ajoutStage")
     */
    public function ajouterStage(ObjectManager $manager, Request $request)
    {
      $stage = new Stage();
      $formulaireStage = $this->createForm(StageType::class, $stage);

      $formulaireStage->handleRequest($request);

      if($formulaireStage->isSubmitted() && $formulaireStage->isValid())
      {
        $manager->persist($stage);
        $manager->flush();

        return $this->redirectToRoute('prostages_accueil');
      }
      //Afficher la page du formulaire d'ajout d'entreprise
        return $this->render('prostages/ajoutStage.html.twig',
      [
        'vueFormulaire'=>$formulaireStage->createView(),
        'action'=>"ajouter"
      ]
    );
    }

    /**
     * @Route("/entreprises/ajouter", name="prostages_ajoutEntreprise")
     */
    public function ajouterEntreprise(ObjectManager $manager, Request $request)
    {
      $entreprise = new Entreprise();
      $formulaireEntreprise = $this->createForm(EntrepriseType::class, $entreprise);

      $formulaireEntreprise->handleRequest($request);

      if($formulaireEntreprise->isSubmitted() && $formulaireEntreprise->isValid())
      {
        $manager->persist($entreprise);
        $manager->flush();

        return $this->redirectToRoute('prostages_accueil');
      }
      //Afficher la page du formulaire d'ajout d'entreprise
        return $this->render('prostages/ajoutModifEntreprise.html.twig',
      [
        'vueFormulaire'=>$formulaireEntreprise->createView(),
        'action'=>"ajouter"
      ]
    );
    }

    /**
     * @Route("/entreprises/modifier/{id}", name="prostages_modifEntreprise")
     */
    public function modifierEntreprise(ObjectManager $manager, Request $request, Entreprise $entreprise)
    {
      $formulaireEntreprise = $this->createForm(EntrepriseType::class, $entreprise);

      $formulaireEntreprise->handleRequest($request);

      if($formulaireEntreprise->isSubmitted() && $formulaireEntreprise->isValid())
      {
        $manager->persist($entreprise);
        $manager->flush();

        return $this->redirectToRoute('prostages_accueil');
      }
      //Afficher la page du formulaire d'ajout d'entreprise
        return $this->render('prostages/ajoutModifEntreprise.html.twig',
      [
        'vueFormulaire'=>$formulaireEntreprise->createView(),
        'action'=>"modifier"
      ]
    );
    }

    /**
     * @Route("/entreprises", name="prostages_entreprises")
     */
    public function entreprise(EntrepriseRepository $repositoryEntreprise): Response
    {
      //On r??cup??re les entreprises de la BD
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
      //On r??cup??re les formations de la BD
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
      //On r??cup??re les stages de la BD
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
      //On r??cup??re les stages de la BD correspondant ?? l'entreprise
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
      //On r??cup??re les stages de la BD correspondant ?? l'entreprise
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
