<?php
/*
This is a livewire backend component used for rendering active users depending on the search filters. It is also used for deleting selected users. It includes following methods:
- Search method that updates the frontend component with the results from the $search property. 
- Helper method to visually distinguish selected rows
- Method to delete selected users
- Helper method to clear checked rows
Pagination is also used
*/
namespace App\Livewire;

use Livewire\WithPagination;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class ShowUsers extends Component
{

 
    use WithPagination;
    public string $empty = "Korisnici nisu pronađeni...";
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
    //Deleting selected users
    public function deleteUser(User $user):void
    {
        Gate::authorize('delete', $user); //Authorisation for admin
        $deletedUsers = [$this->checkBox];
        User::destroy($deletedUsers[0]);
        $this->count = "";
        
    }
    //Clearing checked
    public function clearCheckbox():void
    {
        $this->checkBox = [];
        $this->count = "";
    }

     //Rendering the users with searched characters and pagination
    public function render()
    {
   
        $users = User::whereAny(["name", "email", "role"], "like", "%" . $this->search . "%")->paginate(5);

        return view("livewire.show-users", ["users" => $users]);
    }
}
