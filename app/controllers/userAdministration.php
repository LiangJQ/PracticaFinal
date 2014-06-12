<?php

/*
 * Author: Liang Shan Ji
 */

class UserAdministration extends Controller {

    function __construct() {
        parent::__construct();
        Auth::checkLoggedIn();
        Auth::checkAdmin();
    }

    function index() {
        header('Location: ' . URL . 'manager');
    }

    function listUsers() {
        $data = $this->model->listUsers();
        is_array($data) ? $this->view->listUsers = $data : $this->view->listUsers = array($data);
        $this->_renderArrayDefault('editusers');
        Session::set('createUser_success?', '');
        Session::set('deleteUser_success?', '');
    }

    function createUser() {
        $data = $this->_fetchPostUserData();

        if (Session::get('user_role') == ROLE_ADMIN) {
            $data['user_role'] = 'user';
        } else {
            $data['user_role'] = filter_input(INPUT_POST, 'user_role');
        }

        if ($this->model->userCheckExist($data) == 0) {
            $this->model->createUser($data);
            Session::set('createUser_success?', USER_CREATED);
        } else {
            Session::set('createUser_success?', USER_CREATE_ERROR);
        }
        header('Location: ' . URL . 'userAdministration/listUsers');
    }

    function deleteUser($id) {
        if (Session::get('user_role') == ROLE_ADMIN) {
            $userToDelete = $this->model->singleUser($id);
            if ($userToDelete->user_role == ROLE_USER) {
                $this->model->deleteUser($id);
                Session::set('deleteUser_success?', USER_DELETED);
            }
        } else {
            if ($userToDelete->user_role != ROLE_OWNER) {
                $this->model->deleteUser($id);
                Session::set('deleteUser_success?', USER_DELETED);
            }
        }
        header('Location: ' . URL . 'userAdministration/listUsers');
    }

    function editUser($id) {
        $this->view->user = $this->model->singleUser($id);
        $this->_renderArrayDefault('edituser');
        Session::set('editUser_success?', '');
    }

    function editUserSave($id) {
        $data = $this->_fetchPostUserData();

        if (Session::get('user_role') == ROLE_ADMIN) {
            $data['user_role'] = 'user';
        }

        $currentUser = $this->model->singleUser($id);

        if ($this->model->userCheckExist($data) == 0) {
            $this->model->editUserSave($data, $id);
            Session::set('editUser_success?', USER_EDITED);
            header('Location: ' . URL . 'useradministration/editUser/' . $data['user_id']);
        } else if ($this->model->userCheckExist($data) == 1) {
            if ($data['user_id'] == $id) {
                $this->model->editUserSave($data, $id);
                Session::set('editUser_success?', USER_EDITED);
                header('Location: ' . URL . 'useradministration/editUser/' . $data['user_id']);
            } else if ($data['user_email'] == $currentUser->user_email && empty($this->model->singleUser($data['user_id']))) {
                $this->model->editUserSave($data, $id);
                Session::set('editUser_success?', USER_EDITED);
                header('Location: ' . URL . 'useradministration/editUser/' . $data['user_id']);
            } else {
                Session::set('editUser_success?', USER_EDIT_ERROR);
                header('Location: ' . URL . 'useradministration/editUser/' . $id);
            }
        } else {
            Session::set('editUser_success?', USER_EDIT_ERROR);
            header('Location: ' . URL . 'useradministration/editUser/' . $id);
        }
    }

    private function _fetchPostUserData() {
        $data = array(
            'user_id' => filter_input(INPUT_POST, 'user_id'),
            'user_name' => filter_input(INPUT_POST, 'user_name'),
            'user_surname' => filter_input(INPUT_POST, 'user_surname'),
            'user_password' => filter_input(INPUT_POST, 'user_password'),
            'user_email' => filter_input(INPUT_POST, 'user_email'),
            'user_role' => filter_input(INPUT_POST, 'user_role')
        );
        return $data;
    }

    private function _renderArrayDefault($filename) {
        $array = array(
            1 => "manager/menuaction",
            2 => "useradministration/$filename"
        );
        $this->view->renderArray($array);
    }

}
