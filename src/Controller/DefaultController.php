<?php

namespace App\Controller;

use App\Entity\Advert;
use App\Entity\User;
use App\Form\AddAdvertType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    /**
     * @Route("/ ", name="start")
     */
    public function start()
    {
        return $this->render('default/index.html.twig');
    }

    /**
     * @Route("/edit", name="create")
     */
    public function createAdvert(Request $request, EntityManagerInterface $entityManager){

        $advert = new Advert();
        $form = $this->createForm(AddAdvertType::class, $advert);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $entityManager->persist($advert);
            $entityManager->flush();
            $id = $advert->getId();

            return $this->redirectToRoute('show',[
                'id'=>$id,
                'advert'=>$advert,
            ]);
        }

    return $this->render('advert/create.html.twig', [

        'form'=>$form->createView(),
    ]);
    }

   /**
     * @Route("/{id}", name="show")
     */
    /*   public function showAdvert(){

          return $this->render('advert/show.html.twig');
      }*/

}
