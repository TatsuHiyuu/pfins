<?php

namespace EvenementBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Rassemblement
 *
 * @ORM\Table(name="rassemblement")
 * @ORM\Entity(repositoryClass="EvenementBundle\Repository\RassemblementRepository")
 */
class Rassemblement
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetime")
     */
    private $created;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="changed", type="datetime", nullable=true)
     */
    private $changed;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="lieu", type="string", length=255)
     */
    private $lieu;

    /**
     * @var int
     *
     * @ORM\Column(name="nbPDV", type="integer")
     */
    private $nbPDV;

    /**
     * @var int
     *
     * @ORM\Column(name="placesParPDV", type="integer")
     */
    private $placesParPDV;

    /**
     * @var int
     *
     * @ORM\Column(name="nbBC", type="integer")
     */
    private $nbBC;

    /**
     * @var int
     *
     * @ORM\Column(name="etat", type="integer")
     */
    private $etat;

    /**
     * @ORM\ManyToOne(targetEntity="EvenementBundle\Entity\Evenement", inversedBy="rassemblements")
     * @ORM\JoinColumn(name="evenement_id", referencedColumnName="id")
     */
    private $evenement;

    /**
     * @var string
     *
     * @ORM\Column(name="commentaires", type="text", nullable=true)
     */
    private $commentaires;

    public function __construct()
    {
        $this->created = new \DateTime();
        $this->etat = 0;
    }


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     *
     * @return Rassemblement
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set changed
     *
     * @param \DateTime $changed
     *
     * @return Rassemblement
     */
    public function setChanged($changed)
    {
        $this->changed = $changed;

        return $this;
    }

    /**
     * Get changed
     *
     * @return \DateTime
     */
    public function getChanged()
    {
        return $this->changed;
    }

    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return Rassemblement
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Rassemblement
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set lieu
     *
     * @param string $lieu
     *
     * @return Rassemblement
     */
    public function setLieu($lieu)
    {
        $this->lieu = $lieu;

        return $this;
    }

    /**
     * Get lieu
     *
     * @return string
     */
    public function getLieu()
    {
        return $this->lieu;
    }

    /**
     * Set nbPDV
     *
     * @param integer $nbPDV
     *
     * @return Rassemblement
     */
    public function setNbPDV($nbPDV)
    {
        $this->nbPDV = $nbPDV;

        return $this;
    }

    /**
     * Get nbPDV
     *
     * @return int
     */
    public function getNbPDV()
    {
        return $this->nbPDV;
    }

    /**
     * Set placesParPDV
     *
     * @param integer $placesParPDV
     *
     * @return Rassemblement
     */
    public function setPlacesParPDV($placesParPDV)
    {
        $this->placesParPDV = $placesParPDV;

        return $this;
    }

    /**
     * Get placesParPDV
     *
     * @return int
     */
    public function getPlacesParPDV()
    {
        return $this->placesParPDV;
    }

    /**
     * Set nbBC
     *
     * @param integer $nbBC
     *
     * @return Rassemblement
     */
    public function setNbBC($nbBC)
    {
        $this->nbBC = $nbBC;

        return $this;
    }

    /**
     * Get nbBC
     *
     * @return int
     */
    public function getNbBC()
    {
        return $this->nbBC;
    }

    /**
     * Set etat
     *
     * @param integer $etat
     *
     * @return Rassemblement
     */
    public function setEtat($etat)
    {
        $this->etat = $etat;

        return $this;
    }

    /**
     * Get etat
     *
     * @return int
     */
    public function getEtat()
    {
        return $this->etat;
    }

    /**
     * Set evenement
     *
     * @param \EvenementBundle\Entity\Evenement $evenement
     *
     * @return Rassemblement
     */
    public function setEvenement(\EvenementBundle\Entity\Evenement $evenement = null)
    {
        $this->evenement = $evenement;

        return $this;
    }

    /**
     * Get evenement
     *
     * @return \EvenementBundle\Entity\Evenement
     */
    public function getEvenement()
    {
        return $this->evenement;
    }

    /**
     * Set commentaires
     *
     * @param string $commentaires
     *
     * @return Rassemblement
     */
    public function setCommentaires($commentaires)
    {
        $this->commentaires = $commentaires;

        return $this;
    }

    /**
     * Get commentaires
     *
     * @return string
     */
    public function getCommentaires()
    {
        return $this->commentaires;
    }
}

