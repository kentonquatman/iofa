<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');     

class EE_Cocoa {
	var $EE_VERSION		 = 2;  
	
	// Author & Copyright: Padraig Kennedy, June 2011.
	
	// This is distributed as a component to an app and may only be used 
	// as intended by the app.  Please contact me at padraig.kennedy@gmail.com 
	// if you would like to discuss using it for any other purpose.
	
	// This abstract superclass should be subclassed to customise it for 
	// the app that will communicate with it.
	
	// The 'api' class is called with a post variable named 'data' containing
	// a json object that includes a 'command' variable.
	// Whatever is in the command variable will be called in the subclass with 
	// an 'api' prefix.
	
	// E.G.  {'command':'status'} would call $this->api_status($json_request)
	// api_status would be defined in the subclass.
	// Any data to be returned should be added to the $this->data[] array.
	// This array will be translated to JSON and outputted once the command 
	// function call finishes.

  function EE_Cocoa()
  {
    $this->starttime = microtime(true);
    if (BASEPATH != 1) {
      $this->EE =& get_instance();
      $this->data = array("version" => $this->VERSION);
    }
    if (!function_exists('json_decode')) // PHP 4 doesn't have decode_json()
    {
      $this->EE->load->library('Services_json');
    }
  }
	
	function _finish()
    {
    	$this->EE->load->library('javascript');
    	$this->data["response_time"] = round((microtime(true) - $this->starttime),5);
    	$this->data["ee_version"] = $this->EE_VERSION;  
			//send back an XID to use for the next request.
			$this->data["XID"] = XID_SECURE_HASH;
    	$this->data["site_name"] = $this->EE->config->item('site_short_name');
    	
    	// EE 2.6.1 complains about this
    	// echo $this->EE->javascript->generate_json($this->data);	

      if (!function_exists('json_encode'))
      {
        // use our own copy of the old json method
    	  echo $this->generate_json_old($this->data, true);
      } else {
        // if we have json_encode, use it.
        echo json_encode($this->data);
      }

    	die(); // DO NOT REMOVE THIS
    }
    
    function _is_authorised()
    {
    	return $this->EE->session->userdata['group_id'] == 1;
    }
     
    
    function _start()
    {
  	 	$this->data["logged_in"] 		= $this->EE->session->userdata['session_id']	== "0" ? FALSE:TRUE;
    	$this->data["is_admin"]			= $this->_is_authorised();
    	$this->data["session_id"]		= $this->EE->session->userdata['session_id'];
    
	    if(!$this->data["is_admin"]) 	
	    {
	    	if($this->data["responding_to_command"]=="status")
	       	{
	    		$this->data["site_label"] = $this->EE->config->item('site_label');
	    	   	$this->data["success"] = True;
	       	} 
	       	else
	       	{
       			$this->data["success"] = False;
    		}
       		
    		$this->_finish();
    	}
    
    }
     
    function api()	
    {
    	$this->_start();
    	
    	$instructions = (object)json_decode($this->EE->input->post('data'));
		
		$this->data["responding_to_command"] = @$instructions->command;
		
		if($this->data["responding_to_command"]=="")
		{
			echo "The Module is installed.";
			die();
		}

    	$command = "api_".$this->data["responding_to_command"];
    	
    	$this->$command($instructions);
    	
    	$this->_finish();
    }
    
    function api_logout()
    {
	    $this->EE->load->library('logger');
	    $this->EE->load->library('functions');
    
   		$this->EE->db->where('ip_address', $this->EE->input->ip_address());
		$this->EE->db->where('member_id', $this->EE->session->userdata('member_id'));
		$this->EE->db->delete('online_users');
		
		if(method_exists($this->EE->session,"destroy"))
		{
			$this->EE->session->destroy();
		} else 
		{ 
			$this->EE->db->where('session_id', $this->EE->session->userdata['session_id']);
			$this->EE->db->delete('sessions');
					
			$this->EE->functions->set_cookie($this->EE->session->c_uniqueid);		
			$this->EE->functions->set_cookie($this->EE->session->c_password);	
			$this->EE->functions->set_cookie($this->EE->session->c_session);	
			$this->EE->functions->set_cookie($this->EE->session->c_expire);	
			$this->EE->functions->set_cookie($this->EE->session->c_anon);
			$this->EE->functions->set_cookie('read_topics');  
			$this->EE->functions->set_cookie('tracker');  
		}
		
	
		$this->EE->functions->set_cookie('read_topics'); 

		$this->EE->logger->log_action($this->EE->lang->line('member_logged_out'));

		/* -------------------------------------------
		/* 'cp_member_logout' hook.
		/*  - Perform additional actions after logout
		/*  - Added EE 1.6.1
		*
			$edata = $this->extensions->call('cp_member_logout');
			if ($this->extensions->end_script === TRUE) return;
		/*
		/* -------------------------------------------*/
		$this->data["success"] = TRUE;
    }



	function generate_json_old($result = NULL, $match_array_type = FALSE)
	{
		// JSON data can optionally be passed to this function
		// either as a database result object or an array, or a user supplied array
		if ( ! is_null($result))
		{
			if (is_object($result))
			{
				$json_result = $result->result_array();
			}
			elseif (is_array($result))
			{
				$json_result = $result;
			}
			else
			{
				return $this->_prep_args($result);
			}
		}
		else
		{
			return 'null';
		}

		$json = array();
		$_is_assoc = TRUE;

		if ( ! is_array($json_result) AND empty($json_result))
		{
			show_error("Generate JSON Failed - Illegal key, value pair.");
		}
		elseif ($match_array_type)
		{
			$_is_assoc = $this->_is_associative_array($json_result);
		}

		foreach ($json_result as $k => $v)
		{
			if ($_is_assoc)
			{
				$json[] = $this->_prep_args($k, TRUE).':'.$this->generate_json_old($v, $match_array_type);
			}
			else
			{
				$json[] = $this->generate_json_old($v, $match_array_type);
			}
		}

		$json = implode(',', $json);

		return $_is_assoc ? "{".$json."}" : "[".$json."]";

	}

	function _is_associative_array($arr)
	{
		foreach (array_keys($arr) as $key => $val)
		{
      if ($key !== $val)
			{
				return TRUE;
			}
		}

		return FALSE;
	}

	function _prep_args($result, $is_key = FALSE)
	{
		if (is_null($result))
		{
			return 'null';
		}
		elseif (is_bool($result))
		{
			return ($result === TRUE) ? 'true' : 'false';
		}
		elseif (is_string($result) OR $is_key)
		{
			return '"'.str_replace(array('\\', "\t", "\n", "\r", '"', '/'), array('\\\\', '\\t', '\\n', "\\r", '\"', '\/'), $result).'"';			
	
		}
		elseif (is_scalar($result))
		{
			return $result;
		}
	}
}

?>