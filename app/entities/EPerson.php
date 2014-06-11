<?php

/* 
 * Author: Liang Shan Ji
 */

class Person {

    private $_userId = 0;
    private $_userName = null;
    private $_userEmail = null;
    private $_userRole = null;
    
    public function getUserId() {
        return $this->_userId;
    }

    public function getUserName() {
        return $this->_userName;
    }

    public function getUserEmail() {
        return $this->_userEmail;
    }

    public function getUserRole() {
        return $this->_userRole;
    }

    public function setUserId($userId) {
        $this->_userId = $userId;
    }

    public function setUserName($userName) {
        $this->_userName = $userName;
    }

    public function setUserEmail($userEmail) {
        $this->_userEmail = $userEmail;
    }

    public function setUserRole($userRole) {
        $this->_userRole = $userRole;
    }



}