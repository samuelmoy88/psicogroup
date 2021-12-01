<?php


namespace App\Traits;


trait Searchable
{
    private function buildWildCards(string $term = '')
    {
        if ($term === '') {
            return $term;
        }

        $term = trim($term);

        $reservedSymbols = ['-', '+', '<', '>', '@', '(', ')', '~'];

        $term = str_replace($reservedSymbols, '', $term);

        $words = explode(' ', $term);

        foreach ($words as $index => $word) {
            $words[$index] = '+' . $word . '*';
        }

        $term = implode(' ',$words);

        return $term;
    }

    protected function scopeSearch($query, $term)
    {
        $columns = implode(',', $this->searchable);

        return $query->whereRaw("MATCH ({$columns}) AGAINST (? IN BOOLEAN MODE)", $this->buildWildCards($term));
    }
}
