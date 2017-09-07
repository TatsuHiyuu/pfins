<?php

namespace ClientBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Imagine\Image\Color;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\GroupSequenceProviderInterface;
use Imagine\Image\Box;
use Imagine\Image\Point;
/**
 * Client
 *
 * @ORM\Table(name="client")
 * @ORM\Entity(repositoryClass="ClientBundle\Repository\ClientRepository")
 * @Assert\GroupSequenceProvider()
 */
class Client implements GroupSequenceProviderInterface
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
     * @ORM\Column(name="marque", type="string", length=255)
     * @Assert\NotBlank(message="Compléter le champ 'marque'")
     */
    private $marque;

    /**
     * @Assert\NotBlank(groups = {"ajout"}, message="Veuillez sélectionner un fichier.")
     * @Assert\Image(
            mimeTypes = {"image/jpeg", "image/png", "image/jpg"}),
            maxSize = "1M"
     */
    private $file;

    /**
     * @var string
     *
     * @ORM\Column(name="logo", type="string", length=255)
     */
    private $logo;

    /**
     * @var string
     *
     * @ORM\Column(name="adresse", type="string", length=255)
     * @Assert\NotBlank(message="Compléter le champ 'adresse'")
     */
    private $adresse;

    /**
     * @var string
     *
     * @ORM\Column(name="adresseCP", type="string", length=255)
     * @Assert\NotBlank(message="Compléter le champ 'Code postal'")
     */
    private $adresseCP;

    /**
     * @var string
     *
     * @ORM\Column(name="adresseVille", type="string", length=255)
     * @Assert\NotBlank(message="Compléter le champ 'ville'")
     */
    private $adresseVille;

    /**
     * @var string
     *
     * @ORM\Column(name="site", type="string", length=255, nullable=true)
     * @Assert\Regex(
     *     pattern = "/^https?:\/\/(www\.)?/",
     *     match = true,
     *     message = "L'adresse du site doit commencer par 'http' ou 'https'."
     * )
     */
    private $site;

    /**
     * @var string
     *
     * @ORM\Column(name="commentaires", type="text", nullable=true)
     */
    private $commentaires;

    /**
     * @ORM\OneToMany(targetEntity="ClientBundle\Entity\Contact", mappedBy="client", cascade={"persist"})
     * @Assert\Valid
     */
    private $contacts;

    /**
     * @ORM\OneToMany(targetEntity="EvenementBundle\Entity\Evenement", mappedBy="client", cascade={"persist"})
     * @Assert\Valid
     */
    private $evenements;

    /**
     * @var int
     *
     * @ORM\Column(name="Etat", type="integer")
     */
    private $etat;

    public function __construct()
    {
        $this->created = new \DateTime();
        $this->etat = 0;
        $this->contacts = new ArrayCollection();
        $this->evenements = new ArrayCollection();
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
     * @return Client
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
     * @return Client
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
     * Set marque
     *
     * @param string $marque
     *
     * @return Client
     */
    public function setMarque($marque)
    {
        $this->marque = $marque;

        return $this;
    }

    /**
     * Get marque
     *
     * @return string
     */
    public function getMarque()
    {
        return $this->marque;
    }

    /**
     * Set adresse
     *
     * @param string $adresse
     *
     * @return Client
     */
    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;

        return $this;
    }

    /**
     * Get adresse
     *
     * @return string
     */
    public function getAdresse()
    {
        return $this->adresse;
    }

    /**
     * Set adresseCP
     *
     * @param string $adresseCP
     *
     * @return Client
     */
    public function setAdresseCP($adresseCP)
    {
        $this->adresseCP = $adresseCP;

        return $this;
    }

    /**
     * Get adresseCP
     *
     * @return string
     */
    public function getAdresseCP()
    {
        return $this->adresseCP;
    }

    /**
     * Set adresseVille
     *
     * @param string $adresseVille
     *
     * @return Client
     */
    public function setAdresseVille($adresseVille)
    {
        $this->adresseVille = $adresseVille;

        return $this;
    }

    /**
     * Get adresseVille
     *
     * @return string
     */
    public function getAdresseVille()
    {
        return $this->adresseVille;
    }

    /**
     * Set site
     *
     * @param string $site
     *
     * @return Client
     */
    public function setSite($site)
    {
        $this->site = $site;

        return $this;
    }

    /**
     * Get site
     *
     * @return string
     */
    public function getSite()
    {
        return $this->site;
    }

    /**
     * Set commentaires
     *
     * @param string $commentaires
     *
     * @return Client
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

    /**
     * Set etat
     *
     * @param integer $etat
     *
     * @return Client
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
     * Add contact
     *
     * @param \ClientBundle\Entity\Contact $contact
     *
     * @return Client
     */
    public function addContact(\ClientBundle\Entity\Contact $contact)
    {
        $this->contacts[] = $contact;

        return $this;
    }

    /**
     * Remove contact
     *
     * @param \ClientBundle\Entity\Contact $contact
     */
    public function removeContact(\ClientBundle\Entity\Contact $contact)
    {
        $this->contacts->removeElement($contact);
    }

    /**
     * Get contacts
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getContacts()
    {
        return $this->contacts;
    }

    /**
     * Add evenement
     *
     * @param \EvenementBundle\Entity\Evenement $evenement
     *
     * @return Client
     */
    public function addEvenement(\EvenementBundle\Entity\Evenement $evenement)
    {
        $this->evenements[] = $evenement;

        return $this;
    }

    /**
     * Remove evenement
     *
     * @param \EvenementBundle\Entity\Evenement $evenement
     */
    public function removeEvenement(\EvenementBundle\Entity\Evenement $evenement)
    {
        $this->evenements->removeElement($evenement);
    }

    /**
     * Get evenements
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEvenements()
    {
        return $this->evenements;
    }

    /** FILE */
    public function getFile()
    {
        return $this->file;
    }

    public function setFile(File $file = null)
    {
        $this->file = $file;
        if (null !== $this->logo){
            $this->logo = null;
        }

        $this->file = $file;
    }

    /**
     * Set logo
     *
     * @param string $logo
     *
     * @return Client
     */
    public function setLogo($logo)
    {
        $this->logo = $logo;

        return $this;
    }

    /**
     * Get logo
     *
     * @return string
     */
    public function getLogo()
    {
        return $this->logo;
    }

    /** UPLOAD LOGO */
    public function uploadLogo()
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
        $this->logo = $name;
    }

    /**
     * Retourne le chemin relatif de l'image pour le navigateur
     */
    public function getUploadDir()
    {
        return 'img/client/logo';
    }

    /**
     * On retourne le chemin relatif vers l'image pour notre code PHP
     */
    protected function getUploadRootDir()
    {
        return __DIR__.'/../../../web/'.$this->getUploadDir();
    }

    /** Contrainte selon le groupe(s) : champ vide ou pas ?
     *  Si nous somme sur la page d'ajout, le champ logo est obligatoire
     *  Sinon, sur la page modification, il est facultatif.
     */

    public function getGroupSequence()
    {
        return [
            'Client',
            empty($this->id) ? 'ajout' : 'modification',
        ];
    }

    /** TO STRING */
    public function __toString()
    {
        return $this->marque;
    }

}
