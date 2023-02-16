<?php

namespace ItDevgroup\LaravelSettingLite\Exceptions;

use Exception;
use Illuminate\Support\Facades\Lang;
use ItDevgroup\LaravelSettingLite\Model\SettingModel;

/**
 * Class SettingException
 * @package ItDevgroup\LaravelSettingLite\Exceptions
 */
class SettingException extends Exception
{
    /**
     * @param SettingModel $model
     * @param int|null $code
     * @return static
     */
    public static function keyDuplicate(SettingModel $model, ?int $code = null): static
    {
        $model->setHidden(['options']);

        $key = 'setting_lite.exception.key_duplicate';
        $text = Lang::has($key)
            ? Lang::get($key, $model->toArray())
            : 'Key ' . $model->key . ' exists ';

        return new static($text, $code ?: 422);
    }
}
