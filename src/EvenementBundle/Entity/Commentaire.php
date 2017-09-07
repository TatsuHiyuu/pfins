<?php

namespace EvenementBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Commentaire
 *
 * @ORM\Table(name="commentaire")
 * @ORM\Entity(repositoryClass="EvenementBundle\Repository\CommentaireRepository")
 */
class Commentaire
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
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User", inversedBy="commentaires")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * @var int
     *
     * @ORM\Column(name="etat", type="integer")
     */
    private $etat;

    /**
     * @ORM\ManyToOne(targetEntity="EvenementBundle\Entity\Evenement", inversedBy="commentaires")
     * @ORM\JoinColumn(name="evenement_id", referencedColumnName="id")
     */
    private $evenement;

    /**
     * @var int
     */
    private $evenement_id;

    /**
     * @var string
     *
     * @ORM\Column(name="commentaire", type="string", length=255)
     * @Assert\NotBlank(message="Veuillez mettre au moins un mot.")
     */
    private $commentaire;

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
     * @return Commentaire
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
     * @return Commentaire
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
     * Set commentaire
     *
     * @param string $commentaire
     *
     * @return Commentaire
     */
    public function setCommentaire($commentaire)
    {
        $this->commentaire = $commentaire;

        return $this;
    }

    /**
     * Get commentaire
     *
     * @return string
     */
    public function getCommentaire()
    {
        return $this->commentaire;
    }

    /**
     * Set etat
     *
     * @param integer $etat
     *
     * @return Commentaire
     */
    public function setEtat($etat)
    {
        $this->etat = $etat;

        return $this;
    }

    /**
     * Get etat
     *
     * @return integer
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
     * @return Commentaire
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
     * Set evenement_id
     *
     * @param integer $evenement_id
     *
     * @return Commentaire
     */
    public function setEvenementId($evenement_id)
    {
        $this->evenement_id = $evenement_id;

        return $this;
    }

    /**
     * Get evenement_id
     *
     * @return integer
     */
    public function getEvenementId()
    {
        return $this->evenement_id;
    }

    /**
     * Set user
     *
     * @param \UserBundle\Entity\User $user
     *
     * @return Commentaire
     */
    public function setUser(\UserBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \UserBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }
}

