<?php
/*
This is a livewire backend component used for rendering DELETED users depending on the search filters. It is also used for RESTORING selected users. It includes following methods:
- Search method that updates the frontend component with the results from the $search property. 
- Helper method to visually distinguish selected rows
- Method to restore selected users
- Helper method to clear checked rows
Pagination is also used
*/
namespace App\Livewire;

use Livewire\WithPagination;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class ShowDeletedUsers extends Component
{


    use WithPagination;
    public string $empty = "No users found...";
    public string $search = "";
    public User $user;
    public string $count = "";
    public array $checkBox = [];

    //Storing the user search in variable and resetting the component
    public function updatedSearch(string $search):void
    {


        $this->search = $search;
        $this->resetPage();
    }

    //Selecting user rows 
    public function RowCheckBox(string $parameter):void
    {
       if(in_array($parameter, $this->checkBox)){
        $index=array_search($parameter, $this->checkBox);
        unset($this->checkBox[$index]);
        $this->count--;
       }else {
        $this->checkBox[] = $parameter;
        $this->count = count($this->checkBox);
        
        
    }
    
    }
    //Restoring selected users
    public function restoreUser():void
    {
        Gate::authorize('restore', User::class); //Authorisation for admin
        $deletedUsers = [$this->checkBox];
        User::onlyTrashed()->whereIn("id", $deletedUsers[0])->restore(); 
        $this->count = "";
    }
    //Clearing checked
    public function clearCheckbox():void
    {
        $this->checkBox = [];
        $this->count = "";
    }
    //Rendering the deleted users with searched characters and pagination
    public function render()
    {
        $deletedUsers=User::onlyTrashed()->whereAny(["name", "email", "role"], "like", "%" . $this->search . "%")->paginate(5);

        return view("livewire.show-deleted-users", ["users" => $deletedUsers]);
    }
}
