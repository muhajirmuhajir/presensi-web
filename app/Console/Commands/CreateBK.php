<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Events\UserCreateEvent;
use Illuminate\Console\Command;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Validator;

class CreateBK extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:bk {email?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create user BK';

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
        $email = $this->askValid(
            'Email',
            'email',
            ['required', 'email'],
        );

        $name = $this->askValid(
            'Name',
            'name',
            ['required'],
        );

        $user = User::factory()->create(['name' => $name, 'email' => $email]);
        $bk = Role::firstOrCreate(['name' => config('enums.roles.bk')],[]);
        $user->assignRole($bk);

        event(new UserCreateEvent($user));


        return Command::SUCCESS;
    }

    protected function askValid($question, $field, $rules)
    {
        $value = $this->ask($question);

        if ($message = $this->validateInput($rules, $field, $value)) {
            $this->error($message);

            return $this->askValid($question, $field, $rules);
        }

        return $value;
    }


    protected function validateInput($rules, $fieldName, $value)
    {
        $validator = Validator::make([
            $fieldName => $value
        ], [
            $fieldName => $rules
        ]);

        return $validator->fails()
            ? $validator->errors()->first($fieldName)
            : null;
    }
}
