<?php
//est ce que cela je le sépare ou le met ds ArticleManager.php??
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
    //créa des seters
    public function hydrate(array $data){
        foreach($date as $hey => $value){
            $method = 'set' .ucfirst($key);
        }
    }

    public function setId($id){
        $id = (int) $id;
        //verif que id non null
        if($id > 0){
            $this->id = $id;
        }
    }
    
    public function setTitle($title){
        if (is_string($title)){
            $this->title = $title;
        }
    }

    public function setContent($content){
        if (is_string($content)){
            $this->content = $content;
        }
    }

    public function setAuthor($author){
        if (is_string($author)){
            $this->author = $author;
        }
    }

    public function setImage($image){
        $this->image = $image;
    }

    public function setDate($date){
        $this->date = $date;
    }

    //dois mettre les clé étrangères comme Userid?

}

?>