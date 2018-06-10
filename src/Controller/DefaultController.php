<?php

namespace App\Controller;

use App\Entity\Advert;
use App\Entity\User;
use App\Form\AddAdvertType;
use Doctrine\ORM\EntityManagerInterface;
use FOS\UserBundle\Form\Type\UsernameFormType;
use FOS\UserBundle\Model\UserInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{



    /**
     *
     * @Route("/edit", name="create")
     *
     */
    public function createAdvert(EntityManagerInterface $entityManager, Request $request){

        $advert = new Advert();
        $advert->setUser($this->getUser());
        $form = $this->createForm(AddAdvertType::class, $advert);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($advert);
            $entityManager->flush();
            $id = $advert->getId();

            return $this->redirectToRoute ('success',[
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
     * @Route("/${id}", name="success")
     */
        public function showAdvert(){


          return $this->render('advert/show.html.twig');
        }


/*
    public  function  listAction ( Request  $request )
        {
        $em = $this -> get ( 'doctrine.orm.entity_manager' );
        $dql = " SELECT a FROM AcmeMainBundle: Article a " ;
        $query = $em -> createQuery ( $dql );



        $paginator = $this -> get ( 'knp_paginator' );
        $pagination = $paginator -> paginate ( $query , $request -> query -> getInt ( ' page ' , 5 ) , 5) ;





            // параметры для шаблона
        return $this -> render ( 'default/index.html.twig' ,
            array ( ' pagination ' => $pagination ));
        }*/



    /**
     * @Route("/ ", name="start")
     */
    public function start()
    {
        $repo = $this->getDoctrine()->getRepository(Advert::class);
        $adverts = $repo->findAll();


        return $this->render('default/index.html.twig',[
            'adverts'=>$adverts,
        ]);
    }
}
