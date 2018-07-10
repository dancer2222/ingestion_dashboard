<?php

namespace Ingestion\Api\Gmail;

use Google_Client;
use Google_Service_Gmail;
use Google_Service_Gmail_Message;
use Google_Exception;
use Google_Service_Gmail_Resource_UsersMessages;

/**
 * Class Gmail
 * @package App\Google\Api
 */
class Gmail
{
    /**
     * @var Google_Client
     */
    private $client;

    /**
     * @var Google_Service_Gmail
     */
    private $gmailService;

    /**
     * @var Google_Service_Gmail_Resource_UsersMessages
     */
    private $gmailUsersMessages;

    /**
     * Gmail constructor.
     * @param Google_Client $client
     */
    public function __construct(Google_Client $client)
    {
        $this->client = $client;
        $this->gmailService = new Google_Service_Gmail($client);
        $this->gmailUsersMessages = $this->gmailService->users_messages;
    }

    /**
     * @param string $subject String subject an email address account to impersonate
     */
    public function setSubject(string $subject)
    {
        $this->client->setSubject($subject);
    }

    /**
     * @param string $userId
     * @param array $optParams
     * @return \Google_Service_Gmail_ListMessagesResponse
     */
    public function getMessages(string $userId, array $optParams = []): \Google_Service_Gmail_ListMessagesResponse
    {
        return $this->gmailUsersMessages->listUsersMessages($userId, $optParams);
    }

    /**
     * @param string $userId
     * @param string $messageId
     * @return GmailMessage
     * @throws Google_Exception
     */
    public function getMessage(string $userId, string $messageId): GmailMessage
    {
        $message = $this->gmailUsersMessages->get($userId, $messageId);

        if (!$message) {
            throw new Google_Exception('Message is not found.');
        }

        return new GmailMessage($message);
    }

    /**
     * Delete message permanently
     *
     * @param string $userId
     * @param string $messageId
     * @return mixed
     */
    public function deleteMessage(string $userId, string $messageId)
    {
        return $this->gmailUsersMessages->delete($userId, $messageId);
    }

    /**
     * Move message to trash
     *
     * @param string $userId
     * @param string $messageId
     * @return Google_Service_Gmail_Message
     * @throws Google_Exception
     */
    public function moveMessageToTrash(string $userId, string $messageId)
    {
        return $this->gmailUsersMessages->trash($userId, $messageId);
    }
}
