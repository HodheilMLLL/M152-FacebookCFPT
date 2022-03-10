<?php
class Media {
    private $idMedia;
    private $typeMedia;
    private $nomMedia;
    private $creationDate;
    private $modificationDate;
    private $post_id;

    /**
     * Get the value of idMedia
     */ 
    public function getIdMedia()
    {
        return $this->idMedia;
    }

    /**
     * Get the value of typeMedia
     */ 
    public function getTypeMedia()
    {
        return $this->typeMedia;
    }

    /**
     * Set the value of typeMedia
     *
     * @return  self
     */ 
    public function setTypeMedia($typeMedia)
    {
        $this->typeMedia = $typeMedia;

        return $this;
    }

    /**
     * Get the value of nomMedia
     */ 
    public function getNomMedia()
    {
        return $this->nomMedia;
    }

    /**
     * Set the value of nomMedia
     *
     * @return  self
     */ 
    public function setNomMedia($nomMedia)
    {
        $this->nomMedia = $nomMedia;

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
     * Get the value of post_id
     */ 
    public function getPost_id()
    {
        return $this->post_id;
    }

    /**
     * Set the value of post_id
     *
     * @return  self
     */ 
    public function setPost_id($post_id)
    {
        $this->post_id = $post_id;

        return $this;
    }

    // Insérer de nouvelles données
    public static function addMedia(Media $media, $idPost){
        $typeMedia = $media->getTypeMedia();
        $nomMedia = $media->getNomMedia();
        $creationDate = date("Y/m/d/H/i/s");
        $modificationDate = date("Y/m/d/H/i/s");
        $post_id = $idPost;

        $req = MonPdo::getInstance()->prepare("INSERT INTO media(typeMedia, nomMedia, creationDate, modificationDate, post_id) VALUES(:typeMedia, :nomMedia, :creationDate, :modificationDate, :post_id)");
        $req->bindParam(':typeMedia', $typeMedia);
        $req->bindParam(':nomMedia', $nomMedia);
        $req->bindParam(':creationDate', $creationDate);
        $req->bindParam(':modificationDate', $modificationDate);
        $req->bindParam(':post_id', $post_id);
        $req->execute();
    }

    // Récupérer un media par sont post_id
    public static function getMediaByPostId($idPost){
        $req = MonPdo::getInstance()->prepare("SELECT * FROM media WHERE post_id = :post_id");
        $req->bindParam(':post_id', $idPost);
        $req->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE,'Media');
        $req->execute();
        $res=$req->fetchAll();

        return $res;
    }

    // Supprime un media par sont post_id
    public static function deleteMediaByPostId($idPost){
        // Suppression du post
        $req = MonPdo::getInstance()->prepare("DELETE FROM media WHERE post_id = :post_id");
        $req->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Media');
        $req->bindParam(':post_id', $idPost);
        $req->execute();
    }
}
?>