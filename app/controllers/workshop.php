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
        $hasActivity = !empty($this->model->getUserActivity(Session::get('user_id'))->workshop_id) ? $this->model->getUserActivity(Session::get('user_id'))->workshop_id : '';
        Session::set('userActivity', $hasActivity);
        $this->view->userActivity = $this->model->getUserActivity(Session::get('user_id'));
        $this->_renderArrayDefault('index');
    }

    function distributeUsers() {
        $userActivity = $this->model->getUserActivity(Session::get('user_id'));
        $this->view->userActivity = $userActivity;
        $usersInvited = array();
        if (!empty($userActivity)) {
            $dataUsersInvited = $this->model->listUsersInvited();
            if (!empty($dataUsersInvited)) {
                if (!is_array($dataUsersInvited)) {
                    $usersInvited[] = array(
                        'user_id' => $this->model->singleUser($dataUsersInvited->area_user_id)->user_id,
                        'user_fullname' => $this->model->singleUser($dataUsersInvited->area_user_id)->user_surname . ", " . $this->model->singleUser($dataUsersInvited->area_user_id)->user_name,
                        'user_table' => $dataUsersInvited->area_table,
                        'user_seat' => $dataUsersInvited->area_seat
                    );
                } else {
                    foreach ($dataUsersInvited as $value) {
                        $usersInvited[] = array(
                            'user_id' => $this->model->singleUser($value->area_user_id)->user_id,
                            'user_fullname' => $this->model->singleUser($value->area_user_id)->user_surname . ", " . $this->model->singleUser($value->area_user_id)->user_name,
                            'user_table' => $value->area_table,
                            'user_seat' => $value->area_seat
                        );
                    }
                }
            }
        }

        $this->view->inviteList = $usersInvited;
        $this->view->renderOnePage('workshop/distributeUsers', true);
    }

    function distributeUsersSave() {
        $userDistributionList = json_decode(filter_input(INPUT_POST, 'user_distribution'));

        $array['area_id'] = Session::get('userActivity');
        $this->model->emptyUserDistribution($array['area_id']);
        foreach ($userDistributionList as $value) {
            foreach ($value as $key => $value) {
                if ($key == 'id') {
                    $array['area_user_id'] = $value;
                }
                if ($key == 'mesa') {
                    $array['area_table'] = $value;
                }
                if ($key == 'silla') {
                    $array['area_seat'] = $value;
                }
            }
            if ($this->model->areaWorkshopCheckUserExist($array) == 1) {
                $this->model->toZeroUserRow($array['area_user_id']);
            }
            if ($this->model->areaWorkshopCheckSeatExist($array) == 0) {
                $this->model->distributedUsersSave($array);
            } else {
                $this->model->toZeroSeatRow($array['area_table'], $array['area_seat']);
                $this->model->distributedUsersSave($array);
            }
        }
        header('Location: ' . URL . 'workshop/distributeUsers');
    }

    function inviteUsers() {
        $usersInvited = array();
        $data = $this->model->listUsersToInvite();
        is_array($data) ? $this->view->listUsers = $data : $this->view->listUsers = array($data);
        $dataUsersInvited = $this->model->listUsersInvited();
        if (!empty($dataUsersInvited)) {
            if (!is_array($dataUsersInvited)) {
                $usersInvited[] = $dataUsersInvited->area_user_id;
            } else {
                foreach ($dataUsersInvited as $value) {
                    $usersInvited[] = $value->area_user_id;
                }
            }
        }
        $this->view->usersInvited = $usersInvited;
        $this->view->userActivity = $this->model->getUserActivity(Session::get('user_id'));
        $this->_renderArrayDefault('inviteUsers');
    }

    function inviteUsersList() {
        $userChecked = $this->_fetchPostUserList();
        $userList = $this->model->listUsersToInvite();
        foreach ($userList as $value) {
            $userUnchecked[] = $value->user_id;
        }
        foreach (array_diff($userUnchecked, $userChecked) as $value) {
            $this->model->deleteUserRow($value);
        }
        foreach ($userChecked as $value) {
            if ($this->model->areaWorkshopCheckUserExistSingle($value) == 0) {
                $this->model->insertUserRow($value);
            }
        }
        header('Location: ' . URL . 'workshop/inviteUsers');
    }

    function confirmActivity() {
        $this->model->emptyInvitedUsersNoSeat();
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
            $hasActivity = !empty($this->model->getUserActivity(Session::get('user_id'))->workshop_id) ? $this->model->getUserActivity(Session::get('user_id'))->workshop_id : '';
            Session::set('userActivity', $hasActivity);
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
        $data = array();
        if (!empty($_POST['user_id'])) {
            foreach ($_POST['user_id'] as $user_id) {
                $data[] = $user_id;
            }
        }
        return $data;
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
