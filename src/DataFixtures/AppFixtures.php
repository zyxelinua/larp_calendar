<?php
namespace App\DataFixtures;

use App\Entity\Country;
use App\Entity\EventType;
use App\Entity\EventCategory;
use App\Entity\Event;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // create countries
        $poland = new Country();
        $poland->setName('Poland');
        $manager->persist($poland);

        $ukraine = new Country();
        $ukraine->setName('Ukraine');
        $manager->persist($ukraine);

        //create categories
        $historical = new EventCategory;
        $historical->setName('historical');
        $manager->persist($historical);

        $postapoc = new EventCategory;
        $postapoc->setName('post apocalypse');
        $manager->persist($postapoc);

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

        //create events
        $run1 = new Event;
        $run1->setName('Cool larp run 1');
        $run1->setShortDescription('You are the rot in the state of Denmark. Your country is aflame with the fires of revolution. The court of King Claudius is isolated in a bunker beneath the castle-fortress of Elsinore and you refuse to let go of power.
                Anyone could see that the days of the Kingdom are numbered. But not you. You linger on the edge of action, escaping deeper into decadent madness and murderous paranoia. Your folly is the curse of Hamlet - a numbing fear of decisive action. It will kill you in the end.
                All of you.');
        $run1->setBeginningDate((new \DateTime("November 01, 2018")));
        $run1->setEndDate(new \DateTime("November 04, 2018"));
        $run1->setLocation('beautiful castle');
        $run1->setCountry($poland);
        $run1->setCategory($historical);
        $run1->setType($larp);
        $run1->setStatus('approved');
        $run1->setOrganizers('cool MG');
        $run1->setOrganizerContact('cool_mg@gmail.com');
        $run1->setPublishDate(new \DateTime("September 01, 2018"));
        $manager->persist($run1);

        $run2 = new Event;
        $run2->setName('Cool larp run 2');
        $run2->setShortDescription('You are the rot in the state of Denmark. Your country is aflame with the fires of revolution. The court of King Claudius is isolated in a bunker beneath the castle-fortress of Elsinore and you refuse to let go of power.
                Anyone could see that the days of the Kingdom are numbered. But not you. You linger on the edge of action, escaping deeper into decadent madness and murderous paranoia. Your folly is the curse of Hamlet - a numbing fear of decisive action. It will kill you in the end.
                All of you.');
        $run2->setBeginningDate((new \DateTime("October 01, 2018")));
        $run2->setEndDate(new \DateTime("October 04, 2018"));
        $run2->setLocation('beautiful castle');
        $run2->setCountry($poland);
        $run2->setCategory($historical);
        $run2->setType($chamber);
        $run2->setStatus('approved');
        $run2->setOrganizers('cool MG');
        $run2->setOrganizerContact('cool_mg@gmail.com');
        $run2->setPublishDate(new \DateTime("September 02, 2018"));
        $manager->persist($run2);

        $run3 = new Event;
        $run3->setName('Cool larp run 3');
        $run3->setShortDescription('You are the rot in the state of Denmark. Your country is aflame with the fires of revolution. The court of King Claudius is isolated in a bunker beneath the castle-fortress of Elsinore and you refuse to let go of power.
                Anyone could see that the days of the Kingdom are numbered. But not you. You linger on the edge of action, escaping deeper into decadent madness and murderous paranoia. Your folly is the curse of Hamlet - a numbing fear of decisive action. It will kill you in the end.
                All of you.');
        $run3->setBeginningDate((new \DateTime("October 01, 2018")));
        $run3->setEndDate(new \DateTime("October 04, 2018"));
        $run3->setLocation('beautiful castle');
        $run3->setCountry($poland);
        $run3->setCategory($postapoc);
        $run3->setType($larp);
        $run3->setStatus('approved');
        $run3->setOrganizers('cool MG');
        $run3->setOrganizerContact('cool_mg@gmail.com');
        $run3->setPublishDate(new \DateTime("September 04, 2018"));
        $manager->persist($run3);

        $run4 = new Event;
        $run4->setName('Cool larp run 4');
        $run4->setShortDescription('You are the rot in the state of Denmark. Your country is aflame with the fires of revolution. The court of King Claudius is isolated in a bunker beneath the castle-fortress of Elsinore and you refuse to let go of power.
                Anyone could see that the days of the Kingdom are numbered. But not you. You linger on the edge of action, escaping deeper into decadent madness and murderous paranoia. Your folly is the curse of Hamlet - a numbing fear of decisive action. It will kill you in the end.
                All of you.');
        $run4->setBeginningDate((new \DateTime("October 01, 2018")));
        $run4->setEndDate(new \DateTime("October 04, 2018"));
        $run4->setLocation('beautiful castle');
        $run4->setCountry($poland);
        $run4->setCategory($historical);
        $run4->setType($convent);
        $run4->setStatus('approved');
        $run4->setOrganizers('cool MG');
        $run4->setOrganizerContact('cool_mg@gmail.com');
        $run4->setPublishDate(new \DateTime("September 01, 2018"));
        $manager->persist($run4);

        $run5 = new Event;
        $run5->setName('Cool larp run 5');
        $run5->setShortDescription('You are the rot in the state of Denmark. Your country is aflame with the fires of revolution. The court of King Claudius is isolated in a bunker beneath the castle-fortress of Elsinore and you refuse to let go of power.
                Anyone could see that the days of the Kingdom are numbered. But not you. You linger on the edge of action, escaping deeper into decadent madness and murderous paranoia. Your folly is the curse of Hamlet - a numbing fear of decisive action. It will kill you in the end.
                All of you.');
        $run5->setBeginningDate((new \DateTime("October 01, 2018")));
        $run5->setEndDate(new \DateTime("October 04, 2018"));
        $run5->setLocation('beautiful castle');
        $run5->setCountry($ukraine);
        $run5->setCategory($historical);
        $run5->setType($larp);
        $run5->setStatus('approved');
        $run5->setOrganizers('cool MG');
        $run5->setOrganizerContact('cool_mg@gmail.com');
        $run5->setPublishDate(new \DateTime("September 01, 2018"));
        $manager->persist($run5);

        $run6 = new Event;
        $run6->setName('Cool larp run 6');
        $run6->setShortDescription('You are the rot in the state of Denmark. Your country is aflame with the fires of revolution. The court of King Claudius is isolated in a bunker beneath the castle-fortress of Elsinore and you refuse to let go of power.
                Anyone could see that the days of the Kingdom are numbered. But not you. You linger on the edge of action, escaping deeper into decadent madness and murderous paranoia. Your folly is the curse of Hamlet - a numbing fear of decisive action. It will kill you in the end.
                All of you.');
        $run6->setBeginningDate((new \DateTime("October 01, 2018")));
        $run6->setEndDate(new \DateTime("October 04, 2018"));
        $run6->setLocation('beautiful castle');
        $run6->setCountry($poland);
        $run6->setCategory($historical);
        $run6->setType($larp);
        $run6->setStatus('approved');
        $run6->setOrganizers('cool MG');
        $run6->setOrganizerContact('cool_mg@gmail.com');
        $run6->setPublishDate(new \DateTime("September 01, 2018"));
        $manager->persist($run6);

        $run7 = new Event;
        $run7->setName('Cool larp run 7');
        $run7->setShortDescription('You are the rot in the state of Denmark. Your country is aflame with the fires of revolution. The court of King Claudius is isolated in a bunker beneath the castle-fortress of Elsinore and you refuse to let go of power.
                Anyone could see that the days of the Kingdom are numbered. But not you. You linger on the edge of action, escaping deeper into decadent madness and murderous paranoia. Your folly is the curse of Hamlet - a numbing fear of decisive action. It will kill you in the end.
                All of you.');
        $run7->setBeginningDate((new \DateTime("October 01, 2018")));
        $run7->setEndDate(new \DateTime("October 04, 2018"));
        $run7->setLocation('beautiful castle');
        $run7->setCountry($poland);
        $run7->setCategory($historical);
        $run7->setType($larp);
        $run7->setStatus('approved');
        $run7->setOrganizers('cool MG');
        $run7->setOrganizerContact('cool_mg@gmail.com');
        $run7->setPublishDate(new \DateTime("September 01, 2018"));
        $manager->persist($run7);

        $run8 = new Event;
        $run8->setName('Cool larp run 8');
        $run8->setShortDescription('You are the rot in the state of Denmark. Your country is aflame with the fires of revolution. The court of King Claudius is isolated in a bunker beneath the castle-fortress of Elsinore and you refuse to let go of power.
                Anyone could see that the days of the Kingdom are numbered. But not you. You linger on the edge of action, escaping deeper into decadent madness and murderous paranoia. Your folly is the curse of Hamlet - a numbing fear of decisive action. It will kill you in the end.
                All of you.');
        $run8->setBeginningDate((new \DateTime("October 01, 2018")));
        $run8->setEndDate(new \DateTime("October 04, 2018"));
        $run8->setLocation('beautiful castle');
        $run8->setCountry($poland);
        $run8->setCategory($historical);
        $run8->setType($larp);
        $run8->setStatus('pending');
        $run8->setOrganizers('cool MG');
        $run8->setOrganizerContact('cool_mg@gmail.com');
        $run8->setPublishDate(new \DateTime("September 01, 2018"));
        $manager->persist($run8);

        $runPast = new Event;
        $runPast->setName('Cool larp run past');
        $runPast->setShortDescription('You are the rot in the state of Denmark. Your country is aflame with the fires of revolution. The court of King Claudius is isolated in a bunker beneath the castle-fortress of Elsinore and you refuse to let go of power.
                Anyone could see that the days of the Kingdom are numbered. But not you. You linger on the edge of action, escaping deeper into decadent madness and murderous paranoia. Your folly is the curse of Hamlet - a numbing fear of decisive action. It will kill you in the end.
                All of you.');
        $runPast->setBeginningDate((new \DateTime("May 01, 2018")));
        $runPast->setEndDate(new \DateTime("May 04, 2018"));
        $runPast->setLocation('beautiful castle');
        $runPast->setCountry($poland);
        $runPast->setCategory($historical);
        $runPast->setType($larp);
        $runPast->setStatus('approved');
        $runPast->setOrganizers('cool MG');
        $runPast->setOrganizerContact('cool_mg@gmail.com');
        $runPast->setPublishDate(new \DateTime("April 01, 2018"));
        $manager->persist($runPast);

        $manager->flush();
    }
}
