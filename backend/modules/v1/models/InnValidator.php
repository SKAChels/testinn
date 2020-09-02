<?php

declare(strict_types=1);

namespace app\modules\v1\models;

use yii\base\Model;
use yii\validators\Validator;

class InnValidator extends Validator
{
    private Model $model;
    private string $attribute;
    private string $inn;

    public function validateAttribute($model, $attribute): void
    {
       $this->model = $model;
       $this->attribute = $attribute;
       $this->inn = $model->$attribute;

       $this->validateLength();
       $this->validateCharacters();
       if (strlen($this->inn) === 10) {
           $this->validateLength10();
       } elseif (strlen($this->inn) === 12) {
           $this->validateLength12();
       }
    }

    private function validateLength(): void
    {
        $length = strlen($this->inn);
        if ($length !== 10 && $length !== 12) {
            $this->addError($this->model, $this->attribute, 'Длина ИНН должна быть 10 или 12 символов');
        }
    }

    private function validateCharacters(): void
    {
        if (preg_match('/\D/', $this->inn)) {
            $this->addError($this->model, $this->attribute, 'ИНН должен содержать только цифры');
        }
    }

    private function validateLength10(): void
    {
        $code10 = (($this->inn[0]*2 + $this->inn[1]*4 + $this->inn[2]*10 + $this->inn[3]*3 +
                    $this->inn[4]*5 + $this->inn[5]*9 + $this->inn[6]*4 + $this->inn[7]*6 +
                    $this->inn[8]*8) % 11) % 10;

        if ($code10 !== (int) $this->inn[9]) {
            $this->addError($this->model, $this->attribute, 'Указан некорректный ИНН');
        }
    }

    private function validateLength12(): void
    {
        $code11 = (($this->inn[0]*7 + $this->inn[1]*2 + $this->inn[2]*4 + $this->inn[3]*10 +
                    $this->inn[4]*3 + $this->inn[5]*5 + $this->inn[6]*9 + $this->inn[7]*4 +
                    $this->inn[8]*6 + $this->inn[9]*8) % 11 ) % 10;

        $code12 = (($this->inn[0]*3 + $this->inn[1]*7 + $this->inn[2]*2 + $this->inn[3]*4 +
                    $this->inn[4]*10 + $this->inn[5]*3 + $this->inn[6]*5 + $this->inn[7]*9 +
                    $this->inn[8]*4 + $this->inn[9]*6 + $this->inn[10]*8) % 11 ) % 10;

        if ($code11 !== (int) $this->inn[10] || $code12 !== (int) $this->inn[11]) {
            $this->addError($this->model, $this->attribute, 'Указан некорректный ИНН');
        }
    }
}