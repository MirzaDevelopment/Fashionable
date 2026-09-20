<?php
/*
This is a livewire backend component used for rendering active tenants depending on the search filters. It is also used for deleting selected tenants. It includes following methods:
- Search method that updates the frontend component with the results from the $search property. 
- Helper method to visually distinguish selected rows
- Method to delete selected tenants
- Helper method to clear checked rows
- Pagination is also used
*/
namespace App\Livewire;

use Livewire\Component;

class ShowTenants extends Component
{
    public function render()
    {
        return view('livewire.show-tenants');
    }
}
