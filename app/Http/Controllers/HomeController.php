<?php
namespace App\Http\Controllers;

use App\Google;
use App\User;
use App\Calendar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
   public function index()
   {
        return view('login');
   }

   public function login(Google $google, User $user, Request $request)
   {
        $client = $google->client();
        if ($request->has('code')) {

            $client->authenticate($request->get('code'));
            $token = $client->getAccessToken();

            $plus = new \Google_Service_Plus($client);

            $google_user = $plus->people->get('me');

            $id = $google_user['id'];

            $email = $google_user['emails'][0]['value'];
            $first_name = $google_user['name']['givenName'];
            $last_name = $google_user['name']['familyName'];

            $has_user = $user->where('email', '=', $email)->first();

            if (!$has_user) {
                //not yet registered
                $user->email = $email;
                $user->first_name = $first_name;
                $user->last_name = $last_name;
                $user->token = json_encode($token);
                $user->save();
                $user_id = $user->id;
            } else {
                $user_id = $has_user->id;
                $user = $has_user;
            }

            if (Auth::loginUsingId($user->id)) {
                return redirect('/dashboard');
            }

        } else {
            $auth_url = $client->createAuthUrl();
            return redirect($auth_url);
        }
   }
}