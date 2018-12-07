<?php

namespace App\Service;

use App\Entity\Event;

class AdminNotificationMailer
{
    private $adminMail;
    private $senderMail;
    private $mailer;
    private $templating;

    /**
     * AdminNotificationMailer constructor.
     * @param \Swift_Mailer $mailer
     * @param \Twig_Environment $templating
     * @param $adminMail
     * @param $senderMail
     */
    public function __construct(\Swift_Mailer $mailer, \Twig_Environment $templating, $adminMail, $senderMail)
    {
        $this->mailer = $mailer;
        $this->templating = $templating;
        $this->adminMail = $adminMail;
        $this->senderMail = $senderMail;
    }

    public function getAdminMail()
    {
        return $this->adminMail;
    }

    /**
     * @param Event $event
     */
    public function sendEventCreatedNotification(Event $event)
    {
        $message = (new \Swift_Message(sprintf('В Ролендарь добавлено новое событие "%s"', $event->getName())))
            ->setFrom($this->senderMail)
            ->setTo($this->adminMail)
            ->setBody(
                $this->templating->render(
                    'emails/event_creation.html.twig',
                    ['event' => $event]
                ),
                'text/html'
            );
        $this->mailer->send($message);
    }

    /**
     * @param Event $initialEvent
     * @param Event $event
     * @return array
     */
    public function sendEventEditedNotification(Event $initialEvent, Event $event)
    {
        $difference = $this->compareEvents($initialEvent, $event);
        if ($difference) {
            $message = (new \Swift_Message(sprintf('В Ролендаре отредактировано событие "%s"', $initialEvent->getName())))
                ->setFrom($this->senderMail)
                ->setTo($this->adminMail)
                ->setBody(
                    $this->templating->render(
                        'emails/event_editing.html.twig',
                        [
                            'event' => $event,
                            'difference' => $difference,
                            'initialName' => $initialEvent->getName()
                        ]
                    ),
                    'text/html'
                );
            $this->mailer->send($message);
        }

        return $difference;
    }

