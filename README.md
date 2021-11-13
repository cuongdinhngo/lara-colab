## Installation
1- After clonned, you go to `lara-docker` directory to start docker

```php
docker-compose up -d
```

2- Check docker containers

```php
docker ps
```

```php
λ docker ps
CONTAINER ID        IMAGE                       COMMAND                  CREATED             STATUS              PORTS                                NAMES
d254f8745bac        lara-docker_apache_server   "/bin/sh -c 'tail -f…"   8 days ago          Up 8 minutes        0.0.0.0:8001->80/tcp                 alpha_apache
0f1cd76a8cab        lara-docker_db_mysql        "docker-entrypoint.s…"   10 days ago         Up 8 minutes        33060/tcp, 0.0.0.0:43306->3306/tcp   alpha_db
6d7d8010eece        lara-docker_nginx_server    "/bin/sh -c 'service…"   10 days ago         Up 8 minutes        0.0.0.0:8000->80/tcp                 alpha_server
```

3- Generate app key & Composer install

```php
docker exec alpha_server cp .env.example .env
docker exec alpha_server cp auth.json.example auth.json
docker exec alpha_server composer install
docker exec alpha_server php artisan key:generate
```

4- Open web browser and start the application

`http://localhost:8000/`


## Multi Languges

The multi languages is stored in DB that user is enable to edit the content.
The demostration is aimed to addresse the number of sql queries is executed in retrieving the message/content corresponding to locale.
There are solutions:

- Generate language file are stored in files within the `resources/lang` directory. More detail at [GenerateLangueFile.php](https://github.com/cuongnd88/multi_languages/blob/master/alpha/app/Console/Commands/GenerateLanguageFile.php)
- Use Cache store via file. More detail at [LanguageController.php](https://github.com/cuongnd88/multi_languages/blob/master/alpha/app/Http/Controllers/Language/LanguageController.php)

## OTP Authentication

The `otp-auth` package is used to authenticate User and verify the right access.

```php
//Generate OTP
Route::get("/notify", function(){
    return App\Models\User::find(1)->notify(new App\Authentication\SendOtp('twilio', 4, 10));
});

//Authenticate by OTP
Route::get("/auth-otp/{otp}", function(){
    return App\Models\User::authByOtp(request()->otp, '84905279285');
});

//Check OTP
Route::get("/check-otp/{otp}", function(){
    return auth()->user->checkOtp(request()->otp);
});
```

Please read more the instruction:
[Laravel OTP Auth](https://github.com/cuongnd88/otp-auth)

## Laravel Delivery Channels

Laravel ships with a handful of notification channels, but you may want to more drivers to deliver notifications via other channels. The `delivery-channels` makes it simple. The Twilio channel is supported:

`routes/web.php`

```php
//Generate OTP
Route::get("/notify", function(){
    return App\Models\User::find(1)->notify(new App\Authentication\SendOtp('twilio', 4, 10));
});

```

Please look at [SentOTP class](https://github.com/cuongnd88/lara-colab/blob/master/alpha/app/Authentication/SendOtp.php)
```php
    /**
     * Get the Twilio / SMS representation of the notification.
     *
     * @param  mixed  $notifiable
     *
     * @return mixed
     */
    public function toTwilio($notifiable)
    {
        return (new TwilioMessage)
                    ->to("+xxxxxx")
                    ->from("+xxxxx")
                    ->body('OTP AUTH is '.$this->otp);
    }
```

You read more detail of [delivery-channels package](https://github.com/cuongnd88/delivery-channels)

## Auto-generated Repository Pattern

The `lara-repository` package assists to automatically generate the Interface, Repository, Model and Controller files in saving your time and supporting to focus on implementing the logic. `Especially, you do not need binding the interface and repository class in Service provider class`

```php
php artisan make:repository --interface=Staff/StaffInterface --repository=Staff/StaffRepository --model=Models/Staff --controller=Staff/StaffController@resource

```

You read more detail of [lara-repository package](https://github.com/cuongnd88/lara-repository)
