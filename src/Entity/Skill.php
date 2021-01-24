<?php


namespace App\Entity;


class Skill
{
    private $id;
    private $name;
    private $ratio;
    private $active;

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
    public function getRatio()
    {
        return $this->ratio;
    }

    /**
     * @param mixed $ratio
     */
    public function setRatio($ratio): void
    {
        $this->ratio = $ratio;
    }

    /**
     * @return mixed
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * @param mixed $active
     */
    public function setActive($active): void
    {
        $this->active = $active;
    }


    public function toJson(){
        return [
            'name' => $this->getName(),
            'ratio' => $this->getRatio(),
            'active' => $this->getActive(),

        ];
    }

    public function toJsonId(){
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'ratio' => $this->getRatio(),
            'active' => $this->getActive(),

        ];
    }
}