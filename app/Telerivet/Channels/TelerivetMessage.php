<?php

namespace App\Telerivet\Channels;

class TelerivetMessage
{
    /**
     * Campaign name aka service id placeholder
     *
     * @var boolean
     */
    private $campaign;

    /**
     * Load credits.
     *
     * @var boolean
     */
    public $load = false;

    /**
     * The message content.
     *
     * @var string
     */
    public $content;

    /**
     * The phone number the message should be sent from.
     *
     * @var string
     */
    public $from;

    /**
     * @var null|string
     */
    public $statusCallback = null;

    /**
     * @var null|string
     */
    public $statusCallbackMethod = null;

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
     * Set the phone number the message should be sent from.
     *
     * @param  string $from
     * @return $this
     */
    public function from($from)
    {
        $this->from = $from;

        return $this;
    }

    /**
     * Set the load.
     *
     * @param  boolean $load
     * @return $this
     */
    public function load($load)
    {
        $this->load = $load;

        return $this;
    }

    /**
     * Get the from address.
     *
     * @return string
     */
    public function getFrom()
    {
        return $this->from;
    }

    public function isCampaign()
    {
        return ! empty($this->campaign);
    }

    public function getCampaign()
    {
        return $this->campaign;
    }

    public function setCampaign($campaign)
    {
        $this->campaign = $campaign;

        return $this;
    }

    /**
     * Set the status callback.
     *
     * @param string $statusCallback
     * @return $this
     */
    public function statusCallback($statusCallback)
    {
        $this->statusCallback = $statusCallback;

        return $this;
    }

    /**
     * Set the status callback request method.
     *
     * @param string $statusCallbackMethod
     * @return $this
     */
    public function statusCallbackMethod($statusCallbackMethod)
    {
        $this->statusCallbackMethod = $statusCallbackMethod;

        return $this;
    }
}