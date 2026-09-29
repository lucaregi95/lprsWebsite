<?php

class Post{
    private $id_post;
    private $contenu;
    private $date;
    private $heure;

    /**
     * @param $id_post
     * @param $contenu
     * @param $date
     * @param $heure
     */
    public function __construct($id_post, $contenu, $date, $heure)
    {
        $this->id_post = $id_post;
        $this->contenu = $contenu;
        $this->date = $date;
        $this->heure = $heure;
    }

    /**
     * @return mixed
     */
    public function getIdPost()
    {
        return $this->id_post;
    }

    /**
     * @param mixed $id_post
     */
    public function setId($id_post)
    {
        $this->id = $id_post;
    }

    /**
     * @return mixed
     */
    public function getContenu()
    {
        return $this->contenu;
    }

    /**
     * @param mixed $contenu
     */
    public function setContenu($contenu)
    {
        $this->contenu = $contenu;
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
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * @return mixed
     */
    public function getHeure()
    {
        return $this->heure;
    }

    /**
     * @param mixed $heure
     */
    public function setHeure($heure)
    {
        $this->heure = $heure;
    }



}