<?php

declare(strict_types=1);

namespace Tests;

use GildedRose\GildedRose;
use GildedRose\Item;
use PHPUnit\Framework\TestCase;

class GildedRoseTest extends TestCase
{
    public function testFoo(): void
    {
        $items = [new Item('foo', 0, 0)];
        $gildedRose = new GildedRose($items);
        $gildedRose->updateQuality();
        $this->assertSame('foo', $items[0]->name);
    }

    public function testQualityIsNeverNegative(): void
    {
        $items = [new Item('Default', 10, -1)];
        $gildedRose = new GildedRose($items);
        $gildedRose->updateQuality();
        $this->assertSame(0, $items[0]->quality);
    }

    public function testQualityIsNeverMoreThenFifty(): void
    {
        $items = [new Item('Default', 51, 5)];
        $gildedRose = new GildedRose($items);
        $gildedRose->updateQuality();
        $this->assertSame(50, $items[0]->sellIn);
    }

    public function testQualityDeclineTwiceDateIsPassed(): void
    {
        $items = [new Item('Default', -1, 8)];
        $gildedRose = new GildedRose($items);
        $gildedRose->updateQuality();
        $this->assertSame(6, $items[0]->quality);
    }

    public function testNormalQualityDecline(): void
    {
        $items = [new Item('Default', 5, 8)];
        $gildedRose = new GildedRose($items);
        $gildedRose->updateQuality();
        $this->assertSame(7, $items[0]->quality);
    }

    public function testBrieIncreaseQuality(): void
    {
        $items = [new Item('Aged Brie', 5, 49)];
        $gildedRose = new GildedRose($items);
        $gildedRose->updateQuality();
        $this->assertSame(50, $items[0]->quality);
    }

    public function testSulfurasQualityAlwaysEighty(): void
    {
        $items = [new Item('Sulfuras, Hand of Ragnaros', 5, 39)];
        $gildedRose = new GildedRose($items);
        $gildedRose->updateQuality();
        $this->assertSame(80, $items[0]->quality);
    }

    public function testBackstage11Days(): void
    {
        $items = [new Item('Backstage passes to a TAFKAL80ETC concert', 10, 30)];
        $gildedRose = new GildedRose($items);
        $gildedRose->updateQuality();
        $this->assertSame(32, $items[0]->quality);
    }

    public function testBackstage5Days(): void
    {
        $items = [new Item('Backstage passes to a TAFKAL80ETC concert', 4, 30)];
        $gildedRose = new GildedRose($items);
        $gildedRose->updateQuality();
        $this->assertSame(33, $items[0]->quality);
    }

    public function testConjuredQualityDegradesTwice(): void
    {
        $items = [new Item('Conjured Mana Cake', 10, 30)];
        $gildedRose = new GildedRose($items);
        $gildedRose->updateQuality();
        $this->assertSame(28, $items[0]->quality);
    }
}
