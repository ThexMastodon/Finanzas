<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
  /*
  |--------------------------------------------------------------------------
  | Login Controller
  |--------------------------------------------------------------------------
  |
  | This controller handles authenticating users for the application and
  | redirecting them to your home screen. The controller uses a trait
  | to conveniently provide its functionality to your applications.
  |
  */

  use AuthenticatesUsers;

  public function login(Request $request)
  {
    $this->validate($request, [
      'email' => 'required|string',
      'password' => 'required|string',
    ]);

    $field = filter_var($request->input('email'), FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
    $request->merge([$field => $request->input('email')]);

    $user = User::where($field, $request->input($field))->first();

    if ($user && $user->active && Auth::attempt($request->only($field, 'password'))) {
      // Verificar si el usuario necesita cambiar la contraseña
      if ($user->password_changed_at === null) {
        return redirect()->route('pwd.change');
      }

      return redirect()->intended('admin');
    }

    $errorMsg = $user && !$user->active ? 'Unsubscribed User' : 'Invalid Username or Password';
    return $this->sendFailedLoginResponse($request, $errorMsg);
  }

  protected function sendFailedLoginResponse(Request $request, $errorMsg)
  {
    throw ValidationException::withMessages([
      $this->username() => [$errorMsg],
    ]);
  }

  /**
   * Where to redirect users after login.
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
    $this->middleware('guest')->except('logout');
  }

  protected function authenticated(Request $request, $user)
  {
    if ($user->password_changed_at === null) {
      return redirect()->route('pwd.change');
    }

    return redirect()->intended($this->redirectPath());
  }
}
