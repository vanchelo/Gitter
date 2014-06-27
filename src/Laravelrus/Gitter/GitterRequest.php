<?php namespace Laravelrus\Gitter;

class GitterRequest implements \JsonSerializable {

    protected $properties;

    function __construct(array $request)
    {
        $this->properties = $request;
    }

    public function jsonSerialize()
    {
        return $this->properties;
    }

    public function toJson()
    {
        return json_encode($this, JSON_UNESCAPED_UNICODE);
    }

}
