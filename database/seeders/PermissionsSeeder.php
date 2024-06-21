<?php
namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PermissionsSeeder extends Seeder
{
    public function run(): void{
        DB::table("permissions")->insert([
            'action_name' => 'collect.create'
        ]);
        DB::table("permissions")->insert([
            'action_name' => 'collect.read'
        ]);
        DB::table("permissions")->insert([
            'action_name' => 'collect.delete'
        ]);
        DB::table("permissions")->insert([
            'action_name' => 'store.info'
        ]);
        DB::table("permissions")->insert([
            'action_name' => 'store.changeinfo'
        ]);
        DB::table("permissions")->insert([
            'action_name' => 'store.getlookAndCollect'
        ]);
        DB::table("permissions")->insert([
            'action_name' => 'product.collect_rank'
        ]);
        DB::table("permissions")->insert([
            'action_name' => 'product.edit.status'
        ]);
        DB::table("permissions")->insert([
            'action_name' => 'product.edit.update'
        ]);
        DB::table("permissions")->insert([
            'action_name' => 'product.edit.create'
        ]);
        DB::table("permissions")->insert([
            'action_name' => 'product.edit.delete'
        ]);
        DB::table("permissions")->insert([
            'action_name' => 'product.edit.all'
        ]);
    }
}