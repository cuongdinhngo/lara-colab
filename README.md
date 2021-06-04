## Multi Languges

The multi languages is stored in DB that user is enable to edit the content.
The demostration is aimed to addresse the number of sql queries is executed in retrieving the message/content corresponding to locale.
There are solutions:

- Generate language file are stored in files within the `resources/lang` directory. More detail at [GenerateLangueFile.php](https://github.com/cuongnd88/multi_languages/blob/master/alpha/app/Console/Commands/GenerateLanguageFile.php)
- Use Cache store via file. More detail at [LanguageController.php](https://github.com/cuongnd88/multi_languages/blob/master/alpha/app/Http/Controllers/Language/LanguageController.php)
