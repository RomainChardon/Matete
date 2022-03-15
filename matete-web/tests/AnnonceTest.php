<?php

namespace App\Tests;

use App\Entity\Annonce;
use PHPUnit\Framework\TestCase;

class AnnonceTest extends TestCase
{
    public function testAssertTrue(): void
    {
        $annonce= new Annonce();
        $annonce->setLibelleProduit("test");

        $this->assertTrue($annonce->getLibelleProduit() == 'test', 'libelle');
    }
}
