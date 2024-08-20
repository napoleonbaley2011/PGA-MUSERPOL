<?php

namespace App\Http\Controllers;

use App\Helpers\Ldap;
use Illuminate\Http\Request;

class LdapController extends Controller
{
    public function list_persons_ldap()
    {
        $ldap = new Ldap();

        $user = $ldap->get_entry('aguisbert', 'uid')['employeeNumber'];
        return $user;

        // if ($ldap->bind('lbautista', '9994084')) {
        //     return "verdad";
        // } else {
        //     return "false";
        // }
        // if ($ldap) {
        //     return response()->json($ldap->list_entries());
        // } else {
        //     return false;
        // }
    }
}
