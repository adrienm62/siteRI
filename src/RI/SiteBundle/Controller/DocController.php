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
                
                

                return $this->redirect($this->generateURL('risite_document', array('id' => $user)));
            }
        }
        
        return $this->render('RISiteBundle:Site:document.html.twig', array('documents' => $documents, 'form' => $form->createView()));
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
        
        if($document != null){
            //suppresion du document dans le dossier uploads/documents
            $document->delete();
            
            //suppression du document dans la base de données
            $em = $this->getDoctrine()->getManager();
            $em->remove($document);
            $em->flush();
        }
        
        return $this->redirect($this->generateURL('risite_document', array('id' => $user)));
        
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
    
}

?>
