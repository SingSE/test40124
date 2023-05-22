<?php
final class dbHandler
{
    private $dataSource = "mysql:dbname=swordle;host=localhost";
    private $username = "root";
    private $password = "";

    public function selectAll()
    {
        try{
            $pdo = new PDO($this->dataSource, $this->username, $this->password);
            $statement = $pdo->prepare("Select * from word JOIN category ON word.categoryId = category.categoryId");
            $statement->execute();
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        }
        catch(PDOException $exception){
            return false;
        }
    }

    public function selectCategories()
    {
        try{
            $pdo = new PDO($this->dataSource, $this->username, $this->password);
            $statement = $pdo->prepare("Select * from category");
            $statement->execute();
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        }
        catch(PDOException $exception){
            return false;
        }
    }

    public function createWord($text, $categoryId){
        try{
            $pdo = new PDO($this->dataSource, $this->username, $this->password);
            $statement = $pdo->prepare("Insert into word(text, categoryId) VALUES(:text, :category)");
            $statement->bindValue("text", $text, PDO::PARAM_STR);
            $statement->bindValue("category", $categoryId, PDO::PARAM_INT);
    
            $statement->execute();
            return true;
        }
        catch(PDOException $exception){
            return false;
        }
    }

    public function selectOne($wordId){
        try{
            $pdo = new PDO($this->dataSource, $this->username, $this->password);
            $statement = $pdo->prepare("Select * from word JOIN category ON word.categoryId = category.categoryId WHERE wordId = :id");
            $statement->bindParam("id", $wordId, PDO::PARAM_INT);
            $statement->execute();
            $rows = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $rows[0];
        }
        catch(PDOException $exception){
            return false;
        }
    }

    public function updateWord($wordId, $text, $category){
        try{
            $pdo = new PDO($this->dataSource, $this->username, $this->password);
            $statement = $pdo->prepare("UPDATE word SET text=:text, categoryId=:category WHERE wordId = :id");
            $statement->bindParam("id", $wordId, PDO::PARAM_INT);
            $statement->bindParam("text", $text);
            $statement->bindParam("category", $category);
            $statement->execute();
            return true;
        }
        catch(PDOException $exception){
            return false;
        }
    }

     //Delete
    public function deleteWord($id){
        try{
            $pdo = new PDO($this->dataSource, $this->username, $this->password);

            $statement = $pdo->prepare("DELETE FROM word WHERE wordId = :id");

            $statement->bindValue(":id", $id, PDO::PARAM_INT);

            $statement->execute();
            return true;
        }
        catch(PDOException $e){
            return false;
        }

    }
}
?>