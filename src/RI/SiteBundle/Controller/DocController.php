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
use RI\UserBundle\Entity\UserRepository;

/**
 * Description of DocController
 *
 * @author Solena
 */
class DocController extends Controller  {
    
    public function voirDocumentAction(){
        //récupération des documents de l'utilisateur
        $user= $this->getUser();
        $query = $this->getDoctrine()->getEntityManager()->createQuery(
                'SELECT d FROM RISiteBundle:Document d WHERE d.user = :user')
                ->setParameter('user', $user);
        try{
        $documents=$query->getResult();
        }catch(\Doctrine\Orm\NoResultException $e){
            $document=null;
            return null;
        }
        
        //récupération des documents publics de la secrétaire ou de l'admin
        $q1 = $this->getDoctrine()->getEntityManager()->createQuery(
                'SELECT u FROM RIUserBundle:User u WHERE u.roles = :sec ')
                ->setParameter('sec', 'a:1:{i:0;s:14:"ROLE_SECRETARY";}');
        try{
            $sec=$q1->getResult();
        }catch(\Doctrine\Orm\NoResultException $e){
            $sec=null;
            return null;
        }
        
        $q2 = $this->getDoctrine()->getEntityManager()->createQuery(
                'SELECT u FROM RIUserBundle:User u WHERE u.roles = :admin ')
                ->setParameter('admin', 'a:1:{i:0;s:10:"ROLE_ADMIN";}'); 
        try{
            $admin=$q2->getResult();
        }catch(\Doctrine\Orm\NoResultException $e){
            $admin=null;
            return null;
        }
        
        $query2 =  $this->getDoctrine()->getEntityManager()->createQuery(
                'SELECT d FROM RISiteBundle:Document d WHERE d.user = :sec  OR d.user = :admin ')
                ->setParameter('sec', $sec)
                ->setParameter('admin', $admin); 
        
        try{
        $documents2=$query2->getResult();
        }catch(\Doctrine\Orm\NoResultException $e){
            $documents2=null;
            return null;
        }
        
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
                
                //récupération du nom de fichier modifié avec ajout d'un random via l'upload du fichier
                $nom_fichier = $document->upload();
                
                //après up du form, on a le nom du fichier, donc on met à jour doc_chemin
                $chemin = $document->getUploadRootDir();
                $chemin_fichier = $chemin.'/'.$nom_fichier;
                $document->setDocChemin($chemin_fichier);

                $em->persist($document);
                $em->flush();
                $this->get('session')->getFlashBag()->add('notice', 'Le document a bien été mis en ligne.');
                return $this->redirect($this->generateURL('risite_document'));
            }
        }
        
        //deuxième formulaire pour la recherche de l'utilisateur dont on veut envoyer un document
        //ou consulter les documents
        $defaultData = array('Nom de l\utilisateur' => '', 'Prénom de l\'utilisateur' => '');
        $form2 = $this->createFormBuilder($defaultData)
                
                ->add('users', 'entity', array(
                    'class' => 'RIUserBundle:User', 'label' => 'Nom d\'utilisateur',
                    'query_builder' => function(UserRepository $er) {
                        return $er->createQueryBuilder('u')
                        ->orderBy('u.nom', 'ASC'); }))
                ->add('traitement', 'choice', 
                        array('choices' => array('e' => 'Pour envoi','c' => 'Pour consultation')))
                ->getForm();
        
        if ($this->getRequest()->isMethod('POST')) {
            $form2->bind($this->getRequest());

            // les données sont un tableau avec les clés "name", "email", et "message"
            $user = $form2->get('users')->getData();
            $id_user = $user->getId();
            $choix = $form2->get('traitement')->getData();
            
            if($choix == 'e'){
                return $this->redirect($this->generateURL('risite_document_envoi', array('id' => $id_user)));
            }  elseif ($choix == 'c') {
                return $this->redirect($this->generateURL('risite_document_user', array('id' => $id_user)));
            }
        }
        return $this->render('RISiteBundle:Site:document.html.twig', array('documents' => $documents,
            'documentSecretaire' => $documents2,
            'form' => $form->createView(), 'form2' => $form2->createView()));
    }
    /**
     * Traitement de l'envoi des documents vers un autre utilisateur
     * 
     * Le paramètre user est le nom de lutilisateur
     * 
     * @Secure(roles="ROLE_ADMIN, ROLE_SECRETARY")
     */
    public function envoiDocumentAction($id){
                
        //recherche de l'utilisateur dans la base de données
        
            $query = $this->getDoctrine()->getEntityManager()->createQuery(
                'SELECT u FROM RIUserBundle:User u WHERE u.id = :id')
                ->setParameter('id', $id);
            try{
               $user=$query->getSingleResult();
            }catch(\Doctrine\Orm\NoResultException $e){
               $user=null;
               return null;
            }
        if ($user != null){
            //formulaire du document
            $document = new Document();

            $document->setDocDatedepot(new \DateTime);
            //le chemin est obligatoire, on met temporairement quelque chose
            $document->setDocChemin($document->getUploadRootDir());
            //on met l'utilisateur de destination
            $document->setUser($user);

            $form = $this->createFormBuilder($document)
                ->add('name', 'text', array('label'=>'Nom du Document'))
                ->add('file', null, array('label'=>'Document'))
                ->getForm();

            if ($this->getRequest()->isMethod('POST')) {
                $form->bind($this->getRequest());
                if ($form->isValid()) {
                    $em = $this->getDoctrine()->getManager();

                    //récupération du nom de fichier modifié avec ajout d'un random via l'upload du fichier
                    $nom_fichier = $document->upload();

                    //après up du form, on a le nom du fichier, donc on met à jour doc_chemin
                    $chemin = $document->getUploadRootDir();
                    $chemin_fichier = $chemin.'/'.$nom_fichier;
                    $document->setDocChemin($chemin_fichier);

                    $em->persist($document);
                    $em->flush();
                    $this->get('session')->getFlashBag()->add('notice', 'Le document a bien été envoyé.');
                    return $this->redirect($this->generateURL('risite_document'));
                }
            }
        }
        
        return $this->render('RISiteBundle:Site:documentSec.html.twig', array('user' => $user, 'form' => $form->createView()));
    }
    
    /**
     * @Secure(roles="ROLE_USER")
     */
    public function supprimerDocumentAction($id){
        //récupération du document en faisant attention à ce que l'user soit le propriétaire
        //un étudiant ne doit pas pouvoir supprimer les documents des autres users.
        $user= $this->getUser();
        $query = $this->getDoctrine()->getEntityManager()->createQuery(
                'SELECT d FROM RISiteBundle:Document d WHERE d.id = :id AND d.user = :user')
                ->setParameter('user', $user)
                ->setParameter('id', $id);
        try{
        $document=$query->getSingleResult();
        }catch(\Doctrine\Orm\NoResultException $e){
            $document=null;
            throw $this->createNotFoundException('Impossible de supprimer ce document.');
        }
        
        $form = $this->createFormBuilder($user)->getForm();
        $request= $this->get('request');
        
        if($document != null){
            if ($request->getMethod() == 'POST'){
                //suppresion du document dans le dossier uploads/documents
                $document->delete();

                //suppression du document dans la base de données
                $em = $this->getDoctrine()->getManager();
                $em->remove($document);
                $em->flush();

                $this->get('session')->getFlashBag()->add('notice', 'Le document a bien été supprimé.');
                return $this->redirect($this->generateURL('risite_document', array('id' => $user)));
            }
        }
        
        return $this->render('RISiteBundle:Site:demande3.html.twig', array('form' => $form->createView()));
        
    }
    
    /**
     * @Secure(roles="ROLE_ADMIN, ROLE_SECRETARY")
     */
    public function supprimerDocument2Action($id, $idUser){
        
        //recherche de l'utilisateur dans la base de données
        
            $query2 = $this->getDoctrine()->getEntityManager()->createQuery(
                'SELECT u FROM RIUserBundle:User u WHERE u.id = :id')
                ->setParameter('id', $idUser);
            try{
               $user=$query2->getSingleResult();
            }catch(\Doctrine\Orm\NoResultException $e){
               $user=null;
               return null;
            }
        //récupération du document en ne faisant pas attention à ce que l'user soit le propriétaire
        //un admin ou un secrétaire doit pouvoir supprimer les documents des autres users.
        $query = $this->getDoctrine()->getEntityManager()->createQuery(
                'SELECT d FROM RISiteBundle:Document d WHERE d.id = :id')
                ->setParameter('id', $id);
        try{
        $document=$query->getSingleResult();
        }catch(\Doctrine\Orm\NoResultException $e){
            $document=null;
            throw $this->createNotFoundException('Impossible de supprimer ce document.');
        }
        
        $form = $this->createFormBuilder($document)->getForm();
        $request= $this->get('request');
        
        if($document != null){
            if ($request->getMethod() == 'POST'){
                //suppresion du document dans le dossier uploads/documents
                $document->delete();

                //suppression du document dans la base de données
                $em = $this->getDoctrine()->getManager();
                $em->remove($document);
                $em->flush();

                $this->get('session')->getFlashBag()->add('notice', 'Le document a bien été supprimé.');
                return $this->redirect($this->generateURL('risite_document_user', array('user' => $user)));
            }
        }
        
        return $this->render('RISiteBundle:Site:demande3.html.twig', array('form' => $form->createView()));
        
    }
    
    /**
     * @Secure(roles="ROLE_USER")
     */
    public function telechargerDocumentAction($id){
        //récupération du document en faisant attention à ce que l'user soit le propriétaire
        //un étudiant ne doit pas pouvoir télécharger les documents des autres users.
        $user= $this->getUser();
        $query = $this->getDoctrine()->getEntityManager()->createQuery(
                'SELECT d FROM RISiteBundle:Document d WHERE d.id = :id AND d.user = :user')
                ->setParameter('user', $user)
                ->setParameter('id', $id);
        try{
        $document=$query->getSingleResult();
        }catch(\Doctrine\Orm\NoResultException $e){
            $document=null;
            throw $this->createNotFoundException('Impossible de télécharger ce document.');
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
    
    /**
     * Téléchargement des documents publics
     * 
     * @Secure(roles="ROLE_USER")
     */
    public function telechargerDocument2Action($id){
        //pas de vérification sur le propriétaire du document car le document est public.
        $query = $this->getDoctrine()->getEntityManager()->createQuery(
                'SELECT d FROM RISiteBundle:Document d WHERE d.id = :id')
                ->setParameter('id', $id);
        try{
        $document=$query->getSingleResult();
        }catch(\Doctrine\Orm\NoResultException $e){
            $document=null;
            throw $this->createNotFoundException('Impossible de télécharger ce document.');
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
    
    /**
     * Téléchargement des documents des utilisateurs par la secrétaire et l'admin
     * 
     * @Secure(roles="ROLE_ADMIN, ROLE_SECRETARY")
     */
    public function telechargerDocument3Action($id){
        //pas de vérification sur le propriétaire du document car la secrétaire ou l'admin sont les boss :).
        $query = $this->getDoctrine()->getEntityManager()->createQuery(
                'SELECT d FROM RISiteBundle:Document d WHERE d.id = :id')
                ->setParameter('id', $id);
        try{
        $document=$query->getSingleResult();
        }catch(\Doctrine\Orm\NoResultException $e){
            $document=null;
            throw $this->createNotFoundException('Impossible de télécharger ce document.');
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
    
    /**
     * Gère la page de recherche des documents par utilisateur
     * 
     * @Secure(roles="ROLE_ADMIN, ROLE_SECRETARY")
     */
    public function voirDocUsersAction($id){
        
        //recherche de l'utilisateur dans la base de données
        
            $query = $this->getDoctrine()->getEntityManager()->createQuery(
                'SELECT u FROM RIUserBundle:User u WHERE u.id = :id')
                ->setParameter('id', $id);
            try{
               $user=$query->getSingleResult();
            }catch(\Doctrine\Orm\NoResultException $e){
               $user=null;
               return null;
            }
            
            if ($user != null){
                $query2 = $this->getDoctrine()->getEntityManager()->createQuery(
                'SELECT d FROM RISiteBundle:Document d WHERE d.user = :user')
                ->setParameter('user', $user);
                try{
                    $documents=$query2->getResult();
                }catch(\Doctrine\Orm\NoResultException $e){
                    $documents=null;
                    return null;
                }
            }
        
        
        return $this->render('RISiteBundle:Site:docUtilisateur.html.twig', 
                array('user' => $user, 'docUser' => $documents));
        
        
        
        
    }
    
}

?>
