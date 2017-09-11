<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Book;
use AppBundle\Entity\Genre;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request) {
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            $cond = ['user_readable' => true];
        } else $cond = [];
        $books = $this->getDoctrine()->getRepository(Book::class)->findBy($cond, null, 5);
        return $this->render('default/index.html.twig', [
            'books' => $books
        ]);
    }
    /**
     * @Route("/book/{book_name}", name="book")
     */
    public function bookAction(Request $request, $book_name) {
        $book = $this->getDoctrine()->getRepository(Book::class)->find($book_name);
        if (!$book->getUserReadable() and !$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedHttpException();
        }
        return $this->render('default/book.html.twig', [
            'book' => $book 
        ]);
    }
    /**
     * @Route("/loadmore", name="loadmore")
     */
    public function loadmoreAction(Request $request) {
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            $cond = ['user_readable' => true];
        } else $cond = [];
        $books = $this->getDoctrine()->getRepository(Book::class)->findBy($cond, null, 5, 5);
        return $this->render('default/book_items.html.twig', [
            'books' => $books
        ]);
    }
    /**
     * @Route("/genre/{genre_name}", name="genre")
     */
    public function genreAction(Request $request, $genre_name) {
        return $this->render('default/genre.html.twig', [
            'genre' => $this->getDoctrine()->getRepository(Genre::class)->find($genre_name),
            'only_user_readable' => !$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')
        ]);
    }
}
