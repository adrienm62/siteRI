<?php

namespace RI\SiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Formation
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="RI\SiteBundle\Entity\FormationRepository")
 */
class Formation
{
    /**
     * @var integer
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="for_libelle", type="string", length=255)
     */
    private $for_libelle;

    /**
     * @var integer
     *
     * @ORM\Column(name="for_annee", type="date")
     */
    private $for_annee;
    
    /**
     *@ORM\ManyToOne(targetEntity="RI\SiteBundle\Entity\Departement")
     *@ORM\JoinColumn(nullable=true) 
     */
    private $departement;
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
     * Set for_libelle
     *
     * @param string $forLibelle
     * @return Formation
     */
    public function setForLibelle($forLibelle)
    {
        $this->for_libelle = $forLibelle;
    
        return $this;
    }

    /**
     * Get for_libelle
     *
     * @return string 
     */
    public function getForLibelle()
    {
        return $this->for_libelle;
    }

    /**
     * Set for_annee
     *
     * @param integer $forAnnee
     * @return Formation
     */
    public function setForAnnee($forAnnee)
    {
        $this->for_annee = $forAnnee;
    
        return $this;
    }

    /**
     * Get for_annee
     *
     * @return integer 
     */
    public function getForAnnee()
    {
        return $this->for_annee;
    }

    /**
     * Set departement
     *
     * @param \RI\SiteBundle\Entity\Departement $departement
     * @return Formation
     */
    public function setDepartement(\RI\SiteBundle\Entity\Departement $departement)
    {
        $this->departement= $departement;
    
        return $this;
    }

    /**
     * Get departement
     *
     * @return \RI\SiteBundle\Entity\Departement 
     */
    public function getDepartement()
    {
        return $this->departement;
    }
    
    public function __toString() {
        return $this->libelle . " ";
    }
}