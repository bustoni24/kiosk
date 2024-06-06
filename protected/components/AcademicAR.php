<?php
class AcademicAR extends CActiveRecord {

    private static $dbakademik = null;
 
    protected static function getAcademicDbConnection()
    {
        if (self::$dbakademik !== null)
            return self::$dbakademik;
        else
        {
            self::$dbakademik = Yii::app()->dbakademik;
            if (self::$dbakademik instanceof CDbConnection)
            {
                self::$dbakademik->setActive(true);
                return self::$dbakademik;
            }
            else
                throw new CDbException(Yii::t('yii','Active Record requires a "db" CDbConnection application component.'));
        }
    }
}
?>
