<?php

class VAuth extends CWidget {

    /**
     * to get user by login id
     */

    public static function getUserId() {
        $userId = array();

        if (isset(Yii::app()->user->id))
            array_push($userId, Yii::app()->user->id);

        return $userId;
    }

    public static function getGroupId() {
        $groupId = null;

        if (isset(Yii::app()->user->id)){
            $groupId = User::model()->findByAttributes(['id' => Yii::app()->user->id]);
            if (isset($groupId->level))
                $groupId = $groupId->level;
        }

        return $groupId;
    }

    public static function isAllowed($group_id, $className, $action){
        $tmp = self::getActions($group_id, $className);
        $isAllowed = false;

        foreach ($tmp as $key => $value) {
            if($value == $action)
                $isAllowed = true;
        }

        return $isAllowed;
    }

    /**
     * get actions system admin or another type user
     * @param int $group_id
     * @param type $className
     * @return type
     */
    public static function getActions($group_id, $className) {
        $count = GroupAuth::model()->countByAttributes(array(
            'className' => $className,
            'group_id' => $group_id,
        ));

        if ($count <= 0) {
            return array('');
        } else {
            $model = GroupAuth::model()->findByAttributes(array(
                'className' => $className,
                'group_id' => $group_id,
            ))->action;

            $model = trim($model);
            $arrayModels = explode(',', $model);
            $data = array();

            for ($i = 0; $i < sizeof($arrayModels); $i++) {
                $data[$i] = $arrayModels[$i];
            }

            return $data;
        }
    }

    public static function getAccessRules($className = 'default', $defaultActions = null) {
        $defaultActions = (!$defaultActions) ? array('index', 'view') : $defaultActions;
        $userId = self::getUserId();
        $groupId = self::getGroupId();
        $userName = array();
        $modelUser = User::model()->findByAttributes(['id' => $userId]);
        if (isset($modelUser)) {
            $userName[0] =  $modelUser->username;
        }

        return array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => $defaultActions,
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => self::getActions($groupId, $className),
                'users' => $userName,
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

}
