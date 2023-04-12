<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Artisan;
use Validator;
class CommandController extends Controller
{
    public function seedData()
    {
        Artisan::call('migrate:fresh --seed --database="mysql"');
        Artisan::call('migrate:fresh --seed --database="mysql2"');

        return json_encode("data migration successful");
    }

    public function generateDoc()
    {
        Artisan::call('generate:docs');

        return json_encode("API doc generated successfully");
    }

    public function viewDoc()
    {
        return storage_path('/app/public/docs/index.html');
    }
}
