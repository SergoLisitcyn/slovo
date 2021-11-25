<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "calculator".
 *
 * @property int $id
 * @property int|null $amount
 * @property int|null $min_amount
 * @property int|null $term
 * @property int|null $min_term
 * @property string|null $rule_violation_percent
 * @property string|null $rate
 * @property int|null $amount_step
 * @property int|null $term_step
 */
class Calculator extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'calculator';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['amount', 'min_amount', 'term', 'min_term', 'amount_step', 'term_step'], 'integer'],
            [['rule_violation_percent', 'rate'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'amount' => 'Максимальное значение кредита',
            'min_amount' => 'Минимальное значение кредита',
            'term' => 'Срок кредита',
            'min_term' => 'Минимальное значение срока',
            'rule_violation_percent' => 'Процент',
            'rate' => 'Ставка',
            'amount_step' => 'Шаг кредита',
            'term_step' => 'Шаг срока',
        ];
    }
}
