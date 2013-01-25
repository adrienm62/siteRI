<?php

namespace RI\SiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Partenaire
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="RI\SiteBundle\Entity\StatutPartenaireRepository")
 */
class StatutPartenaire
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
     * @ORM\Column(name="stp_libelle", type="string", length=255)
     */
    private $stp_libelle;


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
     * Set stp_libelle
     *
     * @param string $stpLibelle
     * @return Partenaire
     */
    public function setStpLibelle($stpLibelle)
    {
        $this->stp_libelle = $stpLibelle;
    
        return $this;
    }

    /**
     * Get stp_libelle
     *
     * @return string 
     */
    public function getStpLibelle()
    {
        return $this->stp_libelle;
    }
}
