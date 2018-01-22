<?php

namespace RestauranteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use RestauranteBundle\Form\TapaType;
use RestauranteBundle\Form\UserType;
use RestauranteBundle\Entity\Tapa;
use RestauranteBundle\Entity\User;

class DefaultController extends Controller
{
    public function indexAction()
    {
      $repository = $this->getDoctrine()->getRepository('RestauranteBundle:Tapa');
      $tapas = $repository->findAll();
        return $this->render('RestauranteBundle:Default:index.html.twig',array('tapas'=>$tapas));
    }
    public function cartaAction()
    {
      $repository = $this->getDoctrine()->getRepository('RestauranteBundle:Tapa');
      $tapas = $repository->findAll();
        return $this->render('RestauranteBundle:Default:carta.html.twig',array('tapas'=>$tapas));
    }
    public function singleAction($idTapa)
    {
      $repository = $this->getDoctrine()->getRepository('RestauranteBundle:Tapa');
      $tapa = $repository->find($idTapa);

        return $this->render('RestauranteBundle:Default:single.html.twig',array('tapa'=>$tapa));
    }
    public function addTapaAction(Request $request)
    {
      $tapa = new Tapa();
      $form = $this->createForm(TapaType::class);

      $form->handleRequest($request);

      if ($form->isSubmitted() && $form->isValid()) {
          $tapa = $form->getData();

          $em = $this->getDoctrine()->getManager();
          $em->persist($tapa);
          $em->flush();

          return $this->redirect($this->generateUrl('restaurante_single', array('idTapa' => $tapa->getId())));

      }

        return $this->render('RestauranteBundle:Default:addTapa.html.twig',array('form'=> $form->createView()));
    }

    public function actualizarTapaAction(Request $request, $idTapa)
    {
      $em = $this->getDoctrine()->getManager();
      $tapa = $em->getRepository(Tapa::Class)->find($idTapa);
      $form = $this->createForm(TapaType::class, $tapa);

      $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()) {

        $tapa = $form->getData();
        $em->persist($tapa);
        $em->flush();
        return $this->redirect($this->generateUrl('restaurante_single', array('idTapa' => $tapa->getId())));
    }

      return $this->render('RestauranteBundle:Default:updateTapa.html.twig',array('idTapa' => $tapa->getId() ,'form'=> $form->createView()));
    }

    public function eliminarTapaAction($idTapa)
    {
      $em = $this->getDoctrine()->getManager();
      $tapa = $em->getRepository(Tapa::Class)->find($idTapa);
      $em->remove($tapa);
      $em->flush();

      return $this->redirectToRoute('restaurante_carta');
    }

    public function registerAction(Request $request)
    {
        // 1) build the form
        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        // 2) handle the submit (will only happen on POST)
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            // 3) Encode the password (you could also do this via Doctrine listener)
            $password = $this->get('security.password_encoder')
            ->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);

            // 4) save the User!
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('restaurante_homepage');
        }

        return $this->render(
            'RestauranteBundle:Default:register.html.twig',
            array('form' => $form->createView())
        );
    }
}
