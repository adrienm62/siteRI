<?php

namespace RI\SiteBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Symfony\Component\Httpfoundation\Response;
use Symfony\Component\Httpfoundation\Request;
use RI\SiteBundle\Entity\Partenaire;
use RI\SiteBundle\Entity\Contact;
use RI\SiteBundle\Entity\Document;
use RI\UserBundle\Entity\User;

class SecretaireController extends Controller {
    
    public function voirUsersAction(){
        $users = $this->getDoctrine()->getEntityManager()
                 ->getRepository('RIUserBundle:User')
                ->findDemandeSuppression();
        
        return $this->render('RISiteBundle:Site:users.html.twig',
                array('liste_users' => $users));
    }
    
    
    /**
     * @Secure(roles="ROLE_SECRETARY")
     */
    public function suppressionCompteAction($id){
        $user = $this->getDoctrine()->getManager()->getRepository('RIUserBundle:User')->find($id);
        $stages = $user->getStages();
        $form = $this->createFormBuilder($user)->getForm();
        
        
        $request= $this->get('request');
        
        if ($user->isLocked() ) {
            if ($request->getMethod() == 'POST'){
            
                
                $em= $this->getDoctrine()->getManager();
                foreach ($stages as $stage){
                    $stage->setEtudiant(null);
                }
                $em->remove($user);
                $em->flush();

                return new Response("Suppression effectuée");
            }
       }
       
       return $this->render('RISiteBundle:Site:profilEtudiant.html.twig', array('profil' => $user, 'form' => $form->createView()));
    }
    
    
}

?>
