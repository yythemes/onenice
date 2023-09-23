<?php

namespace vessel\optimize;

class Optimize{

    /**
	 * Constructor
	 */
	public function __construct(){
	    new includes\Advanced;
        new includes\GlobalOptimize;
        if(is_admin()){
            new includes\AdminOptimize;
        }
        else{
            new includes\GuestOptimize;
        }
	}
}