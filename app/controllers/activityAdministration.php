<?php

/*
 * Author: Liang Shan Ji
 */

/**
 * Manages activities actions such as edit, create, delete, authorize activities.
 */
class ActivityAdministration extends Controller {

    /**
     * When constructs, check if user is logged in and is admin.
     * It will automatically exit to index of web if user is not logged in or is an admin
     */
    function __construct() {
        parent::__construct();
        Auth::checkLoggedIn();
        Auth::checkAdmin();
    }

    /**
     * Base page.
     * Redirect to manger controller base page.
     */
    function index() {
        header('Location: ' . URL . 'manager');
    }

    /**
     * Lists all existing activities.
     * Passing to view a list of activities.
     * Redirect to editactivities page
     */
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

    /**
     * Creates a new activity
     * Redirect to listActivities action
     */
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

    /**
     * Deletes activity by passing an activity id
     * Redirect to listActivities action
     * 
     * @param int $id : activity id to be deleted
     */
    function deleteActivity($id) {
        $this->model->deleteActivity($id);
        Session::set('deleteActivity_success?', ACTIVITY_DELETED);
        header('Location: ' . URL . 'activityadministration/listActivities');
    }

    /**
     * Redirects to another page to edit activity by passing an activity id
     * 
     * @param int $id : activity id to be edited
     */
    function editActivity($id) {
        $this->view->listActivitiesLimited = $this->model->listActivitiesLimited();
        $this->view->activity = $this->model->singleActivity($id);
        $this->_renderArrayDefault('editActivity');
        Session::set('editActivity_success?', '');
    }

    /**
     * Saves all changes made of an activity passing an activity id
     * Redirects to editActivity action
     * 
     * @param int $id : activity id to be edited
     */
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

    /**
     * Redirects to another page to authorize activities.
     * Lists activities which have sent request to be authorized
     */
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

    /**
     * Authorizes an activity with its id
     * @param int $id : activity id to be authorized
     */
    public function authorizeActivity($id) {
        $this->model->authorizeActivity($id);
        Session::set('activity_authorized?', ACTIVITY_AUTHORIZED);
        header('Location: ' . URL . 'activityadministration/authorizeActivities');
    }

    /**
     * Denies an activity with its id
     * @param int $id : activity id to be denied
     */
    public function denyActivity($id) {
        $this->model->denyActivity($id);
        Session::set('activity_authorized?', ACTIVITY_DENIED);
        header('Location: ' . URL . 'activityadministration/authorizeActivities');
    }

    /**
     * Formats urls in order to save them to database
     * 
     * @param string $url   : urls separated with '\n'
     * @return string       : urls separated with [{()}]
     */
    private function _formatUrl($url) {
        $urlFormatted = null;
        $urlPrepare = ltrim($url);
        $urlPrepare = explode("\n", $urlPrepare);
        foreach ($urlPrepare as $value) {
            $urlFormatted .= $value . "[{()}]";
        }
        return $urlFormatted;
    }

    /**
     * Fetches data when a form is submitted
     * @param int $id   : activity id. Default = ''
     * @return array    : array with POST data
     */
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

    /**
     * Shows a view called $filename
     * @param string $filename  : filename to be shown in view
     */
    private function _renderArrayDefault($filename) {
        $array = array(
            1 => "manager/menuaction",
            2 => "activityadministration/$filename"
        );
        $this->view->renderArray($array);
    }

}
