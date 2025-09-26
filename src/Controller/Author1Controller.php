<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

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
}
