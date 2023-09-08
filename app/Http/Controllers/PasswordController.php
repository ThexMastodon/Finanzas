<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Admin\HomeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class PasswordController extends Controller
{
  public function showChangeForm()
  {
    return view('auth.passwords.change');
  }

  public function change(Request $request)
  {

    $customMessages = [
      'required' => 'El campo no puede ir vacio',
      'confirmed' => 'Las contraseñas no coinciden',
      'min' => 'La contraseña debe tener al menos 8 caracteres',
    ];
    $request->validate([
      'password' => 'required|confirmed|min:8',
    ], $customMessages);

    $user = Auth::user();
    $user->password = Hash::make($request->input('password'));
    $user->password_changed_at = now();
    $user->save();

    return redirect()->route('admin.home')->with('success', '¡Contraseña cambiada exitosamente!');
  }
}
