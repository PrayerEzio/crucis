<?php

namespace App\Http\Controllers\Admin;

class SystemController extends CommonController
{
    public function phpinfo()
    {
        phpinfo();
    }

    public function tz()
    {
        return view('Admin.System.tz');
    }
}
