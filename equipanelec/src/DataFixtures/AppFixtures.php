<?php

namespace App\DataFixtures;

use App\Entity\Material;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $material = new Material();
        $material->setBarcode('13456789');
        $material->setName('Tornillos');
        $material->setStock(105);
        $material->setLocation('Estanteria 4 bodega 2');
        $material->setBrand('');
        $material->setPurchasePrice(.2);
        $material->setSalePrice(.1);
        $manager->flush();
    }
}
