<?php namespace Laravelrus\Gitter;

class GitterRequest implements \JsonSerializable
{
    protected $properties;

    function __construct(array $request)
    {
        $this->properties = $request;
    }

    public function jsonSerialize()
    {
        return $this->properties;
    }

    public function toJson($option = JSON_UNESCAPED_UNICODE)
    {
        return json_encode($this, $option);
    }
}
