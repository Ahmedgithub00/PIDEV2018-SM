<?php

namespace Sante\SpecialisteBundle\Controller;

use blackknight467\StarRatingBundle\Form\RatingType;
use Sante\SpecialisteBundle\Entity\MedecinSpecialiste;
use Sante\SpecialisteBundle\Entity\specialiste;
use Sante\SpecialisteBundle\Form\MedecinSpecialiste2Type;
use Sante\SpecialisteBundle\Form\MedecinSpecialisteType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Sante\SpecialisteBundle\FileUploader;
use Sante\SpecialisteBundle\sms\SmsGateway;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\JsonResponse;

class MedecinSpecialisteController extends Controller
{


    /******************************mobile   **************/

    public function listePediatresMobileAction(Request $request)
    {

        $em=$this->getDoctrine()->getManager();
        $pediatress = $em->getRepository('SanteSpecialisteBundle:MedecinSpecialiste')->medecinOrdonné("Pédiatre");
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted=$serializer->normalize($pediatress);
        return new JsonResponse($formatted);
    }

    public function findmedbycinAction($cin)
    {

        $em=$this->getDoctrine()->getManager();
        $pediatress = $em->getRepository('SanteSpecialisteBundle:MedecinSpecialiste')->findBy(array('cin'=>$cin));
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted=$serializer->normalize($pediatress);
        return new JsonResponse($formatted);
    }

    public function findmedbyIdAction($id)
    {

        $em=$this->getDoctrine()->getManager();
        $pediatress = $em->getRepository('SanteSpecialisteBundle:MedecinSpecialiste')->findBy(array('id'=>$id));
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted=$serializer->normalize($pediatress);
        return new JsonResponse($formatted);
    }

    public function listeOrthophonistesMobileAction(Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $pediatress = $em->getRepository('SanteSpecialisteBundle:MedecinSpecialiste')->medecinOrdonné("Orthophoniste");
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted=$serializer->normalize($pediatress);
        return new JsonResponse($formatted);
    }

    public function EnvoyerSmsMobileAction(Request $request)
    {
        $smsGateway = new SmsGateway('amal.njeimi@gmail.com', 'amoula12345678');
        $deviceID = 87354;
        $number ='+21690092724';
        $message = 'Bonjour Docteur';
        $result = $smsGateway->sendMessageToNumber($number , $message, $deviceID);
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted=$serializer->normalize("ok");
        return new JsonResponse($formatted);
    }






    /******************************WEEEEEEEBBB   **************/


    private function generateUniqueFileName()
    {
        // md5() reduces the similarity of the file names generated by
        // uniqid(), which is based on timestamps
        return md5(uniqid());
    }
    public function supprimercompteAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $id=$this->get('security.token_storage')->getToken()->getUser()->getId();
        $mark=$em->getRepository('SanteSpecialisteBundle:MedecinSpecialiste')->findOneBy(array('id'=>$id));
        $mark2=$em->getRepository('UserBundle:User')->findOneBy(array('id'=>$id));
        $em->remove($mark);
        $em->remove($mark2);
        $em->flush();

        $session = $request->getSession();

        $authErrorKey = Security::AUTHENTICATION_ERROR;
        $lastUsernameKey = Security::LAST_USERNAME;

        // get the error if any (works with forward and redirect -- see below)
        if ($request->attributes->has($authErrorKey)) {
            $error = $request->attributes->get($authErrorKey);
        } elseif (null !== $session && $session->has($authErrorKey)) {
            $error = $session->get($authErrorKey);
            $session->remove($authErrorKey);
        } else {
            $error = null;
        }

        if (!$error instanceof AuthenticationException) {
            $error = null; // The value does not come from the security component.
        }

        // last username entered by the user
        $lastUsername = (null === $session) ? '' : $session->get($lastUsernameKey);

        $csrfToken = $this->has('security.csrf.token_manager')
            ? $this->get('security.csrf.token_manager')->getToken('authenticate')->getValue()
            : null;

        $routeName = $request->get('_route');
        $data=array(
            'last_username' => $lastUsername,
            'error' => $error,
            'csrf_token' => $csrfToken,
            'routename'=>$routeName,
        );

