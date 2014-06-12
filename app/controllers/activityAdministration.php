<?php

/*
 * Author: Liang Shan Ji
 */

class ActivityAdministration extends Controller {

    function __construct() {
        parent::__construct();
        Auth::checkLoggedIn();
        Auth::checkAdmin();
    }

    function index() {
        header('Location: ' . URL . 'manager');
    }

    function listActivities() {
        $this->view->listActivitiesLimited = $this->model->listActivitiesLimited();
        $data = $this->model->listActivities();
        if (!empty($data)) {
            is_array($data) ? $this->view->listActivities = $data : $this->view->listActivities = array($data);
        } else {
            $this->view->listActivities = $data;
        }
        $this->_renderArrayDefault('editactivities');
        Session::set('createActivity_success?', '');
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
        header('Location: ' . URL . 'activityadministration/listActivities');
    }

    function deleteActivity($id) {
        $this->model->deleteActivity($id);
        Session::set('deleteActivity_success?', ACTIVITY_DELETED);
        header('Location: ' . URL . 'activityadministration/listActivities');
    }

    function editActivity($id) {
        $this->view->listActivitiesLimited = $this->model->listActivitiesLimited();
        $this->view->activity = $this->model->singleActivity($id);
        $this->_renderArrayDefault('editActivity');
        Session::set('editActivity_success?', '');
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
        header('Location: ' . URL . 'activityadministration/editActivity/' . $id);
    }

    public function authorizeActivities() {
        $data = $this->model->listActivitiesAuthorize();
        if (!empty($data)) {
            is_array($data) ? $this->view->listActivities = $data : $this->view->listActivities = array($data);
        } else {
            $this->view->listActivities = $data;
        }
        $this->_renderArrayDefault('authorizeActivities');
        Session::set('activity_authorized?', '');
    }

    public function authorizeActivity($id) {
        $this->model->authorizeActivity($id);
        Session::set('activity_authorized?', ACTIVITY_AUTHORIZED);
        header('Location: ' . URL . 'activityadministration/authorizeActivities');
    }

    public function denyActivity($id) {
        $this->model->denyActivity($id);
        Session::set('activity_authorized?', ACTIVITY_DENIED);
        header('Location: ' . URL . 'activityadministration/authorizeActivities');
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

    private function _fetchPostActivityData($id = "") {
        $data = array(
            'workshop_id' => $id,
            'workshop_user_id' => filter_input(INPUT_POST, 'workshop_user_id'),
            'workshop_name' => filter_input(INPUT_POST, 'workshop_name'),
            'workshop_description' => empty(filter_input(INPUT_POST, 'workshop_description')) ? "" : filter_input(INPUT_POST, 'workshop_description'),
            'workshop_url_web' => empty(rtrim($this->_formatUrl(filter_input(INPUT_POST, 'workshop_url_web')), '[{()}]')) ? "" : filter_input(INPUT_POST, 'workshop_url_web'),
            'workshop_url_file' => empty(rtrim($this->_formatUrl(filter_input(INPUT_POST, 'workshop_url_file')), '[{()}]')) ? "" : filter_input(INPUT_POST, 'workshop_url_file'),
            'workshop_date' => filter_input(INPUT_POST, 'workshop_date'),
            'workshop_request' => empty(filter_input(INPUT_POST, 'workshop_request')) ? "N" : filter_input(INPUT_POST, 'workshop_request'),
            'workshop_authorize' => empty(filter_input(INPUT_POST, 'workshop_authorize')) ? "P" : filter_input(INPUT_POST, 'workshop_authorize')
        );
        return $data;
    }

    private function _renderArrayDefault($filename) {
        $array = array(
            1 => "manager/menuaction",
            2 => "activityadministration/$filename"
        );
        $this->view->renderArray($array);
    }

}
