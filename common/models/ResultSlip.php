<?php
namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "payment_slip".
 *
 * @property integer $id
 * @property string $path
 * @property integer $register_id
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Register $register
 */
class ResultSlip extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'result_slip';
    }
    public function behaviors() {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['path',],'safe'],
            [['register_id', 'created_at', 'updated_at'], 'integer'],
            [['register_id'], 'exist', 'skipOnError' => true, 'targetClass' => Register::className(), 'targetAttribute' => ['register_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'path' => 'Path',
            'register_id' => 'Register',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function fullDelete()
    {
      Yii::$app->webTools->UnlinkFile($this->path);
      $this->delete();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRegister()
    {
        return $this->hasOne(Register::className(), ['id' => 'register_id']);
    }
}
