<?php

namespace App\Controller;

use App\Entity\Advert;
use App\Form\AddAdvertType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{

    /**
     * @Route("/edit", name="create")
     */
    public function createAdvert(Request $request){

        $advert = new Advert();
        $advert->setUser($this->getUser());
        $form = $this->createForm(AddAdvertType::class, $advert);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($advert);
            $entityManager->flush();
            $id = $advert->getId();

            return $this->redirectToRoute ('show',[
                'id'=>$id,
            ]);
        }

    return $this->render('advert/create.html.twig', [

        'form'=>$form->createView(),
    ]);
    }

    /**
     * @Route("/${id}", name="show")
     */
    public function advertPage(Advert $advert)
    {
        return $this->render('advert/show.html.twig', [
            'advert' => $advert,
        ]);
    }

    /**
     * @Route("/delete/${id}", name="delete")
     */
    public function postDelete(Advert $advert)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($advert);
        $entityManager->flush();

        return $this->redirectToRoute('start',[
            'advert' => $advert,
        ]);
    }

    /**
     *@Route("/edit/${id}", name="edit")
     */
    public function advertEdit(Advert $advert, EntityManagerInterface $entityManager, Request $request)
    {

        $form = $this->createForm(AddAdvertType::class, $advert);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $entityManager->persist($advert);
            $entityManager->flush();
            $id = $advert->getId();

            return $this->redirectToRoute ('show',[
                'id'=>$id,
            ]);
        }
        return $this->render('advert/create.html.twig', [

            'form'=>$form->createView(),
        ]);
    }

    /**
     * @Route("/ ", name="start")
     */
    public function start(Request  $request)
    {

        $entityManager = $this->getDoctrine()->getManager();
        $adverts = $entityManager->getRepository('App:Advert')->findAll();

        $paginator = $this -> get( 'knp_paginator' );
        $result = $paginator -> paginate (
            $adverts,
            $request -> query -> getInt ( 'page' , 1 ),
            $request -> query -> getInt ('limit',5)
        );

        return $this->render('default/index.html.twig',[
            'adverts'=>$result,
        ]);
    }
}
