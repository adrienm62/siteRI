<?php

namespace RI\UserBundle\Entity;

use FOS\UserBundle\Entity\User as BaseUser;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="RI\UserBundle\Entity\UserRepository")
 * 
 */
class User extends BaseUser {
     /**
     * @ORM\Id
     * @ORM\Column(name = "id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    
    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Entrez votre nom.")
     * @Assert\MinLength(limit="3", message="Votre nom est trop court")
     * @Assert\MaxLength(limit="255", message="Votre nom est trop long.")
     */
    protected $nom;
    
    
    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Entrez votre prenom")
     * @Assert\MinLength(limit="3", message="Votre prenom est trop court")
     * @Assert\MaxLength(limit="255", message="Votre prénom est trop long.")
     */
    protected $prenom;
    
    
    /**
     *@ORM\Column(type="text", nullable=true)
     *
     */
    protected $adresse;
    
    
    /**
     *@ORM\Column(type="string", length = 5, nullable = true)
     */
    protected $codepostal;
    
    /**
     *@ORM\Column(type="string", length = 255, nullable= true)
     */
    protected $ville;
    
    /**
     *@ORM\Column(type="text", nullable = true)
     */
    protected $tel1;
    
    
    /**
     *@ORM\Column(type="text", nullable = true)
     * 
     */
    protected $tel2;
     /**
     *@ORM\Column(type="string", length = 255, nullable = true)
     * 
     */
    protected $ine;
    
    /**
      * @ORM\OneToMany(targetEntity="RI\SiteBundle\Entity\Document", mappedBy="user")
      * @ORM\JoinColumn(nullable=true)
      */
     protected $documents;
    
     /**
      ** @ORM\OneToMany(targetEntity="RI\SiteBundle\Entity\Stage", mappedBy="etudiant")
      *  @ORM\JoinColumn(nullable=true)
      */
     protected $stages;

     /**
      * @var boolean
      * @ORM\Column(type="boolean", nullable = true)
      */
     protected $demandeSuppression;


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
     * Set nom
     *
     * @param string $nom
     * @return User
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
     * @return User
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
     * Set adresse
     *
     * @param string $adresse
     * @return User
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
     * Set codepostal
     *
     * @param string $codepostal
     * @return User
     */
    public function setCodepostal($codepostal)
    {
        $this->codepostal = $codepostal;
    
        return $this;
    }

    /**
     * Get codepostal
     *
     * @return string 
     */
    public function getCodepostal()
    {
        return $this->codepostal;
    }

    /**
     * Set ville
     *
     * @param string $ville
     * @return User
     */
    public function setVille($ville)
    {
        $this->ville = $ville;
    
        return $this;
    }

    /**
     * Get ville
     *
     * @return string 
     */
    public function getVille()
    {
        return $this->ville;
    }

    /**
     * Set tel1
     *
     * @param string $tel1
     * @return User
     */
    public function setTel1($tel1)
    {
        $this->tel1 = $tel1;
    
        return $this;
    }

    /**
     * Get tel1
     *
     * @return string 
     */
    public function getTel1()
    {
        return $this->tel1;
    }

    /**
     * Set tel2
     *
     * @param string $tel2
     * @return User
     */
    public function setTel2($tel2)
    {
        $this->tel2 = $tel2;
    
        return $this;
    }

    /**
     * Get tel2
     *
     * @return string 
     */
    public function getTel2()
    {
        return $this->tel2;
    }
    
    public function setIne($ine){
        $this->ine = $ine;
        
        return $this;
    }
    
    public function getIne(){
        return $this->ine;
    }
    
    public function __toString() {
        
        return $this->nom . " " . $this->prenom; 
        
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->documents = new \Doctrine\Common\Collections\ArrayCollection();
        $this->user = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add documents
     *
     * @param \RI\SiteBundle\Entity\Document $documents
     * @return User
     */
    public function addDocument(\RI\SiteBundle\Entity\Document $documents)
    {
        $this->documents[] = $documents;
    
        return $this;
    }

    /**
     * Remove documents
     *
     * @param \RI\SiteBundle\Entity\Document $documents
     */
    public function removeDocument(\RI\SiteBundle\Entity\Document $documents)
    {
        $this->documents->removeElement($documents);
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

    

    /**
     * Add stages
     *
     * @param \RI\SiteBundle\Entity\Stage $stages
     * @return User
     */
    public function addStage(\RI\SiteBundle\Entity\Stage $stages)
    {
        $this->stages[] = $stages;
    
        return $this;
    }

    /**
     * Remove stages
     *
     * @param \RI\SiteBundle\Entity\Stage $stages
     */
    public function removeStage(\RI\SiteBundle\Entity\Stage $stages)
    {
        $this->stages->removeElement($stages);
    }

    /**
     * Get stages
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getStages()
    {
        return $this->stages;
    }

    

    /**
     * Set demandeSuppression
     *
     * @param boolean $demandeSuppression
     * @return User
     */
    public function setDemandeSuppression($demandeSuppression)
    {
        $this->demandeSuppression = $demandeSuppression;
    
        return $this;
    }

    /**
     * Get demandeSuppression
     *
     * @return boolean 
     */
        public function suppressionEstDemandee(){
        return $this->demandeSuppression;
    }
}