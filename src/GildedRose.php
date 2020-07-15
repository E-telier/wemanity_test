<?php

namespace App;

final class GildedRose {

    private $items = [];

    public function __construct($items) {
        $this->items = $items;
    }

    public function updateQuality() {

        /* 
            ** FUNCTIONAL SUMMARY **

                1/ STANDARD BEHAVIOR

            	- All items have a SellIn value which denotes the number of days we have to sell the item
                - All items have a Quality value which denotes how valuable the item is
                - At the end of each day our system lowers both values for every item

                - Once the sell by date has passed, Quality degrades twice as fast
                - The Quality of an item is never negative
                - The Quality of an item is never more than 50

                2/ EXCEPTIONS

                - "Aged Brie" actually increases in Quality the older it gets
                - "Sulfuras", being a legendary item, never has to be sold or decreases in Quality 
                    its Quality is 80 and it never alters
                - "Backstage passes", like aged brie, increases in Quality as its SellIn value approaches;
                    Quality increases by 2 when there are 10 days or less and by 3 when there are 5 days or less but
                    Quality drops to 0 after the concert
                - "Conjured" items degrade in Quality twice as fast as normal items

        */
       
        foreach ($this->items as $item) {

            // STANDARD RULE //
            $quality_step = -1;
            $sellin_step = -1;

            $quality_max = 50;

            if ($item->sell_in + $sellin_step < 0) {
                $quality_step *= 2;
            }

            // EXCEPTIONS //
            if ($item->name == 'Aged Brie') {
                $quality_step = 1;
            } else if ($item->name == 'Sulfuras, Hand of Ragnaros') {
                $quality_step = 0;
                $sellin_step = 0;
                $quality_max = 80;
            } else if ($item->name == 'Conjured Mana Cake') {
                $quality_step *= 2;
            } else if ($item->name == 'Backstage passes to a TAFKAL80ETC concert') {

                $current_sellin = $item->sell_in + $sellin_step;

                if ($current_sellin < 0) {
                    // quality drops to zero
                    $quality_step = -$item->quality; 
                } else if ($current_sellin < 5) {
                    $quality_step = 3;
                } else if ($current_sellin < 10) {
                    $quality_step = 2;
                } else {
                    $quality_step = 1;
                }

            }

            // APPLY CHANGES //
            $item->quality += $quality_step;
            $item->sell_in += $sellin_step;

            $item->quality = min($quality_max, $item->quality);
            $item->quality = max(0, $item->quality);
            
        }
        
    }
}

