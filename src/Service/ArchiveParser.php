<?php

namespace App\Service;

use App\Entity\Event;
use App\Repository\EventTypeRepository;
use App\Repository\RegionRepository;
use App\Repository\SettlementRepository;
use App\Repository\SubgenreRepository;
use App\Repository\WeaponRepository;
use Symfony\Component\Console\Output\OutputInterface;
use Doctrine\Common\Persistence\ObjectManager;

class ArchiveParser
{
    private $typeRepository;
    private $subgenreRepository;
    private $settlementRepository;
    private $weaponRepository;
    private $regionRepository;
    private $om;

    public function __construct(EventTypeRepository $eventTypeRepository, RegionRepository $regionRepository, SubgenreRepository $subgenreRepository, SettlementRepository $settlementRepository, WeaponRepository $weaponRepository, ObjectManager $manager)
    {
        $this->typeRepository = $eventTypeRepository;
        $this->subgenreRepository = $subgenreRepository;
        $this->settlementRepository = $settlementRepository;
        $this->weaponRepository = $weaponRepository;
        $this->regionRepository = $regionRepository;
        $this->om = $manager;
    }

    public function parseFile(OutputInterface $output, $filename)
    {
        $events = [];
        $handle = @fopen($filename, "r");
        if ($handle) {
            while (($line = fgets($handle, 16385)) !== false) {
                if (strpos($line, 'Summary:') === 0) {
                    $event = new Event();
                    $event->setStatus(Event::STATUS_APPROVED);
                    $event->setPublishDate(new \DateTime("January 01, 2018"));
                    $event->setName(trim(str_replace('Summary:', '', $line)));
                }

                if (strpos($line, 'Description: Формат:') === 0) {
                    $typename = trim(str_replace('Description: Формат:', '', $line));
                    $eventType = $this->typeRepository->findOneBy(['name' => $typename]);
                    $event->setType($eventType);
                }

                if (strpos($line, 'Тип поселения:') === 0) {
                    $settlementName = trim(str_replace('Тип поселения:', '', $line));
                    $settlement = $this->settlementRepository->findOneBy(['name' => $settlementName]);
                    $event->setSettlement($settlement);
                }

                if (strpos($line, 'Поджанр:') === 0) {
                    $subgenreName = trim(str_replace('Поджанр:', '', $line));
                    $subgenre = $this->subgenreRepository->findOneBy(['name' => $subgenreName]);
                    $event->setSubgenre($subgenre);
                }

                if (strpos($line, 'Материал оружия:') === 0) {
                    $weapons = trim(str_replace('-', '', str_replace('Материал оружия:', '', $line)));
                    $weapons = explode(', ', $weapons);
                    foreach ($weapons as $value) {
                        $weapon = $this->weaponRepository->findOneBy(['name' => $value]);
                        if ($weapon) {
                            $event->addWeapon($weapon);
                        }
                    }
                }

                if (strpos($line, 'Описание:') === 0) {
                    $description = fgets($handle, 16385);
                    while (!(strpos($newLine = fgets($handle, 16385), 'Start:') === 0)) {
                        $description = $description . PHP_EOL . $newLine;
                    }
                    $event->setDescription($description);
                    if (strpos($newLine, 'Start:') === 0) {
                        $event->setStartDate(new \DateTime(substr($newLine, -10)));
                    }
                }

                if (strpos($line, 'Организаторы:') === 0) {
                    $orgs = trim(str_replace('Организаторы:', '', $line));
                    while (!(strpos($newLine = fgets($handle, 16385), "\r\n") === 0)) {
                        $orgs = $orgs . PHP_EOL . $newLine;
                    }
                    $event->setOrganizers($orgs);
                }

                if (strpos($line, 'Ссылки:') === 0) {
                    $links = trim(str_replace('Ссылки:', '', $line));
                    while (!(strpos($newLine = fgets($handle, 16385), "\r\n") === 0)) {
                        $links = $links . PHP_EOL . $newLine;
                    }
                    $event->setContactOther($links);
                }

                if (strpos($line, 'Сумма взноса:') === 0) {
                    $price = str_replace('Сумма взноса:', '', $line);
                    $price = str_replace('.', '', $price);
                    $price = str_replace('грн', '', $price);
                    $price = str_replace('от', '', $price);
                    $price = str_replace(' до ', '-', $price);
                    $price = str_replace('уточняется', '', $price);
                    $price = trim($price);
                    if (strpos($price, '-') !== false) {
                        $priceMin = substr($price, 0, strpos($price, '-'));
                        if ($priceMin) {
                            $event->setPriceMin($priceMin);
                        }
                        $priceMax = substr($price, strpos($price, '-')+1);
                        if ($priceMax) {
                            $event->setPriceMax($priceMax);
                        }
                    } else {
                        if ($price) {
                            $event->setPriceMin($price);
                        }
                    }
                }

                if (strpos($line, 'End:') === 0) {
                    $event->setEndDate(new \DateTime(substr($line, -10)));
                }

                if (strpos($line, 'Location:') === 0) {
                    $location = str_replace('Location:', '', $line);
                    $location = str_replace('область,', 'область', $location);
                    $location = trim($location);

                    if (strpos($location, 'область') !== false) {
                        $locRegion = explode(' ', $location);
                        $locationName = implode(' ', array_slice($locRegion, 0, array_search('область', $locRegion)-1));
                        if (substr($locationName, -1) === ',') {
                            $locationName = substr($locationName, 0, -1);
                        }
                        if ($locationName) {
                            $event->setLocation($locationName);
                        }
                        $regionName = $locRegion[array_search('область', $locRegion)-1];
                        $region =  $this->regionRepository->findOneBy(['name' => $regionName. ' область']);
                        if ($region) {
                            $event->setRegion($region);
                        }
                    } else {
                        $event->setLocation($location);
                    }
                }

                if (strpos($line, 'Created:') === 0) {
                    $events[] = $event;
                    $this->om->persist($event);
                }
            }

            if (!feof($handle)) {
                $output->writeln('Error: unexpected fgets() fail\n');
            }
            fclose($handle);
        }
        $this->om->flush();

        $eventNames = [];
        foreach ($events as $value) {
            $eventNames[] = $value->getName();
        }

        $output->writeln('Done');
    }
}
