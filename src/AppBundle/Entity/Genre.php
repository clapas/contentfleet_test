<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="genre")
 */
class Genre {
    /**
     * @ORM\Column(type="string", length=128)
     * @ORM\Id
     */
    private $name;

    /**
     * Many Books have Many Genres.
     * @ORM\ManyToMany(targetEntity="Book", mappedBy="genres")
     */
    private $books;

    public function __construct() {
        $this->books = new ArrayCollection();
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function getName() {
        return $this->name;
    }

    public function getBooks($only_user_readable = false) {
        if ($only_user_readable)
            return $this->books->filter(
                function($entry) {
                    return $entry->getUserReadable();
            });
        else return $this->books;
    }
}
