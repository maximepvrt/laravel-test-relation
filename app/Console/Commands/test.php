<?php

namespace App\Console\Commands;

use App\Models\Group;
use App\Models\GroupPivot;
use App\Models\User;
use Illuminate\Console\Command;

class test extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        User::query()->delete();
        Group::query()->delete();

        $user = User::create(['email' => 'test@test.com', 'name' => 'test', 'password' => '*********']);
        $group1 = Group::create(['name' => 'Group 1']);
        $group2 = Group::create(['name' => 'Group 2']);

        $this->info('attach group');
        $user->groups()->attach([$group1->id => ['status' => GroupPivot::STATUS_PENDING]]);
        $this->info('update pivot group');
        $user->groups()->updateExistingPivot($group1->id, ['status' => GroupPivot::STATUS_ACCEPTED]);

        $this->info('attach group with wherePivot');
        $user->groups()->wherePivot('status', GroupPivot::STATUS_PENDING)->attach([$group2->id => ['status' => GroupPivot::STATUS_PENDING]]);
        $this->info('update pivot group with wherePivot');
        $user->groups()->wherePivot('status', GroupPivot::STATUS_PENDING)->updateExistingPivot($group2->id, ['status' => GroupPivot::STATUS_ACCEPTED]);
    }
}
