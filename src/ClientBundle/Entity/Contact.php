<?php

namespace ClientBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Imagine\Image\Color;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\GroupSequenceProviderInterface;
use Imagine\Image\Box;
use Imagine\Image\Point;

/**
 * Contact
 *
 * @ORM\Table(name="contact")
 * @ORM\Entity(repositoryClass="ClientBundle\Repository\ContactRepository")
 */
class Contact
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
     * @Assert\NotBlank(message="Compléter le champ 'nom'")
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="prenom", type="string", length=255)
     * @Assert\NotBlank(message="Compléter le champ 'prenom'")
     */
    private $prenom;

    /**
     * @Assert\Image(
    mimeTypes = {"image/jpeg", "image/png", "image/jpg"}),
    maxSize = "1M"
     */
    private $file;

    /**
     * @var string
     *
     * @ORM\Column(name="photo", type="string", length=255, nullable=true)
     */
    private $photo;

    /**
     * @var string
     *
     * @ORM\Column(name="fonction", type="string", length=255, nullable=true)
     */
    private $fonction;

    /**
     * @var string
     *
     * @ORM\Column(name="telephone", type="string", length=255, nullable=true)
     */
    private $telephone;

    /**
     * @var string
     *
     * @ORM\Column(name="portable", type="string", length=255, nullable=true)
     */
    private $portable;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255)
     * @Assert\NotBlank(message="Compléter le champ 'e-mail'")
     * @Assert\Email(
     *     message = "L'adresse e-mail '{{ value }}' n'est pas une adresse valide.",
     *     checkMX = true
     *     )
     */
    private $email;

    /**
     * @var int
     *
     * @ORM\Column(name="etat", type="integer")
     */
    private $etat;

    /**
     *
     * @ORM\ManyToOne(targetEntity="ClientBundle\Entity\Client", inversedBy="contacts")
     * @ORM\JoinColumn(name="client_id", referencedColumnName="id")
     */
    private $client;

    public function __construct()
    {
        $this->created = new \DateTime();
        $this->etat = 0;
    }

    /**
     * Get id
     *
     * @return integer
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
     * @return Contact
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
     * @return Contact
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
     * @return Contact
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
     * Set prenom
     *
     * @param string $prenom
     *
     * @return Contact
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get prenom
     *
     * @return string
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Set fonction
     *
     * @param string $fonction
     *
     * @return Contact
     */
    public function setFonction($fonction)
    {
        $this->fonction = $fonction;

        return $this;
    }

    /**
     * Get fonction
     *
     * @return string
     */
    public function getFonction()
    {
        return $this->fonction;
    }

    /**
     * Set telephone
     *
     * @param string $telephone
     *
     * @return Contact
     */
    public function setTelephone($telephone)
    {
        $this->telephone = $telephone;

        return $this;
    }

    /**
     * Get telephone
     *
     * @return string
     */
    public function getTelephone()
    {
        return $this->telephone;
    }

    /**
     * Set portable
     *
     * @param string $portable
     *
     * @return Contact
     */
    public function setPortable($portable)
    {
        $this->portable = $portable;

        return $this;
    }

    /**
     * Get portable
     *
     * @return string
     */
    public function getPortable()
    {
        return $this->portable;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Contact
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set etat
     *
     * @param integer $etat
     *
     * @return Contact
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
     * Set client
     *
     * @param \ClientBundle\Entity\Client $client
     *
     * @return Contact
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

    /** FILE */
    public function getFile()
    {
        return $this->file;
    }

    public function setFile(File $file = null)
    {
        $this->file = $file;
        if (null !== $this->photo){
            $this->photo = null;
        }

        $this->file = $file;
    }

    /**
     * Set photo
     *
     * @param string $photo
     *
     * @return Client
     */
    public function setPhoto($photo)
    {
        $this->photo = $photo;

        return $this;
    }

    /**
     * Get photo
     *
     * @return string
     */
    public function getPhoto()
    {
        return $this->photo;
    }

    /** UPLOAD PHOTO */
    public function uploadPhoto()
    {
        // Si jamais il n'y a pas de fichier (champ facultatif), on ne fait rien
        if (is_null($this->file)) {
            return;
        }

        // On récupère le nom original du fichier de l'internaute
        $name = uniqid().'.'.strtolower(pathinfo($this->file->getClientOriginalName(), PATHINFO_EXTENSION));

        // On déplace le fichier envoyé dans le répertoire de notre choix
        $this->file->move($this->getUploadRootDir(), $name);

        // Redimension de l'image
        $width = 170;
        $height = 170;

        $imagine = new \Imagine\Gd\Imagine();
        $size = new Box($width, $height);
        $target = $this->getUploadDir().'/'.$name;
        $image = $imagine->open($target);
        $resizeimg = $image->thumbnail($size,'inset');

        $sizeR = $resizeimg->getSize();
        $widthR = $sizeR->getWidth();
        $heightR = $sizeR->getHeight();

        $palette = new Color('#FFF');
        $preserve = $imagine->create(new Box($width,$height),$palette);
        $startX = $startY = 0;

        if ($widthR < $width) {
            $startX = ($width - $widthR) / 2;
        }

        if ($heightR < $height) {
            $startY = ($height - $heightR) / 2;
        }

        $preserve->paste($resizeimg, new Point($startX,$startY))
            ->save($this->getUploadDir().'/'.$name);

        /* On enregistre le nom de l'image dans l'entité */
        $this->photo = $name;
    }

    /**
     * Retourne le chemin relatif de l'image pour le navigateur
     */
    public function getUploadDir()
    {
        return 'img/client/photo';
    }

    /**
     * On retourne le chemin relatif vers l'image pour notre code PHP
     */
    protected function getUploadRootDir()
    {
        return __DIR__.'/../../../web/'.$this->getUploadDir();
    }

}
