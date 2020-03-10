<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Entity\Serie;
use App\Form\CategorieType;
use App\Form\SerieType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AllController extends AbstractController
{
    /**
     * @Route("/", name="index")
    */
    public function index(Request $request, EntityManagerInterface $entityManager)
    {
        $categorie = new categorie();

        $categorieRepository = $this->getDoctrine()
        ->getRepository(Categorie::class)
        ->findAll();



        $serieRepository = $this->getDoctrine()
        ->getRepository(Serie::class)
        ->findAll();
    
        $form = $this->createForm(CategorieType::class, $categorie);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $categorie = $form->getData();
            
            $entityManager->persist($categorie);
            $entityManager->flush();
        }


        return $this->render('all/index.html.twig', [
            'categories' => $categorieRepository,
            'series' => $serieRepository,
            'formCategorie' => $form->createView()

        ]);
    }
    
    /**
     * @Route("/categories/{id}", name="categories")
    */

    public function singleCategorie($id, Request $request, EntityManagerInterface $entityManager){

        $categorieRepository = $this->getDoctrine()
        ->getRepository(Categorie::class)
        ->find($id);
        
        
        $form = $this->createForm(CategorieType::class, $categorieRepository);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $categorie = $form->getData();
            
            $entityManager->persist($categorie);
            $entityManager->flush();
        }
 

        return $this->render('all/categorie.html.twig', [
            'categories' => $categorieRepository,
            'formCategorie' => $form->createView()
        ]);
    }

    /**
     * @Route("/series", name="series")
    */

    public function series(Request $request, EntityManagerInterface $entityManager) {

        $serie = new Serie();

        $serieRepository = $this->getDoctrine()
        ->getRepository(Serie::class)
        ->findAll();
    
        $form = $this->createForm(SerieType::class, $serie);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $serie = $form->getData();
            $image = $serie->getAffiche();

            $imageName = md5(uniqid()).'.'.$image->guessExtension();
            
            $image->move($this->getParameter('upload_files'),$imageName);
            $serie ->setAffiche($imageName);

            $entityManager->persist($serie);
            $entityManager->flush();
        }

        return $this->render('all/series.html.twig', [
            'series' => $serieRepository,
            'serieForm' => $form
        ]);
    }

}
