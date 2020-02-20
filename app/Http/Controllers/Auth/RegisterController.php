<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showRegistrationForm()
    {
        $ufs = \App\Models\State::select('abbr')->orderBy('abbr')->get();

        return view('auth.register', compact('ufs'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showRegistrationFormEntity()
    {
        $ufs = \App\Models\State::select('abbr')->orderBy('abbr')->get();

        return view('auth.entity-register', compact('ufs'));
    }

    public function entityRegister(Request $request)
    {
        $data = $request->all();
        Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'document' => ['required'],
            'document_type' => ['required'],
            'phone' => ['required'],
            'city_id' => ['required'],
            'address' => ['required'],
            'neighborhood' => ['required'],
            'image' => ['required', 'image']
        ])->validate();

        $verifyDocument = \App\Models\Entity::where('document_type', $data['document_type'])->where('document', preg_replace('/[^0-9]/', '', $data['document']))->count();

        if ($verifyDocument != 0) {
            return redirect()
                ->route('entity-register')
                ->with('error', 'Já existe uma entidade com esse documento cadastrada!');
        }

        $imageName = md5(mt_rand()).'.'.$data['image']->getClientOriginalExtension();
        $data['image']->move(public_path('uploads/'), $imageName);
        \Image::make(public_path('uploads/' . $imageName))->fit(config('app.upload_width'), config('app.upload_height'))->save(public_path('uploads/' . $imageName));

        $entity = \App\Models\Entity::create([
            'city_id' => $data['city_id'],
            'document' => $data['document'],
            'document_type' => $data['document_type'],
            'corporate_name' => $data['corporate_name'],
            'image' => $imageName,
            'name' => $data['name'],
            'phone' => $data['phone'],
            'address' => $data['address'],
            'neighborhood' => $data['neighborhood'],
            'cep' => $data['cep'],
            'description_payment' => ''
        ]);

        $user = User::create([
            'name' => $data['corporate_name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'is_entity' => 1,
            'entity_id' => $entity->id,
        ]);

        $this->guard()->login($user);

        return $this->registered($request, $user)
            ?: redirect($this->redirectPath());
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,NULL,id,deleted_at,NULL'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'document' => ['required'],
            'phone' => ['required'],
            'city_id' => ['required']
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'is_entity' => 0,
            'document' => $data['document'],
            'phone' => $data['phone'],
            'city_id' => $data['city_id'],
        ]);
    }
}
