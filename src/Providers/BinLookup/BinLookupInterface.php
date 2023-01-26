<?php

namespace Talebyte\Providers\BinLookup;

interface BinLookupInterface
{
    public function getCountry(string $bin): array;
}