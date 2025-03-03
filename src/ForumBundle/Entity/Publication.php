<?php
/**
 * Created by PhpStorm.
 * User: ikbel
 * Date: 11/02/2018
 * Time: 19:41
 */

namespace ForumBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
/**
 * Class Publication
 * @package ForumBundle\Entity
 */
/**
 * @ORM\Entity(repositoryClass="ForumBundle\Repository\publicationRepository")
 */
class Publication
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
     * @var int
     *
     * @ORM\Column(name="u", type="integer")
     */
    private $u;

    /**
     * @var int
     *
     * @ORM\Column(name="idcategorie", type="integer")
     */
    private $iddcategorie;

    /**
     * @ORM\ManyToOne(targetEntity="ForumBundle\Entity\Categorie")
     * @ORM\JoinColumn(name="id_categorie", referencedColumnName="id")
     */
    private $id_categorie;


    /**
     * @var string
     *
     * @ORM\Column(name="titre_qestion", type="string")
     */
    private $titre;

    /**
     * @var int
     *
     * @ORM\Column(name="nbr_vue", type="integer")
     */
    private $nbr_vue;

    /**
     * @ORM\Column(name="created", type="integer")
     */
    private $created;

    /**
     * @var int
     *
     * @ORM\Column(name="nbr_reponse", type="integer")
     */
    private $nbrReponse;

    /**
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User")
     * @ORM\JoinColumn(name="id_user", referencedColumnName="id")
     */
    private $iduser;

    /**
     * @var string
     *
     * @ORM\Column(name="location", type="string")
     */
    private $location;

    /**
     *
     * @ORM\Column(name="contenu", type="text")
     */
    private $contenu;

    /**
     * @var string
     *
     * @ORM\Column(name="piece_jointe", type="string", length=5000)
     */
    private $pieceJointe;

    /**
     * @ORM\OneToMany(targetEntity="ForumBundle\Entity\Reponse",mappedBy="id_publication")
     * @ORM\JoinColumn(name="id_reponse", referencedColumnName="id")
     */
    private $id_reponse;
    /**
     *  @var int
     *
     * @ORM\Column(name="resolu", type="integer")
     */
    private $resolu;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->id_reponse = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set titre
     *
     * @param string $titre
     *
     * @return Publication
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;

        return $this;
    }

    /**
     * Get titre
     *
     * @return string
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * Set nbrVue
     *
     * @param integer $nbrVue
     *
     * @return Publication
     */
    public function setNbrVue($nbrVue)
    {
        $this->nbr_vue = $nbrVue;

        return $this;
    }

    /**
     * Get nbrVue
     *
     * @return integer
     */
    public function getNbrVue()
    {
        return $this->nbr_vue;
    }

    /**
     * Set created
     *
     * @param integer $created
     *
     * @return Publication
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return integer
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set nbrReponse
     *
     * @param integer $nbrReponse
     *
     * @return Publication
     */
    public function setNbrReponse($nbrReponse)
    {
        $this->nbrReponse = $nbrReponse;

        return $this;
    }

    /**
     * Get nbrReponse
     *
     * @return integer
     */
    public function getNbrReponse()
    {
        return $this->nbrReponse;
    }

    /**
     * Set location
     *
     * @param string $location
     *
     * @return Publication
     */
    public function setLocation($location)
    {
        $this->location = $location;

        return $this;
    }

    /**
     * Get location
     *
     * @return string
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * Set contenu
     *
     * @param string $contenu
     *
     * @return Publication
     */
    public function setContenu($contenu)
    {
        $this->contenu = $contenu;

        return $this;
    }

    /**
     * Get contenu
     *
     * @return string
     */
    public function getContenu()
    {
        return $this->contenu;
    }

    /**
     * Set pieceJointe
     *
     * @param string $pieceJointe
     *
     * @return Publication
     */
    public function setPieceJointe($pieceJointe)
    {
        $this->pieceJointe = $pieceJointe;

        return $this;
    }

    /**
     * Get pieceJointe
     *
     * @return string
     */
    public function getPieceJointe()
    {
        return $this->pieceJointe;
    }

    /**
     * Set idCategorie
     *
     * @param \ForumBundle\Entity\Categorie $idCategorie
     *
     * @return Publication
     */
    public function setIdCategorie( $idCategorie )
    {
        $this->id_categorie = $idCategorie;

        return $this;
    }

    /**
     * Get idCategorie
     *
     * @return \ForumBundle\Entity\Categorie
     */
    public function getIdCategorie()
    {
        return $this->id_categorie;
    }

    /**
     * Set iduser
     *
     * @param \UserBundle\Entity\User $iduser
     *
     * @return Publication
     */
    public function setIduser( $iduser )
    {
        $this->iduser = $iduser;

        return $this;
    }

    /**
     * Get iduser
     *
     * @return \UserBundle\Entity\User
     */
    public function getIduser()
    {
        return $this->iduser;
    }

    /**
     * Add idReponse
     *
     * @param \ForumBundle\Entity\Publication $idReponse
     *
     * @return Publication
     */
    public function addIdReponse(\ForumBundle\Entity\Publication $idReponse)
    {
        $this->id_reponse[] = $idReponse;

        return $this;
    }

    /**
     * Remove idReponse
     *
     * @param \ForumBundle\Entity\Publication $idReponse
     */
    public function removeIdReponse(\ForumBundle\Entity\Publication $idReponse)
    {
        $this->id_reponse->removeElement($idReponse);
    }

    /**
     * Get idReponse
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getIdReponse()
    {
        return $this->id_reponse;
    }

    /**
     * Set iddcategorie
     *
     * @param integer $iddcategorie
     *
     * @return Publication
     */
    public function setIddcategorie($iddcategorie)
    {
        $this->iddcategorie = $iddcategorie;

        return $this;
    }

    /**
     * Get iddcategorie
     *
     * @return integer
     */
    public function getIddcategorie()
    {
        return $this->iddcategorie;
    }

    /**
     * Set resolu
     *
     * @param integer $resolu
     *
     * @return Publication
     */
    public function setResolu($resolu)
    {
        $this->resolu = $resolu;

        return $this;
    }

    /**
     * Get resolu
     *
     * @return integer
     */
    public function getResolu()
    {
        return $this->resolu;
    }

    /**
     * @return int
     */
    public function getU()
    {
        return $this->u;
    }

    /**
     * @param int $u
     */
    public function setU($u)
    {
        $this->u = $u;
    }
}
