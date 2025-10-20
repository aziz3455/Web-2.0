<?php

namespace App\Controller;

use App\Entity\Book;
use App\Entity\Author;
use App\Form\BookType;
use App\Repository\BookRepository;
use App\Repository\AuthorRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/book')]
final class BookController extends AbstractController
{
    #[Route('/', name: 'book_list')]
    public function list(BookRepository $bookRepo): Response
    {
        $books = $bookRepo->findAll();

        $publishedCount = 0;
        $unpublishedCount = 0;

        foreach ($books as $book) {
            if ($book->isPublished()) {
                $publishedCount++;
            } else {
                $unpublishedCount++;
            }
        }

        return $this->render('book/list.html.twig', [
            'books' => $books,
            'publishedCount' => $publishedCount,
            'unpublishedCount' => $unpublishedCount,
        ]);
    }

    #[Route('/add', name: 'book_add')]
    public function add(EntityManagerInterface $em, Request $request): Response
    {
        $book = new Book();
        $book->setPublished(true); // default to published

        $form = $this->createForm(BookType::class, $book);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $author = $book->getAuthor();
            if ($author) {
                $author->setNbBook($author->getNbBook() + 1);
                $em->persist($author);
            }

            $em->persist($book);
            $em->flush();

            $this->addFlash('success', 'Book added successfully!');
            return $this->redirectToRoute('book_list');
        }

        return $this->render('book/form.html.twig', [
            'bookForm' => $form->createView(),
        ]);
    }

    #[Route('/edit/{id}', name: 'book_edit')]
    public function edit(EntityManagerInterface $em, Request $request, Book $book): Response
    {
        $form = $this->createForm(BookType::class, $book);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($book);
            $em->flush();

            $this->addFlash('success', 'Book updated successfully!');
            return $this->redirectToRoute('book_list');
        }

        return $this->render('book/form.html.twig', [
            'bookForm' => $form->createView(),
        ]);
    }

    #[Route('/delete/{id}', name: 'book_delete')]
    public function delete(EntityManagerInterface $em, Book $book): Response
    {
        $author = $book->getAuthor();
        if ($author) {
            $author->setNbBook(max(0, $author->getNbBook() - 1));
            $em->persist($author);
        }

        $em->remove($book);
        $em->flush();

        $this->addFlash('success', 'Book deleted successfully!');
        return $this->redirectToRoute('book_list');
    }

    // Delete authors with 0 books
    #[Route('/authors/delete-zero-books', name: 'delete_authors_zero_books')]
    public function deleteAuthorsZeroBooks(EntityManagerInterface $em, AuthorRepository $authorRepo): Response
    {
        $authors = $authorRepo->findAll();
        foreach ($authors as $author) {
            if ($author->getNbBook() === 0) {
                $em->remove($author);
            }
        }
        $em->flush();

        $this->addFlash('success', 'Authors with 0 books have been deleted.');
        return $this->redirectToRoute('book_list');
    }
}
