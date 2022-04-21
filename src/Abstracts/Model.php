<?php

namespace JosanBr\GalaxPay\Abstracts;

abstract class Model implements \ArrayAccess, \JsonSerializable
{
    /**
     * Id type: myId
     */
    public const MY_ID = 'myId';

    /**
     * Id type: galaxPayId
     */
    public const GALAX_PAY_ID = 'galaxPayId';

    /**
     * @var array
     */
    private $attributes = [];

    /**
     * @var array
     */
    protected $defaultValues = [];

    /**
     * @var string[]
     */
    protected $fillable = [];

    /**
     * @var string[]
     */
    protected $modelRefs = [];

    public function __construct(array $attributes = [])
    {
        $this->fill($attributes);
    }

    public function __get($attribute)
    {
        return $this->getAttribute($attribute);
    }

    public function __set($attribute, $value): void
    {
        $this->setAttribute($attribute, $value);
    }

    public function __isset($attribute): bool
    {
        return $this->issetAttribute($attribute);
    }

    public function __unset($attribute): void
    {
        $this->unsetAttribute($attribute);
    }

    public function offsetGet($attribute)
    {
        return $this->getAttribute($attribute);
    }

    public function offsetSet($attribute, $value): void
    {
        $this->setAttribute($attribute, $value);
    }

    public function offsetExists($attribute): bool
    {
        return $this->issetAttribute($attribute);
    }

    public function offsetUnset($attribute): void
    {
        $this->unsetAttribute($attribute);
    }

    public function jsonSerialize(): array
    {
        return $this->serialize($this->attributes);
    }

    public static function fromJson($json)
    {
        return json_decode($json, true);
    }

    private function getAttribute(string $attribute)
    {
        return array_key_exists($attribute, $this->attributes) ? $this->attributes[$attribute] : null;
    }

    private function setAttribute(string $attribute, $value): void
    {
        if (!in_array($attribute, $this->fillable)) return;

        if ($this->isModel($attribute) && is_array($value)) {
            $this->attributes[$attribute] = $this->createInstance($attribute, $value);
        } else {
            $this->attributes[$attribute] = $value;
        }
    }

    private function issetAttribute(string $attribute): bool
    {
        return isset($this->attributes[$attribute]);
    }

    private function unsetAttribute(string $attribute): void
    {
        unset($this->attributes[$attribute]);
    }

    private function hasDefaultValue(string $attribute): bool
    {
        return array_key_exists($attribute, $this->defaultValues);
    }

    private function isInstance(string $attribute, $value): bool
    {
        return $value instanceof $this->modelRefs[$attribute];
    }

    private function isModel(string $attribute): bool
    {
        return array_key_exists($attribute, $this->modelRefs) && class_exists($this->modelRefs[$attribute]);
    }

    private function createInstance(string $attribute, array $attributes = [])
    {
        $instances = [];
        $model = $this->modelRefs[$attribute];

        foreach ($attributes as $key => $value)
            if (is_integer($key) && is_array($value))
                array_push($instances, new $model($value));

        return count($instances) ? $instances : new $model($attributes);
    }

    private function fill(array $attributes = []): void
    {
        if (is_null($attributes) || is_array($attributes) && count($attributes) == 0) return;

        foreach ($this->fillable as $fill) {
            if (!array_key_exists($fill, $attributes)) continue;

            if ($this->isModel($fill)) {
                $this->attributes[$fill] = $this->createInstance($fill, $attributes[$fill]);
            } elseif (is_null($attributes[$fill]) && $this->hasDefaultValue($fill)) {
                $this->attributes[$fill] = $this->defaultValues[$fill];
            } else {
                $this->attributes[$fill] = $attributes[$fill];
            }
        }
    }

    private function serialize($attributes): array
    {
        $data = [];

        foreach ($attributes as $key => $value) {
            if ($this->isModel($key)) {
                if (is_array($value)) {
                    $data[$key] = $this->serialize($value);
                } elseif ($this->isInstance($key, $value)) {
                    $data[$key] = $value->jsonSerialize();
                }
            } else $data[$key] = $value;
        }

        return $data;
    }
}
