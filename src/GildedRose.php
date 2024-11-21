<?php

declare(strict_types=1);

namespace GildedRose;

final class GildedRose
{
    /**
     * @param Item[] $items
     */
    public function __construct(
        private array $items
    ) {
    }

    public function qualityIsNeverNegative(Item $item): void
    {
        if ($item->quality < 0) {
            $item->quality = 0;
        }
    }

    public function qualityIsNeverMoreThenFifty(Item $item): void
    {
        if ($item->quality > 50) {
            $item->quality = 50;
        }
    }

    public function default(Item $item): void
    {
        $item->sellIn--;

        if ($item->sellIn < 0) {
            $item->quality -= 2;
        } else {
            $item->quality--;
        }

        $this->qualityIsNeverNegative($item);

        $this->qualityIsNeverMoreThenFifty($item);
    }

    public function backStage(Item $item): void
    {
        if ($item->sellIn > 0) {
            $item->quality++;

            if ($item->sellIn < 11) {
                $item->quality++;
                if ($item->sellIn < 6) {
                    $item->quality++;
                }
            }
        } else {
            $item->quality = 0;
        }

        $item->sellIn--;

        $this->qualityIsNeverMoreThenFifty($item);
    }

    public function brie(Item $item): void
    {
        if ($item->quality < 50) {
            $item->quality++;
        }

        $item->sellIn--;

        if ($item->sellIn < 0 && $item->quality < 50) {
            $item->quality++;
        }
    }

    public function conjures(Item $item): void
    {
        $item->quality -= 2;

        $item->sellIn--;

        $this->qualityIsNeverNegative($item);

        $this->qualityIsNeverMoreThenFifty($item);
    }

    public function sulfaras(Item $item): void
    {
        $item->quality = 80;
    }

    public function updateQuality(): void
    {
        foreach ($this->items as $item) {
            if ($item->name === ItemStatus::Backstage->value) {
                $this->backStage($item);
            } elseif ($item->name === ItemStatus::AgedBrie->value) {
                $this->brie($item);
            } elseif ($item->name === ItemStatus::Conjured->value) {
                $this->conjures($item);
            } elseif ($item->name === ItemStatus::Sulfuras->value) {
                $this->sulfaras($item);
            } else {
                $this->default($item);
            }
        }
    }
}
