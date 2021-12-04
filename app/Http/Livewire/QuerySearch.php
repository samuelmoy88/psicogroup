<?php

namespace App\Http\Livewire;

use App\Models\Disease;
use App\Models\Services;
use App\Models\Speciality;
use App\Search;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\View;
use Livewire\Component;

class QuerySearch extends Component
{

    public string $query = '';

    public string $service = '';

    public string $speciality = '';

    public string $disease = '';

    public string $profile = '';

    public array $baseSearch = [];

    public array $search = [];

    public int $highlightIndex = 0;

    protected $listeners = [
        'baseSearch',
        'fillQuery',
        'search',
        'refreshComponent',
        'incrementHighlight',
        'decrementHighlight',
        'autofillSelection',
        'setProfile'
    ];

    public function baseSearch() : void
    {
        if (strlen($this->query) > 1) {
            $this->search();
            return;
        }

        $specialities = Speciality::active()->orderBy('order', 'desc')->select('title','id')->limit(5)->get()->toArray();

        $services = Services::active()->orderBy('order', 'desc')->select('title','id')->limit(5)->get()->toArray();

        $diseases = Disease::active()->orderBy('order', 'desc')->select('title','id')->limit(5)->get()->toArray();

        $this->baseSearch['services'] = $services;

        $this->baseSearch['specialities'] = $specialities;

        $this->baseSearch['diseases'] = $diseases;
    }

    public function search() : void
    {
        if (strlen($this->query) < 3) {
            $this->baseSearch();
            return;
        }

        $this->reset('baseSearch');

        $search = new Search();

        $this->search = $search->basicSearch($this->query);
    }

    /**
     * Called when the user clicks on result items
     * @param $query
     * @param string $queryType
     * @param null $typeId
     */
    public function fillQuery($query, $queryType = '', $typeId = null) : void
    {
        $this->query = $query;

        if ($queryType === 'specialities') {
            $this->fillSpeciality($typeId);
        }

        if ($queryType === 'services') {
            $this->fillService($typeId);
        }

        if ($queryType === 'diseases') {
            $this->fillDisease($typeId);
        }

        $this->reset('baseSearch');
    }

    public function fillService($id) : void
    {
        $this->service = $id;

        $this->reset('baseSearch', 'speciality', 'disease');
    }

    public function fillSpeciality($id) : void
    {
        $this->speciality = $id;

        $this->reset('baseSearch', 'service', 'disease');
    }

    public function fillDisease($id) : void
    {
        $this->disease = $id;

        $this->reset('baseSearch', 'service', 'speciality');
    }

    public function updatedQuery() : void
    {
        $this->search();
    }

    public function render() : View
    {
        return view('livewire.query-search');
    }

    public function refreshComponent() : void
    {
        $this->baseSearch = [];

        $this->search = [];

        $this->highlightIndex = 0;
    }

    public function incrementHighlight() : void
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

    public function decrementHighlight() : void
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

    public function autofillSelection() : void
    {
        if (!$this->search && !$this->baseSearch) {
            return;
        }

        if (!$this->search && $this->baseSearch) {
            $this->takeFirstAvailableItem($this->baseSearch['services'], 'service');
            $this->dispatchBrowserEvent('submitSearch');
            return;
        }

        if (isset($this->search['services'])) {
            $this->takeFirstAvailableItem($this->search['services'], 'service');
            $this->dispatchBrowserEvent('submitSearch');
            return;
        }

        if (isset($this->search['specialities'])) {
            $this->takeFirstAvailableItem($this->search['specialities'], 'speciality');
            $this->dispatchBrowserEvent('submitSearch');
            return;
        }

        if (isset($this->search['diseases'])) {
            $this->takeFirstAvailableItem($this->search['diseases'], 'disease');
            $this->dispatchBrowserEvent('submitSearch');
            return;
        }

    }

    public function takeFirstAvailableItem($searchResult, $type) : void
    {
        $firstItem = array_shift($searchResult);

        if ($type === 'service') {
            $this->fillService($firstItem['id']);
        }

        if ($type === 'speciality') {
            $this->fillSpeciality($firstItem['id']);
        }

        if ($type === 'disease') {
            $this->fillDisease($firstItem['id']);
        }

        $this->query = $firstItem['title'];
    }

    public function setProfile(string $profile) : void
    {
        $this->profile = $profile;
    }
}
