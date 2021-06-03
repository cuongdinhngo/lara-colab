<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\Language\LanguageService;
use File;
use Illuminate\Support\Collection;

class GenerateLanguageFile extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:lang {locale?} {directoryPath?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    const DEFAUT_DIRECTORY = 'resources/lang/';

    protected $directoryPath;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $locale = $this->argument('locale') ?? null;
        $this->setDirectory();

        $select = [
            'languages.locale as language_locale',
            'm.key',
            'm.content',
        ];
        $where = is_null($locale) ? [] : [['languages.locale', '=', $locale]];

        $data = $this->groupLanguageDataByAlias($where, $select);
        $this->generateMessageFile($data);
    }

    public function setDirectory()
    {
        $this->directoryPath = $this->argument('directoryPath') ?? self::DEFAUT_DIRECTORY;
    }

    public function getDirectory()
    {
        return $this->directoryPath;
    }

    /**
     * Language data is grouped by alias
     *
     * @param  array $where  where condition
     * @param  array $select selected columns
     *
     * @return Collection
     */
    public function groupLanguageDataByAlias($where, $select): Collection
    {
        return app(LanguageService::class)
                    ->getLanguageMessages($where, $select)
                    ->mapToGroups(function ($item) {
                        return [$item['language_locale'] => [$item['key'] => $item['content']]];
                    });
    }

    /**
     * To generate message file
     *
     * @param  Collection $data Data
     *
     * @return void
     */
    public function generateMessageFile($data)
    {
        $directoryPath = $this->getDirectory();
        foreach ($data as $lang => $messages) {
            $path = $directoryPath."$lang";
            if (File::missing($path)) {
                File::makeDirectory($path);
            }
            $filePath = "$path/messages.php";
            $content = $messages->collapse()->all();
            File::put(
                $filePath,
                '<?php '.PHP_EOL.''.PHP_EOL.'return '.var_export($content, true).';'.PHP_EOL
            );
        }
    }
}
