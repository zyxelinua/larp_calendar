<?php

namespace App\Service;

use App\Entity\Event;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class IftttHandlerTelegram
{
    private $key;
    private $logger;
    private $request;

    public function __construct($key, LoggerInterface $logger, RequestStack $requestStack)
    {
        $this->key = $key;
        $this->logger = $logger;
        $this->request = $requestStack->getCurrentRequest();
    }

    public function preUpdate(PreUpdateEventArgs $args)
    {
        $entity = $args->getObject();

        if (!$entity instanceof Event) {
            return;
        }

        $changeSet = $args->getEntityChangeSet();
        if (key_exists('status', $changeSet)) {
            if ($changeSet['status'][0] == Event::STATUS_PENDING && $changeSet['status'][1] == Event::STATUS_APPROVED) {
                $this->handleEventAnnouncement($entity);
            }
        }
    }

    public function handleEventAnnouncement(Event $event)
    {
        $this->logger->info('Calling IFTTT...');
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type:application/json']);
        $url = sprintf(
            "https://maker.ifttt.com/trigger/%s/with/key/%s",
            'event_approved',
            $this->key
        );
        $this->logger->info(sprintf('Calling URL: %s', $url));
        curl_setopt($ch, CURLOPT_URL, $url);
        $imgUrl = $this->generateImageUrl($event);
        $body = json_encode(
            [
                "value1" => nl2br($event->createAnnouncement()),
                "value2" => $imgUrl],
            JSON_UNESCAPED_UNICODE
        );
        $this->logger->info(sprintf('Request body: %s', $body));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
        $response = curl_exec($ch);
        $this->logger->info(sprintf('Got response: %s', $response));
        curl_close($ch);
    }

    public function generateImageUrl(Event $event)
    {
        if ($event->getPicture()) {
            $imgUrl = $this->request->headers->get('host') . '/images/pictures/' . $event->getPicture();
        } else {
            $imgUrl = $this->request->headers->get('host') . '/images/rolendar-1.jpg';
        }
        return $imgUrl;
    }
}
