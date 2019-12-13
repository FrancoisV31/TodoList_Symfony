<?php

namespace App\Controller;

use DateTime;
use DateTimeZone;
use App\Entity\Todo;
use App\Form\TodoType;
use App\Entity\Category;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;



class MainController extends AbstractController
{
    private $menu_categories;

    function __construct(CategoryRepository $repo)
    {
        $this->menu_categories = $repo->findAll();
    }
    /**
     * @Route("/", name="home")
     */
    public function index()
    {
        
        $repo = $this->getDoctrine()->getRepository(Todo::class);
        $todos = $repo->findAll();
        // dump($todos);
        return $this->render('main/index.html.twig', [
            'todos' => $todos,
            'menu_categories' => $this->menu_categories
            
        ]);
    }

     /**
     * @Route("/new", name="create_todo")
     */

     public function create( Request $request){

        $todo = new Todo();
        $form = $this->createForm(TodoType::class, $todo);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            // $form->getData() récupère les données soumises
            // but, the original `$task` variable has also been updated
     
            // sauvegarde en base de données!
             $entityManager = $this->getDoctrine()->getManager();
             $entityManager->persist($data);
             $entityManager->flush();
            //  être redirigé
    
            return $this->redirectToRoute('home');
        }

        return $this->render('crud/create.html.twig', [
            'myform' => $form-> createView(),
            'menu_categories' => $this->menu_categories
            
        ]);



     }

     /**
     * @Route("/edit/{id}", name="update_todo")
     */

     public function update($id, Request $request){
         $todo = $this->getDoctrine()->getRepository(Todo::class)->find($id);
        //  on alimente le formulaire avec :
         $form = $this->createForm(TodoType::class, $todo);
         $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            // je récupère la date d'aujourd'hui comme date de modification
            $now = new DateTime("now", new DateTimeZone('Europe/Paris'));
            $todo-> setUpdatedAt($now);
            //  j'enregistre en base de données.
            $em = $this->getDoctrine()->getManager();
            $em->persist($todo);
            $em->flush();
            // préparer un message en session limitée 
            $this->addFlash("success", "La Todo a bien été modifiée");
            // redirection
            return $this->redirectToRoute('home');
        }
        
         return $this->render('crud/update.html.twig', [
             'myform' => $form->createView(),
             'menu_categories' => $this->menu_categories
         ]);
        
    }
         /**
     * @Route("delete/{id}", name="delete_todo")
     */

     public function delete($id, Request $request){
         $todo = $this->getDoctrine()->getRepository(Todo::class)->find($id);
         $em = $this->getDoctrine()->getManager();
         $em->remove($todo);
         $em->flush();
          // préparer un message en session limitée 
          $this->addFlash("danger", "La Todo a bien été supprimée");
          // redirection
          return $this->redirectToRoute('home');
     }
          /**
     * @Route("/todo/{id}", name="todo_category")
     */
    public function todoByCategory($id, CategoryRepository $repo)
    {
       $category = $repo ->find($id);
       $todos = $category->getTodos();
       return $this->render('main/index.html.twig', [
        'todos' => $todos,
        'menu_categories' => $this->menu_categories
        
       ]);
    }
}
