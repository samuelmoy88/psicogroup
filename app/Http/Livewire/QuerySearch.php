<?php

namespace App\Http\Livewire;

use App\Models\Services;
use App\Models\Speciality;
use App\Search;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class QuerySearch extends Component
{

    public string $query = '';

    public string $service = '';

    public string $speciality = '';

    public array $baseSearch = [];

    public array $search = [];

    public int $highlightIndex = 0;

    protected array $listeners = [
        'baseSearch',
        'fillQuery',
        'search',
        'refreshComponent',
        'incrementHighlight',
        'decrementHighlight'
    ];

    public function baseSearch()
    {
        if (strlen($this->query) > 1) {
            $this->search();
            return;
        }

        $specialities = Speciality::active()->orderBy('order', 'desc')->select('title','id')->limit(5)->get()->toArray();

        $services = Services::active()->orderBy('order', 'desc')->select('title','id')->limit(5)->get()->toArray();

        $this->baseSearch['specialities'] = $specialities;

        $this->baseSearch['services'] = $services;
    }

    public function search()
    {
        if (strlen($this->query) < 2) {
            $this->baseSearch();
            return;
        }

        $this->reset('baseSearch');

        $search = new Search();

        $this->search = $search->basicSearch($this->query);
    }

    public function fillQuery($query, $queryType = '', $typeId = null)
    {
        $this->query = $query;

        if ($queryType === 'specialities') {
            $this->fillSpeciality($typeId);
        }

        if ($queryType === 'services') {
            $this->fillService($typeId);
        }

        $this->reset('baseSearch');
    }

    public function fillService($id)
    {
        $this->service = $id;

        $this->reset('baseSearch');
    }

    public function fillSpeciality($id)
    {
        $this->speciality = $id;

        $this->reset('baseSearch');
    }

    public function updatedQuery()
    {
        $this->search();
    }

    public function render()
    {
        return view('livewire.query-search');
    }

    public function refreshComponent()
    {
        $this->baseSearch = [];

        $this->search = [];

        $this->highlightIndex = 0;
    }

    public function incrementHighlight()
    {
        if (count($this->baseSearch) === $this->highlightIndex) {
            $this->highlightIndex = 0;
            return;
        } elseif (count($this->search) === $this->highlightIndex) {
            $this->highlightIndex = 0;
            return;
        }

        $this->highlightIndex++;
    }

    public function decrementHighlight()
    {
        if ($this->highlightIndex === 0) {
            if (count($this->baseSearch) > 0) {
                $this->highlightIndex = count($this->baseSearch);
                return;
            } elseif (count($this->search) > 0) {
                $this->highlightIndex = count($this->search);
                return;
            }
        }

        $this->highlightIndex--;
    }
}
