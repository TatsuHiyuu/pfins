<?php

namespace EvenementBundle\Entity;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Evenement
 *
 * @ORM\Table(name="evenement")
 * @ORM\Entity(repositoryClass="EvenementBundle\Repository\EvenementRepository")
 */
class Evenement
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
     * @ORM\ManyToOne(targetEntity="ClientBundle\Entity\Client", inversedBy="evenements")
     * @ORM\JoinColumn(name="client_id", referencedColumnName="id")
     */
    private $client;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;

    /**
     * @var date
     *
     * @ORM\Column(name="dateDebut", type="date")
     */
    private $dateDebut;

    /**
     * @var date
     *
     * @ORM\Column(name="dateFin", type="date")
     */
    private $dateFin;

    /**
     * @ORM\OneToMany(targetEntity="EvenementBundle\Entity\Document", mappedBy="evenement", cascade={"persist"})
     * @Assert\Valid
     */
    private $documents;

    /**
     * @ORM\OneToMany(targetEntity="EvenementBundle\Entity\Commentaire", mappedBy="evenement", cascade={"persist"})
     * @Assert\Valid
     */
    private $commentaires;

    /**
     * @ORM\OneToMany(targetEntity="EvenementBundle\Entity\Rassemblement", mappedBy="evenement", cascade={"persist"})
     * @Assert\Valid
     */
    private $rassemblements;

    /**
     * @ORM\ManyToOne(targetEntity="EvenementBundle\Entity\Statut", inversedBy="evenements")
     * @ORM\JoinColumn(name="statut_id", referencedColumnName="id")
     */
    private $statut;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var int
     *
     * @ORM\Column(name="etat", type="integer")
     */
    private $etat;

    public function __construct()
    {
        $this->created = new \DateTime();
        $this->etat = 0;
        $this->documents = new ArrayCollection();
        $this->commentaires = new ArrayCollection();
        $this->rassemblements = new ArrayCollection();
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
     * @return Evenement
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
     * @return Evenement
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
     * Set client
     *
     * @param \ClientBundle\Entity\Client $client
     *
     * @return Evenement
     */
    public function setClient(\ClientBundle\Entity\Client $client = null)
    {
        $this->client = $client;

        return $this;
    }

    /**
     * Get client
     *
     * @return \ClientBundle\Entity\Client
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return Evenement
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
     * Set dateDebut
     *
     * @param date $dateDebut
     *
     * @return Evenement
     */
    public function setDateDebut($dateDebut)
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    /**
     * Get dateDebut
     *
     * @return date
     */
    public function getDateDebut()
    {
        return $this->dateDebut;
    }

    /**
     * Set dateFin
     *
     * @param date $dateFin
     *
     * @return Evenement
     */
    public function setDateFin($dateFin)
    {
        $this->dateFin = $dateFin;

        return $this;
    }

    /**
     * Get dateFin
     *
     * @return date
     */
    public function getDateFin()
    {
        return $this->dateFin;
    }
    /*----------------------------------------------------------*/
    /**
     * Set statut
     *
     * @param integer $statut
     *
     * @return Evenement
     */
    public function setStatut($statut)
    {
        $this->statut = $statut;

        return $this;
    }

    /**
     * Get statut
     *
     * @return int
     */
    public function getStatut()
    {
        return $this->statut;
    }
    /*----------------------------------------------------------*/
    /**
     * Set description
     *
     * @param string $description
     *
     * @return Evenement
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get $description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set etat
     *
     * @param integer $etat
     *
     * @return Evenement
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
    /*----------------------------------------------------------*/
    /**
     * Add document
     *
     * @param \EvenementBundle\Entity\Document $document
     *
     * @return Evenement
     */
    public function addDocument(\EvenementBundle\Entity\Document $document)
    {
        $this->documents[] = $document;

        return $this;
    }

    /**
     * Remove document
     *
     * @param \EvenementBundle\Entity\Document $document
     */
    public function removeDocument(\EvenementBundle\Entity\Document $document)
    {
        $this->documents->removeElement($document);
    }

    /**
     * Get documents
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDocuments()
    {
        return $this->documents;
    }
    /*----------------------------------------------------------*/
    /**
     * Add commentaire
     *
     * @param \EvenementBundle\Entity\Commentaire $commentaire
     *
     * @return Evenement
     */
    public function addCommentaire(\EvenementBundle\Entity\Commentaire $commentaire)
    {
        $this->commentaires[] = $commentaire;

        return $this;
    }

    /**
     * Remove commentaire
     *
     * @param \EvenementBundle\Entity\Commentaire $commentaire
     */
    public function removeCommentaire(\EvenementBundle\Entity\Commentaire $commentaire)
    {
        $this->commentaires->removeElement($commentaire);
    }

    /**
     * Get commentaires
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCommentaires()
    {
        return $this->commentaires;
    }

    /*----------------------------------------------------------*/
    /**
     * Add rassemblement
     *
     * @param \EvenementBundle\Entity\Rassemblement $rassemblement
     *
     * @return Evenement
     */
    public function addRassemblement(\EvenementBundle\Entity\Rassemblement $rassemblement)
    {
        $this->rassemblements[] = $rassemblement;

        return $this;
    }

    /**
     * Remove rassemblement
     *
     * @param \EvenementBundle\Entity\Rassemblement $rassemblement
     */
    public function removeRassemblement(\EvenementBundle\Entity\Rassemblement $rassemblement)
    {
        $this->rassemblements->removeElement($rassemblement);
    }

    /**
     * Get rassemblements
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRassemblements()
    {
        return $this->rassemblements;
    }
    /*----------------------------------------------------------*/

    /** TO STRING */
    public function __toString()
    {
        return $this->nom;
    }
}

