<?php

namespace App\Authentication;

trait HasOtpAuth
{
    /**
     * Check OTP
     *
     * @return bool
     */
    public function checkOtp($otp)
    {
        $authenticator = $this->otp();
        return $this->validateOtp($authenticator, $otp);
    }

    /**
     * Get OTP data
     *
     * @return \Illuminate\Notifications\DatabaseNotification
     */
    public function otp()
    {
        return $this->notifications()
                ->where('type', 'LIKE', '%SendOtp%')
                ->whereNull('read_at')
                ->first();
    }

    /**
     * Validate OTP
     *
     * @param \Illuminate\Notifications\DatabaseNotification $authenticator
     * @param mixed $otp
     *
     * @return void
     */
    public function validateOtp($authenticator, $otp)
    {
        $result = false;
        if (is_null($authenticator)) {
            return response()->json($result,200);
        }
        if ($authenticator
            && now()->lte($authenticator->data['expired_at'])
            && $authenticator->data['otp'] == $otp
        ) {
            $result = true;
        }
        $authenticator->markAsRead();
        return response()->json($result,200);
    }

    /**
     * Authenticate by OTP
     *
     * @param string $otp
     * @param string $credentialValue
     * @return void
     */
    public static function authByOtp($otp, $credentialValue)
    {
        $model = new static;
        $credentialName = property_exists($model,'credential') ? $model->credential : 'email';

        $authenticator = $model->where($credentialName, '=', $credentialValue)->first();
        if (is_null($authenticator)) {
            return response()->json(false,200);
        }

        $authenticator = $authenticator->notifications()
                    ->where('type', 'LIKE', '%SendOtp%')
                    ->whereNull('read_at')
                    ->first();

        return $model->validateOtp($authenticator, $otp);
    }
}