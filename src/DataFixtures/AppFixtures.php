<?php

namespace App\DataFixtures;

use App\Entity\Skin;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        $this -> loadSkins($manager);

    }
    
    private function loadSkins(ObjectManager $manager)
    {
        foreach ($this->getSkinData() as [$name, $rarety]) {
            $skin = new Skin();
            $skin->setName($name);
            $skin->setRarety($rarety);
            $manager->persist($skin);
        }
        $manager->flush();
    }
    
    private function getSkinData()
    {
        // Skin = [name, rarety];
        yield ['Supreme Dragon', "Legendary"];
        yield ['LittleMan', "Epic"];
        yield ['SpeedWagon',  "Rare"];
        yield ['The World', "Unique"];
        
    }
}
