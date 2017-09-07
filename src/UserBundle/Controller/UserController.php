<?php

namespace UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use UserBundle\Entity\User;
use UserBundle\Form\UserType;
use UserBundle\Form\CompteType;
use UserBundle\Form\RegisterType;
use UserBundle\Form\UserPasswordType;
use Symfony\Component\HttpFoundation\JsonResponse;

class UserController extends Controller
{

    /**
     * Formulaire de connexion
     * @param  Request $request
     */
    public function LoginAction(Request $request)
    {

        $authenticationUtils = $this->get('security.authentication_utils');
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render(
            'UserBundle:Client:login.html.twig',
            array(
                // last username entered by the user
                'last_username' => $lastUsername,
                'error'         => $error,
            )
        );

    }

    /**
     * Formulaire d'inscription
     * @param  Request $request
     */
    public function RegisterAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();

        $user = new User;
        $form = $this->get('form.factory')->create(RegisterType::class, $user);

        /* Récéption du formulaire */
        if ($form->handleRequest($request)->isValid()){
            $password = $this->container->get('security.password_encoder')
                                        ->encodePassword($user, $form->get('password')->getData());
            $user->setPassword($password);

            $user->uploadAvatar();

            $em->persist($user);
            $em->flush();

            $request->getSession()->getFlashBag()->add('succes', 'Vous êtes maintenant inscrit, votre compte est en attente de validation');
            return $this->redirect($this->generateUrl('login'));
        }

