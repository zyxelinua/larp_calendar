<?php
namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Author;
use App\Entity\Region;
use App\Entity\EventType;
use App\Entity\Settlement;
use App\Entity\Subgenre;
use App\Entity\Genre;
use App\Entity\Event;
use App\Entity\Weapon;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        //create types
        $typeList = [
            'Полигонная игра',
            'Полигонная игра на турбазе',
            'Конвент',
            'Фестиваль',
            'Турнир',
            'Камеральная игра',
            'Городская игра',
            'Игровой турнир',
            'Полигонная игра-фестиваль',
            'Полигонная страйкбольно-ролевая игра',
            'Бал'
        ];

        foreach ($typeList as $value) {
            $type = new EventType();
            $type->setName($value);
            $manager->persist($type);
        }

        //create genres
        $history = new Genre;
        $history->setName('Исторический/Псевдоисторический');
        $manager->persist($history);

        $fantasy = new Genre;
        $fantasy->setName('Фэнтези');
        $manager->persist($fantasy);

        $sciFi = new Genre;
        $sciFi->setName('Научная фантастика');
        $manager->persist($sciFi);

        $na = new Genre;
        $na->setName('-');
        $manager->persist($na);

        //create subgenres
        $naSub = new Subgenre;
        $naSub->setName('-');
        $naSub->setGenre($na);
        $manager->persist($naSub);

        $subgenreSciFiList = [
            'Научная фантастика',
            'Киберпанк',
            'Постапокалипсис',
            'Киберпанк',
            'Стимпанк',
            'Космическая сага',
        ];

        foreach ($subgenreSciFiList as $value) {
            $subgenre = new Subgenre();
            $subgenre->setName($value);
            $subgenre->setGenre($sciFi);
            $manager->persist($subgenre);
        }

        $subgenreFantasyList = [
            'Высокое фэнтези',
            'Тёмное фэнтези',
            'Мифологическое фэнтези',
            'Историческое фэнтези',
            'Городское фэнтези',
            'Супергеройское фэнтези',
            'Научное фэнтези',
            'Фэнтези',
        ];

        foreach ($subgenreFantasyList as $value) {
            $subgenre = new Subgenre();
            $subgenre->setName($value);
            $subgenre->setGenre($fantasy);
            $manager->persist($subgenre);
        }

        $subgenreHistList = [
            'Первобытность',
            'Античность',
            'Средневековье',
            '17 век',
            '18 век',
            '19 век',
            '20 век',
            'Псевдоисторический-Первобытность',
            'Псевдоисторический-Античность',
            'Псевдоисторический-Средневековье',
            'Псевдоисторический-17 век',
            'Псевдоисторический-18 век',
            'Псевдоисторический-19 век',
            'Псевдоисторический-20 век',
        ];

        foreach ($subgenreHistList as $value) {
            $subgenre = new Subgenre();
            $subgenre->setName($value);
            $subgenre->setGenre($history);
            $manager->persist($subgenre);
        }

        //create settlements
        $settlementList = [
            'Самостоятельное/Палатки',
            'Турбаза',
            'Гостиница/пансионат',
            'На квартирах',
            'Не требуется',
        ];

        foreach ($settlementList as $value) {
            $settlement = new Settlement();
            $settlement->setName($value);
            $manager->persist($settlement);
        }

        //create weapons
        $weaponList = [
            'Резина',
            'Дерево',
            'Текстолит',
            'LARP',
            'Сталь/дюраль',
            'Edison/резиновые пульки',
            'Аирсофт',
            'Модели огнестрела',
        ];

        foreach ($weaponList as $value) {
            $weapon = new Weapon();
            $weapon->setName($value);
            $manager->persist($weapon);
        }

        // create regions
        $regionList = [
            'АР Крым',
            'Винницкая',
            'Волынская',
            'Днепропетровская',
            'Донецкая',
            'Житомирская',
            'Закарпатская',
            'Запорожская',
            'Ивано-Франковская',
            'Киевская',
            'Кировоградская',
            'Луганская',
            'Львовская',
            'Николаевская',
            'Одесская',
            'Полтавская',
            'Ровненская',
            'Сумская',
            'Тернопольская',
            'Харьковская',
            'Херсонская',
            'Хмельницкая',
            'Черкасская',
            'Черниговская',
            'Черновицкая',
        ];

        foreach ($regionList as $value) {
            $region = new Region();
            $region->setName($value. ' область');
            $manager->persist($region);
        }

        $kiev = new Region();
        $kiev->setName('Киев');
        $manager->persist($kiev);

        $manager->flush();
    }
}
