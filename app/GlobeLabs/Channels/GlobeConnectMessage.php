<?php

namespace App\GlobeLabs\Channels;

class GlobeConnectMessage
{
    /**
     * The phone number the message should be sent from.
     *
     * @var string
     */
    public $sender;

    /**
     * The message content.
     *
     * @var string
     */
    public $content;

    /**
     * Create a message object.
     * @param string $content
     * @return static
     */
    public static function create($content = '')
    {
        return new static($content);
    }

    /**
     * Create a new message instance.
     *
     * @param  string $content
     */
    public function __construct($content = '')
    {
        $this->content = $content;
    }

    /**
     * Set the message content.
     *
     * @param  string $content
     * @return $this
     */
    public function content($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Set the phone number or sender name the message should be sent from.
     *
     * @param  string  $from
     *
     * @return $this
     */
    public function sender($sender)
    {
        $this->sender = $sender;
        
        return $this;
    }
}