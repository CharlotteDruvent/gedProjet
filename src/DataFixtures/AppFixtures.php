<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use App\Entity\Company;
use App\Entity\WorkUnit;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{

    public function load(ObjectManager $manager)
    {

        $faker = Factory::create('fr_FR');

        for($u =0; $u < 10; $u++){
            $user = new User();           
            $user->setEmail($faker->email)
                 ->setUsername($faker->firstName)
                 ->setPassword('password');
            
            $manager->persist($user);

            for($c = 0; $c < 3; $c++) {
                $company = new Company();
                $company->setName($faker->company())
                        ->setAddress($faker->streetAddress)
                        ->setCity($faker->city)
                        ->setZipCode($faker->postcode)
                        ->addUser($user);
    
                $manager->persist($company);
    
                    for($w = 0; $w < mt_rand(2,8); $w++){
                        $workUnit = new WorkUnit();
                        $workUnit->setName($faker->randomElement(['BUREAU','ATELIER SOUDURE','CUISINE','ATELIER MENUISERIE']))
                                 ->setCompany($company)
                                 ->setLibelle($faker->sentence($nbWords=6,$variableNbWords=True));
    
                        $manager->persist($workUnit);
                    }
            }
        }

        $manager->flush();
    }
}
