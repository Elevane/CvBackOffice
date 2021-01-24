<?php


namespace App\Entity;


class Projet
{
    private $id;
    private $image;
    private $nom;
    private $technos;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param mixed $image
     */
    public function setImage($image): void
    {
        $this->image = $image;
    }

    /**
     * @return mixed
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * @param mixed $nom
     */
    public function setNom($nom): void
    {
        $this->nom = $nom;
    }

    /**
     * @return mixed
     */
    public function getTechnos()
    {
        return $this->technos;
    }

    /**
     * @param mixed $technos
     */
    public function setTechnos($technos): void
    {
        $this->technos = $technos;
    }

}