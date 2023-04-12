<?php

namespace App\Console\Commands;
use App\Helpers\Decrypt;
use App\Models\KeycloakSettings;
use Ixudra\Curl\Facades\Curl;
use Illuminate\Console\Command;

class ApiTest extends Command
{
/**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'api:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test call';

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
     * @return int
     */
    public function handle()
    {
        $auth = $this->choice(
            'Does API required user to be login first?',
            ['NO', 'YES'],
            0
        );

        $method = $this->choice(
            'Please enter method',
            ['GET', 'POST'],
            0
        );

        $module = $this->choice(
            'Please state API module',
            ['module0','module1','module2','module3','module4','module5','module6','module7'],
            0
        );
        // $method = $this->anticipate('Please enter method', ['GET','POST']);
        $apiname = $this->anticipate('Please state API path after api/moduleX/ (Example. Try key-in: demo-data)', ['']);
        $jsondata = $this->anticipate('Please state JSON data if any (Example. Try key-in: {"DATA":"abu"}', ['']);

        $data = new Decrypt();
        $admin = $data->keycloakAdminPass();

        $setting = KeycloakSettings::where('KEYCLOAK_REALM_NAME', 'master')
            ->first();

        $token = Curl::to($setting->KEYCLOAK_TOKEN_URL)

            ->withData([
                'username' => $admin['username'],
                'password' => $admin['password'],
                'client_id' => $setting->KEYCLOAK_CLIENT_ID,
                'grant_type' => 'password',
                'client_secret' => $setting->KEYCLOAK_CLIENT_SECRET,
            ])
            ->post();

        $token = json_decode($token, true);

        $token = $token['access_token'];

        switch($module){
            case 'module0':
                $apipath = 'http://localhost:'.env('MODULE0_PORT', 0). '/api/module0/' . $apiname;
            break;
            case 'module1':
                $apipath = 'http://localhost:'.env('MODULE1_PORT', 0). '/api/module1/' . $apiname;
            break;
            case 'module2':
                $apipath = 'http://localhost:'.env('MODULE2_PORT', 0). '/api/module2/' . $apiname;
            break;
            case 'module3':
                $apipath = 'http://localhost:'.env('MODULE3_PORT', 0). '/api/module3/' . $apiname;
            break;
            case 'module4':
                $apipath = 'http://localhost:'.env('MODULE4_PORT', 0). '/api/module4/' . $apiname;
            break;
            case 'module5':
                $apipath = 'http://localhost:'.env('MODULE5_PORT', 0). '/api/module5/' . $apiname;
            break;
            case 'module6':
                $apipath = 'http://localhost:'.env('MODULE6_PORT', 0). '/api/module6/' . $apiname;
            break;
            case 'module7':
                $apipath = 'http://localhost:'.env('MODULE7_PORT', 0). '/api/module7/' . $apiname;
            break;
        }

        $jsonArray = json_decode($jsondata,true);

        // print_r($jsonArray);
        if($method == 'GET'){

            if($auth === 'NO'){

                $response = Curl::to($apipath)
                ->withData( $jsonArray )
                ->get();
            }else{

                $response = Curl::to($apipath)
                ->withBearer($token)
                ->withData( $jsonArray )
                ->get();
            }
        }else{

            if($auth === 'NO'){
                $response = Curl::to($apipath)
                ->withData( $jsonArray )
                ->post();
            }else{
                $response = Curl::to($apipath)
                ->withBearer($token)
                ->withData( $jsonArray )
                ->post();
            }
        }

        echo $response;

    }
}

