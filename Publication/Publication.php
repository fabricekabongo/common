<?php

namespace FabriceKabongo\Common\Publication;

/**
 * une publication abstraite
 * 
 * @copyright (c) 2014, Fabrice Kabongo
 * @version 1.0.0.0
 * @author Fabrice Kabongo <fabrice.k.kabongo at gmail.com>
 */
abstract class Publication implements IPublication {

    /**
     * le contenu de l'alerte
     * 
     * @var string 
     * 
     * @Assert\NotBlank(message="Le contenu est obligatoire")
     */
    protected $content;

    /**
     * l'auteur de l'alerte
     * 
     * @var \Symfony\Component\Security\Core\User\UserInterface 
     * @Assert\NotBlank()
     * @Assert\Type(type="\FabriceKabongo\Entities\User", message="Cette auteur n'est pas un utilisateur")
     */
    protected $author;

    /**
     * la date de creation
     * 
     * @var \Datetime 
     */
    protected $createdAt;

    public function getAuthor() {
        return $this->author;
    }

    public function getContent() {
        return $this->content;
    }

    public function getCreatedAt() {
        return $this->createdAt;
    }

    public function setAuthor(\Symfony\Component\Security\Core\User\UserInterface $user) {
        $this->author = $user;
        return $this;
    }

    public function setContent($content) {
        $this->content = $content;
        return $this;
    }

    public function setCreatedAt(\DateTime $createAt) {
        $this->createdAt = $createAt;
        return $this;
    }

}

?>
