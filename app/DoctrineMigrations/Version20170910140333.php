<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use AppBundle\Entity\User;
use AppBundle\Entity\Genre;
use AppBundle\Entity\Book;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170910140333 extends AbstractMigration implements ContainerAwareInterface {

    /**
     * @var ContainerInterface
     */
    private $container;

    public function setContainer(ContainerInterface $container = null) {
        $this->container = $container;
    }

    /**
     * @param Schema $schema
     */
    public function up(Schema $schema) {
        $em = $this->container->get('doctrine.orm.entity_manager');
        $passwordEncoder = $this->container->get('security.password_encoder');
        
        $user = new User();
        $user->setUsername('admin');
        $user->setUsernameCanonical('admin');
        $user->setEmail('admin@admin.com');
        $user->setEmailCanonical('admin@admin.com');
        $user->setEnabled(true);
        $user->setSalt(md5(time()));
        $user->setRoles(['ROLE_ADMIN']);
        $user->setPassword($passwordEncoder->encodePassword($user, 'admin'));
        $em->persist($user);
        
        $user = new User();
        $user->setUsername('user');
        $user->setUsernameCanonical('user');
        $user->setEmail('user@user.com');
        $user->setEmailCanonical('user@user.com');
        $user->setEnabled(true);
        $user->setSalt(md5(time()));
        $user->setRoles(['ROLE_USER']);
        $user->setPassword($passwordEncoder->encodePassword($user, 'user'));
        $em->persist($user);

        $genres = [
            'Police',
            'Comedy',
            'Drama',
            'Non-fiction',
            'Horror',
            'Tragedy',
            'Children',
            'Fiction',
            'Satire'
        ];
        foreach ($genres as $genre_name) {
            $genre = new Genre();
            $genre->setName($genre_name);
            $em->persist($genre);
        }

        $books = [[
                'name' => 'Doctor With Big Eyes',
                'release_date' => '2016-02-01',
                'length' => 200,
                'genres' => ['Police'],
                'user_readable' => true,
                'admin_readable' => true
            ], [
                'name' => 'Hunger Of My Town',
                'release_date' => '2016-05-02',
                'length' => 10,
                'genres' => ['Comedy'],
                'user_readable' => true,
                'admin_readable' => true
            ], [
                'name' => 'Colleagues And Demons',
                'release_date' => '2015-04-06',
                'length' => 30,
                'genres' => ['Drama'],
                'user_readable' => true,
                'admin_readable' => true
            ], [
                'name' => 'Humans In The Library',
                'release_date' => '1982-06-15',
                'length' => 600,
                'genres' => ['Non-fiction', 'Horror'],
                'user_readable' => false,
                'admin_readable' => true
            ], [
                'name' => 'Founders Of Evil',
                'release_date' => '1530-08-30',
                'length' => 900,
                'genres' => ['Drama'],
                'user_readable' => true,
                'admin_readable' => true
            ], [
                'name' => 'Ancestor With Horns',
                'release_date' => '2019-10-10',
                'length' => 1000,
                'genres' => ['Drama'],
                'user_readable' => true,
                'admin_readable' => true
            ], [
                'name' => 'Age Of The Light',
                'release_date' => '1923-12-06',
                'length' => 234,
                'genres' => ['Tragedy'],
                'user_readable' => true,
                'admin_readable' => true
            ], [
                'name' => 'Learning With The River',
                'release_date' => '1965-02-02',
                'length' => 200,
                'genres' => ['Children', 'Fiction'],
                'user_readable' => true,
                'admin_readable' => true
            ], [
                'name' => 'Lord And Buffoon',
                'release_date' => '2001-07-09',
                'length' => 240,
                'genres' => ['Horror', 'Satire'],
                'user_readable' => true,
                'admin_readable' => true
        ]];
        $em->flush();
        foreach ($books as $book_data) {
            $book = new Book();
            $book->setName($book_data['name']);
            $book->setReleaseDate(new \DateTime($book_data['release_date']));
            $book->setLength($book_data['length']);
            foreach ($book_data['genres'] as $genre_name) {
                $genre = $em->getRepository(Genre::class)->findOneBy(['name' => $genre_name]);
                $book->addGenre($genre);
            }
            $book->setUserReadable($book_data['user_readable']);
            $book->setAdminReadable($book_data['admin_readable']);
            $em->persist($book);
        }
        $em->flush();
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema) {
        $em = $this->container->get('doctrine.orm.entity_manager');
        $query = $em->createQuery('DELETE AppBundle:User');
        $query->execute();
        $query = $em->getConnection()->prepare('DELETE from book_genre');
        $query->execute();
        $query = $em->createQuery('DELETE AppBundle:Book');
        $query->execute();
        $query = $em->createQuery('DELETE AppBundle:Genre');
        $query->execute();
        $em->flush();
    }
}
