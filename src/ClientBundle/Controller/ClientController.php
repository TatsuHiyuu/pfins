<?php

namespace ClientBundle\Controller;

use Doctrine\Common\Collections\ArrayCollection;
use GlobalBundle\Service\FileUploader;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use ClientBundle\Entity\Client;
use ClientBundle\Form\ClientType;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\HttpFoundation\JsonResponse;

class ClientController extends Controller
{
    public function AdminAjouterAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $client = new Client;
        $form = $this->get('form.factory')->create(ClientType::class, $client);

        /* Réception du formulaire */
        if ($form->handleRequest($request)->isValid()) {
            foreach($client->getContacts() as $contact) {
                $contact->setClient($client);
                $contact->uploadPhoto();
            }
            $client->uploadLogo();

            $em->persist($client);
            $em->flush();

            $request->getSession()->getFlashBag()->add('succes', 'Client enregistré avec succès');
            return $this->redirect($this->generateUrl('admin_client_manager'));
        }

        return $this->render('ClientBundle:Admin:ajouter.html.twig',
            array(
                'form' => $form->createView()
            )
            );
    }

    public function AdminModifierAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $client = $this->getDoctrine()
                       ->getRepository('ClientBundle:Client')
                       ->find($id);
        $form = $this->get('form.factory')->create(ClientType::class, $client);

        $originalImages = new ArrayCollection();
        $client->setChanged(new \DateTime());

        /* On garde en mémoire la liste avant modification pour effectuer d'éventuelles suppression */
        $contactList1 = array();

        foreach($client->getContacts() as $contact)
        {
            array_push($contactList1, $contact);
            $originalImages->add($contact);
        }

        /* Réception du formulaire */
        if ($form->handleRequest($request)->isValid())
        {
            $contactList2 = array();
            foreach($client->getContacts() as $contact) {
                array_push($contactList2, $contact);
                $contact->setClient($client);
                $contact->uploadPhoto();
            }

            /* Suppression des éléments qui ne sont pas dans la liste 2 alors qu'ils sont dans la liste 1 */
            if ($contactList1 != $contactList2) {
                foreach ($contactList1 as $contact) {
                    if (!in_array($contact, $contactList2)) {
                        $em->remove($contact);
                    }
                }
            }

            $client->uploadLogo();

            $em->persist($client);
            $em->flush();

            $request->getSession()->getFlashBag()->add('succes', 'Utilisateur modifié avec succès');
            return $this->redirect($this->generateUrl('admin_client_manager'));

        }

        return $this->render('ClientBundle:Admin:modifier.html.twig',
            array(
                'form' => $form->createView(),
                'client' => $client,
                'contacts' => $originalImages
            )
            );
    }

    public function AdminManagerAction(Request $request)
    {

        /* Services */
        $rechercheService = $this->get('recherche.service');
        $recherches = $rechercheService->setRecherche('client_manager', array(
                'clientname'
            )
        );

        /* Doctrine */
        $em = $this->getDoctrine()->getManager();

        $repository = $em->getRepository('ClientBundle:Client');
        $clients = $repository->getAllClients($recherches['clientname']);

        /* Pagination */
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $clients, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            50/*limit per page*/
        );

        return $this->render('ClientBundle:Admin:manager.html.twig',
                array(
                    'pagination' => $pagination,
                    'recherches' => $recherches
                )
            );

    }

    public function AdminSupprimerImageAction(Request $request, $id)
    {
        if($request->isXmlHttpRequest()){
            $em = $this->getDoctrine()->getManager();

            $contact = $this->getDoctrine()
                ->getRepository('ClientBundle:Contact')
                ->find($id);
            $contact->setPhoto(null);
            $em->flush();

            return new JsonResponse(array('state' => 'ok'));
        }
    }

}
