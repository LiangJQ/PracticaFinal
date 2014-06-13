<?php

/*
 * Author: Liang Shan Ji
 */

/**
 * Creates a PDO database connection.
 */
class Database extends PDO {

    function __construct($dbType, $dbHost, $dbName, $dbUser, $dbPass, $options = '') {
        $options = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ, PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING);

        parent::__construct($dbType . ':host=' . $dbHost . ';dbname=' . $dbName . ';charset=utf8', $dbUser, $dbPass, $options);
    }

    /**
     * Database selectStatement
     * 
     * @param string $table         : name of table to select
     * @param string $attr         : strings array of attributes
     * @param string $condition     : WHERE $condition
     * @param string $conditionArrayValues    : (Optional) associative array if need binding condition values
     * @return Resulset
     */
    private function selectStatement($table, $attr, $condition = null, $conditionArrayValues = array()) {

        $attrr = implode(', ', $attr);

        $sth = $this->prepare("SELECT $attrr FROM $table $condition");

        foreach ($conditionArrayValues as $key => $value) {
            $sth->bindValue(":$key", $value);
        }

        $sth->execute();

        return $sth;
    }

    /**
     * Database Select
     * 
     * @param string $table         : name of table to select
     * @param string $attr         : strings array of attributes
     * @param string $condition     : WHERE $condition
     * @param string $conditionArrayValues    : (Optional) associative array if need binding condition values
     * @return array of Objects             : Row(s)
     */
    public function select($table, $attr, $condition = null, $conditionArrayValues = array()) {

        $sth = $this->selectStatement($table, $attr, $condition, $conditionArrayValues);

        if ($sth->rowCount() > 1) {
            return $sth->fetchAll();
        } else {
            return $sth->fetch();
        }
    }

    /**
     * Database Row Count
     * 
     * @param string $table         : name of table to select
     * @param string $attr         : strings array of attributes
     * @param string $condition     : WHERE $condition
     * @param string $conditionArrayValues    : (Optional) associative array if need binding condition values
     * @return integer          : row count
     */
    public function rowCountNumber($table, $attr, $condition = null, $conditionArrayValues = array()) {

        $sth = $this->selectStatement($table, $attr, $condition, $conditionArrayValues);

        return $sth->rowCount();
    }

    /**
     * Database Insert
     * 
     * @param string $table : name of table to insert to
     * @param string $data  : associative array
     * @return bool         : TRUE on success or FALSE on failure
     */
    public function insert($table, $data) {

        ksort($data);

        $dataKeysName = implode('`, `', array_keys($data));
        $dataBindValuesName = implode(', :', array_keys($data));

        $sth = $this->prepare("INSERT INTO $table (`$dataKeysName`) VALUES (:$dataBindValuesName)");

        foreach ($data as $key => $value) {
            $sth->bindValue(":$key", $value);
        }

        return $sth->execute();
    }

    /**
     * Database Update
     * 
     * @param string $table         : name of table to update
     * @param string $data          : associative array
     * @param string $condition     : WHERE $condition 
     * @param string $conditionArrayValues : (Optional) associative array if need binding condition values
     */
    public function update($table, $data, $condition, $conditionArrayValues = array()) {
        ksort($data);

        $dataDetails = null;
        foreach ($data as $key => $value) {
            $dataDetails .= "`$key` = :$key, ";
        }
        $dataDetails = rtrim($dataDetails, ', ');

        $sth = $this->prepare("UPDATE $table SET $dataDetails $condition");

        foreach ($data as $key => $value) {
            $sth->bindValue(":$key", $value);
        }

        foreach ($conditionArrayValues as $key => $value) {
            $sth->bindValue(":$key", $value);
        }

        $sth->execute();
    }

    /**
     * Database Delete
     * 
     * @param string $table         : name of table to select
     * @param string $condition     : WHERE $condition 
     * @param string $conditionArrayValues    : (Optional) associative array if need binding condition values
     * @param int $limit            : (Optional) limit number of rows to delete. Default = 1
     * @return int                  : affected rows 
     */
    public function delete($table, $condition, $conditionArrayValues = array(), $limit = 1) {

        $sth = $this->prepare("DELETE FROM $table $condition LIMIT $limit");

        foreach ($conditionArrayValues as $key => $value) {
            $sth->bindValue(":$key", $value);
        }

        return $sth->execute();
    }

}
