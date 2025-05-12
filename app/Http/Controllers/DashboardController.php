<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $data = [];

        if (auth()->user()->hasRole('super-admin')) {
            $data['totalUsers'] = 125;
            $data['totalAdmins'] = 8;
            $data['totalCards'] = 350;
            $data['totalTemplates'] = 12;
        } elseif (auth()->user()->hasRole('admin')) {
            $data['departmentUsers'] = 42;
        } else {
            $data['userCards'] = 3;
        }

        $data['userBusinessCards'] = [
            (object)[
                'id' => 1,
                'name' => 'Corporate Card',
                'created_at' => '2023-08-15',
                'status' => 'approved'
            ],
            (object)[
                'id' => 2,
                'name' => 'Event Card',
                'created_at' => '2023-09-20',
                'status' => 'pending'
            ]
        ];

        $data['pendingApprovalCards'] = [
            (object)[
                'id' => 2,
                'name' => 'Event Card',
                'user_name' => 'John Doe',
                'created_at' => '2023-09-20'
            ],
            (object)[
                'id' => 3,
                'name' => 'Sales Card',
                'user_name' => 'Jane Smith',
                'created_at' => '2023-09-22'
            ]
        ];

        return view('dashboard.index', $data);
    }
}
