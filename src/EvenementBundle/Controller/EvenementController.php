<?php

namespace EvenementBundle\Controller;

use EvenementBundle\Entity\Commentaire;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;
use EvenementBundle\Entity\Evenement;
use EvenementBundle\Entity\Rassemblement;
use EvenementBundle\Form\EvenementType;
use EvenementBundle\Form\CommentaireType;
use EvenementBundle\Form\RassemblementType;
use EvenementBundle\Form\CsvType;


class EvenementController extends Controller
{
    public function AdminAjouterAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $evenement = new Evenement();
        $form = $this->get('form.factory')->create(EvenementType::class, $evenement);

        /* Réception du formulaire */
        if ($form->handleRequest($request)->isValid()) {
            foreach($evenement->getDocuments() as $document) {
                $document->setAuteur($this->getUser()->getUsername());
                $document->setEvenement($evenement);
                $document->uploadDocument();
            }
            $em->persist($evenement);
            $em->flush();

            $request->getSession()->getFlashBag()->add('succes', 'Événement enregistré avec succès');
            return $this->redirect($this->generateUrl('admin_evenement_manager'));
        }

        return $this->render('EvenementBundle:Admin:ajouter.html.twig',
            array(
                'form' => $form->createView()
            )
        );
    }

    public function AdminModifierAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $evenement = $this->getDoctrine()
            ->getRepository('EvenementBundle:Evenement')
            ->find($id);
        $form = $this->get('form.factory')->create(EvenementType::class, $evenement);
        $evenement->setChanged(new \DateTime());

        /* On garde en mémoire la liste avant modification pour effectuer d'éventuelles suppression */
        $documentList1 = array();

        foreach($evenement->getDocuments() as $document)
        {
            array_push($documentList1, $document);
        }

        /* Réception du formulaire */
        if ($form->handleRequest($request)->isValid())
        {
            $documentList2 = array();
            foreach ($evenement->getDocuments() as $document) {
                array_push($documentList2, $document);
                $document->setAuteur($this->getUser()->getUsername());
                $document->setEvenement($evenement);
                $document->setChanged(new \DateTime());
                $document->uploadDocument();
            }

            /* Suppression des éléments qui ne sont pas dans la liste 2 alors qu'ils sont dans la liste 1 */
            if ($documentList1 != $documentList2) {
                foreach ($documentList1 as $document) {
                    if (!in_array($document, $documentList2)) {
                        $em->remove($document);
                    }
                }
            }

            $em->persist($evenement);
            $em->flush();

            $request->getSession()->getFlashBag()->add('succes', 'Evenement modifié avec succès');
            return $this->redirect($this->generateUrl('admin_evenement_manager'));
        }

        return $this->render('EvenementBundle:Admin:modifier.html.twig',
            array(
                'form' => $form->createView(),
                'evenement' => $evenement,
            )
        );
    }

    public function AdminManagerAction(Request $request)
    {

        /* Services */
        $rechercheService = $this->get('recherche.service');
        $recherches = $rechercheService->setRecherche('evenement_manager', array(
                'evenementname'
            )
        );

        /* Doctrine */
        $em = $this->getDoctrine()->getManager();

        $repository = $em->getRepository('EvenementBundle:Evenement');
        $evenements = $repository->getAllEvenements($recherches['evenementname']);
        $user = $em->getRepository('UserBundle:User')->find($this->getUser()->getId());
        $forms = array();

        /* form */
        foreach ($evenements as $evenement) {
            $commentaire = new Commentaire();
            $form = $this->get('form.factory')->create(CommentaireType::class, $commentaire);
            $forms[$evenement->getId()]['view'] = $form->createView();
        }

        /* Réception du formulaire */
        if ($form->handleRequest($request)->isValid())
        {
            $evenementid = $form->getData()->getEvenementId();
            $evenement = $em->getRepository('EvenementBundle:Evenement')->find($evenementid);
            $commentaire->setEvenement($evenement);
            $commentaire->setUser($user);
            $em->persist($commentaire);
            $em->flush();

            $request->getSession()->getFlashBag()->add('succes', 'Commentaire posté avec succès');
            return $this->redirect($this->generateUrl('admin_evenement_manager'));
        }

        /* Pagination */
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $evenements, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            50/*limit per page*/
        );

        return $this->render('EvenementBundle:Admin:manager.html.twig',
            array(
                'pagination' => $pagination,
                'recherches' => $recherches,
                'forms' => $forms,
            )
        );

    }

    public function AdminAjouterDateAction(Request $request, $evtid)
    {
        $em = $this->getDoctrine()->getManager();

        $rassemblement = new Rassemblement();
        $evenement = $this->getDoctrine()
            ->getRepository('EvenementBundle:Evenement')
            ->find($evtid);
        $evtnom = $evenement->getNom();
        $rassemblement->setEvenement($evenement);
        $form = $this->get('form.factory')->create(RassemblementType::class, $rassemblement);

        /* Réception du formulaire */
        if ($form->handleRequest($request)->isValid()) {
            $em->persist($rassemblement);
            $em->flush();

            $request->getSession()->getFlashBag()->add('succes', 'Date enregistrée avec succès');
            return $this->redirect($this->generateUrl('admin_evenement_manager'));
        }

        return $this->render('EvenementBundle:Admin:ajouterDate.html.twig',
            array(
                'form' => $form->createView(),
                'evenementnom' => $evtnom
            )
        );
    }

    public function AdminModifierDateAction(Request $request, $id)
    {

    }

    public function AdminViewEvenementAction(Request $request, $id)
    {

        $em = $this->getDoctrine()->getManager();

        $evenement = $this->getDoctrine()
            ->getRepository('EvenementBundle:Evenement')
            ->find($id);

        $form = $this->get('form.factory')->create(CsvType::class);

        /* Réception du formulaire */
        if ($form->handleRequest($request)->isValid()) {
//            if (($handle = fopen("")))
            $csv = fgetcsv($form, 1000, ";");
            dump($csv);
//            dump($form->getData()); die();
        }

        return $this->render('EvenementBundle:Admin:evenement.html.twig',
            array(
                'form' => $form->createView(),
                'evenement' => $evenement
            )
        );
    }
}
