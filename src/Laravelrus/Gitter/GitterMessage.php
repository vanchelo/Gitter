<?php namespace Laravelrus\Gitter;

class GitterMessage extends GitterRequest
{
    function __construct($message = null)
    {
        $this->setMessage($message);
    }

    public function setMessage($message = null)
    {
        if (empty($message) || ! is_scalar($message))
        {
            throw new \InvalidArgumentException('Message can not be empty and can be a scalar');
        }

        $this->properties['text'] = $message;

        return $this;
    }

    public function isStatus($status = true)
    {
        $this->properties['status'] = (boolean) $status;

        return $this;
    }

    public static function newInstance($message = null)
    {
        return new self($message);
    }
}
