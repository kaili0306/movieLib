<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Bouncer;
use App\User;

class InitBouncer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Init:Bouncer';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Initialize Bouncer';

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
        //Define roles
        $admin = Bouncer::role()->create([
            'name' => 'admin',
            'title' => 'Administrator',
        ]);

        $rater = Bouncer::role()->create([
            'name' => 'rater',
            'title' => 'rater',
        ]);

        $member = Bouncer::role()->create([
            'name' => 'member',
            'title' => 'Member',
        ]);

        //Define abilities

        $manageMovies = Bouncer::ability()->create([
            'name' => 'manage-movies',
            'title' => 'Manage Movies',
        ]);

        $manageRaters = Bouncer::ability()->create([
            'name' => 'manage-raters',
            'title' => 'Manage Raters',
        ]);

        $manageComments = Bouncer::ability()->create([
            'name' => 'manage-comments',
            'title' => 'Manage Comments',
        ]);

        $viewMovies = Bouncer::ability()->create([
            'name' => 'view-movies',
            'title' => 'View Movies',
        ]);

        $viewComments = Bouncer::ability()->create([
            'name' => 'view-comments',
            'title' => 'View Comments',
        ]);

        // Assign abilities to roles
        Bouncer::allow($admin)->to($manageMovies);
        Bouncer::allow($admin)->to($manageRaters);
        Bouncer::allow($admin)->to($viewMovies);
        Bouncer::allow($admin)->to($viewComments);

        Bouncer::allow($rater)->to($manageComments);
        Bouncer::allow($rater)->to($viewMovies);
        Bouncer::allow($rater)->to($viewComments);

        Bouncer::allow($member)->to($viewMovies);
        Bouncer::allow($member)->to($viewComments);

        // Assign role to users
        $user = User::where('email', 'admin@gmail.com')->first();
        Bouncer::assign($admin)->to($user);

        $user = User::where('email', 'womanOfWonder@hotmail.com')->first();
        Bouncer::assign($rater)->to($user);

        $user = User::where('email', 'captain@gmail.com')->first();
        Bouncer::assign($member)->to($user);

    }
}
