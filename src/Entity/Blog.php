<?php


namespace App\Entity;


class Blog
{
    const NAME = "blog";

    private $id;
    private $date;
    private $title;
    private $image;
    private $text;

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
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param mixed $date
     */
    public function setDate($date): void
    {
        $this->date = $date;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title): void
    {
        $this->title = $title;
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
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param mixed $text
     */
    public function setText($text): void
    {
        $this->text = $text;
    }

    public function toJson()
    {
        return [
            'title' => $this->getTitle(),
            'date' => $this->getDate(),
            'image' => $this->getImage(),
            'text' => $this->getText(),
        ];
    }

    public function toJsonId()
    {
        return [
            'id' => $this->getId(),
            'title' => $this->getTitle(),
            'date' => $this->getDate(),
            'image' => $this->getImage(),
            'text' => $this->getText(),
        ];
    }


}