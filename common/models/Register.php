<?php
namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "register".
 *
 * @property integer $id
 * @property string $id_card
 * @property string $title
 * @property string $firstname
 * @property string $lastname
 * @property integer $gender_type
 * @property integer $department_id
 * @property integer $shirt_id
 * @property integer $alumni_id
 * @property string $email
 * @property string $tel
 * @property string $code_id
 * @property integer $group_id
 * @property integer $category_id
 * @property integer $payment_type
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $acordul_tc
 * @property string $addr_1
 * @property string $addr_2
 * @property string $addr_3
 * @property string $province
 * @property integer $zip
 * @property string $strava_acc

 *
 * @property Department $department
 * @property Group $group
 * @property Shirt $shirt
 * @property Alumni $alumni
 * @property Code $code
 * @property Category $category
 */
class Register extends \yii\db\ActiveRecord
{
    public $ckagree;
    const PAYMENT_TYPE_MONEY_TRANSFER = 10;
    const PAYMENT_TYPE_PAY_BEFORE_START_WORKSHOP = 11;

    const MALE = 1;
    const FEMALE = 2;

    /**
     * @inheritdoc
     */

    public static function tableName()
    {
        return 'register';
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
            [['title', 'firstname', 'lastname','email', 'tel'], 'required', 'message' => 'กรุณาระบุ{attribute}'],
            [['id_card','title', 'firstname', 'lastname','email', 'tel'], 'trim'],
            [['ckagree'], 'required', 'requiredValue' => 1, 'message' => 'กรุณา{attribute}'],
            [['group_id','department_id','gender_type','shirt_id','category_id'], 'required', 'message' => 'กรุณาระบุ{attribute}'],
            [['addr_1','addr_2','addr_3','province' ,'zip'],'required',  'message' => 'กรุณาระบุ{attribute}'],
//            ['id_card', 'unique', 'message' => 'มีผู้ใช้เลขบัตรประจำตัวประชาชนนี้แล้ว'],
            ['code_id', 'unique', 'message' => 'รหัสนี้ถูกใช้ไปแล้ว'],
            ['tel', 'unique', 'message' => 'เบอร์โทรศัพท์นี้ถูกใช้ไปแล้ว'],
//          ['email', 'unique', 'message' => 'มีผู้ใช้อีเมลนี้ในระบบแล้ว'],
//          ['id_card', 'validateIdCard'],

            [['department_id', 'category_id', 'group_id', 'payment_type','gender_type', 'created_at', 'updated_at','id'], 'integer'],
            [['id_card', 'alumni_id', 'code_id' ], 'string'],
            [['title', 'firstname', 'lastname', 'email'], 'string', 'max' => 45],
            [['id_card'], 'string', 'max' => 13],
            [['addr_1','addr_2','addr_3','province'], 'string'],
            [['zip'], 'string', 'max' => 5],
 //         [['position'], 'string', 'max' => 255],
            ['email', 'email'],
            [['department_id'], 'exist', 'skipOnError' => true, 'targetClass' => Department::className(), 'targetAttribute' => ['department_id' => 'id']],
            [['group_id'], 'exist', 'skipOnError' => true, 'targetClass' => Group::className(), 'targetAttribute' => ['group_id' => 'id']],
            [['shirt_id'], 'exist', 'skipOnError' => true, 'targetClass' => Shirt::className(), 'targetAttribute' => ['shirt_id' => 'id']],
          	[['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['category_id' => 'id']],
           	[['alumni_id'], 'exist', 'skipOnError' => true, 'targetClass' => Alumni::className(), 'targetAttribute' => ['alumni_id' => 'id']],
// 		 	[['code_id'], 'exist', 'skipOnError' => true, 'targetClass' => Code::className(), 'targetAttribute' => ['code_id' => 'id']],

//          ['acordul_tc', 'required', 'on' => ['register']],
//          ['acordul_tc', 'integer', 'max' => 1, 'message' => 'my test message'],
        ];
    }

    public function validateIdCard($attribute) {
        if (!$this->checkPID(str_replace('-', '', $this->id_card))) {
            $this->addError($attribute, 'เลขบัตรประจำตัวประชาชนไม่ถูกต้อง');
        }
    }

    public function checkPID($pid) {
        if (strlen($pid) != 13)
            return false;
        for ($i = 0, $sum = 0; $i < 12; $i++)
            $sum += (int) ($pid{$i}) * (13 - $i);
        if ((11 - ($sum % 11)) % 10 == (int) ($pid{12}))
            return true;
        return false;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_card' => 'เลขประจำตัวประชาชน',
            'title' => 'คำนำหน้าชื่อ',
            'firstname' => 'ชื่อ',
            'lastname' => 'นามสกุล',
            'gender_type' => 'เพศ',
            'alumni_id' => 'รุ่น (เฉพาะนักเรียนเก่าปรินส์รอยแยลส์วิทยาลัยเท่านั้น)',
            'department_id' => 'ประเภทการสมัคร',
            'shirt_id' => 'ขนาดเสื้อ',
            'email' => 'อีเมล',
            'tel' => 'เบอร์โทรศัพท์',
            'group_id' => 'รายการ',
            'payment_type' => 'ยอดการชำระ',
            'created_at' => 'วันที่ลงทะเบียน',
            'updated_at' => 'วันที่ปรับปรุงข้อมูล',
            'ckagree' => 'ยอมรับข้อตกร่วมกัน',
            'code_id' => 'รหัส',
        	  'category_id' => 'ประเภทการสมัคร',
            'addr_1' => 'ที่อยู่',
            'addr_2' => 'ตำบล',
            'addr_3' => 'อำเภอ',
            'province' => 'จังหวัด',
            'zip' => 'รหัสไปรษณีย์',
            'FullAddress' => 'ที่อยู่',
        ];
    }

