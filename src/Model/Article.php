<?php

class Article
{
//ts les attribues de la table
    private $id;
    private $title;
    private $chapo;
    private $content;
    private $author;
    private $image;
    private $date;
    private $user_id;

    public function __construct(array $data){
        $this->hydrate($data);
    }

//hydratation: pr chaque valeur du tableau on récup la clé et la valeur
    public function hydrate(array $data){
        foreach($date as $hey => $value){
            $method = 'set' .ucfirst($key);
        }
    }
// seters
    public function setId($id){
        $this->id = $id;
    }
    
    public function setTitle($title){
        $this->title = $title;
    }

    public function setContent($content){
        $this->content = $content;  
    }

    public function setAuthor($author){
        $this->author = $author;
    }

    public function setImage($image){
        $this->image = $image;
    }

    public function setDate($date){
        $this->date = $date;
    }

    public function setUserId(){
        $this->UserId = $userId
    }

    public fuction setArticleId(){
        $this->ArticleId = $articleId
    }
//trouver comme faire le typage php

//getters 
    public function id(){
        $this->id = $id;
    }
    
    public function $title(){
        $this->title = $title;
    }

    public function $content(){
        $this->content = $content;  
    }

    public function $author(){
        $this->author = $author;
    }

    public function $image(){
        $this->image = $image;
    }

    public function $date(){
        $this->date = $date;
    }

    public function $userId(){
        $this->UserId = $userId
    }

    public fuction $articleId(){
        $this->ArticleId = $articleId
    }
}

?>