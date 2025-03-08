<?php

namespace YourNamespace\AppSumo\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use YourNamespace\AppSumo\AppSumo;

class OAuthController extends Controller
{
    /**
     * Handle the OAuth callback from AppSumo.
     */
    public function callback(Request $request)
    {
        $code = $request->query('code');

        if (!$code) {
            return redirect('/')->withErrors('No code provided');
        }

        $appsumo = new AppSumo();
        $tokenData = $appsumo->getAccessToken($code);

        if (isset($tokenData['access_token'])) {
            $licenseData = $appsumo->getLicense($tokenData['access_token']);

            // Process the license data (e.g., create or update the user account)
            // For example purposes, we simply return the license information.
            return response()->json([
                'access_token' => $tokenData['access_token'],
                'license'      => $licenseData,
            ]);
        }

        return redirect('/')->withErrors('Error retrieving access token.');
    }
}
