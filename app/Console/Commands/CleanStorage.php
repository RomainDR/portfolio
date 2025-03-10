<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class CleanStorage extends Command
{
    protected $signature = 'storage:clean';
    protected $description = 'Nettoyer le dossier storage/app/public';

    public function handle()
    {
        // Supprimer tous les fichiers dans storage/app/public
        $files = Storage::allFiles('public');
        Storage::delete($files);

        $this->info('Le dossier storage/app/public a été nettoyé.');
    }
}
