<?php

namespace App\Service;

use App\Entity\Event;
use App\Form\MixDesk;
use App\Repository\EventRepository;
use Symfony\Component\Console\Output\OutputInterface;
use Doctrine\Common\Persistence\ObjectManager;

class ArchiveMixDeskParser
{
    private $eventRepository;
    private $om;

    public function __construct(EventRepository $eventRepository, ObjectManager $manager)
    {
        $this->eventRepository = $eventRepository;
        $this->om = $manager;
    }

    public function parseFile(OutputInterface $output, $filename)
    {
        $handle = @fopen($filename, "r");
        if (!($handle)) {
            throw \RuntimeException(sprintf("Cannot open input file %s for reading", $filename));
        }
        while (($values = fgetcsv($handle, 16385)) !== false) {
            $event = $this->eventRepository->findOneBy(['name' => $values[0]]);
            if ($event) {
                //
                $output->writeln($event->getName());

                $event->setMixDeskRuntimeGM(MixDesk::RuntimeGM['values'][$values[1]]);
                $event->setMixDeskOpenness(MixDesk::Openness['values'][$values[2]]);
                $event->setMixDeskPlayerPressure(MixDesk::PlayerPressure['values'][$values[3]]);
                $event->setMixDeskCharCreation(MixDesk::CharCreation['values'][$values[4]]);
                $event->setMixDeskMetatechniques(MixDesk::Metatechniques['values'][$values[5]]);
                $event->setMixDeskStoryEngine(MixDesk::StoryEngine['values'][$values[6]]);
                $event->setMixDeskCommunicationStyle(MixDesk::CommunicationStyle['values'][$values[7]]);
                $event->setMixDeskBleedIn(MixDesk::BleedIn['values'][$values[8]]);
                $event->setMixDeskLoyaltyToSetting(MixDesk::LoyaltyToSetting['values'][$values[9]]);
                $event->setMixDeskRepresentaionOfTheme(MixDesk::RepresentaionOfTheme['values'][$values[10]]);
                $event->setMixDeskScenography(MixDesk::Scenography['values'][$values[11]]);

                if ($event->isMixDeskValid()) {
                    $this->om->persist($event);
                }
            }
        }

        $this->om->flush();
        $output->writeln('Done');
    }
}
