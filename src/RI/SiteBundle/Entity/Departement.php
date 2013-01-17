<?php

namespace RI\SiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Departement
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="RI\SiteBundle\Entity\DepartementRepository")
 */
class Departement
{
    /**
     * @var integer
     *
     * @ORM\Column(name="dpt_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="dpt_libelle", type="string", length=255)
     */
    private $dpt_libelle;


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
     * Set dpt_libelle
     *
     * @param string $dptLibelle
     * @return Departement
     */
    public function setDptLibelle($dptLibelle)
    {
        $this->dpt_libelle = $dptLibelle;
    
        return $this;
    }

    /**
     * Get dpt_libelle
     *
     * @return string 
     */
    public function getDptLibelle()
    {
        return $this->dpt_libelle;
    }
}