    public function getIdCard(){
        return substr($this->id_card, 0,1).'-'.substr($this->id_card, 1,4).'-'.substr($this->id_card, 5,5).'-'.substr($this->id_card, 10,2).'-'.substr($this->id_card, 12,1);
    }

    public function getFullname() {
        return $this->title . $this->firstname . ' ' . $this->lastname;
    }

    public function getNTname() {
        return $this->firstname . ' ' . $this->lastname;
    }

    public function getFullAddress() {
        return $this->addr_1 . ' ' . $this->addr_2. ' ' . $this->addr_3.' '.$this->province.' '.$this->zip;
    }

    public static function findByEmail($email,$tel)
    {
        return static::findOne(['email' => $email,'tel' => $tel]);
    }

    public function fullDelete(){
        foreach ($this->paymentStatuses as $paymentStatus) {
            $paymentStatus->delete();
        }
        foreach ($this->paymentSlips as $paymentSlip) {
            $paymentSlip->fullDelete();
        }
        $this->delete();
    }

    public function Pending(){
        foreach ($this->paymentStatuses as $paymentStatus) {
            $paymentStatus->delete();
        }
        foreach ($this->paymentSlips as $paymentSlip) {
            $paymentSlip->fullDelete();
        }
        $this->delete();
    }

    /*    public static function findByEmail($email,$id_card)
        {
            return static::findOne(['email' => $email,'id_card' => $id_card]);
        }
    */

    /*    public static function findByID($id)
        {
            return static::findOne(['id' => $id]);
        }
    */

    //enum ----------------------------------------------------
    public function getItemPaymentType() {
        return [
            self::PAYMENT_TYPE_MONEY_TRANSFER => '',
            self::PAYMENT_TYPE_PAY_BEFORE_START_WORKSHOP => '',
        ];
    }

    public function getIsMoneyTransfer()
    {
      return $this->payment_type == self::PAYMENT_TYPE_MONEY_TRANSFER;
    }

    public function getIsPayBeforeStartWorkshop()
    {
      return $this->payment_type == self::PAYMENT_TYPE_PAY_BEFORE_START_WORKSHOP;
    }

    public function getPaymentTypeName($payment_type = null) {
        $items = $this->getItemPaymentType();
        if ($payment_type != null) {
            return array_key_exists($payment_type, $items) ? $items[$payment_type] : '';
        } else {
            return array_key_exists($this->payment_type, $items) ? $items[$this->payment_type] : '';
        }
    }

    public function getItemGenderType() {
        return [
            self::MALE => 'ชาย',
            self::FEMALE => 'หญิง',
        ];
    }

    public function getIsMale()
    {
      return $this->gender_type == self::MALE;
    }

    public function getIsFemale()
    {
      return $this->gender_type == self::FEMALE;
    }

    public function getGenderTypeName($gender_type = null) {
        $items = $this->getItemGenderType();
        if ($gender_type != null) {
            return array_key_exists($gender_type, $items) ? $items[$gender_type] : '';
        } else {
            return array_key_exists($this->gender_type, $items) ? $items[$this->gender_type] : '';
        }
    }

    //relationship---------------------------------------------

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCode()
    {
        return $this->hasOne(Code::className(), ['id' => 'code_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDepartment()
    {
        return $this->hasOne(Department::className(), ['id' => 'department_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGroup()
    {
        return $this->hasOne(Group::className(), ['id' => 'group_id']);
    }

    /**
      * @return \yii\db\ActiveQuery
     */
    public function getshirt()
    {
        return $this->hasOne(Shirt::className(), ['id' => 'shirt_id']);
    }

    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }

    public function getAlumni()
    {
        return $this->hasOne(Alumni::className(), ['id' => 'alumni_id']);
    }

    public function getPaymentStatuses()
    {
        return $this->hasMany(PaymentStatus::className(), ['register_id' => 'id']);
    }

    public function getLastPaymentStatus() {
        return PaymentStatus::findOne(PaymentStatus::find()->where(['register_id' => $this->id])->max('id'));
    }

    public function getPaymentSlips()
    {
        return $this->hasMany(PaymentSlip::className(), ['register_id' => 'id']);
    }

    public function getLastPaymentSlip()
    {
        return PaymentSlip::findOne(PaymentSlip::find()->where(['register_id' => $this->id])->max('id'));
    }

    public function getAddress()
    {
        return PaymentSlip::findOne(PaymentSlip::find()->where(['register_id' => $this->id])->max('id'));
    }

}