    /**
     * @param Event $initialEvent
     * @param Event $event
     * @return array
     */
    public function compareEvents(Event $initialEvent, Event $event)
    {
        $difference=[];
        if ($initialEvent->getName() != $event->getName()) {
            $difference['Название'] = [$initialEvent->getName(), $event->getName()];
        }
        if ($initialEvent->getStartDate()->format('Y-m-d') != $event->getStartDate()->format('Y-m-d')) {
            $difference['Дата начала'] = [$initialEvent->getStartDate()->format('Y-m-d'), $event->getStartDate()->format('Y-m-d')];
        }
        if ($initialEvent->getEndDate()->format('Y-m-d') != $event->getEndDate()->format('Y-m-d')) {
            $difference['Дата окончания'] = [$initialEvent->getEndDate()->format('Y-m-d'), $event->getEndDate()->format('Y-m-d')];
        }
        if ($initialEvent->getLocation() != $event->getLocation()) {
            $difference['Место проведения'] = [$initialEvent->getLocation(), $event->getLocation()];
        }
        if ($initialEvent->getRegion()->getName() != $event->getRegion()->getName()) {
            $difference['Область'] = [$initialEvent->getRegion()->getName(), $event->getRegion()->getName()];
        }
        if ($initialEvent->getPriceMin() != $event->getPriceMin()) {
            $difference['Размер денежного взноса от'] = [$initialEvent->getPriceMin(), $event->getPriceMin()];
        }
        if ($initialEvent->getPriceMax() != $event->getPriceMax()) {
            $difference['Размер денежного взноса до'] = [$initialEvent->getPriceMax(), $event->getPriceMax()];
        }
        if ($initialEvent->getType()->getName() != $event->getType()->getName()) {
            $difference['Формат'] = [$initialEvent->getType()->getName(), $event->getType()->getName()];
        }
        if ($initialEvent->getSubgenre()->getGenre()->getName() != $event->getSubgenre()->getGenre()->getName()) {
            $difference['Жанр'] = [$initialEvent->getSubgenre()->getGenre()->getName(), $event->getSubgenre()->getGenre()->getName()];
        }
        if ($initialEvent->getSubgenre()->getName() != $event->getSubgenre()->getName()) {
            $difference['Поджанр'] = [$initialEvent->getSubgenre()->getName(), $event->getSubgenre()->getName()];
        }
        if ($initialEvent->getSettlement()->getName() != $event->getSettlement()->getName()) {
            $difference['Тип поселения'] = [$initialEvent->getSettlement()->getName(), $event->getSettlement()->getName()];
        }
        if (
            array_diff($initialEvent->getWeapons()->toArray(), $event->getWeapons()->toArray()) ||
            array_diff($event->getWeapons()->toArray(), $initialEvent->getWeapons()->toArray())) {
            $difference['Тип оружия'] = [$initialEvent->getWeapons()->toArray(), $event->getWeapons()->toArray()];
        }
        if ($initialEvent->getOrganizers() != $event->getOrganizers()) {
            $difference['Организаторы'] = [$initialEvent->getOrganizers(), $event->getOrganizers()];
        }
        if ($initialEvent->getOrganizerContact() != $event->getOrganizerContact()) {
            $difference['Контакты организаторов'] = [$initialEvent->getOrganizerContact(), $event->getOrganizerContact()];
        }
        if ($initialEvent->getContactSite() != $event->getContactSite()) {
            $difference['Сайт'] = [$initialEvent->getContactSite(), $event->getContactSite()];
        }
        if ($initialEvent->getContactFB() != $event->getContactFB()) {
            $difference['Группа в Facebook'] = [$initialEvent->getContactFB(), $event->getContactFB()];
        }
        if ($initialEvent->getContactVK() != $event->getContactVK()) {
            $difference['Группа в Вконтакте'] = [$initialEvent->getContactVK(), $event->getContactVK()];
        }
        if ($initialEvent->getContactTelegram() != $event->getContactTelegram()) {
            $difference['Телеграм'] = [$initialEvent->getContactTelegram(), $event->getContactTelegram()];
        }
        if ($initialEvent->getContactOther() != $event->getContactOther()) {
            $difference['Другие ссылки и контакты'] = [$initialEvent->getContactOther(), $event->getContactOther()];
        }
        if ($initialEvent->getDescription() != $event->getDescription()) {
            $difference['Описание'] = [$initialEvent->getDescription(), $event->getDescription()];
        }
        if ($initialEvent->isMixDesk() != $event->isMixDesk()) {
            $difference['Заполнена форма эквалайзера'] =
                [
                    $initialEvent->isMixDesk()?'да':'нет',
                    $event->isMixDesk()?'да':'нет'
                ];
        }
        if ($initialEvent->isMixDesk() && $event->isMixDesk() && (
                $initialEvent->getMixDeskBleedIn() != $event->getMixDeskBleedIn() ||
                $initialEvent->getMixDeskCharCreation() != $event->getMixDeskCharCreation() ||
                $initialEvent->getMixDeskCommunicationStyle() != $event->getMixDeskCommunicationStyle() ||
                $initialEvent->getMixDeskLoyaltyToSetting() != $event->getMixDeskLoyaltyToSetting() ||
                $initialEvent->getMixDeskMetatechniques() != $event->getMixDeskMetatechniques() ||
                $initialEvent->getMixDeskOpenness() != $event->getMixDeskOpenness() ||
                $initialEvent->getMixDeskRepresentaionOfTheme() != $event->getMixDeskRepresentaionOfTheme() ||
                $initialEvent->getMixDeskRuntimeGM() != $event->getMixDeskRuntimeGM() ||
                $initialEvent->getMixDeskScenography() != $event->getMixDeskScenography() ||
                $initialEvent->getMixDeskStoryEngine() != $event->getMixDeskStoryEngine() ||
                $initialEvent->getMixdeskPlayerPressure() != $event->getMixdeskPlayerPressure()
            )) {
            $difference['Форма эквалайзера'] = ['заполнена', 'изменена'];
        }

        return $difference;
    }
}
