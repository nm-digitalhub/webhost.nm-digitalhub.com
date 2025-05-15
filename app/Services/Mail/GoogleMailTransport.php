<?php

declare(strict_types=1);

namespace App\Services\Mail;

use Google\Service\Gmail;
use Google\Service\Gmail\Message;
use Illuminate\Mail\Transport\Transport;
use Symfony\Component\Mailer\SentMessage;
use Symfony\Component\Mailer\Transport\AbstractTransport;
use Symfony\Component\Mime\MessageConverter;

class GoogleMailTransport extends AbstractTransport
{
    /**
     * Create a new Gmail transport instance.
     */
    public function __construct(/**
     * GoogleOAuthService instance
     */
        protected GoogleOAuthService $oauthService
    ) {
        parent::__construct();
    }

    /**
     * {@inheritDoc}
     */
    protected function doSend(SentMessage $message): void
    {
        $originalMessage = $message->getOriginalMessage();

        $originalMessage = MessageConverter::toEmail($originalMessage);

        $gmailMessage = $this->buildGmailMessage($originalMessage);
        $this->sendMessage($gmailMessage);
    }

    /**
     * Build the Gmail message object
     *
     * @param  \Symfony\Component\Mime\Email  $email
     */
    protected function buildGmailMessage($email): Message
    {
        // Get MIME content
        $mimeMessage = $email->toString();

        // Create Gmail message
        $googleMessage = new Message;
        $googleMessage->setRaw(base64_encode($mimeMessage));

        return $googleMessage;
    }

    /**
     * Send the message via Gmail API
     */
    protected function sendMessage(Message $message): void
    {
        // Setup OAuth client
        $this->oauthService->setupClient();

        // Get access token
        $accessToken = $this->oauthService->getAccessToken();

        if (! $accessToken) {
            throw new \RuntimeException('No valid Google OAuth access token available');
        }

        // Create Gmail service
        $client = $this->oauthService->getClient();
        $gmailService = new Gmail($client);

        // Send message
        $gmailService->users_messages->send('me', $message);
    }

    /**
     * Get the string representation of the transport.
     */
    public function __toString(): string
    {
        return 'gmail-api';
    }
}
