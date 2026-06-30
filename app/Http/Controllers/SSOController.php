<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use League\OAuth2\Client\Provider\GenericProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\User;

class SSOController extends Controller
{
    public function redirectToProvider()
    {

        $provider = $this->provider();
        $authUrl = $provider->getAuthorizationUrl();

     //   $authUrl = $provider->getAuthorizationUrl();
        session(['oauth2state' => $provider->getState()]);

        return redirect($authUrl);
    }

    public function handleCallback(Request $request)
    {

  
        $provider = $this->provider();
       // Log::info('OAuth token response', ['body' => $request->all()]);

        $sessionState = session()->pull('oauth2state');

        if (!$request->has('code') || $request->get('state') !== $sessionState) {                  
            return redirect('/auth/login')->withErrors('Invalid OAuth state.');
        }


        try {
            $token = $provider->getAccessToken('authorization_code', [
                'code' => $request->get('code')
            ]);
  
           


                //             echo $accessToken = $token->getToken();
                //             echo '<br>';

                //             // // Expiration time (UNIX timestamp)
                //             echo $expires = $token->getExpires();
                //             echo '<br>';
                //             // // Convert to readable format
                //             echo $expiresAt = \Carbon\Carbon::createFromTimestamp($expires)->toDateTimeString();
                //             echo '<br>';
                //             // echo $accessToken.'   '.$expires.'   '.$expiresAt;die;
                // //             Log::info('Access Token Info', [
                // //     'token' => $accessToken,
                // //     'expires' => $expires,
                // //     'expiresAt' => $expiresAt,
                // // ]);
            if ($token->hasExpired()) {
                Log::warning("Access token has expired");
                return redirect('/auth/login')->withErrors('Token Expired');
            }
            $user = $provider->getResourceOwner($token);

            $userInfo = $user->toArray();
           
            $appUser = User::whereRaw('LOWER(email) = ?', [strtolower($userInfo['email'])])->where([['status','=','Active']])->first();
            // $appUser = User::updateOrCreate(
            //     ['email' => $userInfo['email']], 
            //     ['status' => 'Active']
            // );
           if($appUser)
           {
              Auth::login($appUser);
              return redirect('/dashboard');
           }
           else
           {
               return redirect('/auth/login')->withErrors('User not Exists.');
           }
            

        }
        catch (\League\OAuth2\Client\Provider\Exception\IdentityProviderException $e) {

            Log::error('Token Exchange Error', [
                'response' => $e->getResponseBody(),
            ]);
            return redirect('/auth/login')->withErrors('Authentication failed: ' . $e->getMessage());
        } 
        // catch (\Exception $e) {
        //     return redirect('/auth/login')->withErrors('Authentication failed: ' . $e->getMessage());
        // }
    }

    private function provider()
    {
        return new GenericProvider([
            'clientId'                => 'BrandIdeaProd',
            'clientSecret'            => 'Fdc63xoXGsFXO925D8ZWoSPRQi2zz6ZReC5fXivivMGrPXkJdvFe1DsnJ8pPZ2vV',
            'redirectUri'             => 'https://analytics.brandidea.com/bilocaview/public/oauth/callback',
            'urlAuthorize'            => 'https://pf.ping.aws.mdlz.com/as/authorization.oauth2',
            'urlAccessToken'          => 'https://pf.ping.aws.mdlz.com/as/token.oauth2',
            'urlResourceOwnerDetails' => 'https://pf.ping.aws.mdlz.com/idp/userinfo.openid',
            'scopes'                  =>  'openid email profile'
        ]);
    }
}  