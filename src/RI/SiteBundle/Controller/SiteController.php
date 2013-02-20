<?php
namespace RI\SiteBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Symfony\Component\Httpfoundation\Response;
use Symfony\Component\Httpfoundation\Request;
use RI\SiteBundle\Entity\Partenaire;
use RI\SiteBundle\Entity\Contact;
use RI\UserBundle\Entity\User;
    
    
class SiteController extends Controller {
    public function indexAction(){
        return $this->render('RISiteBundle:Site:index.html.twig');
    }
    
    public function voirProfilAction($id){
        $user = $this->getDoctrine()->getManager()->getRepository('RIUserBundle:User')->find($id);
        $profil = $user;
        if($user === null){
            throw $this->createNotFoundException('Le profil de l\'utilisateur [id='.$id.'] n\'existe pas.');
        }
        
        
        
        $user->setUsername($profil->getUsername());
        $user->setPassword($profil->getPassword());
        $user->setNom($profil->getNom());
        $user->setPrenom($profil->getPrenom());
        $user->setAdresse($profil->getAdresse());
        $user->setCodepostal($profil->getCodepostal());
        $user->setVille($profil->getVille());
        $user->setEmail($profil->getEmail());
        $user->setTel1($profil->getTel1());
        $user->setTel2($profil->getTel2());
        $user->setIne($profil->getIne());
        
        $form=$this->createFormBuilder($user)
                ->add('adresse','text')
                ->add('codepostal','text', array('label'=>'Code Postal'))
                ->add('ville','text')
                ->add('email','text')
                ->add('tel1','text', array('label'=>'Téléphone 1'))
                ->add('tel2','text', array('label'=>'Téléphone 2'))
                ->add('ine','text', array('label'=>'Numéro INE'))
                ->getForm();
        
        $request=  $this->get('request');
        
        if ($request->getMethod() == 'POST'){
            $form->bind($request);
            
            if($form->isValid()){
                
                $em=  $this->getDoctrine()->getManager();
                
                $em->flush();
                
                
                return $this->redirect($this->generateURL('risite_profil', array('id' => $id)));
            }
        }
        
        return $this->render('RISiteBundle:Site:profil.html.twig', array('profil' => $profil, 'form' => $form->createView()));
    }
    
    
    public function voirPartenairesAction(){
        $partenaires = $this->getDoctrine()->getManager()->getRepository('RISiteBundle:Partenaire')->findAll();
 
        if($partenaires === null){
            throw $this->createNotFoundException('La liste des partenaires est vide.');
        }
        
        return $this->render('RISiteBundle:Site:listepartenaires.html.twig', array('partenaires' => $partenaires));
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
        $stage = $this->getDoctrine()->getManager()->getRepository('RISiteBundle:Stage')->find($idStage);
        
        if($stage === null){
            throw $this->createNotFoundException('Le stage n\'existe pas.');
        }
        
        return $this->render('RISiteBundle:Site:stage.html.twig', array('stage' => $stage));
    }
    
    /**
     * @Secure(roles="ROLE_SECRETARY")
     */
    public function inscrireEtudiantAction(){
        $user = new User;
       
        
        /*$form = $this->createFormBuilder($user)
                    ->add('username', 'text')
                    ->add('password', 'password')
                    ->add('email', 'text')
                    ->add('nom', 'text')
                    ->add('prenom', 'text')
                    ->add('adresse', 'textarea')
                    ->add('ville', 'text')
                    ->getForm();
        
        $request = $this->get('request');
        
        if ($request->getMethod() == 'POST'){
            $form->bind($request);
            
            if ($form->isValid()){
                $role = array ("ROLE_USER");
                $user->addRole($role);
                $em = $this->getDoctrine()->getManager();
                $em->persist($user);
                $em->flush();
                
                return $this->redirect($this->generateUrl('risite_profil'), array('id' => $user->getId()));
                
            }
            
            
        }
        
        return $this->render('RISiteBundle:Site:ajouteretudiant.html.twig', array('form' => $form->createView()));
                    
        */
        
        $mailer = $this->get('mailer');
        
        $message = \Swift_Message::newInstance()->setSubject('bonjour')
                ->setFrom('tutorial@symfony2.com')
                ->setTo('adrien.mercier62@gmail.com')
                ->setBody('Coucou, voici un email que vous venez de recevoir!');
    
        $mailer->send($message);
        
        return new Response('Email bien envoyé');
    }
    
