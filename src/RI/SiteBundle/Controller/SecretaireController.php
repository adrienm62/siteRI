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
use RI\SiteBundle\Controller\DocController;


class SecretaireController extends Controller {
    
    public function voirUsersAction(){
        $users = $this->getDoctrine()->getEntityManager()
                 ->getRepository('RIUserBundle:User')
                ->findDemandeSuppression();
        
        return $this->render('RISiteBundle:Site:listeetudiantssuppression.html.twig',
                array('liste_users' => $users));
    }
    
    /**
     * @Secure(roles="ROLE_ADMIN, ROLE_SECRETARY")
     */
    public function inscrireEtudiantAction(){
        $user = new User;
       
        
        $form = $this->createFormBuilder($user)
                    ->add('username', 'text', array('label'=>'Nom d\'utilisateur*'))
                    ->add('nom', 'text', array('label'=>'Nom*'))
                    ->add('prenom', 'text', array('label'=>'Prénom*'))
                    ->add('email', 'text', array('label'=>'Email*') )
                    ->add('adresse', 'textarea', array('required'=>false))
                    ->add('ville', 'text', array('required'=>false))
                    ->add('ine', 'text', array('label'=>'Numéro d\'INE*'))
                    ->getForm();
        
        $request = $this->get('request');
        
        if ($request->getMethod() == 'POST'){
            $form->bind($request);
            
            if ($form->isValid()){
                $password = sha512("1234");
                $user->setPassword($password);
                $em = $this->getDoctrine()->getManager();
                $em->persist($user);
                $em->flush();
                
                return $this->redirect($this->generateUrl('risite_profil'), array('id' => $user->getId()));
                
            }
            
            
        }
        
        return $this->render('RISiteBundle:Site:ajouteretudiant.html.twig', array('form' => $form->createView()));
                    
                
    }
    
    /**
     * @Secure(roles="ROLE_ADMIN, ROLE_SECRETARY")
     */
    public function suppressionCompteAction($id){
        $user = $this->getDoctrine()->getManager()->getRepository('RIUserBundle:User')->find($id);
        $stages = $user->getStages();
        $documents = $user->getDocuments();
        $form = $this->createFormBuilder($user)->getForm();
        
        $request= $this->get('request');
        
        if ($user->isLocked() ) {
            if ($request->getMethod() == 'POST'){
            
                
                $em= $this->getDoctrine()->getManager();
                foreach ($stages as $stage){
                    $stage->setEtudiant(null);
                }
                
                foreach ($documents as $document) {
                   $document->delete();
                }
                $em->remove($user);
                $em->flush();

                $this->get('session')->getFlashBag()->add('notice', 'Suppression bien prise en compte');
                return $this->redirect( $this->generateUrl('risite_liste_demandes') );
            }
       }
       
       return $this->render('RISiteBundle:Site:demande2.html.twig', array('profil' => $user, 'form' => $form->createView()));
    }
    
    
}

?>
