<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * @var User
     */
    public $userModel;

    /**
     * UserController constructor.
     *
     * @param User $userModel
     */
    public function __construct(User $userModel)
    {
        $this->userModel = $userModel;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $users = $this->userModel->where('is_entity', 0)->orderBy('created_at', 'DESC')->paginate(10);

        return view('admin.user.index', compact('users'));
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        $user = $this->userModel->find($id);

        return view('admin.user.show', compact('user'));
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $user = $this->userModel->find($id);
        $user->delete();

        return redirect()
            ->route('users.index')
            ->with('success', 'Usuário removido com sucesso!');
    }

    public function edit($id)
    {
        $user = $this->userModel->find($id);
        $ufs = \App\Models\State::select('abbr')->orderBy('abbr')->get();

        return view('admin.user.edit', compact('user', 'ufs'));
    }

    /**
     * @param UserRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UserRequest $request, $id)
    {
        $data = $request->all();
        $user = $this->userModel->find($id);

        if (!empty($data['password'])) {
            $data['password'] = \Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $update = $user->update($data);

        return redirect()
            ->route('users.index')
            ->with('success', 'Dados atualizados com sucesso!');
    }
}
