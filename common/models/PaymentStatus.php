<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "payment_status".
 *
 * @property integer $id
 * @property integer $status
 * @property string $description
 * @property integer $register_id
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Register $register
 */
class PaymentStatus extends \yii\db\ActiveRecord
{
  public $max_id;
  const STATUS_WAIT_FOR_PAY = 10;
  const STATUS_WAIT_FOR_CHECK_PAYMENT = 11;
  const STATUS_PAID = 12;
  const STATUS_CONFIRM_AGAIN = 13;
  const STATUS_WAIT_FOR_APPROVE_PAYMENT = 14;
  const STATUS_PAY_BEFORE_START_WORKSHOP = 15;

  const ARRAY_STATUS_FINISH_UPLOAD = [self::STATUS_WAIT_FOR_CHECK_PAYMENT,self::STATUS_WAIT_FOR_APPROVE_PAYMENT,self::STATUS_PAID,self::STATUS_CONFIRM_AGAIN];
  const ARRAY_STATUS_APPROVE_PAYMENT = [self::STATUS_WAIT_FOR_APPROVE_PAYMENT,self::STATUS_PAID,self::STATUS_PAY_BEFORE_START_WORKSHOP];
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'payment_status';
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
            [['status', 'register_id', 'created_at', 'updated_at'], 'integer'],
            [['description'], 'string'],
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
            'status' => 'สถานะการจ่ายเงิน',
            'description' => 'หมายเหตุ',
            'register_id' => 'Register',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public static function AddStatus($id,$status = self::STATUS_WAIT_FOR_PAY){
        $paymentStatus = new self();
        $paymentStatus->register_id = $id;
        $paymentStatus->status = $status;
        return $paymentStatus->save();
    }

    public static function getItemStatus(array $unset = null) {
        $items = [
            self::STATUS_WAIT_FOR_PAY => 'รอแจ้งหลักฐานการโอนเงิน',
            self::STATUS_WAIT_FOR_CHECK_PAYMENT => 'รอการตรวจสอบหลักฐานการโอนเงิน',
            self::STATUS_PAID => 'การชำระเงินเสร็จสมบูรณ์',
            self::STATUS_CONFIRM_AGAIN => 'แจ้งหลักฐานการโอนเงินใหม่อีกครั้ง',
            self::STATUS_WAIT_FOR_APPROVE_PAYMENT => 'รอการตรวจสอบหลักฐานการโอนเงิน',
            self::STATUS_PAY_BEFORE_START_WORKSHOP => 'การลงทะเบียนสมบูรณ์',

        ];
        if(isset($unset)){
            foreach ($unset as $value){
                unset($items[$value]);
            }
        }
        return $items;
    }

    public static function getItemStatusAdmin(array $unset = null) {
        $items = [
            self::STATUS_WAIT_FOR_PAY => 'รอแจ้งหลักฐานการโอนเงิน',
            self::STATUS_WAIT_FOR_CHECK_PAYMENT => 'แจ้งหลักฐานการโอนเงินแล้ว',
            self::STATUS_PAID => 'การชำระเงินเสร็จสมบูรณ์',
            self::STATUS_CONFIRM_AGAIN => 'หลักฐานการโอนเงินไม่ถูกต้อง ยืนยันการโอนเงินใหม่',
            self::STATUS_WAIT_FOR_APPROVE_PAYMENT => 'แจ้งหลักฐานการโอนเงินแล้ว (รอการตรวจสอบ)',
            self::STATUS_PAY_BEFORE_START_WORKSHOP => 'การลงทะเบียนสมบูรณ์',
        ];
        if(isset($unset)){
            foreach ($unset as $value){
                unset($items[$value]);
            }
        }
        return $items;
    }
    public static function getItemStatusSearch(array $unset = null) {
        $items = [
           self::STATUS_WAIT_FOR_PAY => 'ยังไม่แจ้งหลักฐานการโอนเงิน',
           self::STATUS_WAIT_FOR_CHECK_PAYMENT => 'แจ้งหลักฐานการโอนเงินแล้ว',
           self::STATUS_PAID => 'การชำระเงินเสร็จสมบูรณ์',
           self::STATUS_CONFIRM_AGAIN => 'หลักฐานการโอนเงินไม่ถูกต้อง ยืนยันการโอนเงินใหม่',
           self::STATUS_WAIT_FOR_APPROVE_PAYMENT => 'แจ้งหลักฐานการโอนเงินแล้ว (รอการตรวจสอบ)',
           self::STATUS_PAY_BEFORE_START_WORKSHOP => 'การลงทะเบียนสมบูรณ์',
        ];
        return $items;
    }

    public static function getItemBootstrapStatusColor(array $unset = null) {
        $items = [
            self::STATUS_WAIT_FOR_PAY => 'warning',
            self::STATUS_WAIT_FOR_CHECK_PAYMENT => 'info',
            self::STATUS_PAID => 'success',
            self::STATUS_CONFIRM_AGAIN => 'danger',
            self::STATUS_WAIT_FOR_APPROVE_PAYMENT => 'primary',
            self::STATUS_PAY_BEFORE_START_WORKSHOP => 'success',

        ];
        if(isset($unset)){
            foreach ($unset as $value){
                unset($items[$value]);
            }
        }
        return $items;
    }

    public function getStatusName($status = null) {
        $items = $this->getItemStatus();
        if ($status != null) {
            return array_key_exists($status, $items) ? $items[$status] : '';
        } else {
            return array_key_exists($this->status, $items) ? $items[$this->status] : '';
        }
    }

    public function getStatusNameAdmin($status = null) {
        $items = $this->getItemStatusAdmin();
        if ($status != null) {
            return array_key_exists($status, $items) ? $items[$status] : '';
        } else {
            return array_key_exists($this->status, $items) ? $items[$this->status] : '';
        }
    }

    public function getBootstrapStatusColor($status = null) {
        $items = $this->getItemBootstrapStatusColor();
        if ($status != null) {
            return array_key_exists($status, $items) ? $items[$status] : '';
        } else {
            return array_key_exists($this->status, $items) ? $items[$this->status] : '';
        }
    }

    public function getIsWaitForPay()
    {
      return $this->status == self::STATUS_WAIT_FOR_PAY;
    }

    public function getIsWaitForCheckPayment()
    {
      return $this->status == self::STATUS_WAIT_FOR_CHECK_PAYMENT;
    }

    public function getIsPaid()
    {
      return $this->status == self::STATUS_PAID;
    }

    public function getIsConfirmAgain()
    {
      return $this->status == self::STATUS_CONFIRM_AGAIN;
    }

    public function getIsWaitForApprovePayment()
    {
      return $this->status == self::STATUS_WAIT_FOR_APPROVE_PAYMENT;
    }

    public function getIsPayBeforeStartWorkshop()
    {
      return $this->status == self::STATUS_PAY_BEFORE_START_WORKSHOP;
    }

    public function getIsArrayFinishUpload()
    {
      return in_array($this->status, self::ARRAY_STATUS_FINISH_UPLOAD);
    }

    public function getIsArrayApprovePayment()
    {
      return in_array($this->status, self::ARRAY_STATUS_APPROVE_PAYMENT);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRegister()
    {
        return $this->hasOne(Register::className(), ['id' => 'register_id']);
    }
}
