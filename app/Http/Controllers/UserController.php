<?php
//Used mainly for admin user manipulation
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Gate;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;

use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    }

    /**
     * Show the form for creating a new resource. (Note: this is not needed all the time)
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, User $user): RedirectResponse
    {
        Gate::authorize('create', $user); //Authorisation for admin
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        
        $user->role = $request->role;
        $user->save();

        return redirect()->back()->with("status", "Novi korisnik je uspješno dodan!");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource (user data).
     */
    public function edit(string $id):mixed
    {
        $wantedUser = User::find($id);
        $user = auth()->user();
        Gate::authorize('create', $user);
        return view('edituser')->with(["name" => $wantedUser->name, "email" => $wantedUser->email, "id" => $id]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user):RedirectResponse
    {

        if ($request->name && $request->email && $request->role) {
            $request->validate([
                'name' => ['string', 'max:255'],
                'email' => ['string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
                'role' => ['required'],
            ]);
            User::where("id", $user->id)->update(['name' => $request->name, 'email' => $request->email, 'role' => $request->role]);

            return redirect()->back()->with("status", "Korisnik je uspješno ažuriran!");
        } else if ($request->name) {
            $request->validate([
                'name' => ['string', 'max:255'],
            ]);
            User::where("id", $user->id)->update(['name' => $request->name]);
            return redirect()->back()->with("status", "Korisnikovo ime je izmijenjeno uspješno!");
        } else if ($request->role) {
            $request->validate([
                'role' => ['required'],
            ]);
            User::where("id", $user->id)->update(['role' => $request->role]);
            return redirect()->back()->with("status", "Korisnikova uloga je izmijenjena uspješno");
        } else {
            $request->validate([
                'email' => ['string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            ]);
            User::where("id", $user->id)->update(['email' => $request->email]);
            return redirect()->back()->with("status", "Korisnikov mail je izmijenjen uspješno");
        }
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

}
