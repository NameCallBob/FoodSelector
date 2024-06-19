<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('private')->insert([
            'account' => 'binbin',
            'password' => Hash::make('binbin'),
            'remember_token' => '',
        ]);
        DB::table('private')->insert([
            'account' => 'yeh',
            'password' => Hash::make('yeh'),
            'remember_token' => '',
        ]);
        DB::table('private')->insert([
            'account' => 'saltygirl',
            'password' => Hash::make('saltygirl'),
            'remember_token' => '',
        ]);
        DB::table('private')->insert([
            'account' => 'tsaitsai',
            'password' => Hash::make('tsaitsai'),
            'remember_token' => '',
        ]);
        DB::table('private')->insert([
            'account' => 'teststore1',
            'password' => Hash::make('teststore1'),
            'remember_token' => '',
        ]);
        DB::table('private')->insert([
            'account' => 'teststore2',
            'password' => Hash::make('teststore2'),
            'remember_token' => '',
        ]);
        DB::table('private')->insert([
            'account' => 'teststore3',
            'password' => Hash::make('teststore3'),
            'remember_token' => '',
        ]);
        DB::table('private')->insert([
            'account' => 'teststore4',
            'password' => Hash::make('teststore4'),
            'remember_token' => '',
        ]);
        DB::table('private')->insert([
            'account' => 'teststore5',
            'password' => Hash::make('teststore5'),
            'remember_token' => '',
        ]);
        DB::table('private')->insert([
            'account' => 'teststore6',
            'password' => Hash::make('teststore6'),
            'remember_token' => '',
        ]);
        DB::table('private')->insert([
            'account' => 'teststore7',
            'password' => Hash::make('teststore7'),
            'remember_token' => '',
        ]);
        DB::table('private')->insert([
            'account' => 'teststore8',
            'password' => Hash::make('teststore8'),
            'remember_token' => '',
        ]);
        DB::table('private')->insert([
            'account' => 'teststore9',
            'password' => Hash::make('teststore9'),
            'remember_token' => '',
        ]);
        DB::table('private')->insert([
            'account' => 'teststore10',
            'password' => Hash::make('teststore10'),
            'remember_token' => '',
        ]);
    }
}