        return $this->render( 'UserBundle:Client:register.html.twig', array(
                'form' => $form->createView()
            )
        );
    }

    /**
     * Modification compte administration
     * @param  Request $request
     */
    public function AdminCompteModifierAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();

        /* Création du fomulaire */
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $form = $this->get('form.factory')->create(CompteType::class, $user);

        /* Récéption du formulaire */
        if ($form->handleRequest($request)->isValid()){
            $user->uploadAvatar();

            $em->flush();

            $request->getSession()->getFlashBag()->add('succes', 'Informations modifiés avec succès');
            return $this->redirect($this->generateUrl('admin_page_index'));
        }

        /* BreadCrumb */
        $breadcrumb = array(
            'Accueil' => 'admin_page_index',
            'Mes informations' => ''
        );

        return $this->render( 'UserBundle:Admin:compteModifier.html.twig',
            array(
                'breadcrumb' => $breadcrumb,
                'utilisateur' => $user,
                'form' => $form->createView()
            )
        );

    }

    /**
     * Modification compte password administration
     * @param  Request $request
     */
    public function AdminComptePasswordAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();

        /* Création du fomulaire */
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $form = $this->get('form.factory')->create(UserPasswordType::class, $user);

        /* Récéption du formulaire */
        if ($form->handleRequest($request)->isValid()){
            $password = $this->container->get('security.password_encoder')
                                        ->encodePassword($user, $form->get('password')->getData());
            $user->setPassword($password);

            $em->persist($user);
            $em->flush();

            $request->getSession()->getFlashBag()->add('succes', 'Mot de passe modifié avec succès');
            return $this->redirect($this->generateUrl('admin_page_index'));
        }

        /* BreadCrumb */
        $breadcrumb = array(
            'Accueil' => 'admin_page_index',
            'Mes informations' => ''
        );

        return $this->render( 'UserBundle:Admin:comptePassword.html.twig',
            array(
                'breadcrumb' => $breadcrumb,
                'form' => $form->createView()
            )
        );

    }

    /**
     * Gestion des utilisateurs
     * @param  Request $request
     */
    public function AdminManagerAction(Request $request)
    {
        /* Services */
        $rechercheService = $this->get('recherche.service');
        $recherches = $rechercheService->setRecherche('user_manager', array(
                'username'
            )
        );

        /* La liste des utilisateurs */
        $utilisateurs = $this->getDoctrine()
                             ->getRepository('UserBundle:User')
                             ->getAllUser($recherches['username']);

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $utilisateurs, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            50/*limit per page*/
        );

        return $this->render( 'UserBundle:Admin:manager.html.twig', array(
                'pagination' => $pagination,
                'recherches' => $recherches
            )
        );

    }

    /**
     * Ajouter un utilisateur
     * @param  Request $request
     */
    public function AdminAjouterAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $user = new User;
        $form = $this->get('form.factory')->create(UserType::class, $user);

        /* Récéption du formulaire */
        if ($form->handleRequest($request)->isValid()){
            $password = $this->container->get('security.password_encoder')
                                        ->encodePassword($user, $form->get('password')->getData());
            $user->setPassword($password);

            $user->uploadAvatar();

            $em->persist($user);
            $em->flush();

            $request->getSession()->getFlashBag()->add('succes', 'Utilisateur enregistré avec succès');
            return $this->redirect($this->generateUrl('admin_user_manager'));
        }

        return $this->render( 'UserBundle:Admin:ajouter.html.twig',
            array(
                'form' => $form->createView()
            )
        );

    }

    /**
     * Publication dépublication
     * @param  Request $request
     * @param  int $id id de l'utilisateur
     */
    public function AdminPublierAction(Request $request, $id){

        if($request->isXmlHttpRequest()){
            $em = $this->getDoctrine()->getManager();

            $utilisateur = $this->getDoctrine()
                                ->getRepository('UserBundle:User')
                                ->find($id);

            $state = $utilisateur->reverseState();

            $utilisateur->setIsActive($state);
            $em->flush();

            return new JsonResponse(array('state' => $state));
        }

    }

    /**
     * Supprimer l'avatar d'un utilisateur
     * @param Request $request [description]
     * @param int l'identifiant de l'utilisateur
     */
    public function AdminSupprimerAvatarAction(Request $request, $id)
    {
        if($request->isXmlHttpRequest()){
            $em = $this->getDoctrine()->getManager();

            $user = $this->getDoctrine()
                         ->getRepository('UserBundle:User')
                         ->find($id);
            $user->setAvatar(null);
            $em->flush();

            return new JsonResponse(array('state' => 'ok'));
        }
    }

    /**
     * Modifier un utilisateur
     * @param  Request $request
     * @param  int $id id de l'utilisateur
     */
    public function AdminModifierAction(Request $request, $id)
    {

        $em = $this->getDoctrine()->getManager();

        $user = $this->getDoctrine()
                     ->getRepository('UserBundle:User')
                     ->find($id);

        $form = $this->get('form.factory')->create(CompteType::class, $user);

        /* Récéption du formulaire */
        if ($form->handleRequest($request)->isValid()){
            $user->uploadAvatar();

            $em->persist($user);
            $em->flush();

            $request->getSession()->getFlashBag()->add('succes', 'Utilisateur enregistré avec succès');
            return $this->redirect($this->generateUrl('admin_user_manager'));
        }

        /* BreadCrumb */
        $breadcrumb = array(
            'Accueil' => 'admin_page_index',
            'Gestion des utilisateurs' => 'admin_user_manager',
            'Modifier un utilisateur' => ''
        );

        return $this->render( 'UserBundle:Admin:modifier.html.twig',
            array(
                'breadcrumb' => $breadcrumb,
                'form' => $form->createView(),
                'utilisateur' => $user
            )
        );

    }

    /**
     * Modifier le mot de passe
     * @param  Request $request
     * @param  int $id id de l'utilisateur
     */
    public function AdminModifierPasswordAction(Request $request, $id)
    {

        $em = $this->getDoctrine()->getManager();

        $user = $this->getDoctrine()
            ->getRepository('UserBundle:User')
            ->find($id);

        $form = $this->get('form.factory')->create(UserPasswordType::class, $user);

        /* Récéption du formulaire */
        if ($form->handleRequest($request)->isValid()){
            $password = $this->container->get('security.password_encoder')
                                        ->encodePassword($user, $form->get('password')->getData());
            $user->setPassword($password);

            $em->persist($user);
            $em->flush();

            $request->getSession()->getFlashBag()->add('succes', 'Utilisateur enregistré avec succès');
            return $this->redirect($this->generateUrl('admin_user_manager'));
        }

        /* BreadCrumb */
        $breadcrumb = array(
            'Accueil' => 'admin_page_index',
            'Gestion es utilisateurs' => 'admin_user_manager',
            'Modifier un mot de passe' => ''
        );

        return $this->render( 'UserBundle:Admin:modifierPassword.html.twig',
            array(
                'breadcrumb' => $breadcrumb,
                'form' => $form->createView(),
                'utilisateur' => $user
            )
        );

    }
}
