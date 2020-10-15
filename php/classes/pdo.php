<?php
/**     pdo.php
 *  @version : 1.0.2
 *  @date : 2020-10-14
 *  
 Query database and return a single row:

    $database = SimplePDO::getInstance();
    $database->query("SELECT `column` FROM `table` WHERE `columnValue` = :id");
    $database->bind(':id', 123);
    $result = $database->single();
    
 Query database and return multiply rows:

    $database = SimplePDO::getInstance();
    $database->query("SELECT * FROM `table`");
    $result = $database->resultSet();
    
 Insert new row in database:

    $database = SimplePDO::getInstance();
    $database->query("INSERT INTO `users` (name, email) VALUES (:name, :email)");
    $database->bind(':name', $name);
    $database->bind(':name', $email);
    $database->execute();
    
 Update existing row:

    $database = SimplePDO::getInstance();
    $database->query("UPDATE `users` SET `name` = :name WHERE `id` = :id");
    $database->bind(':name', $newName);
    $database->bind(':id', $id);
    $database->execute();
*/

class SimplePDO {     
    private static $_instance = null;

    private $_pdo;
    private $_stmt;
    private $_error;
    private $_query;

    public function __construct(){
        // Installation en local ou chez un hébergeur        
        if( substr(gethostbyname(gethostname()),0,8) == '192.168.')
            $host = 'localhost'; // the IP of the database
        else 
            $host = DB_HOST;
        
        try {
            $this->_pdo = new PDO('mysql:host=' . $host . ';dbname=' . DB_DBNAME, DB_USERNAME, DB_PASSWORD, array( PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8')) ;
        } catch(PDOException $e){
            print "Erreur !: " . $e->getMessage() . "<br/>";
            die();
        }
    }

    /** Singleton
     * 
     * @return SimplePDO
     */
    public static function getInstance() {
        if(!isset(self::$_instance)) {
            self::$_instance = new SimplePDO();
        }

        return self::$_instance;
    }

    /**
     * 
     * @param string $query
     */
    public function query($query) {
        $this->_query = $query;
        $this->_stmt = $this->_pdo->prepare($query);
    }

    /**
     * 
     * @param string $param
     * @param string $value
     * @param string $type
     */
    public function bind($param, $value, $type = null) {
    if (is_null($type)) {
      switch (true) {
        case is_int($value):
          $type = PDO::PARAM_INT;
          break;
        case is_bool($value):
          $type = PDO::PARAM_BOOL;
          break;
        case is_null($value):
          $type = PDO::PARAM_NULL;
          break;
        default:
          $type = PDO::PARAM_STR;
      }
    }
    $this->_stmt->bindValue($param, $value, $type);
    
    switch ($type) {
        case PDO::PARAM_INT:
        case PDO::PARAM_BOOL:
            $this->_query = str_replace( $param, $value, $this->_query);
            break;

        case PDO::PARAM_NULL:
            $this->_query = str_replace( $param, 'NULL', $this->_query);
            break;
            
        default:
            $this->_query = str_replace( $param, '"' . $value . '"', $this->_query);
    }
  }
  
  /**
   * Debug de la requ^te préparé
   */
  public function Dump() {
      var_dump($this->_query);
  }

  /**
   * 
   * @return boolean/string
   */
  public function execute() {
      try {
          return $this->_stmt->execute();
      } catch (PDOException $e) {
          echo $e->getMessage();
      } 
  }

  /**
   * 
   * @return array
   */
  public function resultSet() {
    $this->execute();
    return $this->_stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  /**
   * 
   * @return number
   */
  public function rowCount() {
    return $this->_stmt->rowCount();
  }

  /**
   * 
   * @return array
   */
  public function single() {
    $this->execute();
    return $this->_stmt->fetch(PDO::FETCH_ASSOC);
  }
  
  /**
   * 
   * @param string $name
   * @return string
   */
  public function lastInsertId($name = null)
  {
      return $this->_pdo->lastInsertId($name);
  }
  
  /**
   * 
   */
  public function debugDumpParams()
  {
      return $this->_stmt->debugDumpParams();
  }
  
  /**
   * 
   * @param array $sqls
   * @param array $params
   * @throws PDOException
   */
  public function transaction($sqls = array(), $params = array())
  {
        try {
            $this->_pdo->beginTransaction();
          
            foreach($sqls as $sql) {
                $this->query($sql);
                foreach($params as $key => $value) {
                    // La $key existe dans l'ordre sql
                    if(strpos($sql, $key))
                        $this->bind( $key, $value);
                }

                $this->execute();
                sleep(1);
          }
          $this->_pdo->commit();

      } catch(PDOException $e) {
          if(stripos($e->getMessage(), 'DATABASE IS LOCKED') !== false) {
              // This should be specific to SQLite, sleep for 0.25 seconds
              // and try again.  We do have to commit the open transaction first though
              $this->_pdo->commit();
              usleep(250000);
          } else {
              $this->_pdo->rollBack();
              throw $e;
          }
      }
  }
}