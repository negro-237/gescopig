<?php
/**
* @file UserController.php
* Contrôleur des utilisateurs du système
* @date 2022
*/

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserRequest;
use App\Models\Role;
use App\Repositories\UserRepository;
use App\User;
use Illuminate\Http\Request;
use Laracasts\Flash\Flash;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use DB;

class UserController extends Controller
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->middleware('auth');
        $this->middleware(['role:Admin']);
        $this->userRepository = $userRepository;
    }

    /**
    * Afficher la liste des utilisateurs
    * @return \Illuminate\Http\Response
    *
    */
    public function index()
    {
        $users = $this->userRepository->orderBy('id', 'desc')->get();
        return view('users.index', compact('users'));
    }

    /**
     * Afficher le formulaire de création des utilisateurs
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::all();
        return view('users.create', compact('roles'));
    }

    /**
     * Enregistrer un utilisateur
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateUserRequest $request)
    {

        $user = $this->userRepository->create($request->except('roles'));

        if($request->roles <> ''){
            $user->assignRole($request->roles);
        }
        Flash::success('User created successfully');
        return redirect()->route('users.index');
    }

    /**
     * Afficher les informations d'un utilisateur
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Afficher le formulaire de modification des utilisateurs
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = $this->userRepository->findWithoutFail($id);
        $roles = Role::all();

        return view('users.edit', compact('user', 'roles'));
    }

    /**
     * Modifier un utilisateur.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = $this->userRepository->findWithoutFail($id);
        $input = $request->except('roles');
        $this->userRepository->update($input, $user->id);

        if($request->roles <> ''){
            $user->syncRoles($request->roles);
        }
        else{
            $user->roles()->detach();
        }

        Flash::success('User updated sucesfully');

        return redirect()->route('users.index');
    }

    /**
     * Supprimer un utilisateur.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        Flash::success('User updated sucesfully');

        return redirect()->route('users.index');
    }

    /**
     * Permettre à un utilisateur d'afficher le formulaire de modification de son mot de passe
     *
     * @return \Illuminate\Http\Response
     */
    public function password(){
        return view('users.password');
    }

    /**
     * Modifier son mot de passe
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function changePassword(Request $request){
        $validatedData = $request->validate([
            'password' => 'min:8|required_with:confirm|same:confirmer',
        ]);
        $oldPassword = $request->input('oldPassword');
        $password = $request->input('password');
        if(Hash::check($oldPassword, Auth::user()->password)){
            $id = Auth::user()->id;
            $user = User::findOrFail($id); 
            $user->password = $password;

            $user->save();
            
            return back()->with('success','mot de passe modifé avec succès.');
        }else{
            return back()->with('error','Le mot de passe saisi ne correspond pas à votre ancien mot de passe.'); 
        }
    }

    /**
     * Afficher la liste des utilisateurs, leur dernière connexion et les adresses ip des machines utilisées  
     *
     * @return \Illuminate\Http\Response
     */
    public function userLogs(){
        $users = User::all();
        return view('users.users-logs', compact('users'));
    } 

    /**
     * Afficher les logs d'un utilisateurs.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showUserLogs($id){
        $user = User::findOrFail($id);
        $logs = DB::table('revisions')
        ->where('user_id', $id)
        ->get();
        return view('users.show-logs', compact('logs', 'user'));
    }

}
