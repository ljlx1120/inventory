<?php
  class Inventory {

    private $id;
    private $collection;

    function __construct($collection, $id = null){
      $this->collection = $collection;
      $this->id = $id;
    }

    function setId($new_id){
      $this->id = (int) $new_id;
    }

    function getId(){
      return $this->id;
    }

    function setCollection($new_collection){
      $this->collection = (string) $new_collection;
    }

    function getCollection(){
      return $this->collection;
    }

    function save() {
      $executed = $GLOBALS['db']->exec("INSERT INTO collections (collection) VALUES ('{$this->getCollection()}');");
      if ($executed) {
        $this->id = $GLOBALS['db']->lastInsertId();
        return true;
      } else {
        return false;
      }
    }

    static function deleteAll() {
      $executed = $GLOBALS['db']->exec("DELETE FROM collections;");
      if($executed){
        return true;
      } else {
        return false;
      }
    }

    static function getAll() {
      $collection_array = array ();
      $returned_collection = $GLOBALS['db']->query("SELECT * FROM collections;");
      $results = $returned_collection->fetchAll(PDO::FETCH_OBJ);
      foreach($results as $collection) {
        array_push($collection_array, $collection->collection);
      }
      return $collection_array;
    }

    static function find($search) {
      $collection_array = array ();
      $returned_collection = $GLOBALS['db']->prepare("SELECT * FROM collections WHERE id = :id;");
      $returned_collection->bindParam(':id', $search, PDO::PARAM_STR);
      $returned_collection->execute();
      $results = $returned_collection->fetchAll(PDO::FETCH_OBJ);
      foreach ($results as $result){
        array_push($collection_array, $result->collection);
      }
      return $collection_array;
    }



  }

?>
