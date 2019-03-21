<?php
/**
 * Copyright (c) 2019. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
 * Morbi non lorem porttitor neque feugiat blandit. Ut vitae ipsum eget quam lacinia accumsan.
 * Etiam sed turpis ac ipsum condimentum fringilla. Maecenas magna.
 * Proin dapibus sapien vel ante. Aliquam erat volutpat. Pellentesque sagittis ligula eget metus.
 * Vestibulum commodo. Ut rhoncus gravida arcu.
 */

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GithubController extends Controller
{
    public function webhook(Request $request)
    {
        if ($this->requestMethod() == 'POST') {
            $branch = config('crucis.github_webhook_branch');
            $base_path = config('crucis.root_path');
            system_log('Github webhook.', "post请求已被接受,拉取{$branch}分支,start git cmd.", 'github', 0, 'github', $request->ip());
            $cmd = "cd {$base_path};sudo git checkout {$branch};sudo git pull origin {$branch}:{$branch};";
            $output = shell_exec($cmd);
            system_log('Github webhook.', $output, 'github', 0, 'github', $request->ip());
        }
    }
}
