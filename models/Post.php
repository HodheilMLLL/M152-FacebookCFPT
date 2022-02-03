<?php
class Post
{
    private $idPost;
    private $commentaire;
    private $creationDate;
    private $modificationDate;

    /**
     * Get the value of idPost
     */ 
    public function getIdPost()
    {
        return $this->idPost;
    }

    /**
     * Get the value of commentaire
     */ 
    public function getCommentaire()
    {
        return $this->commentaire;
    }

    /**
     * Set the value of commentaire
     *
     * @return  self
     */ 
    public function setCommentaire($commentaire)
    {
        $this->commentaire = $commentaire;

        return $this;
    }

    /**
     * Get the value of creationDate
     */ 
    public function getCreationDate()
    {
        return $this->creationDate;
    }

    /**
     * Get the value of modificationDate
     */ 
    public function getModificationDate()
    {
        return $this->modificationDate;
    }

    // Insérer de nouvelles données
    public static function addPost(Post $post){
        $commentaire = $post->getCommentaire();
        $creationDate = date("Y/m/d/H/i/s");
        $modificationDate = date("Y/m/d/H/i/s");
        
        $req = MonPdo::getInstance()->prepare("INSERT INTO post(commentaire, creationDate, modificationDate) VALUES(:commentaire, :creationDate, :modificationDate)");
        $req->bindParam(':commentaire',$commentaire);
        $req->bindParam(':creationDate',$creationDate);
        $req->bindParam(':modificationDate',$modificationDate);
        $req->execute();
    }
}

?>