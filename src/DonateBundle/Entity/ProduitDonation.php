<?php

namespace DonateBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert ;
/**
 * ProduitDonation
 *
 * @ORM\Table(name="produit_donation")
 * @ORM\Entity(repositoryClass="DonateBundle\Repository\ProduitDonationRepository")
 */
class ProduitDonation
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
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;


    /**
     * @var integer
     *
     * @ORM\Column(name="idu", type="integer")
     */
    private $idu;




    /**
     * @var integer
     *
     * @ORM\Column(name="nbj", type="integer")
     */
    private $nbj='0';


    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;


    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datenow", type="date")
     */
    private $datenow;

    /**
     * @var string
     *
     * @ORM\Column(name="categorie", type="string", length=255)
     */
    private $categorie;
    /**
     * @ORM\Column(type="string")
     *
     * @Assert\NotBlank(message="Please, upload the product brochure as a PDF file.")
     * @Assert\Image()
     */
    private $image;

    /**
     * @var integer
     *
     * @ORM\Column(name="tel", type="integer",)
     */
    private $tel;

     /**
     * @var integer
     *
     * @ORM\Column(name="appro", type="integer",)
     */
    private $appro="0";


    /**
     * @var string
     *
     * @ORM\Column(name="etat", type="string",)
     */
    private $etat="en attente";

    /**
     * @var string
     *
     * @ORM\Column(name="adresse", type="string", length=255)
     */
    public $adresse;






    /**
     * @var string
     *
     * @ORM\Column(name="nomuser", type="string", length=255)
     */
    private $nomuser;


    /**
     * @var string
     *
     * @ORM\Column(name="genre", type="string", length=255)
     */
    private $genre;




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
     * Set nom
     *
     * @param string $nom
     *
     * @return ProduitDonation
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
     * Set datenow
     *
     * @param \DateTime $datenow
     *
     * @return ProduitDonation
     */
    public function setDatenow($datenow)
    {
        $this->datenow = $datenow;

        return $this;
    }

    /**
     * Get datenow
     *
     * @return \DateTime
     */
    public function getDatenow()
    {
        return $this->datenow;
    }

    /**
     * Set categorie
     *
     * @param string $categorie
     *
     * @return ProduitDonation
     */
    public function setCategorie($categorie)
    {
        $this->categorie = $categorie;

        return $this;
    }

    /**
     * Get categorie
     *
     * @return string
     */
    public function getCategorie()
    {
        return $this->categorie;
    }

    /**
     * Set image
     *
     * @param string $image
     *
     * @return ProduitDonation
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set tel
     *
     * @param string $tel
     *
     * @return ProduitDonation
     */
    public function setTel($tel)
    {
        $this->tel = $tel;

        return $this;
    }

    /**
     * Get tel
     *
     * @return string
     */
    public function getTel()
    {
        return $this->tel;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return ProduitDonation
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set nomuser
     *
     * @param string $nomuser
     *
     * @return ProduitDonation
     */
    public function setNomuser($nomuser)
    {
        $this->nomuser = $nomuser;

        return $this;
    }

    /**
     * Get nomuser
     *
     * @return string
     */
    public function getNomuser()
    {
        return $this->nomuser;
    }

    /**
     * Set genre
     *
     * @param string $genre
     *
     * @return ProduitDonation
     */
    public function setGenre($genre)
    {
        $this->genre = $genre;

        return $this;
    }

    /**
     * Get genre
     *
     * @return string
     */
    public function getGenre()
    {
        return $this->genre;
    }

    /**
     * Set idu
     *
     * @param integer $idu
     *
     * @return ProduitDonation
     */
    public function setIdu($idu)
    {
        $this->idu = $idu;

        return $this;
    }

    /**
     * Get idu
     *
     * @return integer
     */
    public function getIdu()
    {
        return $this->idu;
    }

    /**
     * Set adresse
     *
     * @param string $adresse
     *
     * @return ProduitDonation
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
     * Set appro.
     *
     * @param int $appro
     *
     * @return ProduitDonation
     */
    public function setAppro($appro)
    {
        $this->appro = $appro;

        return $this;
    }

    /**
     * Get appro.
     *
     * @return int
     */
    public function getAppro()
    {
        return $this->appro;
    }

    /**
     * Set etat.
     *
     * @param int $etat
     *
     * @return ProduitDonation
     */
    public function setEtat($etat)
    {
        $this->etat = $etat;

        return $this;
    }

    /**
     * Get etat.
     *
     * @return int
     */
    public function getEtat()
    {
        return $this->etat;
    }

    /**
     * Set nbj.
     *
     * @param int $nbj
     *
     * @return ProduitDonation
     */
    public function setNbj($nbj)
    {
        $this->nbj = $nbj;

        return $this;
    }

    /**
     * Get nbj.
     *
     * @return int
     */
    public function getNbj()
    {
        return $this->nbj;
    }
}
