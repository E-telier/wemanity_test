<?php

namespace App;

class GildedRoseTest extends \PHPUnit\Framework\TestCase {

	public function testConjured() {
        $items      = [ new Item('Conjured Mana Cake', 3, 12) ];
        $gildedRose = new GildedRose($items);
        $gildedRose->updateQuality();
        $this->assertEquals(10, $items[0]->quality);
    }
	
	public function testBackstage() {
        $items      = [ 
			new Item('Backstage passes to a TAFKAL80ETC concert', 5, 49), 
			new Item('Backstage passes to a TAFKAL80ETC concert', 5, 20),
			new Item('Backstage passes to a TAFKAL80ETC concert', 10, 20),
			new Item('Backstage passes to a TAFKAL80ETC concert', 25, 10)
		];
        $gildedRose = new GildedRose($items);
        $gildedRose->updateQuality();
        $this->assertEquals(50, $items[0]->quality);		
		$this->assertEquals(23, $items[1]->quality);
		$this->assertEquals(22, $items[2]->quality);
		$this->assertEquals(11, $items[3]->quality);
		
    }
	
}
