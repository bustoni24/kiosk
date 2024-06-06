<?php

/**
 * THIS CLASS WAS CREATED BY VLO CORPORATION (AUTHOR: EGA WACHID RADIEGTYA)
 * 1. add this variable to model 
 * public $image;  
 * 2. add rules to model
 * array('file_name', 'file', 'types' => 'jpg, gif, png, jpeg', 'allowEmpty' => true),
 * 3. don't use $model->attributes when saving data, but save it by every POST data
 * 4. add this to form view CActiveForm begin widget array
 * 'htmlOptions' => array('enctype' => 'multipart/form-data'),
 * 5. change textField in view to fileField
 * 6. import VUpload in controller
 * Yii::import('ext.vlo.upload.VUpload');
 * 7. define VUpload in Controller function create or update after line if (isset($_POST['Model'])) {
 * $VUpload = new VUpload();
 * 8. setting the path
 * $VUpload->path = 'images/';
 * 9. do upload
 * $VUpload->doUpload($model, 'image');
 * 10. to delete file, do'nt delete from database first, but call doDelete() first
 * $model = $this->loadModel($id);
        $VUpload = new VUpload();
        $VUpload->path = 'images/slider/';
        $VUpload->doDelete($model, 'image');        
        $model->delete();
 * 
 */
class VUpload extends CComponent {

    public $path;
    public $fileName;

    /**
     * setting the path      
     */
    public function setPath($path) {
        $this->path = Yii::getPathOfAlias('webroot') . "/$path/";
    }

    /**
     * get the path for controller    
     */
    public function getPath() {
        return $this->path;
    }

    /**
     * doing upload     
     */
    public function doUpload($model, $fileName, $sameName = false) {

        
        //set image name for saved to db
		$mod_count = date('i') % 2;		
        $encryptImage = date('Ymdhis') . Yii::app()->user->id;
        ${$fileName} = CUploadedFile::getInstance($model, "$fileName");
        $prefix = Yii::app()->controller->id;
        //if isset image file uploaded
        if (${$fileName}) {
            /* if(Yii::app()->controller->id == 'akreditasi') {
                if(!preg_match("/(png)|(jpg)|(jpeg)|(tif)|(bmp)/", ${$fileName}->extensionName)){
                    Yii::app()->user->setFlash('error', 'Format File Tidak Tepat');
                    $this->redirect(Yii::app()->createUrl('akreditasi/admin'));
                }
            } */
       
            if(${$fileName}->size > 10000000 || ${$fileName}->size == 0){
                Yii::app()->user->setFlash('error', 'Max File Foto 10MB');
                Helper::getInstance()->dump('Max File Foto 10MB');
                $this->redirect(Yii::app()->createUrl(Yii::app()->controller->id . '/admin'));
                
            }
            //unlink from folder if there is field in db
            if ($model->{$fileName})
            {
                $oldFileName = $this->getPath() . $model->{$fileName};
                if (file_exists($oldFileName))
                    unlink($oldFileName);
            }
            
            $tmp = ${$fileName}->name;
            $tmp = preg_replace('/[%]/', '', $tmp);
            $tmp = preg_replace('/[\s!@#$^&*()+_\/\\ ]/', '-', $tmp);
            //saved to db
            if($sameName){
                $model->{$fileName} = $tmp;
            }elseif($mod_count > 0){
                $model->{$fileName} = $prefix.'_'. $encryptImage .'_'. $tmp;
            }else{
                $model->{$fileName} = $prefix.'_'. $encryptImage .'_'. $tmp;
            }
				
            //upload image as to path and name same with db
            ${$fileName}->saveAs($this->getPath() . $model->{$fileName});
        }
        
        $this->fileName = $model->{$fileName};
    }

    public function doUploads($model, $fileName, $sameName = false, $loop) {

        
        //set image name for saved to db
		$mod_count = date('i') % 2;		
        $encryptImage = date('Ymdhis') . Yii::app()->user->id;
        ${$fileName} = CUploadedFile::getInstances($model, "$fileName", $loop);
        $prefix = Yii::app()->controller->id;

        if (${$fileName}) {
            /* if(Yii::app()->controller->id == 'akreditasi') {
                if(!preg_match("/(png)|(jpg)|(jpeg)|(tif)|(bmp)/", ${$fileName}->extensionName)){
                    Yii::app()->user->setFlash('error', 'Format File Tidak Tepat');
                    $this->redirect(Yii::app()->createUrl('akreditasi/admin'));
                }
            } */
       
            if(${$fileName}->size > 10000000 || ${$fileName}->size == 0){
                Yii::app()->user->setFlash('error', 'Max File Foto 10MB');
                Helper::getInstance()->dump('Max File Foto 10MB');
                $this->redirect(Yii::app()->createUrl(Yii::app()->controller->id . '/admin'));
                
            }
            //unlink from folder if there is field in db
            if ($model->{$fileName})
            {
                $oldFileName = $this->getPath() . $model->{$fileName};
                if (file_exists($oldFileName))
                    unlink($oldFileName);
            }
            
            $tmp = ${$fileName}->name;
            $tmp = preg_replace('/[%]/', '', $tmp);
            $tmp = preg_replace('/[\s!@#$^&*()+_\/\\ ]/', '-', $tmp);
            //saved to db
            if($sameName){
                $model->{$fileName} = $tmp;
            }elseif($mod_count > 0){
                $model->{$fileName} = $prefix.'_'. $encryptImage .'_'. $tmp;
            }else{
                $model->{$fileName} = $prefix.'_'. $encryptImage .'_'. $tmp;
            }
				
            //upload image as to path and name same with db
            ${$fileName}->saveAs($this->getPath() . $model->{$fileName});
        }
        
        $this->fileName = $model->{$fileName};
    }

    public function doSimpleUpload($model, $fileName, $object) {
        $mod_count = date('i') % 2;
        $encryptImage = date('Ymdhis').Yii::app()->user->id;
        ${$fileName} = CUploadedFile::getInstance($model, "$fileName");
        $prefix = Yii::app()->controller->id;

        if (${$fileName}) {
            if ($model->{$object}) {
                $oldFileName = $this->getPath() . $model->{$object};
                if (file_exists($oldFileName))
                    unlink($oldFileName);
            }

            $tmp = ${$fileName}->name;
            $tmp = preg_replace('/[%]/', '', $tmp);
            $tmp = preg_replace('/[\s!@#$^&*()+_\/\\ ]/', '-', $tmp);

            if ($mod_count > 0)
                $model->{$object} = $prefix.'_'.$encryptImage.'_'.$tmp;
            else
                $model->{$object} = $prefix.'_'.$encryptImage.'_'.$tmp;

            ${$fileName}->saveAs($this->getPath().$model->{$object});
        }

        $this->fileName = $model->{$object};
    }
    
     public function getFileName(){
        return $this->fileName;
    }
    
    /**
     * to delete or unlink file     
     */
    public function doDelete($model, $fileName){
        $model;
        if ($model->{$fileName})
            unlink($this->getPath() . $model->{$fileName});        
    }

    public function redirect($url,$terminate=true,$statusCode=302)
    {
        if(is_array($url))
        {
            $route=isset($url[0]) ? $url[0] : '';
            $url=$this->createUrl($route,array_splice($url,1));
        }
        Yii::app()->getRequest()->redirect($url,$terminate,$statusCode);
    }

}