<?php

namespace Tests\Feature;

use App\Models\Account;
use App\Repository\AccountRepository;
use App\Services\AccountService;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class AccountTest extends TestCase
{
    use DatabaseMigrations;
    
    private $accountModel;
    private $accountRepository;
    private $accountService;

    public function __construct()
    {
        parent::__construct();

        $this->accountModel = new Account();
        $this->accountRepository = new AccountRepository($this->accountModel);
        $this->accountService = new AccountService($this->accountRepository);
    }
        
    /** @test */
    public function reset_all_data_front_start_tests()
    {
        $response = $this->post('/reset');

        $response->assertStatus(200);
    }

    /** @test */
    public function view_balance_of_account()
    {
        $response = $this->post('/reset');
        
        $response = $this->get('/balance?account_id=100');

        $response->assertStatus(200);
    }

    /** @test */
    public function create_new_account()
    {
        $data = [
            'type' => 'deposit',
            'destination' => 105,
            'amount' => 10
        ];

        // $return = [
        //     "destination" => [
        //         "id" => "105",
        //         "balance" => 10
        //     ]
        // ];

        $response = $this->post('/event', $data);

        $response->assertStatus(200);

        // $response->assertExactJson($return);

        // {"destination": {"id":"100", "balance":10}}
    }
}
