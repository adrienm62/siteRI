<?php

namespace RI\SiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ContactSecondaire
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="RI\SiteBundle\Entity\ContactSecondaireRepository")
 */
class ContactSecondaire
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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
}
