<?php
namespace App\Tests;

use App\Entity\Annonce;
use PHPUnit\Framework\TestCase;
require ('App\Entity\Annonce');

class AnnonceTest extends TestCase
{
    public function testAssertTrue():void
    {
        $annonce = new  Annonce();
        $date = new \DateTime();
        $annonce->setLibelleProduit("oui");
        $annonce->setDateMiseEnLigne($date);

        $this->assertTrue($annonce->getDateMiseEnLigne()===$date);
        $this->assertTrue($annonce->getLibelleProduit()=="oui");
    }

    public function testAssertFalse():void
    {
        $annonce = new  Annonce();
        $date = new \DateTime();

        $this->assertFalse($annonce->getDateMiseEnLigne()===$date);
        $this->assertFalse($annonce->getLibelleProduit()=="oui");
    }

    public function testAssertEmpty():void
    {
        $annonce = new  Annonce();
        $date = new \DateTime();

        $this->assertEmpty($annonce->getDateMiseEnLigne()===$date);
        $this->assertEmpty($annonce->getLibelleProduit()=="oui");
    }
}