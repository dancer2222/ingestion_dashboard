<?php

namespace Ingestion\Api\Gmail;

use Google_Service_Gmail_Message;
use Google_Service_Gmail_MessagePartHeader;
use Google_Service_Gmail_MessagePart;

class GmailMessage
{
    /**
     * @var Google_Service_Gmail_MessagePartHeader[]
     */
    private $headers;

    /**
     * @var Google_Service_Gmail_MessagePart
     */
    private $payload;

    /**
     * @var array
     */
    private $messageProps = [];

    public function __construct(Google_Service_Gmail_Message $message)
    {
        $this->payload = $message->getPayload();
        $this->headers = $this->payload->getHeaders();

        $this->formatBody();
    }

    /**
     * Gets the body of the message from payload,
     * decode it and set to $this->messageProps['body']
     */
    private function formatBody()
    {
        $body = $this->payload->getBody()->getData() ?? '';

        $this->messageProps['body'] = base64_decode($body, true);
    }

    /**
     * Find key in message headers and set to $this->messageProps[$needle]
     *
     * @param string $needle
     * @return bool
     */
    private function setPropFromHeaders(string $needle): bool
    {
        $needleUpper = ucfirst($needle);
        $needleLower = strtolower($needle);

        $this->messageProps[$needleLower] = false;

        foreach ($this->headers as $header) {
            if ($needleUpper == $header->getName()) {
                $this->messageProps[$needleLower] = $header->getValue();

                return true;
            }
        }

        return false;
    }

    /**
     * @param $name
     * @return bool|mixed
     */
    public function __get($name)
    {
        $name = strtolower($name);
        $value = false;

        if (isset($this->messageProps[$name]) && $this->messageProps[$name]) {
            $value = $this->messageProps[$name];
        } elseif ($this->setPropFromHeaders($name) && $this->messageProps[$name]) {
            $value = $this->messageProps[$name];
        }

        return $value;
    }
}
