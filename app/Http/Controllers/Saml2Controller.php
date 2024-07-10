<?php

namespace App\Http\Controllers;

use Aacotroneo\Saml2\Http\Controllers\Saml2Controller as BaseController;
use Aacotroneo\Saml2\Saml2Auth;
use Illuminate\Support\Facades\Auth;
use App\Models\User; // Userモデルをインポート

class Saml2Controller
{
  public function acs(Saml2Auth $saml2Auth, $idpName)
  {
    $saml2Auth = app('Aacotroneo\Saml2\Saml2Auth');
    $errors = $saml2Auth->acs();

    if (!empty($errors)) {
      dd($errors);
      abort(500, 'SAML ACS Error: ' . implode(', ', $errors));
    }

    $saml2User = $saml2Auth->getSaml2User();
    $userData = [
      'id' => $saml2User->getUserId(),
      'email' => $saml2User->getAttribute('email'),
      'name' => $saml2User->getAttribute('name'),
    ];

    // ユーザーが存在しない場合、作成する
    $laravelUser = User::firstOrCreate([
      'email' => $userData['id'],
    ], [
      'email' => $userData['id'],
      'name' => "test",
      'password' => "test",
    ]);

    Auth::login($laravelUser);

    return redirect()->intended('/success');
  }
}
