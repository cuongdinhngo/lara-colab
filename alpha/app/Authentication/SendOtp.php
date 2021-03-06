<?php

namespace App\Authentication;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Cuongnd88\DeliveryChannel\Messages\TwilioMessage;

class SendOtp extends Notification
{
    use Queueable;

    protected $defaultChannels = ['database'];

    protected $otp;

    protected $lifeTime;

    const OPT_LIFETIME = 1;

    const OPT_LENGTH = 6;

    /**
     * Construct
     *
     * @param array|string $channels
     * @param integer|string $otpLength
     * @param integer|string $lifeTime
     */
    public function __construct($channels = null, $otpLength = null, $lifeTime = null)
    {
        $this->otp = $this->generateOtp($otpLength ?? self::OPT_LENGTH);
        $this->lifeTime = $lifeTime ?? self::OPT_LIFETIME;
        $this->defaultChannels = $this->verifyChannels($channels);
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return $this->defaultChannels;
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('Your OTP is '.$this->otp)
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'otp' => $this->otp,
            'expired_at' => now()->addMinutes($this->lifeTime)->toDateTimeString(),
        ];
    }

    /**
     * Get the Twilio / SMS representation of the notification.
     *
     * @param  mixed  $notifiable
     *
     * @return mixed
     */
    public function toTwilio($notifiable)
    {
        // return [
        //     'to' => "+84xxxxxxxxxx",
        //     'body' => 'OTP AUTH is '.$this->otp
        // ];
        return (new TwilioMessage)
                    ->to("+8439xxxxxxx")
                    ->from("+xxxxxxxxxx")
                    ->body('OTP AUTH is '.$this->otp);
    }

    /**
     * Generate OTP
     *
     * @param integer|string $n
     *
     * @return string
     */
    public function generateOtp($n)
    {
        $generator = "0987654321";
        $result = "";

        for ($i = 1; $i <= $n; $i++) {
            $result .= substr($generator, (rand()%(strlen($generator))), 1);
        }
        return $result;
    }

    /**
     * Verify channels
     *
     * @param string|array $channels
     *
     * @return array
     */
    public function verifyChannels($channels)
    {
        if ($channels && is_array($channels)) {
            return array_merge($this->defaultChannels, $channels);
        }
        if ($channels && is_string($channels)) {
            array_push($this->defaultChannels, $channels);
        }
        return $this->defaultChannels;
    }
}