    public function demandeSuppressionAction(){
        $user = $this->getUser();
        
        $form=$this->createFormBuilder($user)
                ->add('username', 'text')->getForm();
        
        return $this->render('RISiteBundle:Site:demande.html.twig', array('form' => $form->createView()));
    }
    
    public function voirDocumentAction($id){
        //récupération des documents de l'utilisateur
        $user_id=$id;
        $user= $this->getDoctrine()->getManager()->getRepository('RIUserBundle:User')->find($user_id);
        $query = $this->getDoctrine()->getEntityManager()->createQuery(
                'SELECT d FROM RISiteBundle:Document d WHERE d.user = :user')
                ->setParameter('user', $user);
        $documents=$query->getResult();
        
        //upload d'un document
        $document = new Document();
        
    
        $document->setDocDatedepot(new \DateTime);
        //le chemin est obligatoire, on met temporairement quelque chose
        $document->setDocChemin($document->getUploadRootDir());
        $document->setUser($user);
        
        $form = $this->createFormBuilder($document)
            ->add('name', 'text', array('label'=>'Nom du Document'))
            ->add('file', null, array('label'=>'Document'))
            ->getForm();

        if ($this->getRequest()->isMethod('POST')) {
            $form->bind($this->getRequest());
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                
                //après up du form, on a le nom du fichier, donc on met à jour doc_chemin
                $nom_fichier = $document->recupNomFichier();
                $chemin = $document->getUploadRootDir();
                $chemin_fichier = $chemin.'/'.$nom_fichier;
                $document->setDocChemin($chemin_fichier);
                
                $document->upload();

                $em->persist($document);
                $em->flush();
                
                

                return $this->redirect($this->generateURL('risite_document', array('id' => $user_id)));
            }
        }
        
        return $this->render('RISiteBundle:Site:document.html.twig', array('documents' => $documents, 'form' => $form->createView()));
    }
    
    /**
     * @Secure(roles="ROLE_USER")
     */
    public function supprimerDocumentAction($id, $user_id){
        //récupération du document en faisant attention à ce que l'user soit le propriétaire
        //un étudiant ne doit pas pouvoir supprimer les documents des autres users.
        $user= $this->getDoctrine()->getManager()->getRepository('RIUserBundle:User')->find($user_id);
        $query = $this->getDoctrine()->getEntityManager()->createQuery(
                'SELECT d FROM RISiteBundle:Document d WHERE d.id = :id AND d.user = :user')
                ->setParameter('user', $user)
                ->setParameter('id', $id);
        try{
        $document=$query->getSingleResult();
        }catch(\Doctrine\Orm\NoResultException $e){
            $document=null;
        }
        
        if($document != null){
            //suppresion du document dans le dossier uploads/documents
            $document->delete();
            
            //suppression du document dans la base de données
            $em = $this->getDoctrine()->getManager();
            $em->remove($document);
            $em->flush();
        }
        
        return $this->redirect($this->generateURL('risite_document', array('id' => $user_id)));
        
    }
    
    /**
     * @Secure(roles="ROLE_USER")
     */
    public function telechargerDocumentAction($id, $user_id){
        //récupération du document en faisant attention à ce que l'user soit le propriétaire
        //un étudiant ne doit pas pouvoir télécharger les documents des autres users.
        $user= $this->getDoctrine()->getManager()->getRepository('RIUserBundle:User')->find($user_id);
        $query = $this->getDoctrine()->getEntityManager()->createQuery(
                'SELECT d FROM RISiteBundle:Document d WHERE d.id = :id AND d.user = :user')
                ->setParameter('user', $user)
                ->setParameter('id', $id);
        try{
        $document=$query->getSingleResult();
        }catch(\Doctrine\Orm\NoResultException $e){
            $document=null;
        }
        
        $fichier = $document->getDocChemin();
        $nom = pathinfo($fichier, PATHINFO_BASENAME);
        $ext = pathinfo($fichier, PATHINFO_EXTENSION);
        
        $response = new Response();
        $response->setStatusCode(200);
        $response->headers->set('Content-Type', 'application/'.$ext.'');
        $response->setContent(file_get_contents($fichier));
        $response->headers->set('Content-Disposition', sprintf('attachment;filename="%s"', $nom));
        $response->headers->set('X-Sendfile', $fichier);

        
        $response->send();
        return $response;
    }
    
}

?>

