<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="book")
 */
class Book {
    /**
     * @ORM\Column(type="string", length=128)
     * @ORM\Id
     */
    private $name;

    /**
     * @ORM\Column(type="date")
     */
    private $release_date;

    /**
     * @ORM\Column(type="integer")
     */
    private $length;

    /**
     * @ORM\Column(type="boolean")
     */
    private $user_readable;

    /**
     * @ORM\Column(type="boolean")
     */
    private $admin_readable;

    /**
     * Many Books have Many Genres.
     * @ORM\ManyToMany(targetEntity="Genre", inversedBy="books")
     * @ORM\JoinTable(name="book_genre",
     *     joinColumns={@ORM\JoinColumn(name="book_name", referencedColumnName="name")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="genre_name", referencedColumnName="name")}
     * )
     */
    private $genres;

    public function __construct() {
        $this->genres = new ArrayCollection();
    }

    public function addGenre($genre) {
        $this->genres[] = $genre;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function setReleaseDate($release_date) {
        $this->release_date = $release_date;
    }

    public function setLength($length) {
        $this->length = $length;
    }

    public function setUserReadable($user_readable) {
        $this->user_readable = $user_readable;
    }

    public function setAdminReadable($admin_readable) {
        $this->admin_readable = $admin_readable;
    }

    public function getName() {
        return $this->name;
    }

    public function getReleaseDate() {
        return $this->release_date;
    }

    public function getLength() {
        return $this->length;
    }

    public function getUserReadable() {
        return $this->user_readable;
    }

    public function getAdminReadable() {
        return $this->admin_readable;
    }
    public function getGenres() {
        return $this->genres;
    }
}
