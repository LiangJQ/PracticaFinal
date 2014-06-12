<?php

/*
 * Author: Liang Shan Ji
 */

class Workshop extends Controller {

    function __construct() {
        parent::__construct();

        if (empty(Session::get('is_user_logged_in'))) {
            Session::destroy();
            header('location: ' . URL . 'index');
            exit;
        }
    }

    function index() {
        $this->view->userActivity = $this->model->getUserActivity(Session::get('user_id'));
        $this->_renderArrayDefault('index');
    }

    function inviteUsers() {
        $data = $this->model->listUsers();
        is_array($data) ? $this->view->listUsers = $data : $this->view->listUsers = array($data);
        $this->view->userActivity = $this->model->getUserActivity(Session::get('user_id'));
        $this->_renderArrayDefault('inviteUsers');
    }

    function inviteUsersList() {
        $this->_fetchPostUserList();
        header('Location: '. URL . 'workshop/inviteUsers');
    }

    function confirmActivity() {
        $this->view->userActivity = $this->model->getUserActivity(Session::get('user_id'));
        $this->_renderArrayDefault('confirmActivity');
    }

    function confirmActivitySave($id) {
        $this->model->confirmActivitySave($id);
        $this->view->userActivity = $this->model->getUserActivity(Session::get('user_id'));
        $this->_renderArrayDefault('confirmActivity');
    }

    function manageActivity() {
        $this->view->listActivitiesLimited = $this->model->listActivitiesLimited();
        $this->view->userActivity = $this->model->getUserActivity(Session::get('user_id'));
        $this->_renderArrayDefault('manageActivity');
        Session::set('createActivity_success?', '');
        Session::set('editActivity_success?', '');
        Session::set('deleteActivity_success?', '');
    }

    function createActivity() {
        $data = $this->_fetchPostActivityData();

        if ($this->model->activityCheckExist($data) == 0) {
            $this->model->createActivity($data);
            Session::set('createActivity_success?', ACTIVITY_CREATED);
        } else {
            Session::set('createActivity_success?', ACTIVITY_CREATE_ERROR);
        }
        header('Location: ' . URL . 'workshop/manageActivity');
    }

    function editActivitySave($id) {
        $data = $this->_fetchPostActivityData();

        if ($this->model->activityCheckExist($data) == 0) {
            $this->model->editActivitySave($data, $id);
            Session::set('editActivity_success?', ACTIVITY_EDITED);
        } else if ($this->model->activityCheckExist($data) == 1) {
            if ($this->model->singleActivityByData($data)->workshop_id == $id) {
                $this->model->editActivitySave($data, $id);
                Session::set('editActivity_success?', ACTIVITY_EDITED);
            } else {
                Session::set('editActivity_success?', ACTIVITY_EDIT_ERROR);
            }
        } else {
            Session::set('editActivity_success?', ACTIVITY_EDIT_ERROR);
        }
        header('Location: ' . URL . 'workshop/manageActivity');
    }

    function deleteActivity($id) {
        $this->model->deleteActivity($id);
        Session::set('deleteActivity_success?', ACTIVITY_DELETED);
        Session::set('checkedUsers', '');
        header('Location: ' . URL . 'workshop/manageActivity');
    }

    private function _fetchPostUserList() {
        if (!empty($_POST['user_id'])) {
            foreach ($_POST['user_id'] as $user_id) {
                $data[] = $user_id;
            }
            Session::set('checkedUsers', $data);
        }
    }

    private function _fetchPostActivityData() {
        $data = array(
            'workshop_user_id' => Session::get('user_id'),
            'workshop_name' => filter_input(INPUT_POST, 'workshop_name'),
            'workshop_description' => empty(filter_input(INPUT_POST, 'workshop_description')) ? "" : filter_input(INPUT_POST, 'workshop_description'),
            'workshop_url_web' => empty(rtrim($this->_formatUrl(filter_input(INPUT_POST, 'workshop_url_web')), '[{()}]')) ? "" : filter_input(INPUT_POST, 'workshop_url_web'),
            'workshop_url_file' => empty(rtrim($this->_formatUrl(filter_input(INPUT_POST, 'workshop_url_file')), '[{()}]')) ? "" : filter_input(INPUT_POST, 'workshop_url_file'),
            'workshop_date' => filter_input(INPUT_POST, 'workshop_date'),
        );
        return $data;
    }

    private function _renderArrayDefault($filename) {
        $array = array(
            1 => "workshop/menuaction",
            2 => "workshop/$filename"
        );
        $this->view->renderArray($array);
    }

    private function _formatUrl($url) {
        $urlFormatted = null;
        $urlPrepare = ltrim($url);
        $urlPrepare = explode("\n", $urlPrepare);
        foreach ($urlPrepare as $value) {
            $urlFormatted .= $value . "[{()}]";
        }
        return $urlFormatted;
    }

}
