<?php

  /**
  * @backupGlobals disabled
  * @backupStaticAttributes disabled
  */

  require_once 'src/Inventory.php';

  $server = 'mysql:host=localhost:8889;dbname=inventory_test';
  $username = 'root';
  $pass = 'root';
  $db = new PDO($server,$username,$pass);

  class InventoryTest extends PHPUnit_Framework_TestCase {

    function tearDown(){
      Inventory::deleteAll();
    }

    function test_save(){
      $collection = "cup";
      $test_collection = new Inventory($collection);
      $executed = $test_collection->save();
      $this->assertTrue($executed, "Fail");
    }

    function test_getAll(){
      $collection = "stamp";
      $test_collection = new Inventory($collection);
      $test_collection -> save();
      $collection2 = "pen";
      $test_collection2 = new Inventory($collection2);
      $test_collection2 -> save();

      $result = Inventory::getAll();

      $this->assertEquals(array ('stamp','pen'), $result);
    }


  }


?>
