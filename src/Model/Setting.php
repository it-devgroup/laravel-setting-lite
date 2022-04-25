<?php

namespace ItDevgroup\LaravelSettingLite\Model;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Lang;

/**
 * Class Setting
 * @package ItDevgroup\LaravelSettingLite\Model
 * @property-read int $id
 * @property string $key
 * @property string|null $description
 * @property string|null $description_default
 * @property string|null $value
 * @property array|null $options
 * @property string $type
 * @property string|null $group
 * @property bool $is_public
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Setting extends Model
{
    /**
     * List of types
     * @type string
     */
    public const TYPE_TEXT = 'text';
    public const TYPE_MULTILINE = 'multilinetext';
    public const TYPE_BOOLEAN = 'boolean';
    public const TYPE_INTEGER = 'integer';
    public const TYPE_FLOAT = 'float';
    public const TYPE_LIST = 'list';
    public const TYPE_MULTILIST = 'multilist';
    public const TYPE_PASSWORD = 'password';
    public const TYPE_CHECKBOX = 'checkbox';
    public const TYPE_RADIO = 'radio';

    /**
     * @inheritDoc
     */
    protected $fillable = [
        'key',
        'description',
        'value',
        'options',
        'type',
        'group',
        'is_public',
    ];
    /**
     * @inheritDoc
     */
    protected $dates = [
        'created_at',
        'updated_at',
    ];
    /**
     * @inheritDoc
     */
    protected $casts = [
        'options' => 'array',
        'is_public' => 'boolean',
    ];

    /**
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $this->table = Config::get('setting_lite.table');

        parent::__construct($attributes);
    }

    /**
     * @return string|null
     */
    protected function getDescriptionAttribute(): ?string
    {
        if (
            $this->attributes['description']
            || !Config::get('setting_lite.description_field_from_lexicon')
        ) {
            return $this->attributes['description'];
        }

        return $this->getAttribute('description_default');
    }

    /**
     * @return string|null
     */
    protected function getDescriptionDefaultAttribute(): ?string
    {
        $key = sprintf(
            '%s.setting.%s',
            Config::get('setting_lite.lexicon'),
            $this->getAttribute('key'),
        );

        if (Lang::has($key)) {
            return Lang::get($key);
        }

        return null;
    }

    /**
     * @param string $key
     * @param string|null $value
     * @param string $type
     * @param string|null $group
     * @return static
     */
    public static function register(
        string $key,
        ?string $value,
        string $type,
        ?string $group = null
    ) {
        $model = new static();
        $model->key = $key;
        $model->value = $value;
        $model->type = $type;
        $model->group = $group;
        $model->is_public = false;

        return $model;
    }
}
