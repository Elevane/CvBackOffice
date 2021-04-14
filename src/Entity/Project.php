<?php


namespace App\Entity;


class Project
{
    const NAME = "project";
    private $id;
    private $image;
    private $name;
    private $skills;
    private $description;

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description): void
    {
        $this->description = $description;
    }


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
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getSkills()
    {
        return $this->skills;
    }

    /**
     * @param mixed $skills
     */
    public function setSkills($skills): void
    {
        $this->skills = $skills;
    }

    public function toJson(){
        return [
             'name' => $this->getName(),
            'skills' => $this->getSkills(),
            'image' => $this->getImage(),
            'description' => $this->getDescription()
        ];
    }


    public function toJsonId(){
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'skills' => $this->getSkills(),
            'image' => $this->getImage(),
            'description' => $this->getDescription()
        ];
    }

}