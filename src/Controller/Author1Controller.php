<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\AuthorRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Author;
use App\Form\AuthorType;
use App\Entity\Book;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;





final class Author1Controller extends AbstractController
{
    #[Route('/author1', name: 'app_author1')]
    public function index(): Response
    {
        return $this->render('author1/index.html.twig', [
            'controller_name' => 'Author1Controller',
        ]);
    }


    #[Route('/show/{name}',name: 'showAuthor' )]    
     public function show($name): Response
    {
        return $this->render('author1/show.html.twig', [
            'nom' => $name,
        ]);
    }
     #[Route('/authors', name: 'list_authors')]
    public function listAuthors(): Response
{
    $authors = [
        [
            'id' => 1,
            'picture' => '/assets/images/victorhugo.webp', 
            'username' => 'Victor Hugo',
            'email' => 'victor.hugo@gmail.com',
            'nb_books' => 100
        ],
        [
            'id' => 2,
            'picture' => '/assets/images/william.webp',
            'username' => 'William Shakespeare',
            'email' => 'william.shakespeare@gmail.com',
            'nb_books' => 200
        ],
        [
            'id' => 3,
            'picture' => '/assets/images/taha.jpg',
            'username' => 'Taha Hussein',
            'email' => 'taha.hussein@gmail.com',
            'nb_books' => 300
        ],
    ];

    // calcul du nombre d'auteurs
    $nbAuthors = count($authors);

    // calcul du nombre total de livres
    $totalBooks = array_sum(array_column($authors, 'nb_books'));

    // un seul return !
    return $this->render('author1/list.html.twig', [
        'authors' => $authors,
        'nbAuthors' => $nbAuthors,
        'totalBooks' => $totalBooks,
    ]);
}
#[Route('/author/{id}', name: 'author_details')]
public function authorDetails(int $id): Response
{
    $authors = [
        [
            'id' => 1,
            'picture' => '/assets/images/victorhugo.webp',
            'username' => 'Victor Hugo',
            'email' => 'victor.hugo@gmail.com',
            'nb_books' => 100
        ],
        [
            'id' => 2,
            'picture' => '/assets/images/william.webp',
            'username' => 'William Shakespeare',
            'email' => 'william.shakespeare@gmail.com',
            'nb_books' => 200
        ],
        [
            'id' => 3,
            'picture' => '/assets/images/taha.jpg',
            'username' => 'Taha Hussein',
            'email' => 'taha.hussein@gmail.com',
            'nb_books' => 300
        ],
    ];

    // 🔎 Chercher l’auteur par son id
    $author = null;
    foreach ($authors as $a) {
        if ($a['id'] === $id) {
            $author = $a;
            break;
        }
    }

    if (!$author) {
        throw $this->createNotFoundException("Auteur avec ID $id non trouvé !");
    }

    return $this->render('author1/showauthor.html.twig', [
        'author' => $author,
    ]);




}
#[Route('/showAll', name: 'showAll')]
public function showAll(AuthorRepository $repo, ManagerRegistry $doctrine): Response {
    $authors=$repo->findAll();
    $bookRepo = $doctrine->getRepository(Book::class);
    $books = $bookRepo->findAll(); //
    return $this->render('author1/showAll.html.twig',[
          'list'=>$authors,
    'listbook' => $books,
     ]);

}

#[Route('/addForm',name:'addForm')]
    public function addForm(Request $request, ManagerRegistry $doctrine){
    $author=new Author();
    $form=$this->createForm(AuthorType::class,$author);
    $form->add('Add',SubmitType::class);
 
    $form->handleRequest($request);
    if($form->isSubmitted()){
     $em=$doctrine->getManager();
     $em->persist($author);
     $em->flush();
     return $this->redirectToRoute('showAll');
    }
    return $this->render('author1/add.html.twig',['formulaire'=>$form->createView()]);
    // return $this->renderForm()
    }

     #[Route('/deleteAuthor/{id}',name:'deleteAuthor')]
    public function deleteAuthor($id,AuthorRepository $repo, ManagerRegistry $doctrine){
     // chercher un auteur selon son id
     //find , findAll , findOneby 
     $author=$repo->find($id);
     //procéder à la suppression 
      $em=$doctrine->getManager();
      $em->remove($author);
      $em->flush();// l'ajout , la suppression et la modification
      return $this->redirectToRoute('showAll');
    }
    #[Route('/showDetails/{id}',name:'showDetails')]
    public function showDetails($id,AuthorRepository $repo){
       $author=$repo->find($id);
       return $this->render('author1/showDetails.html.twig',['author'=>$author]);
    }

    
  #[Route('/update/{id}', name:'updateAuthor')]
public function updateAuthor($id, ManagerRegistry $doctrine, Request $request): Response
{
    $em = $doctrine->getManager();
    $author = $em->getRepository(Author::class)->find($id);

    if (!$author) {
        throw $this->createNotFoundException("Auteur introuvable !");
    }

    // Créer le formulaire avec les données existantes
    $form = $this->createForm(AuthorType::class, $author);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $em->flush(); // Pas besoin de persist car l’objet existe déjà
        return $this->redirectToRoute('showAll'); // Retour vers la liste
    }

    return $this->render('author1/update.html.twig', [
        'form' => $form->createView(),
    ]);
}





}
