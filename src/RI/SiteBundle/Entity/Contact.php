<?php

namespace RI\SiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Contact
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="RI\SiteBundle\Entity\ContactRepository")
 */
class Contact
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="cont_nom", type="string", length=255)
     */
    private $cont_nom;

    /**
     * @var string
     *
     * @ORM\Column(name="cont_prenom", type="string", length=255)
     */
    private $cont_prenom;

    /**
     * @var string
     *
     * @ORM\Column(name="cont_adresse", type="text")
     */
    private $cont_adresse;

    /**
     * @var string
     *
     * @ORM\Column(name="cont_mail", type="text")
     */
    private $cont_mail;

    /**
     * @var integer
     *
     * @ORM\Column(name="cont_tel", type="integer")
     */
    private $cont_tel;

    /**
     * @var string
     *
     * @ORM\Column(name="cont_mdp", type="text")
     */
    private $cont_mdp;
    
    /**
     *
     *@ORM\OneToMany(targetEntity="RI\SiteBundle\Entity\Partenaire", mappedBy="contact")
     *@ORM\JoinColumn(nullable=false)
     */
    
    private $partenaire;
    
    
    /**
     * @ORM\ManyToMany(targetEntity="RI\SiteBundle\Entity\Document", cascade = {"persist"})
     * @ORM\JoinColumn(nullable=true)
     */
    protected $documents;
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
     * Set cont_nom
     *
     * @param string $contNom
     * @return Contact
     */
    public function setContNom($contNom)
    {
        $this->cont_nom = $contNom;
    
        return $this;
    }

    /**
     * Get cont_nom
     *
     * @return string 
     */
    public function getContNom()
    {
        return $this->cont_nom;
    }

    /**
     * Set cont_prenom
     *
     * @param string $contPrenom
     * @return Contact
     */
    public function setContPrenom($contPrenom)
    {
        $this->cont_prenom = $contPrenom;
    
        return $this;
    }

    /**
     * Get cont_prenom
     *
     * @return string 
     */
    public function getContPrenom()
    {
        return $this->cont_prenom;
    }

    /**
     * Set cont_adresse
     *
     * @param string $contAdresse
     * @return Contact
     */
    public function setContAdresse($contAdresse)
    {
        $this->cont_adresse = $contAdresse;
    
        return $this;
    }

    /**
     * Get cont_adresse
     *
     * @return string 
     */
    public function getContAdresse()
    {
        return $this->cont_adresse;
    }

    /**
     * Set cont_mail
     *
     * @param string $contMail
     * @return Contact
     */
    public function setContMail($contMail)
    {
        $this->cont_mail = $contMail;
    
        return $this;
    }

    /**
     * Get cont_mail
     *
     * @return string 
     */
    public function getContMail()
    {
        return $this->cont_mail;
    }

    /**
     * Set cont_tel
     *
     * @param integer $contTel
     * @return Contact
     */
    public function setContTel($contTel)
    {
        $this->cont_tel = $contTel;
    
        return $this;
    }

    /**
     * Get cont_tel
     *
     * @return integer 
     */
    public function getContTel()
    {
        return $this->cont_tel;
    }

    /**
     * Set cont_mdp
     *
     * @param string $contMdp
     * @return Contact
     */
    public function setContMdp($contMdp)
    {
        $this->cont_mdp = $contMdp;
    
        return $this;
    }

    /**
     * Get cont_mdp
     *
     * @return string 
     */
    public function getContMdp()
    {
        return $this->cont_mdp;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->partenaire = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add partenaire
     *
     * @param \RI\SiteBundle\Entity\Partenaire $partenaire
     * @return Contact
     */
    public function addPartenaire(\RI\SiteBundle\Entity\Partenaire $partenaire)
    {
        $this->partenaire[] = $partenaire;
    
        return $this;
    }

    /**
     * Remove partenaire
     *
     * @param \RI\SiteBundle\Entity\Partenaire $partenaire
     */
    public function removePartenaire(\RI\SiteBundle\Entity\Partenaire $partenaire)
    {
        $this->partenaire->removeElement($partenaire);
    }

    /**
     * Get partenaire
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPartenaire()
    {
        return $this->partenaire;
    }

    /**
     * Add documents
     *
     * @param \RI\SiteBundle\Entity\Document $documents
     * @return Contact
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
}