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
    
    
class SiteController extends Controller {
    public function indexAction(){
        $query = $this->getDoctrine()->getEntityManager()->createQuery(
                'SELECT u FROM RIUserBundle:User u WHERE u.roles = :admin ')
                ->setParameter('admin', 'a:1:{i:0;s:10:"ROLE_ADMIN";}'); 
        try{
            $admin=$query->getSingleResult();
        }catch(\Doctrine\Orm\NoResultException $e){
            $admin=null;
            return null;
        }
        
        return $this->render('RISiteBundle:Site:index.html.twig', array('admin' => $admin));
    }
    
    public function voirProfilAction(){
        $profil = $this->getUser();
        
        $form=$this->createFormBuilder($profil)
            ->add('adresse','text',array('label'=>'Adresse',  'required' => false))
            ->add('codepostal','text', array('label'=>'Code Postal',  'required' => false))
            ->add('ville','text', array('label'=>'Ville',  'required' => false))
            ->add('email','text', array('label'=>'Email*',  'required' => false))
            ->add('tel1','text', array('label'=>'Téléphone 1',  'required' => false))
            ->add('tel2','text', array('label'=>'Téléphone 2',  'required' => false))
            ->getForm();

        
        $request= $this->get('request');

        if ($request->getMethod() == 'POST'){
            $form->bind($request);

            if($form->isValid()){
                
                $em= $this->getDoctrine()->getManager();
                $em->flush();

                return $this->redirect($this->generateURL('risite_profil'));
            }
        }
        
        //suppression ou modification de mot de passe
        $defaultData = array('Nom de l\utilisateur' => '', 'Prénom de l\'utilisateur' => '');
        $form2 = $this->createFormBuilder($defaultData)
                ->add('traitement', 'choice', 
                        array('choices' => array('m' => 'Modifier le mot de passe','s' => 'Demande de suppression'),
                            'label'=>'Modification de mot de passe ou suppression de compte?'))
                ->getForm();
        
        if ($this->getRequest()->isMethod('POST')) {
            $form2->bind($this->getRequest());

            // les données sont un tableau avec les clés "name", "email", et "message"
            
            $choix = $form2->get('traitement')->getData();
            
            if($choix == 'm'){
                return $this->redirect($this->generateURL('fos_user_change_password'));
            }  elseif ($choix == 's') {
                return $this->redirect($this->generateURL('risite_demandesuppression'));
            }
        }

        return $this->render('RISiteBundle:Site:profil.html.twig', array('profil' => $profil, 
            'form' => $form->createView(),'form2' => $form2->createView()));
    }
    
    
    public function voirProfil2Action($id){
        $profil = $this->getDoctrine()->getManager()->getRepository('RIUserBundle:User')->find($id);
        $current_user = $this->getUser();
        
        if($profil === null){
            throw $this->createNotFoundException('Le profil de cet utilisateur id['.$id.'] n\'existe pas.');
        }
               
        if($current_user == $profil){
            return $this->redirect($this->generateURL('risite_profil'));
        }else{
            return $this->render('RISiteBundle:Site:profilUser.html.twig', array('profil' => $profil));
        }
    }
    
    public function voirPartenairesAction(){
        $partenaires = $this->getDoctrine()->getManager()->getRepository('RISiteBundle:Partenaire')->findAll();
 
        if($partenaires === null){
            throw $this->createNotFoundException('La liste des partenaires est vide.');
        }
        
        return $this->render('RISiteBundle:Site:listepartenaires.html.twig', array('partenaires' => $partenaires));
    }
    
    public function voirEtudiantsAction(){
        $em = $this->getDoctrine()->getEntityManager();
        $query = $em->createQuery('SELECT e FROM RIUserBundle:User e 
            WHERE e.ine IS NOT NULL');

        $etudiants = $query->getResult();
 
        if($etudiants === null){
            throw $this->createNotFoundException('La liste des étudiants est vide.');
        }
        
        return $this->render('RISiteBundle:Site:listeEtudiants.html.twig', 
                array('etudiants' => $etudiants));
    }
    
    public function voirInfoPartenaireAction($id){
        $partenaire = $this->getDoctrine()->getManager()->getRepository('RISiteBundle:Partenaire')->find($id);
        
        if($partenaire === null){
            throw $this->createNotFoundException('Le partenaire [id='.$id.'] n\'existe pas.');
        }
        
        return $this->render('RISiteBundle:Site:partenaire.html.twig', array('partenaire' => $partenaire));
    }
    
    public function voirInfoContactAction($id){
        $contact = $this->getDoctrine()->getManager()->getRepository('RISiteBundle:Contact')->find($id);
        
        if($contact === null){
            throw $this->createNotFoundException('Le contact [id='.$id.'] n\'existe pas.');
        }
        
        return $this->render('RISiteBundle:Site:contact.html.twig', array('contact' => $contact));
    }
    
    public function voirStagesAction(){
        $stages = $this->getDoctrine()->getManager()->getRepository('RISiteBundle:Stage')->findAll();
        
        if($stages === null){
            throw $this->createNotFoundException('La liste des stages est vide.');
        }
        
        return $this->render('RISiteBundle:Site:listeStages.html.twig', array('stages' => $stages));
    }
    
    public function voirInfoStageAction($idStage){
        //récupération du stage
        $stage = $this->getDoctrine()->getManager()->getRepository('RISiteBundle:Stage')->find($idStage);
        
        if($stage === null){
            throw $this->createNotFoundException('Le stage n\'existe pas.');
        }
        
        return $this->render('RISiteBundle:Site:stage.html.twig', array('stage' => $stage));
    }   
    
    
    public function demandeSuppressionAction(){
        $user = $this->getUser();
        $form = $this->createFormBuilder($user)->getForm();
        
        
        $request= $this->get('request');

        if ($request->getMethod() == 'POST'){
            
            $user->setDemandeSuppression(true);
            $em= $this->getDoctrine()->getManager();
            $em->flush();

            $this->get('session')->getFlashBag()->add('notice', 'Demande bien prise en compte');
            return $this->redirect( $this->generateUrl('risite_accueil') );
       }
        
        return $this->render('RISiteBundle:Site:demande.html.twig', array('form' => $form->createView()));
    }
    
}
