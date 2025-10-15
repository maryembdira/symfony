<?php
// src/Controller/BookController.php
namespace App\Controller;

use App\Entity\Book;
use App\Form\BookType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;


class BookController extends AbstractController
{
    #[Route('/book/new', name: 'book_new')]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $book = new Book();
        $form = $this->createForm(BookType::class, $book);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Save to database
            $em->persist($book);
            $em->flush();

            $this->addFlash('success', 'Book saved successfully!');

            return $this->redirectToRoute('book_new'); // or any page
        }

        return $this->render('book/addform.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/bookform', name: 'bookform')]
public function bookform(Request $request, ManagerRegistry $doctrine): Response
{
    $book = new Book();
    $form = $this->createForm(BookType::class, $book);
    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()) {
        $em = $doctrine->getManager();
        $em->persist($book);
        $em->flush();

        return $this->redirectToRoute('showAll'); // ou une autre route
    }

    return $this->render('book/add.html.twig', [
        'form' => $form->createView(),
    ]);
}

#[Route('/deleteBook/{id}', name: 'deleteBook')]
public function deleteBook($id, ManagerRegistry $doctrine): Response
{
    $book = $doctrine->getRepository(Book::class)->find($id);

    if (!$book) {
        throw $this->createNotFoundException('Book not found with id ' . $id);
    }

    $em = $doctrine->getManager();
    $em->remove($book);
    $em->flush();

    return $this->redirectToRoute('showAll');               

}

#[Route('/updateBook/{id}', name: 'updateBook')]        
public function updateBook($id, Request $request, ManagerRegistry $doctrine): Response
{
    $book = $doctrine->getRepository(Book::class)->find($id);                   
    if (!$book) {
        throw $this->createNotFoundException('Book not found with id ' . $id);
    }               
    $form = $this->createForm(BookType::class, $book);
    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()) {
        $em = $doctrine->getManager();
        $em->flush();

        return $this->redirectToRoute('showAll');
    }

    return $this->render('book/updateBook.html.twig', [
        'form' => $form->createView(),
    ]);
}

#[Route('/showBookDetails/{id}', name: 'showBookDetails')]
public function showBookDetails($id, ManagerRegistry $doctrine): Response
{
    $book = $doctrine->getRepository(Book::class)->find($id);

    if (!$book) {
        throw $this->createNotFoundException('Book not found with id ' . $id);
    }

    return $this->render('book/showBookDetails.html.twig', [
        'book' => $book,
    ]);
}



}