<?php

namespace RI\SiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Stage
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="RI\SiteBundle\Entity\StageRepository")
 */
class Stage
{
    /**
     * @var integer
     *
     * @ORM\Column(name="sta_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="sta_sujet", type="text")
     */
    private $sta_sujet;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="sta_debut", type="date")
     */
    private $sta_debut;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="sta_fin", type="date")
     */
    private $sta_fin;

    /**
     * @ORM\ManyToOne(targetEntity="RI/SiteBundle/Entity/Contact")
     * @ORM\JoinColumn(nullable=false)
     */
    private $contactPrimaire;
    
    /**
     *@ORM\ManyToOne(targetEntity="RI/SiteBundle/Entity/Formation")
     *@ORM\JoinColumn(nullable=false)
     */
    private $formation;
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
     * Set sta_sujet
     *
     * @param string $staSujet
     * @return Stage
     */
    public function setStaSujet($staSujet)
    {
        $this->sta_sujet = $staSujet;
    
        return $this;
    }

    
    /**
     * Get sta_sujet
     *
     * @return string 
     */
    public function getStaSujet()
    {
        return $this->sta_sujet;
    }

    /**
     * Set sta_debut
     *
     * @param \DateTime $staDebut
     * @return Stage
     */
    public function setStaDebut($staDebut)
    {
        $this->sta_debut = $staDebut;
    
        return $this;
    }

    /**
     * Get sta_debut
     *
     * @return \DateTime 
     */
    public function getStaDebut()
    {
        return $this->sta_debut;
    }

    /**
     * Set sta_fin
     *
     * @param \DateTime $staFin
     * @return Stage
     */
    public function setStaFin($staFin)
    {
        $this->sta_fin = $staFin;
    
        return $this;
    }

    /**
     * Get sta_fin
     *
     * @return \DateTime 
     */
    public function getStaFin()
    {
        return $this->sta_fin;
    }

    /**
     * Set contactPrimaire
     *
     * @param \RI\SiteBundle\Entity\RI/SiteBundle/Entity/Contact $contactPrimaire
     * @return Stage
     */
    public function setContactPrimaire(\RI\SiteBundle\Entity\Contact $contactPrimaire)
    {
        $this->contactPrimaire = $contactPrimaire;
    
        return $this;
    }

    /**
     * Get contactPrimaire
     *
     * @return \RI\SiteBundle\Entity\RI/SiteBundle/Entity/Contact 
     */
    public function getContactPrimaire()
    {
        return $this->contactPrimaire;
    }

    /**
     * Set formation
     *
     * @param \RI\SiteBundle\Entity\RI/SiteBundle/Entity/Formation $formation
     * @return Stage
     */
    public function setFormation(\RI\SiteBundle\Entity\Formation $formation)
    {
        $this->formation = $formation;
    
        return $this;
    }

    /**
     * Get formation
     *
     * @return \RI\SiteBundle\Entity\RI/SiteBundle/Entity/Formation 
     */
    public function getFormation()
    {
        return $this->formation;
    }
}