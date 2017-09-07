<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use EvenementBundle\Entity\Statut;

class LoadStatutData implements FixtureInterface, ContainerAwareInterface
{

	/**
	 * @var   ContainerInterface
	 */
	private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {
        $statutInconnu = new Statut();
        $statutEnCours = new Statut();
        $statutTermine = new Statut();
        $statutArchive = new Statut();
        $statutAnnule = new Statut();

        /* Infos de chaque statut */
        $statutInconnu->setNom('Inconnu');
        $statutInconnu->setEtat(true);

        $statutEnCours->setNom('En cours');
        $statutEnCours->setEtat(true);

        $statutTermine->setNom('Terminé');
        $statutTermine->setEtat(true);

        $statutArchive->setNom('Archivé');
        $statutArchive->setEtat(true);

        $statutAnnule->setNom('Annulé');
        $statutAnnule->setEtat(true);

        $manager->persist($statutInconnu);
        $manager->persist($statutEnCours);
        $manager->persist($statutTermine);
        $manager->persist($statutArchive);
        $manager->persist($statutAnnule);

        $manager->flush();
    }
}

?>