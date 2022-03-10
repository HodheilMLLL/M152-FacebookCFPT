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

        return MonPdo::getInstance()->lastInsertId();
    }

    // Fonction qui permet récuperer les données
    public static function getAllPosts(): array{
        $sql = MonPdo::getInstance()->prepare("SELECT * FROM post ORDER BY creationDate DESC"); // Affiche le plus récent d'abord
        $sql->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE,'Post');
        $sql->execute();
        $retourSQL=$sql->fetchAll();

        return $retourSQL;
    }

    // Fonction qui permet récuperer le nombre de posts
    public static function countAllPosts(){
        $sql = MonPdo::getInstance()->prepare("SELECT * FROM post");
        $sql->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE,'Post');
        $sql->execute();
        $count = $sql->rowCount(); 

        return $count;
    }

    // Supprime un post par son id
    public static function deletePostById($idPost){
        // Suppression du post
        $req = MonPdo::getInstance()->prepare("DELETE FROM post WHERE idPost = :idPost");
        $req->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Post');
        $req->bindParam(':idPost', $idPost);
        $req->execute();
    }
}

?>