        return $this->redirectToRoute('sante_specialiste_homepage',$data);

    }
    public function ajouterInfoAction(Request $request)
    {
        $a= new MedecinSpecialiste();
        $id=$this->get('security.token_storage')->getToken()->getUser()->getId();
        $form = $this->createForm(MedecinSpecialisteType::class,$a);
        if($form->handleRequest($request)->isValid())
        {
            $file = $a->getImage();

            $fileName = $this->generateUniqueFileName().'.'.$file->guessExtension();

            // moves the file to the directory where brochures are stored
            $file->move(
                $this->getParameter('images_directory'),
                $fileName
            );

            // updates the 'brochure' property to store the PDF file name
            // instead of its contents
            $a->setImage($fileName);


            $a->setEtatverif(0);
            $a->setId($id);
        $a->setRating(0);
            $em = $this->getDoctrine()->getManager();
            $em->persist($a); // insert into table
            $em->flush(); //executer

            return $this->redirectToRoute('ajouterHoraire1',array('id' => $id));
        }
        $session = $request->getSession();

        $authErrorKey = Security::AUTHENTICATION_ERROR;
        $lastUsernameKey = Security::LAST_USERNAME;

        // get the error if any (works with forward and redirect -- see below)
        if ($request->attributes->has($authErrorKey)) {
            $error = $request->attributes->get($authErrorKey);
        } elseif (null !== $session && $session->has($authErrorKey)) {
            $error = $session->get($authErrorKey);
            $session->remove($authErrorKey);
        } else {
            $error = null;
        }

        if (!$error instanceof AuthenticationException) {
            $error = null; // The value does not come from the security component.
        }

        // last username entered by the user
        $lastUsername = (null === $session) ? '' : $session->get($lastUsernameKey);

        $csrfToken = $this->has('security.csrf.token_manager')
            ? $this->get('security.csrf.token_manager')->getToken('authenticate')->getValue()
            : null;

        $routeName = $request->get('_route');
        $data=array(
            'last_username' => $lastUsername,
            'error' => $error,
            'csrf_token' => $csrfToken,
            'routename'=>$routeName, 'f'=>$form->createView()
        );

        return $this->render('SanteSpecialisteBundle:MedecinSpecialiste:ajouter_info.html.twig', $data  );

    }
    public function DetailMedecinAction($cin,Request $request)
    {
        $s =new MedecinSpecialiste();
        $m=$this->getDoctrine()->getManager();
        $article = $m->getRepository('SanteSpecialisteBundle:MedecinSpecialiste')->findOneBy(array('cin'=>$cin));
        $horaire = $m->getRepository('SanteSpecialisteBundle:horaireTravail')->findBy(array('id'=>$article->getId(),));
        $n=$article->getRating();
        $form=$this->createFormBuilder($s)
            ->add('rating', RatingType::class, ['label' => 'Rating'])
            ->add('Voter', SubmitType::class)->setMethod('GET')->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $article->setRating($n+$s->getRating());
            $m->persist($article);
            $m->flush();
        }
        $session = $request->getSession();

        $authErrorKey = Security::AUTHENTICATION_ERROR;
        $lastUsernameKey = Security::LAST_USERNAME;

        // get the error if any (works with forward and redirect -- see below)
        if ($request->attributes->has($authErrorKey)) {
            $error = $request->attributes->get($authErrorKey);
        } elseif (null !== $session && $session->has($authErrorKey)) {
            $error = $session->get($authErrorKey);
            $session->remove($authErrorKey);
        } else {
            $error = null;
        }

        if (!$error instanceof AuthenticationException) {
            $error = null; // The value does not come from the security component.
        }

        // last username entered by the user
        $lastUsername = (null === $session) ? '' : $session->get($lastUsernameKey);

        $csrfToken = $this->has('security.csrf.token_manager')
            ? $this->get('security.csrf.token_manager')->getToken('authenticate')->getValue()
            : null;

        $routeName = $request->get('_route');
        $data=array(
            'last_username' => $lastUsername,
            'error' => $error,
            'csrf_token' => $csrfToken,
            'routename'=>$routeName,
            'horaire'=>$horaire,
            'm' => $article,
            'rating'=>$form->createView()
        );
        return $this->render('SanteSpecialisteBundle:MedecinSpecialiste:detailMedecin.html.twig', $data
            // ...
        );
    }
    public function modifierInfoAction(Request $request,$id)
    {
        $em = $this->getDoctrine()->getManager();
        $mark=$em->getRepository('SanteSpecialisteBundle:MedecinSpecialiste')->findOneBy(array('id'=>$id));
        $form=$this->createForm(MedecinSpecialiste2Type::class,$mark);
        if ($form->handleRequest($request)->isValid())
        {   $mark->setId($id);
            $em->persist($mark);
            $em->flush();
            return $this->redirectToRoute('modifierHoraire',array('id' => $id));
        }

        $session = $request->getSession();

        $authErrorKey = Security::AUTHENTICATION_ERROR;
        $lastUsernameKey = Security::LAST_USERNAME;

        // get the error if any (works with forward and redirect -- see below)
        if ($request->attributes->has($authErrorKey)) {
            $error = $request->attributes->get($authErrorKey);
        } elseif (null !== $session && $session->has($authErrorKey)) {
            $error = $session->get($authErrorKey);
            $session->remove($authErrorKey);
        } else {
            $error = null;
        }

        if (!$error instanceof AuthenticationException) {
            $error = null; // The value does not come from the security component.
        }

        // last username entered by the user
        $lastUsername = (null === $session) ? '' : $session->get($lastUsernameKey);

        $csrfToken = $this->has('security.csrf.token_manager')
            ? $this->get('security.csrf.token_manager')->getToken('authenticate')->getValue()
            : null;

        $routeName = $request->get('_route');
        $data=array(
            'last_username' => $lastUsername,
            'error' => $error,
            'csrf_token' => $csrfToken,
            'routename'=>$routeName, 'f'=>$form->createView(),'m'=>$mark
        );
        return $this->render('SanteSpecialisteBundle:MedecinSpecialiste:modifier_info.html.twig',  $data);

    }
    public function accepterspecialisteAction(Request $request,$id)
    {
        $em = $this->getDoctrine()->getManager();
        $mark=$em->getRepository('SanteSpecialisteBundle:MedecinSpecialiste')->findOneBy(array('id'=>$id));

        $mark->setEtatverif(1);

            $smsGateway = new SmsGateway('amal.njeimi@gmail.com', 'amoula12345678');

            $deviceID = 79831;
            $number ='+216'.$mark->getTelephone();
            $message = 'Bonjour Docteur'.' '.$mark->getNom().' '.$mark->getPrenom().' '. 'votre profil a été bien vérifié et il est partagé sur notre site. Veuillez vous connecter pour gérer votre espace. ALL FOR KIDS';

            $result = $smsGateway->sendMessageToNumber($number , $message, $deviceID);
            $em->persist($mark);
            $em->flush();

        $this->get('session')->getFlashBag()->add(
            'success',
            '  Le spécialiste a été bien accepté et informé.'
        );
        $session = $request->getSession();

        $authErrorKey = Security::AUTHENTICATION_ERROR;
        $lastUsernameKey = Security::LAST_USERNAME;

        // get the error if any (works with forward and redirect -- see below)
        if ($request->attributes->has($authErrorKey)) {
            $error = $request->attributes->get($authErrorKey);
        } elseif (null !== $session && $session->has($authErrorKey)) {
            $error = $session->get($authErrorKey);
            $session->remove($authErrorKey);
        } else {
            $error = null;
        }

        if (!$error instanceof AuthenticationException) {
            $error = null; // The value does not come from the security component.
        }

        // last username entered by the user
        $lastUsername = (null === $session) ? '' : $session->get($lastUsernameKey);

        $csrfToken = $this->has('security.csrf.token_manager')
            ? $this->get('security.csrf.token_manager')->getToken('authenticate')->getValue()
            : null;

        $routeName = $request->get('_route');
        $data=array(
            'last_username' => $lastUsername,
            'error' => $error,
            'csrf_token' => $csrfToken,
            'routename'=>$routeName
        );
            return $this->redirectToRoute('verifprofil',$data);

    }
    public function refuserspecialisteAction(Request $request,$id)
    {
        $em = $this->getDoctrine()->getManager();
        $mark=$em->getRepository('SanteSpecialisteBundle:MedecinSpecialiste')->findOneBy(array('id'=>$id));
        $mark2=$em->getRepository('UserBundle:User')->findOneBy(array('id'=>$id));
        $smsGateway = new SmsGateway('amal.njeimi@gmail.com', 'amoula12345678');

        $deviceID = 79831;
        $number ='+216'.$mark->getTelephone();
        $message = 'Bonjour Mr/Mme'.' '.$mark->getNom().' '.$mark->getPrenom().' '. 'votre profil n\'est pas valide. Votre compte ne sara plu disponible. ALL FOR KIDS';

        $result = $smsGateway->sendMessageToNumber($number , $message, $deviceID);
        $em->remove($mark);
        $em->remove($mark2);
        $em->flush();

        $this->get('session')->getFlashBag()->add(
            'success',
            '  Le spécialiste a été bien refusé et informé.'
        );
        $session = $request->getSession();

        $authErrorKey = Security::AUTHENTICATION_ERROR;
        $lastUsernameKey = Security::LAST_USERNAME;

        // get the error if any (works with forward and redirect -- see below)
        if ($request->attributes->has($authErrorKey)) {
            $error = $request->attributes->get($authErrorKey);
        } elseif (null !== $session && $session->has($authErrorKey)) {
            $error = $session->get($authErrorKey);
            $session->remove($authErrorKey);
        } else {
            $error = null;
        }

        if (!$error instanceof AuthenticationException) {
            $error = null; // The value does not come from the security component.
        }

        // last username entered by the user
        $lastUsername = (null === $session) ? '' : $session->get($lastUsernameKey);

        $csrfToken = $this->has('security.csrf.token_manager')
            ? $this->get('security.csrf.token_manager')->getToken('authenticate')->getValue()
            : null;

        $routeName = $request->get('_route');
        $data=array(
            'last_username' => $lastUsername,
            'error' => $error,
            'csrf_token' => $csrfToken,
            'routename'=>$routeName
        );
        return $this->redirectToRoute('verifprofil',$data);

    }
    public function listePediatresAction(Request $request)
    {

        $em=$this->getDoctrine()->getManager();
        $pediatress = $em->getRepository('SanteSpecialisteBundle:MedecinSpecialiste')->medecinOrdonné("Pédiatre");
        if($request->getMethod()=="POST") {
            $pediatress = $em->getRepository('SanteSpecialisteBundle:MedecinSpecialiste')->findmedecin($request->get('nom'),$request->get('prenom'),"Pédiatre",$request->get('gouv'));

        }

        /**
         * @var $paginator \Knp\Component\Pager\Paginator
         */
        $paginator=$this->get('knp_paginator');
        $pediatres=$paginator->paginate(
            $pediatress,
            $request->query->getInt('page',1),
            $request->query->getInt('limit',3)
        );
        dump(get_class($paginator));
        $session = $request->getSession();

        $authErrorKey = Security::AUTHENTICATION_ERROR;
        $lastUsernameKey = Security::LAST_USERNAME;

        // get the error if any (works with forward and redirect -- see below)
        if ($request->attributes->has($authErrorKey)) {
            $error = $request->attributes->get($authErrorKey);
        } elseif (null !== $session && $session->has($authErrorKey)) {
            $error = $session->get($authErrorKey);
            $session->remove($authErrorKey);
        } else {
            $error = null;
        }

        if (!$error instanceof AuthenticationException) {
            $error = null; // The value does not come from the security component.
        }

        // last username entered by the user
        $lastUsername = (null === $session) ? '' : $session->get($lastUsernameKey);

        $csrfToken = $this->has('security.csrf.token_manager')
            ? $this->get('security.csrf.token_manager')->getToken('authenticate')->getValue()
            : null;

        $routeName = $request->get('_route');
        $data=array(
            'last_username' => $lastUsername,
            'error' => $error,
            'csrf_token' => $csrfToken,
            'routename'=>$routeName,"pediatres"=>$pediatres
        );
        return $this->render('SanteSpecialisteBundle:specialiste:listeSpecialiste.html.twig',$data);
    }
    public function verifprofilAction(Request $request)
    {

        $em=$this->getDoctrine()->getManager();
        $articless = $em->getRepository('SantearticleBundle:article')->findBy(array('etat'=>"en cours"));
        $pediatress = $em->getRepository('SanteSpecialisteBundle:MedecinSpecialiste')->medecinOrdonnéverif();
        if($request->isXmlHttpRequest()) {
            $serializer = new Serializer(array(new ObjectNormalizer()));
            $pediatress = $em->getRepository('SanteSpecialisteBundle:MedecinSpecialiste')->findmedecinverif2($request->get('nom'),$request->get('prenom'),$request->get('specialite'),$request->get('cin'));
            $data=$serializer->normalize($pediatress);
            return new JsonResponse($data);
        }

        $session = $request->getSession();

        $authErrorKey = Security::AUTHENTICATION_ERROR;
        $lastUsernameKey = Security::LAST_USERNAME;

        // get the error if any (works with forward and redirect -- see below)
        if ($request->attributes->has($authErrorKey)) {
            $error = $request->attributes->get($authErrorKey);
        } elseif (null !== $session && $session->has($authErrorKey)) {
            $error = $session->get($authErrorKey);
            $session->remove($authErrorKey);
        } else {
            $error = null;
        }

        if (!$error instanceof AuthenticationException) {
            $error = null; // The value does not come from the security component.
        }

        // last username entered by the user
        $lastUsername = (null === $session) ? '' : $session->get($lastUsernameKey);

        $csrfToken = $this->has('security.csrf.token_manager')
            ? $this->get('security.csrf.token_manager')->getToken('authenticate')->getValue()
            : null;

        $routeName = $request->get('_route');
        $data=array(
            'last_username' => $lastUsername,
            'error' => $error,
            'csrf_token' => $csrfToken,
            'routename'=>$routeName,"pediatres"=>$pediatress,"articles"=>$articless
        );
        return $this->render('SanteSpecialisteBundle:specialiste:articleValidation.html.twig',$data);
    }
    public function listeOrthophonistesAction(Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $pediatress = $em->getRepository('SanteSpecialisteBundle:MedecinSpecialiste')->medecinOrdonné("Orthophoniste");
        if($request->getMethod()=="POST") {
            $pediatress = $em->getRepository('SanteSpecialisteBundle:MedecinSpecialiste')->findmedecin($request->get('nom'),$request->get('prenom'),"Orthophoniste",$request->get('gouv'));

        }
        /**
         * @var $paginator \Knp\Component\Pager\Paginator
         */
        $paginator=$this->get('knp_paginator');
        $pediatres=$paginator->paginate(
            $pediatress,
            $request->query->getInt('page',1),
            $request->query->getInt('limit',6)
        );
        dump(get_class($paginator));
        $session = $request->getSession();

        $authErrorKey = Security::AUTHENTICATION_ERROR;
        $lastUsernameKey = Security::LAST_USERNAME;

        // get the error if any (works with forward and redirect -- see below)
        if ($request->attributes->has($authErrorKey)) {
            $error = $request->attributes->get($authErrorKey);
        } elseif (null !== $session && $session->has($authErrorKey)) {
            $error = $session->get($authErrorKey);
            $session->remove($authErrorKey);
        } else {
            $error = null;
        }

        if (!$error instanceof AuthenticationException) {
            $error = null; // The value does not come from the security component.
        }

        // last username entered by the user
        $lastUsername = (null === $session) ? '' : $session->get($lastUsernameKey);

        $csrfToken = $this->has('security.csrf.token_manager')
            ? $this->get('security.csrf.token_manager')->getToken('authenticate')->getValue()
            : null;

        $routeName = $request->get('_route');
        $data=array(
            'last_username' => $lastUsername,
            'error' => $error,
            'csrf_token' => $csrfToken,
            'routename'=>$routeName,
            "pediatres"=>$pediatres
        );
        return $this->render('SanteSpecialisteBundle:specialiste:listeOrthophonistes.html.twig', $data);
    }
}
