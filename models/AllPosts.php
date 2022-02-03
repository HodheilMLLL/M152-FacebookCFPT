<?php
class AllPosts
{
    private $idPost;
    private $commentaire;
    private $creationDate;
    private $modificationDate;
    private $media_idMedia;

    

    /**
     * Get the value of idPost
     */ 
    public function getIdPost()
    {
        return $this->idPost;
    }

    /**
     * Set the value of idPost
     *
     * @return  self
     */ 
    public function setIdPost($idPost)
    {
        $this->idPost = $idPost;

        return $this;
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
     * Set the value of creationDate
     *
     * @return  self
     */ 
    public function setCreationDate($creationDate)
    {
        $this->creationDate = $creationDate;

        return $this;
    }

    /**
     * Get the value of modificationDate
     */ 
    public function getModificationDate()
    {
        return $this->modificationDate;
    }

    /**
     * Set the value of modificationDate
     *
     * @return  self
     */ 
    public function setModificationDate($modificationDate)
    {
        $this->modificationDate = $modificationDate;

        return $this;
    }

    /**
     * Get the value of media_idMedia
     */ 
    public function getMedia_idMedia()
    {
        return $this->media_idMedia;
    }

    /**
     * Set the value of media_idMedia
     *
     * @return  self
     */ 
    public function setMedia_idMedia($media_idMedia)
    {
        $this->media_idMedia = $media_idMedia;

        return $this;
    }

    // Insérer de nouvelles données
    public static function newPost(AllPosts $post){

    }
}

?>