<?php

namespace Adri\BlogBundle\Entity;
use Doctrine\ORM\Mapping as ORM;

class ContactSecondaireStage {
    
    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="RI\SiteBundle\Stage")
     */
     private $stage;
    
    /**
    * @ORM\Id
    * @ORM\ManyToOne(targetEntity="RI\SiteBundle\Entity\Contact")
     */
    private $contact;
    
    
    
    public function setStage(\RI\SiteBundle\Entity\Stage $stage){
        $this->stage = $stage;
    }
    
    public function getStage(){
        return $this->stage;
    }
    
    public function setContact(\RI\SiteBundle\Entity\Contact $contact) {
        $this->contact = $contact;
    }
    
    public function getContact(){
        return $this->contact;
    }
}
?>
