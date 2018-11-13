<?php
namespace App\Service;
use App\Entity\Event;
use Doctrine\ORM\Event\PreUpdateEventArgs;

class GoogleEvent
{
    /**
     * @var \Google_Client
     */
    private $googleClient;

    private $tokenPath;

    private $calendarId;

    public function __construct(\Google_Client $googleClient)
    {
        $this->googleClient = $googleClient;
    }

    public function setTokenPath($tokenPath)
    {
        $this->tokenPath = $tokenPath;
    }

    public function setCalendarId($calendarId)
    {
        $this->calendarId = $calendarId;
    }

    public function preUpdate(PreUpdateEventArgs $args)
    {
        $entity = $args->getObject();

        if (!$entity instanceof Event) {
            return;
        }

        $changeSet = $args->getEntityChangeSet();
        if (key_exists('status', $changeSet)) {
            if ($changeSet['status'][0] == 'pending' && $changeSet['status'][1] == 'approved') {
                $this->createGoogleEvent($entity);
            }
        }
    }

    /**
     * @param $event
     */
    public function createGoogleEvent(Event $event)
    {
        $service = $this->getService();

        $googleEvent = new \Google_Service_Calendar_Event(array(
            'summary' => $event->getName(),
            'location' => $event->createGoogleLocation(),
            'description' => $event->createGoogleDescription(),
            'start' => array(
                'date' =>  $event->getStartDate()->format('Y-m-d'),
            ),
            'end' => array(
                'date' => $event->getEndDate()->format('Y-m-d'),
            ),

        ));

        $calendarId = $this->calendarId;
        $service->events->insert($calendarId, $googleEvent);
    }

    private function getService() {
        $client = $this->googleClient;
        $service = new \Google_Service_Calendar($client);

        // Load previously authorized token from a file, if it exists.
        // The file token.json stores the user's access and refresh tokens, and is
        // created automatically when the authorization flow completes for the first
        // time.
        if (file_exists($this->tokenPath)) {
            $accessToken = json_decode(file_get_contents($this->tokenPath), true);
            $client->setAccessToken($accessToken);
        }
        else {
            throw new \Exception("Token file doesn't exist");
        }

        // If there is no previous token or it's expired.
        if ($client->isAccessTokenExpired()) {
            // Refresh the token if possible, else fetch a new one.
            if ($client->getRefreshToken()) {
                $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
            } else {
                throw new \Exception("There is no valid token");
            }
        }
        // Save the token to a file.
        file_put_contents($this->tokenPath, json_encode($client->getAccessToken()));

        return $service;
    }
}
