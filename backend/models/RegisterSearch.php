<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Register;
use common\models\PaymentStatus;
use yii\helpers\ArrayHelper;

class RegisterSearch extends Register {

    public $q = '';
    public $payment;

    public function rules() {
        return [
            [['id', 'department_id', 'group_id', 'payment_type', 'payment', 'created_at', 'updated_at'], 'integer'],
            [['id_card', 'title', 'firstname', 'lastname', 'payment', 'department_id', 'email', 'tel', 'payment_slip', 'q', 'code_id'], 'safe'],
        ];
    }

    public function search($params, $pagin = ['pageSize' => 50,]) {
        $query = Register::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => $pagin,
            'sort' => [
                'defaultOrder' => [
                    'created_at' => SORT_DESC,
                    'fullname' => SORT_ASC,
                    'department_id' => SORT_ASC,
                ],
                'attributes' => [
                    'fullname' => [
                      'asc' => ['firstname' => SORT_ASC, 'lastname' => SORT_ASC],
                      'desc' => ['firstname' => SORT_DESC, 'lastname' => SORT_DESC],
                      'default' => SORT_ASC,
                    ],
                    'department_id' => [
                      'asc' => ['department_id' => SORT_ASC],
                    ],
                    'created_at',
                ],
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        if (!empty($params)) {
            if (!empty($this->department_id)) {
                $query->where(['department_id' => $this->department_id]);
            } else if (!empty($this->group_id)) {
                $query->where(['group_id' => $this->group_id]);
            } else if (!empty($this->q)) {
                $query->where(['or',
                    ['like', 'firstname', $this->q],
                    ['like', 'lastname', $this->q]]);
                $splitQ = explode(' ', $this->q);
                foreach ($splitQ as $value) {
                    $query->orWhere(['or',
                        ['like', 'firstname', $value],
                        ['like', 'lastname', $value]]);
                }
                foreach ($splitQ as $value) {
                    $query->andFilterWhere(['or',
                        ['like', 'firstname', $value],
                        ['like', 'lastname', $value]]);
                }
            }

            if ($this->payment_type != null) {
                $query->andWhere(['payment_type' => $this->payment_type]);
            }
            if ($this->payment != null) {
                $arrPaymentStatus = [
                    PaymentStatus::STATUS_WAIT_FOR_PAY => [PaymentStatus::STATUS_WAIT_FOR_PAY],
                    PaymentStatus::STATUS_CONFIRM_AGAIN => [PaymentStatus::STATUS_CONFIRM_AGAIN],
                    //PaymentStatus::STATUS_WAIT_FOR_CHECK_PAYMENT => [PaymentStatus::STATUS_WAIT_FOR_CHECK_PAYMENT, PaymentStatus::STATUS_WAIT_FOR_APPROVE_PAYMENT],
                    PaymentStatus::STATUS_WAIT_FOR_CHECK_PAYMENT => [PaymentStatus::STATUS_WAIT_FOR_CHECK_PAYMENT],
                    PaymentStatus::STATUS_PAID => [PaymentStatus::STATUS_PAID],
                    PaymentStatus::STATUS_WAIT_FOR_APPROVE_PAYMENT => [PaymentStatus::STATUS_WAIT_FOR_APPROVE_PAYMENT],
                ];
                $lastPaymentStatus = PaymentStatus::find()->select('*,max(id) as max_id')->groupBy('register_id')->all();
                $query->andWhere([
                    'in', 'id', ArrayHelper::getColumn(PaymentStatus::find()->where(['in', 'status', $arrPaymentStatus[$this->payment]])->andWhere(['in', 'id', ArrayHelper::getColumn($lastPaymentStatus, 'max_id')])->all(), 'register_id'),
                ]);
            }
        } else {
            $query->where(['firstname' => $this->q]);
        }

        return $dataProvider;
    }

}
