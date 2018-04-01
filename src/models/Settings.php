<?php

namespace experience\entitle\models;

use craft\base\Model;

class Settings extends Model
{
    /** @var string */
    public $protectedWords;

    /**
     * The model validation rules
     *
     * @return array
     */
    public function rules()
    {
        $rules = parent::rules();

        return array_merge(parent::rules(), [
            ['protectedWords', 'required'],
            ['protectedWords', 'string'],
        ]);
    }
}
