<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function reordenarIDs()
    {
        \DB::statement('SET FOREIGN_KEY_CHECKS = 0;');

        \DB::statement('SET @num := 0;');
        \DB::statement('UPDATE users SET id = (@num := @num + 1) ORDER BY id;');

        \DB::statement('ALTER TABLE users AUTO_INCREMENT = 1;');

        \DB::statement('SET FOREIGN_KEY_CHECKS = 1;');

        return redirect()->back()->with('success', 'IDs renumerados correctamente.');
    }
}
