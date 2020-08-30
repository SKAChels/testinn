<?php

declare(strict_types=1);

namespace app\modules\v1\models;

use yii\base\Model;

class Inn extends Model
{
    private string $inn = '';

    public function rules(): array
    {
        return [
            ['inn', 'required'],
            ['inn', 'string'],
            ['inn', 'trim'],
            ['inn', InnValidator::class],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'inn' => 'ИНН',
        ];
    }

    public function formName(): string
    {
        return '';
    }

    public function getInn(): string
    {
        return $this->inn;
    }

    public function setInn(string $inn): void
    {
        $this->inn = $inn;
    }
}