<?php

namespace App\DataFixtures;

use App\Entity\Conference;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class ConfFixtures extends Fixture {

    public function load(ObjectManager $manager) {

        $conf1 = new Conference();
        $conf1->setTitle('Ma Conference');
        $conf1->setDescription('Lorem ipsum dolor sit amet, consectetur adipiscing elit. '
                . 'Donec nisi ipsum, malesuada at pulvinar at, pellentesque vitae massa. Praesent tristique. ');
        $conf1->setAdresse('1 rue Lointaine');
        $conf1->setIntervenant('Thierry');
        $conf1->setDate(\DateTime::createFromFormat("Y-m-d H:i:s", "2032-10-03 20:00:00"));
        $conf1->setSousTitre('Climat');

        $manager->persist($conf1);

        $conf2 = new Conference();
        $conf2->setTitle('Ma Super Conference');
        $conf2->setDescription('Lorem ipsum dolor sit amet, consectetur adipiscing elit. '
                . 'Donec nisi ipsum, malesuada at pulvinar at, pellentesque vitae massa. Praesent tristique. ');
        $conf2->setAdresse('2 Rue Super Lointaine');
        $conf2->setIntervenant('Henry');
        $conf2->setDate(\DateTime::createFromFormat("Y-m-d H:i:s", "2019-10-03 20:00:00"));
        $conf2->setSousTitre('Nouvelle Technologie');

        $manager->persist($conf2);

        $conf3 = new Conference();
        $conf3->setTitle('Ma Super Giga Conference');
        $conf3->setDescription('Lorem ipsum dolor sit amet, consectetur adipiscing elit. '
                . 'Donec nisi ipsum, malesuada at pulvinar at, pellentesque vitae massa. Praesent tristique. ');
        $conf3->setAdresse('3 Rue Super Giga Lointaine');
        $conf3->setIntervenant('Jeanine');
        $conf3->setDate(\DateTime::createFromFormat("Y-m-d H:i:s", "2020-10-03 20:00:00"));
        $conf3->setSousTitre('Natation');


        $manager->persist($conf3);

        $conf4 = new Conference();
        $conf4->setTitle('Ma Super Giga Mega Conference');
        $conf4->setDescription('Lorem ipsum dolor sit amet, consectetur adipiscing elit. '
                . 'Donec nisi ipsum, malesuada at pulvinar at, pellentesque vitae massa. Praesent tristique. ');
        $conf4->setAdresse('3 Rue Super Giga Mega Lointaine');
        $conf4->setIntervenant('Marcel');
        $conf4->setDate(\DateTime::createFromFormat("Y-m-d H:i:s", "2021-10-03 20:00:00"));
        ;
        $conf4->setSousTitre('Congolexicomatisation');


        $manager->persist($conf4);

        $manager->flush();
    }

}
