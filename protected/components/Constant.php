<?php

class Constant {

    const PROJECT_NAME = "KIOSK Efisiensi";
    const SEARCH_BOARDING = 'boarding';
    const SEARCH_DROP_OFF = 'drop_off';

    public static function baseUrl() {
        return Yii::app()->request->baseUrl;
    }

    public static function baseAdminUrl() {
        return Yii::app()->request->baseUrl.'/home';
    }

    public static function getImageUrl() {
        return Yii::app()->request->baseUrl . "/images";
    }

    public static function baseUploadsPath() {
        return Yii::app()->request->baseUrl . "/uploads";
    }

    public static function baseLoginAdmin() {
        return Yii::app()->request->baseUrl.'/loginadmin';
    }

    public static function baseJsUrl() {
    	return Yii::app()->assetManager->publish('./js');
    }

    public static function baseCssUrl() {
    	return Yii::app()->assetManager->publish('./css');
    }

    public static function frontAssetUrl() {
        return Yii::app()->assetManager->publish('./themes/gentelella');
    }

    public static function imageUrl() {
    	return Yii::app()->assetManager->publish('./images');
    }

    public static function assetsUrl() {
        return Yii::app()->assetManager->publish('./themes/adminlte');
    }

    public static function defaultAction() {
    	return ['admin','index','create','view','update','delete'];
    }
}