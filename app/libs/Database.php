<?php

/*
 * Author: Liang Shan Ji
 */

class Database extends PDO {

    function __construct($dbType, $dbHost, $dbName, $dbUser, $dbPass, $options = '') {
        $options = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ, PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING);

        parent::__construct($dbType . ':host=' . $dbHost . ';dbname=' . $dbName . ';charset=utf8', $dbUser, $dbPass, $options);
    }

    /**
     * Database Select
     * 
     * @param string $table         : name of table to select
     * @param string $array         : strings array of attributes
     * @param string $condition     : WHERE $condition !!{DO NOT ADD "WHERE"}!!
     * @param string $bindValues    : (Optional) associative array
     * @return Resulset
     */
    public function select($table, $array, $condition, $bindValues = array()) {

        $attr = implode(', ', $array);

        $sth = $this->prepare("SELECT $attr FROM $table WHERE $condition");

        foreach ($bindValues as $key => $value) {
            $sth->bindValue(":$key", $value);
        }

        $sth->execute();
        if ($sth->rowCount() > 1) {
            return $sth->fetchAll();
        } else {
            return $sth->fetch();
        }
    }

    /**
     * Database Insert
     * 
     * @param string $table : name of table to insert to
     * @param string $data  : associative array
     */
    public function insert($table, $data) {

        ksort($data);

        $dataKeysName = implode('`, `', array_keys($data));
        $dataBindValuesName = implode(', :', array_keys($data));

        $sth = $this->prepare("INSERT INTO $table (`$dataKeysName`) VALUES (:$dataBindValuesName)");

        foreach ($data as $key => $value) {
            $sth->bindValue(":$key", $value);
        }

        $sth->execute();
    }

    /**
     * Database Update
     * 
     * @param string $table     : name of table to update
     * @param string $data      : associative array
     * @param string $condition : condition(s)
     */
    public function update($table, $data, $condition, $bindValues = array()) {

        ksort($data);

        $dataDetails = null;
        foreach ($data as $key => $value) {
            $dataDetails .= "`$key` = :$key,";
        }
        $dataDetails = rtrim($dataDetails, ',');

        $sth = $this->prepare("UPDATE $table SET $dataDetails WHERE $condition");

        foreach ($data as $key => $value) {
            $sth->bindValue(":$key", $value);
        }
        
        foreach ($bindValues as $key => $value) {
            $sth->bindValue(":$key", $value);
        }

        $sth->execute();
    }

    /**
     * Database Delete
     * 
     * @param string $table         : name of table to select
     * @param string $condition     : WHERE $condition !!{DO NOT ADD "WHERE"}!!
     * @param string $bindValues    : (Optional) associative array
     * @param int $limit            : (Optional) limit number of rows to delete. Default = 1
     * @return int                  : affected rows 
     */
    public function delete($table, $condition, $bindValues = array(), $limit = 1) {

        $sth = $this->prepare("DELETE FROM $table WHERE $condition");

        foreach ($bindValues as $key => $value) {
            $sth->bindValue(":$key", $value);
        }

        return $sth->execute();
    }

}
