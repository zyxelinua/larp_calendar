<?php
namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Author;
use App\Entity\Region;
use App\Entity\EventType;
use App\Entity\Subgenre;
use App\Entity\Genre;
use App\Entity\Event;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // create regions
        $poland = new Region();
        $poland->setName('Poland');
        $manager->persist($poland);

        $ukraine = new Region();
        $ukraine->setName('Ukraine');
        $manager->persist($ukraine);

        //create subgenres
        $alt_historical = new Subgenre;
        $alt_historical->setName('alternative history');
        $manager->persist($alt_historical);

        $postapoc = new Subgenre;
        $postapoc->setName('post apocalypse');
        $manager->persist($postapoc);

        //create genres
        $history = new Genre;
        $history->setName('historical');
        $manager->persist($history);

        $fantasy = new Genre;
        $fantasy->setName('fantasy');
        $manager->persist($fantasy);

        //create types
        $larp = new EventType();
        $larp->setName('larp');
        $manager->persist($larp);

        $convent = new EventType();
        $convent->setName('convent');
        $manager->persist($convent);

        $chamber = new EventType();
        $chamber->setName('chamber larp');
        $manager->persist($chamber);

        //create article author
        $author = new Author();
        $author->setName('Ghostwriter');
        $manager->persist($author);

        //create articles
        $article1 = new Article();
        $article1 -> setName("Article 1");
        $article1 -> setDescription("This is some abstract larp overview");
        $article1->setPublishDate(new \DateTime("October 01, 2018"));
        $article1->setAuthor($author);
        $article1->setCategory(Article::CATEGORY_ARTICLE);
        $manager->persist($article1);

        $article2 = new Article();
        $article2 -> setName("Article 2");
        $article2 -> setDescription("This is some abstract larp overview");
        $article2->setPublishDate(new \DateTime("October 10, 2018"));
        $article2->setAuthor($author);
        $article2->setCategory(Article::CATEGORY_OVERVIEW);
        $manager->persist($article2);

        $article3 = new Article();
        $article3 -> setName("Article 3");
        $article3 -> setDescription("This is some abstract larp overview");
        $article3->setPublishDate(new \DateTime("October 01, 2018"));
        $article3->setAuthor($author);
        $article3->setCategory(Article::CATEGORY_ANNOUNCEMENT);
        $manager->persist($article3);

        //create events
        $run1 = new Event;
        $run1->setName('Cool larp run 1');
        $run1->setDescription('You are the rot in the state of Denmark. Your country is aflame with the fires of revolution. The court of King Claudius is isolated in a bunker beneath the castle-fortress of Elsinore and you refuse to let go of power.
                Anyone could see that the days of the Kingdom are numbered. But not you. You linger on the edge of action, escaping deeper into decadent madness and murderous paranoia. Your folly is the curse of Hamlet - a numbing fear of decisive action. It will kill you in the end.
                All of you.');
        $run1->setStartDate((new \DateTime("November 01, 2018")));
        $run1->setEndDate(new \DateTime("November 04, 2018"));
        $run1->setLocation('beautiful castle');
        $run1->setRegion($poland);
        $run1->setGenre($history);
        $run1->setSubgenres([$alt_historical]);
        $run1->setType($larp);
        $run1->setStatus('approved');
        $run1->setOrganizers('cool MG');
        $run1->setOrganizerContact('cool_mg@gmail.com');
        $run1->setPublishDate(new \DateTime("October 01, 2018"));
        $run1->setPriceMin(100);
        $run1->setPriceMax(200);
        $run1->setContactSite('www.google.com');
        $run1->setContactFB('www.google.com');
        $run1->setContactVK('www.google.com');
        $run1->setContactTelegram('www.google.com');
        $run1->setContactOther('telegram channel @coollarp');
        $manager->persist($run1);

        $run2 = new Event;
        $run2->setName('Cool larp run 2');
        $run2->setDescription('You are the rot in the state of Denmark. Your country is aflame with the fires of revolution. The court of King Claudius is isolated in a bunker beneath the castle-fortress of Elsinore and you refuse to let go of power.
                Anyone could see that the days of the Kingdom are numbered. But not you. You linger on the edge of action, escaping deeper into decadent madness and murderous paranoia. Your folly is the curse of Hamlet - a numbing fear of decisive action. It will kill you in the end.
                All of you.');
        $run2->setStartDate((new \DateTime("December 01, 2018")));
        $run2->setEndDate(new \DateTime("December 04, 2018"));
        $run2->setLocation('beautiful castle');
        $run2->setRegion($poland);
        $run2->setGenre($history);
        $run2->setSubgenres([$alt_historical]);
        $run2->setType($chamber);
        $run2->setStatus('approved');
        $run2->setOrganizers('cool MG');
        $run2->setOrganizerContact('cool_mg@gmail.com');
        $run2->setPublishDate(new \DateTime("October 02, 2018"));
        $run2->setPriceMin(100);
        $run2->setContactSite('www.google.com');
        $run2->setContactOther('telegram channel @coollarp');
        $manager->persist($run2);

        $run3 = new Event;
        $run3->setName('Cool larp run 3');
        $run3->setDescription('You are the rot in the state of Denmark. Your country is aflame with the fires of revolution. The court of King Claudius is isolated in a bunker beneath the castle-fortress of Elsinore and you refuse to let go of power.
                Anyone could see that the days of the Kingdom are numbered. But not you. You linger on the edge of action, escaping deeper into decadent madness and murderous paranoia. Your folly is the curse of Hamlet - a numbing fear of decisive action. It will kill you in the end.
                All of you.');
        $run3->setStartDate((new \DateTime("December 01, 2018")));
        $run3->setEndDate(new \DateTime("December 04, 2018"));
        $run3->setLocation('beautiful castle');
        $run3->setRegion($poland);
        $run3->setSubgenres([$postapoc, $alt_historical]);
        $run3->setGenre($history);
        $run3->setType($larp);
        $run3->setStatus('approved');
        $run3->setOrganizers('cool MG');
        $run3->setOrganizerContact('cool_mg@gmail.com');
        $run3->setPublishDate(new \DateTime("October 04, 2018"));
        $run3->setPriceMax(200);
        $run3->setContactFB('www.google.com');
        $run3->setContactOther('telegram channel @coollarp');
        $run3->setPicture('default-event-picture.jpg');
        $manager->persist($run3);

        $run4 = new Event;
        $run4->setName('Cool larp run 4');
        $run4->setDescription('You are the rot in the state of Denmark. Your country is aflame with the fires of revolution. The court of King Claudius is isolated in a bunker beneath the castle-fortress of Elsinore and you refuse to let go of power.
                Anyone could see that the days of the Kingdom are numbered. But not you. You linger on the edge of action, escaping deeper into decadent madness and murderous paranoia. Your folly is the curse of Hamlet - a numbing fear of decisive action. It will kill you in the end.
                All of you.');
        $run4->setStartDate((new \DateTime("December 01, 2018")));
        $run4->setEndDate(new \DateTime("December 04, 2018"));
        $run4->setLocation('beautiful castle');
        $run4->setRegion($poland);
        $run4->setGenre($fantasy);
        $run4->setSubgenres([$alt_historical]);
        $run4->setType($convent);
        $run4->setStatus('approved');
        $run4->setOrganizers('cool MG');
        $run4->setOrganizerContact('cool_mg@gmail.com');
        $run4->setPublishDate(new \DateTime("October 01, 2018"));
        $run4->setPriceMin(100);
        $run4->setPriceMax(100);
        $run4->setContactSite('www.google.com');
        $run4->setContactFB('www.google.com');
        $manager->persist($run4);

        $run5 = new Event;
        $run5->setName('Cool larp run 5');
        $run5->setDescription('You are the rot in the state of Denmark. Your country is aflame with the fires of revolution. The court of King Claudius is isolated in a bunker beneath the castle-fortress of Elsinore and you refuse to let go of power.
                Anyone could see that the days of the Kingdom are numbered. But not you. You linger on the edge of action, escaping deeper into decadent madness and murderous paranoia. Your folly is the curse of Hamlet - a numbing fear of decisive action. It will kill you in the end.
                All of you.');
        $run5->setStartDate((new \DateTime("December 01, 2018")));
        $run5->setEndDate(new \DateTime("December 04, 2018"));
        $run5->setLocation('beautiful castle');
        $run5->setRegion($ukraine);
        $run5->setSubgenres([$alt_historical]);
        $run5->setGenre($history);
        $run5->setType($larp);
        $run5->setStatus('approved');
        $run5->setOrganizers('cool MG');
        $run5->setOrganizerContact('cool_mg@gmail.com');
        $run5->setPublishDate(new \DateTime("October 01, 2018"));
        $run5->setContactSite('www.google.com');
        $manager->persist($run5);

        $run6 = new Event;
        $run6->setName('Классная игра 6');
        $run6->setDescription('You are the rot in the state of Denmark. Your country is aflame with the fires of revolution. The court of King Claudius is isolated in a bunker beneath the castle-fortress of Elsinore and you refuse to let go of power.
                Anyone could see that the days of the Kingdom are numbered. But not you. You linger on the edge of action, escaping deeper into decadent madness and murderous paranoia. Your folly is the curse of Hamlet - a numbing fear of decisive action. It will kill you in the end.
                All of you.');
        $run6->setStartDate((new \DateTime("December 01, 2018")));
        $run6->setEndDate(new \DateTime("December 04, 2018"));
        $run6->setLocation('beautiful castle');
        $run6->setRegion($poland);
        $run6->setSubgenres([$alt_historical]);
        $run6->setGenre($history);
        $run6->setType($larp);
        $run6->setStatus('approved');
        $run6->setOrganizers('cool MG');
        $run6->setOrganizerContact('cool_mg@gmail.com');
        $run6->setPublishDate(new \DateTime("October 01, 2018"));
        $run6->setContactFB('www.google.com');
        $manager->persist($run6);

        $run7 = new Event;
        $run7->setName('Cool larp run 7');
        $run7->setDescription('You are the rot in the state of Denmark. Your country is aflame with the fires of revolution. The court of King Claudius is isolated in a bunker beneath the castle-fortress of Elsinore and you refuse to let go of power.
                Anyone could see that the days of the Kingdom are numbered. But not you. You linger on the edge of action, escaping deeper into decadent madness and murderous paranoia. Your folly is the curse of Hamlet - a numbing fear of decisive action. It will kill you in the end.
                All of you.');
        $run7->setStartDate((new \DateTime("December 01, 2018")));
        $run7->setEndDate(new \DateTime("December 04, 2018"));
        $run7->setLocation('beautiful castle');
        $run7->setRegion($poland);
        $run7->setSubgenres([$alt_historical]);
        $run7->setGenre($history);
        $run7->setType($larp);
        $run7->setStatus('cancelled');
        $run7->setOrganizers('cool MG');
        $run7->setOrganizerContact('cool_mg@gmail.com');
        $run7->setPublishDate(new \DateTime("October 01, 2018"));
        $run7->setContactOther('telegram channel @coollarp');
        $manager->persist($run7);

        $run8 = new Event;
        $run8->setName(' run 8');
        $run8->setDescription('You are the rot in the state of Denmark. Your country is aflame with the fires of revolution. The court of King Claudius is isolated in a bunker beneath the castle-fortress of Elsinore and you refuse to let go of power.
                Anyone could see that the days of the Kingdom are numbered. But not you. You linger on the edge of action, escaping deeper into decadent madness and murderous paranoia. Your folly is the curse of Hamlet - a numbing fear of decisive action. It will kill you in the end.
                All of you.');
        $run8->setStartDate((new \DateTime("December 01, 2018")));
        $run8->setEndDate(new \DateTime("December 04, 2018"));
        $run8->setLocation('beautiful castle');
        $run8->setRegion($poland);
        $run8->setSubgenres([$alt_historical]);
        $run8->setGenre($history);
        $run8->setType($larp);
        $run8->setStatus('pending');
        $run8->setOrganizers('cool MG');
        $run8->setOrganizerContact('cool_mg@gmail.com');
        $run8->setPublishDate(new \DateTime("October 01, 2018"));
        $manager->persist($run8);

        $runPast = new Event;
        $runPast->setName('Cool larp run past');
        $runPast->setDescription('You are the rot in the state of Denmark. Your country is aflame with the fires of revolution. The court of King Claudius is isolated in a bunker beneath the castle-fortress of Elsinore and you refuse to let go of power.
                Anyone could see that the days of the Kingdom are numbered. But not you. You linger on the edge of action, escaping deeper into decadent madness and murderous paranoia. Your folly is the curse of Hamlet - a numbing fear of decisive action. It will kill you in the end.
                All of you.');
        $runPast->setStartDate((new \DateTime("May 01, 2018")));
        $runPast->setEndDate(new \DateTime("May 04, 2018"));
        $runPast->setLocation('beautiful castle');
        $runPast->setRegion($poland);
        $runPast->setSubgenres([$alt_historical]);
        $runPast->setGenre($history);
        $runPast->setType($larp);
        $runPast->setStatus('approved');
        $runPast->setOrganizers('cool MG');
        $runPast->setOrganizerContact('cool_mg@gmail.com');
        $runPast->setPublishDate(new \DateTime("April 01, 2018"));
        $manager->persist($runPast);

        $manager->flush();
    }
}
