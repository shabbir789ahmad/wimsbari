<?php

use Illuminate\Support\Facades\Auth;
function branch_id($data)
{
	return array_merge($data,['branch_id'=>auth::user()->branch_id]);
}

?>