<?php
	class Crm_model extends CI_Model
	{
		public function __construct() 
		{
			parent::__construct();
            $timezone = new DateTimeZone("Asia/Kolkata" );
		    $date = new DateTime();
		    $date->setTimezone($timezone);
		    $this->curr=$date->format('Y-m-d H:i:s');
		}
		
		public function lead()
		{
			$data['lstatus']=$this->db->get('m29_lead_status');
			$data['ind']=$this->db->get('m30_industry');
			$this->db->where('m_parent_id',-1);
			$this->db->where('m_status',1);
			$data['loc']=$this->db->get('m05_location');
			$data['lsource']=$this->db->get('m28_lead_source');
			$data['id']=$this->uri->segment(3);
			return $data;
			}
		
		public function show_lead($id)
	    {
		   $smenu=array(
			'proc'=>2,
			'lead_for'=>'',
			'lead_owner'=>$this->session->userdata('profile_id'),
			'lead_created_by'=>$id,
			'lead_company'=>'',
			'lead_prefix'=>0,
			'lead_name'=>'',
			'lead_title'=>'',
			'lead_industry'=>'',
			'lead_emp'=>'',
			'lead_email'=>'',
			'lead_mobile'=>'',
			'lead_source'=>'',
			'lead_current_status'=>'',
			'lead_description'=>'',
			'lead_address'=>'',
			'lead_city'=>'',
			'lead_state'=>'',
			'lead_zipcode'=>'',
			'lead_country'=>'',
			'lead_status'=>'',
			'lead_logintype'=>'',
			'lead_regdate'=>''
			);
			$query = " CALL sp_lead(?" . str_repeat(",?", count($smenu)-1) .",@a) ";
			$data['rec']=$this->db->query($query, $smenu);
			$this->db->free_db_resource();
			$data['response']=$this->db->query("SELECT @a as resp");
			$this->db->where('or_m_designation',4);
			$this->db->where('or_m_status',1);
			$data['user']=$this->db->get('m06_user_detail');
			return $data;
		}
		
		public function update_lead()
	    {
			$smenu=array(
			'proc'=>3,
			'lead_for'=>($this->input->post('lead_for')!='')?implode(',',$this->input->post('lead_for')):'',
			'lead_owner'=>$this->session->userdata('profile_id'),
			'lead_created_by'=>$this->session->userdata('user_type'),
			'lead_company'=>$this->input->post('txtcname'),
			'lead_prefix'=>$this->input->post('txtleadprefix'),
			'lead_name'=>$this->input->post('txtleadname'),
			'lead_title'=>$this->input->post('txtltitle'),
			'lead_industry'=>$this->input->post('ddindustry'),
			'lead_emp'=>$this->input->post('txtnoemp'),
			'lead_email'=>$this->input->post('txtmail'),
			'lead_mobile'=>$this->input->post('txtmobile'),
			'lead_source'=>$this->input->post('ddsource'),
			'lead_current_status'=>$this->input->post('ddldstatus'),
			'lead_description'=>$this->input->post('txtlead_des'),
			'lead_address'=>$this->input->post('txtstreet'),
			'lead_city'=>$this->input->post('ddcity'),
			'lead_state'=>$this->input->post('ddstate'),
			'lead_zipcode'=>$this->input->post('txtzipcode'),
			'lead_country'=>$this->input->post('ddcountry'),
			'lead_status'=>$this->input->post('ddldstatus'),
			'lead_logintype'=>$this->uri->segment(3),
			'lead_regdate'=>''
			);
			$query = " CALL sp_lead(?" . str_repeat(",?", count($smenu)-1) .",@a) ";
			$data['rec']=$this->db->query($query, $smenu);
			$this->db->free_db_resource();
			$data['response']=$this->db->query("SELECT @a as resp");
			foreach($data['response']->result() as $rows)
			{
			break;
			}
		    $ids =$rows->resp;
			 return $ids;
			
		}
		
		public function insert_lead()
		{
			$smenu=array(
			'proc'=>1,
			'lead_for'=>($this->input->post('lead_for')!='')?implode(',',$this->input->post('lead_for')):'',
			'lead_owner'=>$this->session->userdata('profile_id'),
			'lead_created_by'=>$this->session->userdata('user_type'),
			'lead_company'=>$this->input->post('txtcname'),
			'lead_prefix'=>$this->input->post('txtleadprefix'),
			'lead_name'=>$this->input->post('txtleadname'),
			'lead_title'=>$this->input->post('txtltitle'),
			'lead_industry'=>$this->input->post('ddindustry'),
			'lead_emp'=>$this->input->post('txtnoemp'),
			'lead_email'=>$this->input->post('txtmail'),
			'lead_mobile'=>$this->input->post('txtmobile'),
			'lead_source'=>$this->input->post('ddsource'),
			'lead_current_status'=>$this->input->post('ddldstatus'),
			'lead_description'=>$this->input->post('txtlead_des'),
			'lead_address'=>$this->input->post('txtstreet'),
			'lead_city'=>$this->input->post('ddcity'),
			'lead_state'=>$this->input->post('ddstate'),
			'lead_zipcode'=>$this->input->post('txtzipcode'),
			'lead_country'=>$this->input->post('ddcountry'),
			'lead_status'=>$this->input->post('ddldstatus'),
			'lead_logintype'=>'4',
			'lead_regdate'=>$this->curr
			);
			$query = " CALL sp_lead(?" . str_repeat(",?", count($smenu)-1) .",@a) ";
			$data['lead']=$this->db->query($query, $smenu);
			$this->db->free_db_resource();
			$data['response']=$this->db->query("SELECT @a as resp");
			foreach($data['response']->result() as $rows)
			{
			}
			$ids =$rows->resp;
			return $ids;
		}
		
		public function delete_lead()
	    {
			$data['id']=$this->uri->segment(3);
			$smenu1=array(
			'proc'=>4,
			'lead_for'=>'',
			'lead_owner'=>$this->uri->segment(3),
			'lead_created_by'=>'',
			'lead_company'=>'',
			'lead_prefix'=>'',
			'lead_name'=>'',
			'lead_title'=>'',
			'lead_industry'=>'',
			'lead_emp'=>'',
			'lead_email'=>'',
			'lead_mobile'=>'',
			'lead_source'=>'',
			'lead_current_status'=>'',
			'lead_description'=>'',
			'lead_address'=>'',
			'lead_city'=>'',
			'lead_state'=>'',
			'lead_zipcode'=>'',
			'lead_country'=>'',
			'lead_status'=>8,
			'lead_logintype'=>'',
			'lead_regdate'=>''
			);
			$query1 = " CALL sp_lead(?" . str_repeat(",?", count($smenu1)-1) .",@a) ";
			$data['rec1']=$this->db->query($query1, $smenu1);
			$this->db->free_db_resource();
			$data['response']=$this->db->query("SELECT @a as resp");
			$t=array('7');
			$smenu=array(
			'proc'=>2,
			'lead_for'=>'',
			'lead_owner'=>$this->session->userdata('profile_id'),
			'lead_created_by'=>$this->uri->segment(3),
			'lead_company'=>'','lead_prefix'=>'',
			'lead_name'=>'','lead_title'=>'',
			'lead_industry'=>'',
			'lead_emp'=>'',
			'lead_email'=>'',
			'lead_mobile'=>'',
			'lead_source'=>'',
			'lead_current_status'=>'',
			'lead_description'=>'',
			'lead_address'=>'',
			'lead_city'=>'',
			'lead_state'=>'',
			'lead_zipcode'=>'',
			'lead_country'=>'',
			'lead_status'=>'',
			'lead_logintype'=>'',
			'lead_regdate'=>''
			);
			$query = " CALL sp_lead(?" . str_repeat(",?", count($smenu)-1) .",@a) ";
			$data['rec']=$this->db->query($query, $smenu);
			$this->db->free_db_resource();
			$data['response']=$this->db->query("SELECT @a as resp");
			$this->db->where('or_m_designation',4);
			$this->db->where('or_m_status',1);
			$data['user']=$this->db->get('m06_user_detail');
			return $data;
			}
		
		public function lead_search_report()
	    {
			$data['id']=$this->uri->segment(3);
			$segment_id=0;
			$condition="";
			$lead_owner=0;
			$lead_email=0;
			$lead_contact=0;
			$lead_company=0;
			$lead_name=0;
			$lead_from='0000-00-00';
			$lead_to='0000-00-00';
			$lead_status=0;
			if($this->input->post('lead_owneralias')!="")
			{
				$lead_owner=$this->input->post('lead_owneralias');
			}
			if($this->input->post('lead_email')!="")
			{
				$lead_email=$this->input->post('lead_email');
			}
			if($this->input->post('lead_contact')!="")
			{
				$lead_contact=$this->input->post('lead_contact');
			}
			if($this->input->post('lead_company')!="")
			{
				$lead_company=$this->input->post('lead_company');
			}
			if($this->input->post('lead_name')!="")
			{
				$lead_name=$this->input->post('lead_name');
			}
			if($this->input->post('lead_created_from')!="")
			{
				$lead_from=$this->input->post('lead_created_from');
			}
			if($this->input->post('leadcreated_to')!="")
			{
				$lead_to=$this->input->post('leadcreated_to');
			}
			if($this->input->post('lead_status')!="")
			{
				$lead_status=$this->input->post('lead_status');
			}
			$condition = $condition."`m32_lead`.`lead_status`!=8 ORDER BY `m32_lead`.`lead_regdate` DESC";
			if($this->uri->segment(3)!="")
			$segment_id=$this->uri->segment(3);
			$smenu=array(
			'proc'=>5,
			'lead_for'=>'',
			'lead_owner'=>$lead_owner,
			'lead_created_by'=>$segment_id,
			'lead_company'=>$lead_company,
			'lead_prefix'=>'0',
			'lead_name'=>$lead_name,
			'lead_title'=>'0',
			'lead_industry'=>'0',
			'lead_emp'=>'0',
			'lead_email'=>$lead_email,
			'lead_mobile'=>$lead_contact,
			'lead_source'=>'0',
			'lead_current_status'=>'0',
			'lead_description'=>$condition,
			'lead_address'=>$lead_to,
			'lead_city'=>'0',
			'lead_state'=>'0',
			'lead_zipcode'=>$lead_from,
			'lead_country'=>'0',
			'lead_status'=>$lead_status,
			'lead_logintype'=>'0',
			'lead_regdate'=>$lead_to
			);
			$query = " CALL sp_lead(?" . str_repeat(",?", count($smenu)-1) .",@a) ";
			$data['rec']=$this->db->query($query, $smenu);
			$this->db->free_db_resource();
			$data['response']=$this->db->query("SELECT @a as resp");
			foreach($data['response']->result() as $rows)
			{
			}
			//$ids =$rows->resp;
			$this->db->where('or_m_designation',4);
			$this->db->where('or_m_status',1);
			$data['user']=$this->db->get('m06_user_detail');
			return $data;
		}
		
		public function view_opportunity()
		{
			$this->db->where('opportunity_owner',$this->session->userdata('profile_id'));
			$this->db->where('opportunity_owned_by',$this->session->userdata('user_type'));
			$data['info']=$this->db->get('m35_opportunity');
			return $data;
		}
		
		
		
		public function view_account()
		{
			$data['id']=$this->uri->segment(3);
			$smenu=array(
			'proc'=>2,
			'account_owner'=>$this->session->userdata('profile_id'),
			'account_owned_by'=>$this->session->userdata('user_type'),
			'account_name'=>'',
			'account_industry'=>'',
			'account_emp'=>'',
			'account_website'=>'',
			'account_phone'=>'',
			'account_email'=>'',
			'account_image'=>'',
			'account_fax'=>'',
			'account_type'=>'',
			'account_ownership'=>'',
			'account_city'=>'',
			'account_state'=>'',
			'account_zipcode'=>'',
			'account_desc'=>'',
			'account_country'=>'',
			'account_address'=>'',
			'account_status'=>'',
			'logintype'=>'',
			'account_regdate'=>'',
			'account_pwd'=>'',
			'account_pinpwd'=>''
			);
			$query ="CALL sp_account(?" . str_repeat(",?", count($smenu)-1) .",@a) ";
			$data['account']=$this->db->query($query, $smenu);
			$this->db->free_db_resource();
			$data['response']=$this->db->query("SELECT @a as resp");
			return $data;
		}
		
		public function show_account()
		{
			$data['id']=$this->uri->segment(3);
			$smenu=array(
			'proc'=>2,
			'account_owner'=>$this->session->userdata('profile_id'),
			'account_owned_by'=>$this->session->userdata('user_type'),
			'account_name'=>'',
			'account_industry'=>'',
			'account_emp'=>'',
			'account_website'=>'',
			'account_phone'=>'',
			'account_email'=>'',
			'account_image'=>'',
			'account_fax'=>'',
			'account_type'=>'',
			'account_ownership'=>'',
			'account_city'=>'',
			'account_state'=>'',
			'account_zipcode'=>'',
			'account_desc'=>'',
			'account_country'=>'',
			'account_address'=>'',
			'account_status'=>'',
			'logintype'=>'',
			'account_regdate'=>'',
			'account_pwd'=>'',
			'account_pinpwd'=>''
			);
			$query = " CALL sp_account(?" . str_repeat(",?", count($smenu)-1) .",@a)";
			$data['account']=$this->db->query($query, $smenu);
			$this->db->free_db_resource();
			$data['response']=$this->db->query("SELECT @a as resp");
			return $data;
		}
		
		public function account()
		{
			$data['ind']=$this->db->get('m30_industry');
			$data['acc_own']=$this->db->get('m31_ac_ownership');
			$this->db->where('m_des_pat_id',-1);
			$data['type']=$this->db->get('m03_designation');
			$this->db->where('m_parent_id',-1);
			$data['loc']=$this->db->get('m05_location');
			$data['id']=$this->uri->segment(3);
			return $data;
		}
		
		public function insert_account()
		{	
			$pwd=random_string('numeric',4);
			$pinpwd=random_string('numeric',4);
			$data['id']=$this->uri->segment(3);
			$smenu=array(
			'proc'=>1,
			'account_owner'=>$this->input->post('txtacc_owner'),
			'account_owned_by'=>$this->uri->segment(3),
			'account_name'=>$this->input->post('txtacc_name'),
			'account_industry'=>$this->input->post('ddindustry'),
			'account_emp'=>$this->input->post('txtemp'),
			'account_website'=>$this->input->post('txtacc_website'),
			'account_phone'=>$this->input->post('txtcontact'),
			'account_email'=>$this->input->post('txtemail'),
			'account_image'=>'NO.JPG',
			'account_fax'=>$this->input->post('txtfax'),
			'account_type'=>$this->input->post('ddacc_type'),
			'account_ownership'=>$this->input->post('ddacc_own'),
			'account_city'=>$this->input->post('ddcity'),
			'account_state'=>$this->input->post('ddstate'),
			'account_zipcode'=>$this->input->post('txtzipcode'),
			'account_country'=>$this->input->post('ddcountry'),
			'account_address'=>$this->input->post('txtstreet'),
			'account_desc'=>$this->input->post('txtacc_des'),
			'account_status'=>'1',
			'logintype'=>$this->input->post('ddacc_type'),
			'account_regdate'=>$this->curr,
			'account_pwd'=>$pwd,
			'account_pinpwd'=>$pinpwd
			);
			
			$query = " CALL sp_account(?" . str_repeat(",?", count($smenu)-1) .",@i) ";
			$data['account']=$this->db->query($query, $smenu);
			
			return 'true';
			/*$message ='<p>Welcome Dear: '.$this->input->post('txtacc_name').',<br><br>
				Thank you for signing up with us. Your new account has been setup and you can now login to your account using the details below. <br><br>
				Login Id: '.$this->input->post('txtemail') .'<br><br>
				Password: '. trim($pwd) .'<br><br>
				Login Url: '.base_url().'index.php/auth/</p>';
				$this->load->library('email');
				$this->email->set_newline("\r\n");
				$this->email->from('office@metroheights.co.in','Support Ferryipl'); // change it to yours
				$this->email->to($this->input->post('txtemail'));// change it to yours
				$this->email->subject('FerryIPL USER Account Setup');
				$this->email->message($message);
				if($this->email->send())
				{
				echo 'true';
			}*/
		}
		
		public function update_account()
		{
			$data['account_id']=$this->uri->segment(3);
			$smenu=array(
			'proc'=>3,
			'account_owner'=>$this->uri->segment(3),
			'account_owned_by'=>'',
			'account_name'=>$this->input->post('txtacc_name'),
			'account_industry'=>$this->input->post('ddindustry'),
			'account_emp'=>$this->input->post('txtemp'),
			'account_website'=>$this->input->post('txtacc_website'),
			'account_phone'=>$this->input->post('txtcontact'),
			'account_email'=>$this->input->post('txtemail'),
			'account_image'=>'',
			'account_fax'=>$this->input->post('txtfax'),
			'account_type'=>$this->input->post('ddacc_type'),
			'account_ownership'=>'',
			'account_city'=>$this->input->post('ddcity'),
			'account_state'=>$this->input->post('ddstate'),
			'account_zipcode'=>$this->input->post('txtzipcode'),
			'account_country'=>$this->input->post('ddcountry'),
			'account_address'=>$this->input->post('txtstreet'),
			'account_desc'=>$this->input->post('txtacc_des'),
			'account_status'=>'',
			'logintype'=>'',
			'account_regdate'=>'',
			'account_pwd'=>'',
			'account_pinpwd'=>''
			);
			$query = " CALL sp_account(?" . str_repeat(",?", count($smenu)-1) .",@) ";
			$data['account']=$this->db->query($query, $smenu);
			$this->db->free_db_resource();
			return 'true';
		}
		
		public function insert_acc_proj()
		{
			$timezone = new DateTimeZone("Asia/Kolkata" );
			$date = new DateTime();
			$date->setTimezone($timezone);
			$doj=$date->format('my');
			$query=$this->db->query("select max(m_acc_project) as m_acc_project from m43_acc_project");
			$count=$this->db->count_all_results('m43_acc_project');
			$row = $query->row();
			if($count>0)
			{
				$user_code=$row->m_acc_project;
				$user_code=($user_code+1);
				$length=strlen($user_code);
				if($length<3)
				{
					$user_code='00'.$user_code;
				}
				else
				{
					$user_code=($user_code);
				}
				$doj=$date->format('my');
				$proj_id='FIPL'.$doj.'PRO'.$user_code;
			}
			else
			{
				$proj_id='FIPL'.$doj.'PRO'.'001';
			}
			
			$data=array(
			'm_acc_id'=>$this->uri->segment(3),
			'm_project_sno'=>$proj_id,
			'm_acc_owner'=>$this->input->post('txtacc_owner'),
			'm_project_name'=>$this->input->post('txtprojectname'),
			'm_actual_price'=>$this->input->post('txtprojectcost'),
			'm_project_description'=>$this->input->post('txtdescription'),
			'm_project_stauts'=>1,
			'm_project_create'=>$this->curr,
			);
			$this->db->insert('m43_acc_project',$data);
			return "true";
		}
		
		public function change_account_image()
		{
			$config['upload_path']   =   "application/uploadimage/";
			$config['allowed_types'] =   "gif|jpg|jpeg|png|pdf|doc|xlsx|xml|zip|txt"; 
			$config['max_size']      =   "5000";
			$config['max_width']     =   "1907";
			$config['max_height']    =   "1280";
			$this->load->library('upload',$config);
			$this->upload->do_upload();
			$finfo=$this->upload->data();
			$this->load->helper('url');
			$this->load->library('session');
			$this->load->database();
			$fileupload=$finfo['raw_name'].$finfo['file_ext'];
			$id=$this->uri->segment(3);
			if($fileupload=="")
			{
				$fi="";
			}
			else
			{
				$fi=$fileupload;
			}
			$data=array(
			'account_image'=>$fi,
			);
			$this->db->where('account_id',$this->uri->segment(3));
			$this->db->update('m33_account',$data);
			return $id;
		}
		
		public function contact()
		{
			$data['acname']=$this->db->get('m33_account');
			$this->db->where('m_parent_id',-1);
			$data['loc']=$this->db->get('m05_location');
			return $data;
		}
		
		public function view_contact()
		{
			$contact=array(
			'proc'=>2,
			'account_id'=>'',
			'contact_title'=>'',
			'contact_name'=>'',
			'contact_designation'=>'',
			'contact_mobile'=>'',
			'contact_email'=>'',
			'contact_address'=>'',
			'contact_city'=>'',
			'contact_state'=>'',
			'contact_country'=>'',
			'contact_zipcode'=>'',
			'contact_status'=>1,
			'contact_reg_date'=>'',
			'is_account'=>1
			);
			$query = "CALL sp_contact(?" . str_repeat(",?", count($contact)-1) .",@) ";
			$data['rec']=$this->db->query($query,$contact);
			$this->db->free_db_resource();
			return $data;
		}
		
		public function insert_contact()
		{
			$contact=array(
			'proc'=>1,
			'account_id'=>$this->input->post('accountname'),
			'contact_title'=>$this->input->post('txtcontactprefix'),
			'contact_name'=>$this->input->post('txtcontactname'),
			'contact_designation'=>$this->input->post('designation'),
			'contact_mobile'=>$this->input->post('txtmobile'),
			'contact_email'=>$this->input->post('txtmail'),
			'contact_address'=>$this->input->post('txtstreet'),
			'contact_city'=>$this->input->post('ddcity'),
			'contact_state'=>$this->input->post('ddstate'),
			'contact_country'=>$this->input->post('ddcountry'),
			'contact_zipcode'=>$this->input->post('txtzipcode'),
			'contact_status'=>1,
			'contact_reg_date'=>$this->curr,
			'is_account'=>1
			);
			
			$query = " CALL sp_contact(?" . str_repeat(",?", count($contact)-1) .",@)";
			$data['rec']=$this->db->query($query,$contact);
			
			$this->db->free_db_resource();
			return 'true';
		}
		
		public function update_contact()
		{
			$data['contact_id']=$this->uri->segment(3);
			$contact1=array(
			'proc'=>3,
			'account_id'=>$this->uri->segment(3),
			'contact_title'=>$this->input->post('txtcontactprefix'),
			'contact_name'=>$this->input->post('txtcontactname'),
			'contact_designation'=>$this->input->post('designation'),
			'contact_mobile'=>$this->input->post('txtmobile'),
			'contact_email'=>$this->input->post('txtemail'),
			'contact_address'=>$this->input->post('txtstreet'),
			'contact_city'=>$this->input->post('ddcity'),
			'contact_state'=>$this->input->post('ddstate'),
			'contact_country'=>$this->input->post('ddcountry'),
			'contact_zipcode'=>$this->input->post('txtzipcode'),
			'contact_status'=>1,
			'contact_reg_date'=>$this->curr,
			'is_account'=>1
			);
			$query = "CALL sp_contact(?" . str_repeat(",?", count($contact1)-1) .",@) ";
			$data['rec']=$this->db->query($query,$contact1);
			$this->db->free_db_resource();
			return 'true';
			
		}
		
		public function insert_task()
		{
			if($this->input->post('txtreminder')!='' || $this->input->post('txtreminder')!='0')
			{
				$reminder=$this->input->post('txtreminder');
			}
			else
			{
				$reminder=$this->input->post('ddrecurance_before');
			}
			if($this->input->post('checkrec')==1)
			{
				$task_recurance=$this->input->post('radio_rec');
			}
			else
			{
				$task_recurance='0';
			}
			$taskdata=array(
			'proc'=>1,
			'task_parent'=>0,
			'task_subject'=>$this->input->post('txtsub'), //name change
			'task_type'=>$this->input->post('txttasktype'),
			'task_assignto_id'=>$this->input->post('txtassign_id'),
			'task_priority'=>$this->input->post('ddpriority'),
			'task_related_to'=>$this->input->post('txtrel'),
			'task_rel_name'=>$this->input->post('ddname'),
			'task_relto_service'=>$this->input->post('ddrelate'),
			'related_to_servicename'=>$this->input->post('txtname'),
			'task_recurrence'=>$task_recurance,
			'task_reminder'=>$reminder,
			'task_attachment'=>$this->input->post('fileatt'),
			'task_comment'=>$this->input->post('txtcomment'),
			'task_status'=>$this->input->post('ddstatus'),  //Changed the order
			'task_create_date'=>$this->curr,                //Changed the order
			'task_date'=>$this->input->post('txtduedate'),
			'task_complete_at'=>'0000-00-00',
			'querey'=>''
			);
			//var_dump($taskdata);
			$query = "CALL sp_task(?" . str_repeat(",?", count($taskdata)-1) .") ";
			$data['rec']=$this->db->query($query,$taskdata);
			$this->db->free_db_resource();
			if($this->input->post('checkrec')!=0)
			{
				$start_date=$this->input->post('txtfromdate');
				$subject=$this->input->post('txtsubject');
				$task_id='';
				$value=$this->input->post('radio_rec');
				$from_date=date_create($this->input->post('txtfromdate'));
				$to_date=date_create($this->input->post('txttodate'));
				$diff=date_diff($from_date,$to_date);
				$diff1=$diff->format("%a");
				$rec='';
				$this->db->where('task_subject',$subject);
				$data1['rec']=$this->db->get('m38_task');					
				foreach($data1['rec']->result() as $row1)
				{
					$task_id=$row1->task_id;
					break;
				}
				if($diff1 > 0)
				{
					if($value==1)
					{
						$count=$diff1;
					}
					if($value==2)
					{
						$count=$diff1%7;
					}
					if($value==3)
					{
						$count=$diff1%30;
					}
					if($value==4)
					{
						$count=$diff1%365;
					}
				}
				
				for($i=1;$i<$count;$i++)
				{
					if($value==1)
					{
						$start_date=date('Y-m-d', strtotime('+1 day', strtotime($start_date)));
					}
					if($value==2)
					{
						$start_date=date('Y-m-d', strtotime('+1 Week', strtotime($start_date)));
					}
					if($value==3)
					{
						$start_date=date('Y-m-d', strtotime('+1 month', strtotime($start_date)));
					}
					if($value==4)
					{
						$start_date=date('Y-m-d', strtotime('+1 year', strtotime($start_date)));
					}
					$spec_data=array(
					'task_parent'=>$task_id,
					'task_date'=>date('Y-m-d',strtotime($start_date))
					);
					
					$this->db->insert('m38_task',$spec_data);
				}
			}
			
			return 'true';
		}
		
		public function edit_task()
		{
			$data['curr']=$this->curr;
			$data['task_id']=$this->uri->segment(3);
			$taskdata=array(
			'proc'=>3,
			'task_parent'=>0,
			'task_subject'=>'',
			'task_type'=>'',
			'task_assignto_id'=>'',
			'task_priority'=>'',
			'task_related_to'=>'',
			'task_rel_name'=>'',
			'task_relto_service'=>'',
			'related_to_servicename'=>'',
			'task_recurrence'=>'',
			'task_reminder'=>'',
			'task_attachment'=>'',
			'task_comment'=>'',
			'task_status'=>'',
			'task_date'=>'',
			'task_create_date'=>'',
			'task_complete_at'=>'',
			'querey'=>'task_id='.$this->uri->segment(3)
			);
			$query = "CALL sp_task(?" . str_repeat(",?", count($taskdata)-1) .") ";
			$data['info']=$this->db->query($query,$taskdata);
			$this->db->free_db_resource();
			return $data;
		}
		
		
		public function update_task()
		{
			$proc=4;
			if($this->input->post('ddstatus')==2)
			{
				$proc=5;
			}
			$taskdata=array(
			'proc'=>$proc,
			'task_parent'=>'',
			'task_subject'=>'',
			'task_type'=>'',
			'task_assignto_id'=>'',
			'task_priority'=>'',
			'task_related_to'=>'',
			'task_rel_name'=>'',
			'task_relto_service'=>'',
			'related_to_servicename'=>'',
			'task_recurrence'=>'',
			'task_reminder'=>'',
			'task_attachment'=>'',
			'task_comment'=>'',
			'task_status'=>'',
			'task_date'=>'',
			'task_create_date'=>'',
			'task_complete_at'=>$this->curr,
			'querey'=>'task_id='.$this->uri->segment(3)
			);
			$query = "CALL sp_task(?" . str_repeat(",?", count($taskdata)-1) .") ";
			$data['rec']=$this->db->query($query,$taskdata);
			$this->db->free_db_resource();
			return 'true';
		}
		
		public function complete_task()
		{
			$taskdata=array(
			'proc'=>5,
			'task_parent'=>'',
			'task_subject'=>'',
			'task_type'=>'',
			'task_assignto_id'=>'',
			'task_priority'=>'',
			'task_related_to'=>'',
			'task_rel_name'=>'',
			'task_relto_service'=>'',
			'related_to_servicename'=>'',
			'task_recurrence'=>'',
			'task_reminder'=>'',
			'task_attachment'=>'',
			'task_comment'=>'',
			'task_status'=>'',
			'task_date'=>'',
			'task_create_date'=>'',
			'task_complete_at'=>$this->curr,
			'querey'=>'task_id='.$this->uri->segment(3)
			);
			$query = "CALL sp_task(?" . str_repeat(",?", count($taskdata)-1) .") ";
			$data['rec']=$this->db->query($query,$taskdata);
			$this->db->free_db_resource();
			return $data;
		}
		
		
		public function show_task()
		{	
			$data['curr']=$this->curr;
			$taskdata=array(
			'proc'=>3,
			'task_parent'=>0,
			'task_subject'=>'',
			'task_type'=>'',
			'task_assignto_id'=>'',
			'task_priority'=>'',
			'task_related_to'=>'',
			'task_rel_name'=>'',
			'task_relto_service'=>'',
			'related_to_servicename'=>'',
			'task_recurrence'=>'',
			'task_reminder'=>'',
			'task_attachment'=>'',
			'task_comment'=>'',
			'task_status'=>'',
			'task_date'=>'',
			'task_create_date'=>'',
			'task_complete_at'=>'',
			'querey'=>'1'
			);
			$query = "CALL sp_task(?" . str_repeat(",?", count($taskdata)-1) .") ";
			$data['rec']=$this->db->query($query,$taskdata);
			$this->db->free_db_resource();
			$data['fetch']=$this->db->get('m34_contact');
			$data['lead']=$this->db->get('m32_lead');
			return $data;
		}
		
		
		public function view_task_history()
		{
			$p_id=$this->uri->segment(3);
			$data['task_id']=$this->uri->segment(3);
			$taskdata=array(
			'proc'=>4,
			'task_parent'=>0,
			'task_subject'=>'',
			'task_type'=>'',
			'task_assignto_id'=>'',
			'task_priority'=>'',
			'task_related_to'=>'',
			'task_rel_name'=>'',
			'task_relto_service'=>'',
			'related_to_servicename'=>'',
			'task_recurrence'=>'',
			'task_reminder'=>'',
			'task_attachment'=>'',
			'task_comment'=>'',
			'task_status'=>'',
			'task_date'=>'',
			'task_create_date'=>'',
			'task_complete_at'=>'',
			'querey'=>'task_id='.$p_id
			);
			$query = "CALL sp_task(?" . str_repeat(",?", count($taskdata)-1) .") ";
			$data['rec']=$this->db->query($query,$taskdata);
			$this->db->free_db_resource();
			return $data;
		}
		
		
		public function insert_follow_up()
		{
			$task_no=$this->uri->segment(3);
			$task_reply=$this->input->post('task_description');
			$taskdata=array(
			'proc'=>2,
			'task_parent'=>$task_no,
			'task_subject'=>'',
			'task_type'=>'',
			'task_assignto_id'=>$this->session->userdata('name'),
			'task_priority'=>'',
			'task_related_to'=>'',
			'task_rel_name'=>'',
			'task_relto_service'=>'',
			'related_to_servicename'=>'',
			'task_recurrence'=>'',
			'task_reminder'=>'',
			'task_attachment'=>'',
			'task_comment'=>$task_reply,
			'task_status'=>'',
			'task_date'=>'',
			'task_create_date'=>'',
			'task_complete_at'=>$this->curr,
			'querey'=>'1'
			);
			$query = "CALL sp_task(?" . str_repeat(",?", count($taskdata)-1) .") ";
			$data['rec']=$this->db->query($query,$taskdata);
			$this->db->free_db_resource();
			return 1;
			//header("Location:".base_url()."index.php/crm/view_task_history/$task_no");
		}
		
		
		public function admin_response()
		{
			$task_no=$this->input->post('txtticket');
			$data=array(
			'proc'=>2,
			'ticket_no'=>$this->input->post('txtticket'),
			'tkt_person_name'=>'',
			'tkt_email'=>'',
			'tkt_department'=>'',
			'emp_id'=>'',
			'tkt_subject'=>'',
			'tkt_urgency'=>'',
			'tkt_discription'=>'',
			'tkt_response_type'=>1,
			'response_by'=>$this->session->userdata('name'),
			'tkt_userfile'=>$fi,
			'tkt_status'=>1,
			'account_id'=>'',
			'affiliate_id'=>'',
			'tkt_sub_date'=>$date->format('Y-m-d H:i:s'),
			'trans_description'=>$this->input->post('txtdiscription'),
			'trans_response_date'=>$date->format('Y-m-d H:i:s'),
			'trans_status'=>1
			);
			$query = "CALL sp_task(?" . str_repeat(",?", count($data)-1) .")";
			$data['rec']=$this->db->query($query,$data);
			$this->db->free_db_resource();
			return $task_no;
			
		}
		
		
		public function project_category()
		{
			$query=$this->db->query("SELECT * FROM `m42_project` WHERE `m42_project`.`m_project_stauts`=1 and `m42_project`.`m_project_type`=".$this->uri->segment(3));
			$json=json_encode($query->result());
			return $json;
		}
		
		
		public function services_category()
		{
			$query=$this->db->query("SELECT `m_service_type_id`,`m_service_type` FROM `admin_metro_new`.`m10_service_type` WHERE `m_service_status`=1");
			$json=json_encode($query->result());
			return $json;
		}
		
		
		public function convert_opportunity()
		{
			$id=$this->uri->segment(3);
			$data['id']=$this->uri->segment(3);
			$smenu1=array(
			'proc'=>4,'lead_for'=>'','lead_owner'=>$this->uri->segment(3),'lead_created_by'=>'','lead_company'=>'','lead_prefix'=>'','lead_name'=>'','lead_title'=>'','lead_industry'=>'',
			'lead_emp'=>'','lead_email'=>'','lead_mobile'=>'','lead_source'=>'','lead_current_status'=>'','lead_description'=>'','lead_address'=>'','lead_city'=>'',
			'lead_state'=>'','lead_zipcode'=>'','lead_country'=>'','lead_status'=>7,'lead_logintype'=>'','lead_regdate'=>'');
			$query1 = " CALL sp_lead(?" . str_repeat(",?", count($smenu1)-1) .",@a) ";
			$data['rec1']=$this->db->query($query1, $smenu1);
			$this->db->free_db_resource();
			$this->db->where('lead_id',$id);
			$data['ldinfo']=$this->db->get('m32_lead');
			$row=$data['ldinfo']->row();
			$lead_created_by=$row->lead_created_by;
			$query=$this->db->query("SELECT COUNT(*) as pl_count  FROM `m35_opportunity` WHERE 1");
			$row1 = $query->row();
			$OSn='P'.$row1->pl_count;
			$opportunity=array(
			'proc'=>1,
			'lead_id'=>$row->lead_id,
			'account_id'=>0,
			'opportunity_sno'=>'P'.$row1->pl_count,
			'opportunity_for'=>$row->lead_for,
			'opportunity_website_id'=>'0',
			'opportunity_project_id'=>'0',
			'opportunity_service_id'=>'0',
			'expected_revenue'=>'0.00',
			'probability'=>'0.00',
			'opportunity_proposal_copy'=>'',
			'opportunity_subject'=>$row->lead_title,
			'opportunity_owner'=>$row->lead_owner,
			'opportunity_owned_by'=>$this->uri->segment(4),
			'opportunity_account_name'=>$row->lead_company,
			'opportunity_priority'=>'1',
			'opportunity_close_date'=>$this->curr,
			'opportunity_type'=>2,
			'opportunity_stage'=>1,
			'opportunity_description'=>'Lead Convert to Opportunity',
			'opportunity_create_date'=>$this->curr,
			'opportunity_proposal_date'=>'0000-00-00 00:00:00',
			'opportunity_workorder_date'=>'0000-00-00 00:00:00'
			);
			$query1 ="CALL sp_opportunity(?" . str_repeat(",?", count($opportunity)-1) .",@b) ";
			$data['rec1']=$this->db->query($query1, $opportunity);
			$this->db->free_db_resource();
			$query11=$this->db->query("SELECT @b as message");
			$oprow = $query11->row();
			$query001=$this->db->query("SELECT `m35_opportunity`.`opportunity_id` as opp_id FROM `admin_metro_new`.`m35_opportunity` WHERE `m35_opportunity`.`opportunity_sno`='".$OSn."'");
			$row001 = $query001->row();
			//echo $oprow->message;
			$contact=array(
			'account_id'=>$row001->opp_id,
			'contact_title'=>$row->lead_prefix,
			'contact_name'=>$row->lead_name,
			'contact_designation'=>"",
			'contact_mobile'=>$row->lead_mobile,
			'contact_email'=>$row->lead_email,
			'contact_address'=>$row->lead_address,
			'contact_city'=>$row->lead_city,
			'contact_state'=>$row->lead_state,
			'contact_country'=>$row->lead_country,
			'contact_zipcode'=>$row->lead_zipcode,
			'contact_status'=>1,
			'contact_reg_date'=>$this->curr,
			'is_account'=>0
			);
			$this->db->insert('m34_contact',$contact);
			//$data['ld_id']=$this->uri->segment(3);
			$con_id=0;
			$this->db->where('account_id',$row001->opp_id);
			$this->db->where('is_account',0);
			$data['contact']=$this->db->get('m34_contact');
			foreach($data['contact']->result() as $conrow)
			{
				$con_id=$conrow->contact_id;
				break;
			}
			$this->db->where('task_rel_name',$con_id);
			$this->db->where('task_related_to',2);
			$data['task_info']=$this->db->get('m38_task');
			$this->db->where('opportunity_id',$row001->opp_id);
			$data['info']=$this->db->get('m35_opportunity');
			$data['lcid']=$this->uri->segment(4);
			$this->db->where('m_project_stauts',1);
			$data['project']=$this->db->get('m42_project');
			return $data;
		}
		
		
		public function edit_opportunity()
		{
			$con_id="";
			$data['ld_id']=$this->session->userdata('user_type');
			$this->db->where('account_id',$this->uri->segment(3));
			$this->db->where('is_account',0);
			$data['contact']=$this->db->get('m34_contact');
			foreach($data['contact']->result() as $row)
			{
				$con_id=$row->contact_id;
				break;
			}
			$this->db->where('task_rel_name',$con_id);
			$this->db->where('task_related_to',2);
			$data['task_info']=$this->db->get('m38_task');
			$this->db->where('opportunity_id',$this->uri->segment(3));
			$data['info']=$this->db->get('m35_opportunity');
			$data['lcid']=$this->uri->segment(4);
			$this->db->where('m_project_stauts',1);
			$data['project']=$this->db->get('m42_project');
			return $data;
		}
		
		
		public function insert_opportunity_file()
		{
			$fileupload='';
			if($_FILES['userfile']['name']!='')
			{
				$config['upload_path']   =   "application/Proposal/";
				$config['allowed_types'] =   "pdf"; 
				$config['max_size']      =   "10000";
				$this->load->library('upload',$config);
				$this->upload->do_upload();
				$finfo=$this->upload->data();
				$fileupload=($finfo['raw_name'].$finfo['file_ext']);
			}
			return $fileupload;
		}
		
		
		public function insert_opportunity()
		{
			$account_id=0;
		    $account_name=$this->input->post('txtacc_name');
			$query=$this->db->query("SELECT COUNT(*) as pl_count  FROM `m35_opportunity` WHERE 1");
			$row1 = $query->row();
			if($this->input->post('ddop_type')==1)
			{
			$t=explode('-',$this->input->post('txtacc_name'));
			$account_id=$t[0];	
			$account_name=$t[1];	
			}
			$OSn='P'.$row1->pl_count;
			$opportunity=array(
			'proc'=>1,
			'lead_id'=>0,
			'account_id'=>$account_id,
			'opportunity_sno'=>$OSn,
			'opportunity_for'=>($this->input->post('ddenqtype')!='')?implode(',',$this->input->post('ddenqtype')):'',
			'opportunity_website_id'=>$this->input->post('ddwebsite'),
			'opportunity_project_id'=>$this->input->post('ddproject'),
			'opportunity_service_id'=>($this->input->post('ddservice')!='')?implode(',',$this->input->post('ddservice')):'',
			'expected_revenue'=>$this->input->post('txtrevenue'),
			'probability'=>$this->input->post('txtprobability'),
			'opportunity_proposal_copy'=>trim($this->input->post('userfile')),
			'opportunity_subject'=>$this->input->post('txtsubj'),
			'opportunity_owner'=>$this->session->userdata('profile_id'),
			'opportunity_owned_by'=>$this->session->userdata('user_type'),
			'opportunity_account_name'=>$account_name,
			'opportunity_priority'=>$this->input->post('ddpriority'),
			'opportunity_close_date'=>$this->input->post('txtclose_dt'),
			'opportunity_type'=>$this->input->post('ddop_type'),
			'opportunity_stage'=>$this->input->post('ddop_stg'),
			'opportunity_description'=>$this->input->post('txtop_des'),
			'opportunity_create_date'=>$this->curr,
			'opportunity_proposal_date'=>'0000-00-00 00:00:00',
			'opportunity_workorder_date'=>'0000-00-00 00:00:00'
			);
			$query1 ="CALL sp_opportunity(?" . str_repeat(",?", count($opportunity)-1).",@a)";
			$data['rec1']=$this->db->query($query1, $opportunity);
			$this->db->free_db_resource();
			$query1=$this->db->query("SELECT @a as message");
			$row = $query1->row();
			$query001=$this->db->query("SELECT `m35_opportunity`.`opportunity_id` as opp_id FROM `admin_metro_new`.`m35_opportunity` WHERE `m35_opportunity`.`opportunity_sno`='".$OSn."'");
			$row001 = $query001->row();
			if($this->input->post('next_step')!="" && $this->input->post('txtd')!="")
			{
			$query01=$this->db->get_where('m34_contact',array('account_id'=>$row001->opp_id,'is_account'=>0));
			$row01 = $query01->row();
			$taskdata=array(
			'proc'=>1,'task_parent'=>0,'task_subject'=>$this->input->post('txtd'),'task_type'=>1,'task_assignto_id'=>$this->session->userdata('profile_id'),'task_priority'=>$this->input->post('ddpriority'),'task_related_to'=>2,'task_rel_name'=>$row01->contact_id,'task_relto_service'=>($this->input->post('ddenqtype')!='')?implode(',',$this->input->post('ddenqtype')):'','related_to_servicename'=>$this->input->post('ddwebsite'),'task_recurrence'=>0,'task_reminder'=>$this->input->post('next_step'),'task_attachment'=>'','task_comment'=>'','task_status'=>1,'task_create_date'=>$this->curr,'task_date'=>$this->input->post('next_step'),'task_complete_at'=>'0000-00-00','querey'=>''
			               );
			$query = "CALL sp_task(?" . str_repeat(",?", count($taskdata)-1) .") ";
			$data['rec']=$this->db->query($query,$taskdata);
			$this->db->free_db_resource();
			}
			return $row001->opp_id;
		}
		
		
		public function update_opportunity()
		{
			$account_id=0;
		    $account_name=$this->input->post('txtacc_name');
			if($this->input->post('ddop_type')==1)
			{
			$t=explode('-',$this->input->post('txtacc_name'));
			$account_id=$t[0];	
			$account_name=$t[1];	
			}
			$opportunity=array(
			'proc'=>2,
			'lead_id'=>0,
			'account_id'=>$account_id,
			'opportunity_sno'=>$this->uri->segment(3),
			'opportunity_for'=>($this->input->post('ddenqtype')!='')?implode(',',$this->input->post('ddenqtype')):'',
			'opportunity_website_id'=>$this->input->post('ddwebsite'),
			'opportunity_project_id'=>$this->input->post('ddproject'),
			'opportunity_service_id'=>($this->input->post('ddservice')!='')?implode(',',$this->input->post('ddservice')):'',
			'expected_revenue'=>$this->input->post('txtrevenue'),
			'probability'=>$this->input->post('txtprobability'),
			'opportunity_proposal_copy'=>trim($this->input->post('userfile')),
			'opportunity_subject'=>$this->input->post('txtsubj'),
			'opportunity_owner'=>$this->session->userdata('profile_id'),
			'opportunity_owned_by'=>$this->session->userdata('user_type'),
			'opportunity_account_name'=>$account_name,
			'opportunity_priority'=>$this->input->post('ddpriority'),
			'opportunity_close_date'=>$this->input->post('txtclose_dt'),
			'opportunity_type'=>$this->input->post('ddop_type'),
			'opportunity_stage'=>$this->input->post('ddop_stg'),
			'opportunity_description'=>$this->input->post('txtop_des'),
			'opportunity_create_date'=>$this->curr,
			'opportunity_proposal_date'=>'0000-00-00 00:00:00',
			'opportunity_workorder_date'=>'0000-00-00 00:00:00'
			);
			$query1 ="CALL sp_opportunity(?" . str_repeat(",?", count($opportunity)-1) .",@a) ";
			$data['rec1']=$this->db->query($query1, $opportunity);
			$this->db->free_db_resource();
			$query1=$this->db->query("SELECT @a as message");
			$row = $query1->row();
			if($this->input->post('next_step')!="" && $this->input->post('txtd')!="")
			{
			$query01=$this->db->get_where('m34_contact',array('account_id'=>$this->uri->segment(3),'is_account'=>0));
			$row01 = $query01->row();
			$this->db->where('task_rel_name', $row01->contact_id);
			$this->db->where('task_related_to',2);
			$count=$this->db->count_all_results('m38_task');
			if($count<1)
			{
			$taskdata=array(
			'proc'=>1,'task_parent'=>0,'task_subject'=>$this->input->post('txtd'),'task_type'=>1,'task_assignto_id'=>$this->session->userdata('profile_id'),'task_priority'=>$this->input->post('ddpriority'),'task_related_to'=>2,'task_rel_name'=>$row01->contact_id,'task_relto_service'=>($this->input->post('ddenqtype')!='')?implode(',',$this->input->post('ddenqtype')):'','related_to_servicename'=>$this->input->post('ddwebsite'),'task_recurrence'=>0,'task_reminder'=>$this->input->post('next_step'),'task_attachment'=>'','task_comment'=>'','task_status'=>1,'task_create_date'=>$this->curr,'task_date'=>$this->input->post('next_step'),'task_complete_at'=>'0000-00-00','querey'=>''
			              );
			$query = "CALL sp_task(?" . str_repeat(",?", count($taskdata)-1) .") ";
			$data['rec']=$this->db->query($query,$taskdata);
			$this->db->free_db_resource();
			}
			}
			echo $row->message;
		}
		
		
		public function insert_event()
		{
			$timezone = new DateTimeZone("Asia/Kolkata" );
			$date = new DateTime();
			$date->setTimezone($timezone);
			$data=array(
			'subject'=>$this->input->post('txtsub'),
			'event_assignto_id'=>$this->input->post('txtassign'),
			'event_start_date'=>$this->input->post('txtstart_date'),
			'event_end_date'=>$this->input->post('txtend_date'),
			'event_status'=>$this->input->post('ddstatus'),
			'event_location'=>$this->input->post('txtlocation'),
			'event_type'=>$this->input->post('ddeventtype'),
			'event_related_to'=>$this->input->post('ddrttype'),
			'related_to_name'=>$this->input->post('txtrtname'),
			'event_rel_service'=>$this->input->post('ddreltype'),
			'event_rel_servicename'=>$this->input->post('txtrelname'),
			'event_recurrence'=>$this->input->post('checkrec'),
			'event_reminder'=>$this->input->post('ddreminder'),
			'event_attachment'=>$this->input->post('fileatt'),
			'event_comment'=>$this->input->post('txtcomment'),
			'event_create_date'=> $this->curr
			);
			//var_dump($data);
			$this->db->insert('m41_event',$data);
			return "true";
			
		}
		
		
		public function update_event()
		{
			
			$timezone = new DateTimeZone("Asia/Kolkata" );
			$date = new DateTime();
			$date->setTimezone($timezone);
			$data=array(
			'subject'=>$this->input->post('txtsub'),
			'event_assignto_id'=>$this->input->post('txtassign'),
			'event_start_date'=>$this->input->post('txtstart_date'),
			'event_end_date'=>$this->input->post('txtend_date'),
			'event_status'=>$this->input->post('ddstatus'),
			'event_location'=>$this->input->post('txtlocation'),
			'event_type'=>$this->input->post('ddtype'),
			'event_related_to'=>$this->input->post('ddrttype'),
			'related_to_name'=>$this->input->post('txtrtname'),
			'event_rel_service'=>$this->input->post('ddreltype'),
			'event_rel_servicename'=>$this->input->post('txtrelname'),
			'event_recurrence'=>$this->input->post('checkrec'),
			'event_reminder'=>$this->input->post('ddreminder'),
			'event_comment'=>$this->input->post('txtcomment'),
			);
			$this->db->where('event_id',$this->uri->segment(3));
			$this->db->update('m41_event',$data);
			return "true";
			
		}
		
		
		public function taskattachment()
		{
			$this->load->helper('url');
			$this->load->library('session');
			$this->load->database();
			$path = "uploads/";
			$valid_formats = array("jpg", "png", "gif", "bmp");
			$name = $_FILES['fileatt']['name'];
			$size = $_FILES['fileatt']['size'];
			
			if(strlen($name))
			{
				list($txt, $ext) = explode(".", $name);
				if(in_array($ext,$valid_formats))
				{
					if($size<(1024*1024))
					{
						$actual_image_name = time().substr(str_replace(" ", "_", $txt), 5).".".$ext;
						$tmp = $_FILES['fileatt']['tmp_name'];
						if(move_uploaded_file($tmp, $path.$actual_image_name))
						{
							//$this->db->where('profile_id', $CI->session->userdata('profile_id'));
							//$this->db->update('userprofiles', array('image'=>$actual_image_name)); 
							//echo "<div><img src='".base_url()."uploads/".$actual_image_name."'  class='preview' height='150px' width='200px' style='border:2px #CCCCCC solid;' id='pimg'></div>";
							return 'true';
						}
						else
						{
						return "failed";
						}
					}
					else
					{
					return "Image file size max 1 MB";		
					}
				}
				else
				{
				return "Invalid file format..";	
				}
			}
			
			else
			{
			return "Please select image..!";
			}
		}
		
		//<-------------------------Create SMS Compaining---------------->//
		
		public function insert_sms_temp()
		{
			$this->load->library('session');
			$this->load->database();
			$this->load->helper('url');
			$aid=0;
			$data=array
			(
			'affiliate_id'=>$this->session->userdata('affid'),
			'm_email_temp_title'=>$this->input->post('title'),
			'm_email_temp_description'=>$this->input->post('content'),
			'category'=>$this->input->post('category'),
			'm_template_category'=>'2'
			);
			$this->db->insert('m39_email_temp',$data);
			return "true";
		}
		
		
		public function update_companing()
		{
			
			$cont=array(
			'm_email_temp_title'=>$this->input->post('txttitle'),
			'category'=>$this->input->post('ddcategory'),
			'm_email_temp_description'=>$this->input->post('txtdescription')
			);
			$this->db->where('m_email_temp_id',$this->uri->segment(3));
			$this->db->update('m39_email_temp',$cont);
			return 'true';
			
		}
		
		
		public function send_sms($mob,$msg)
		{
			$this->load->library('session');
			$this->load->helper('url');
			$this->load->database();
			$this->db->where('m_api_url_for',11);
			$data['apiurl']=$this ->db->get('m16_api_url');
			foreach($data['apiurl']->result() as $row)
			{
				if($row->m_api_url_id=="9" && $row->m_api_url_status=="1")
				{
					$url=$row->m_api_url_address;
					$params = array (
					'userName'=>'ferryinfotech',
					'pwd'=>'qwerty',
					'mobile'=>$mob,
					'message'=>$msg,
					'root'=>'Premium',
					'type'=>'Transactional',
					'senderID'=>'ETOPUP'
					);
					$options = array(
					CURLOPT_SSL_VERIFYHOST => 0,
					CURLOPT_SSL_VERIFYPEER => 0
					);
					
					$defaults = array(
					CURLOPT_URL => $url. (strpos($url, '?') 
					=== FALSE ? '?' : ''). http_build_query($params),
					CURLOPT_HEADER => 0,
					CURLOPT_RETURNTRANSFER => TRUE,
					CURLOPT_TIMEOUT =>56
					);
					
					$ch = curl_init();
					curl_setopt_array($ch, ($options + $defaults));
					$result = curl_exec($ch);
					if(!$result)
					{
						trigger_error(curl_error($ch));
						$flag=0;
					}
					else
					{	                
						$flag=1;
					}
					curl_close($ch);
					return $result; 
				}
				if($row->m_api_url_id=="10" && $row->m_api_url_status=="1")
				{
					$url=$row->m_api_url_address;
					$params = array (
					'uname'=>'ferry123',
					'pass'=>'727510',
					'send'=>'ETOPUP',
					'dest'=>$mob,
					'msg'=>$msg
					);
					$options = array(
					CURLOPT_SSL_VERIFYHOST => 0,
					CURLOPT_SSL_VERIFYPEER => 0
					);
					
					$defaults = array(
					CURLOPT_URL => $url. (strpos($url, '?') 
					=== FALSE ? '?' : ''). http_build_query($params),
					CURLOPT_HEADER => 0,
					CURLOPT_RETURNTRANSFER => TRUE,
					CURLOPT_TIMEOUT =>56
					);
					
					$ch = curl_init();
					curl_setopt_array($ch, ($options + $defaults));
					$result = curl_exec($ch);
					if(!$result)
					{
						trigger_error(curl_error($ch));
						$flag=0;
					}
					else
					{	                
						$flag=1;
					}
					curl_close($ch);
					return $result; 
				}	
			}
		}
		
		
		//-------------------------End SMS compaining---------------------------------
		
		//-------------------------Get Email compaining-------------------------------
		
		public function insert_email_temp()
		{
			$this->load->library('session');
			$this->load->database();
			$this->load->helper('url');
			$aid=0;
			$data=array
			(
			'affiliate_id'=>0,
			'm_email_temp_title'=>$this->input->post('title'),
			'm_email_temp_description'=>$this->input->post('content'),
			'category'=>$this->input->post('category'),
			'm_template_category'=>'1'
			);
			$this->db->insert('m39_email_temp',$data);
			return "true";
		}
		
		
		public function update_email_template()
		{
			$this->load->library('session');
			$this->load->database();
			$this->load->helper('url');
			$aid=0;
			$id=$this->input->post('id');
			$data=array
			(
			'm_email_temp_title'=>$this->input->post('title'),
			'm_email_temp_description'=>$this->input->post('content'),
			'category'=>$this->input->post('category')
			);
			$this->db->where('m_email_temp_id',$id);
			$this->db->where('affiliate_id',$aid);
			$this->db->update('m39_email_temp',$data);
			return "true";
		}
		
		
		public function delete_email()
		{
			$id=$this->input->post('id');
			$this->db->where('m_email_temp_id',$id);
			$this->db->delete('m39_email_temp');
			return "Email Deleted Successfully";
			//header("location:".base_url()."index.php/CRM/image_upload");
		}
		public function insert_task_db()
		{
			$this->load->helper('url');
			$this->load->database();
			$this->load->library('session');
			$timezone = new DateTimeZone("Asia/Kolkata" );
			$date = new DateTime();
			$date->setTimezone($timezone);
			if($this->input->post('txtreminder')!='' || $this->input->post('txtreminder')!='0')
			{
				$reminder=$this->input->post('txtreminder');
			}
			else
			{
				$reminder=$this->input->post('ddrecurance_before');
			}
			
			
			if($this->input->post('checkrec')==1)
			{
				$task_recurance=$this->input->post('radio_rec');
			}
			else
			{
				$task_recurance='0';
			}
			
			$data=array(
			'task_parent'=>0,
			'task_subject'=>$this->input->post('txtsubject'),
			'task_type'=>$this->input->post('txttasktype'),
			'task_assignto_id'=>$this->input->post('txtassign_id'),
			'task_priority'=>$this->input->post('ddpriority'),
			'task_related_to'=>$this->input->post('txtrel'),
			'task_rel_name'=>$this->input->post('ddname'),
			'task_relto_service'=>$this->input->post('ddrelate'),
			'related_to_servicename'=>$this->input->post('txtname'),
			'task_recurrence'=>$task_recurance,
			'task_reminder'=>$reminder,
			'task_attachment'=>$this->input->post('fileatt'),
			'task_comment'=>$this->input->post('txtcomment'),
			'task_status'=>$this->input->post('ddstatus'),
			'task_date'=>$this->input->post('txtduedate'),
			'task_create_date'=>$date->format( 'Y-m-d H-i-s' )
			);
			
			$this->db->insert('m38_task',$data);
			
			if($this->input->post('checkrec')!=0)
			{
				$from_date=date_create($this->input->post('txtfromdate'));
				$to_date=date_create($this->input->post('txttodate'));
				$diff=date_diff($from_date,$end_date);
				$diff=$diff->format("%R%a");
			}
		}
		//--------------------------Upload CSV Code---------------------------
		
		function upload_sampledata_csv()
		{
			$timezone = new DateTimeZone("Asia/Kolkata");
			$date = new DateTime();
			$date->setTimezone($timezone);
			$fp = fopen($_FILES['userfile']['tmp_name'],'r') or die("can't open file");
			while($csv_line = fgetcsv($fp)) 
			{
				for ($i = 0, $j = count($csv_line); $i < $j; $i++) 
				{
					
					$insert_csv['company'] = $csv_line[0];
					$insert_csv['username'] = $csv_line[1];
					$insert_csv['phone'] = $csv_line[2];
					$insert_csv['email'] = $csv_line[3];
					$insert_csv['address'] = $csv_line[4];
					$insert_csv['description'] = $csv_line[5];
				}
				
				$data = array(
				'proc' => 1 ,
				'lead_for'=>'',
				'lead_owner'=>$this->session->userdata('profile_id'),
				'lead_created_by'=>$this->session->userdata('user_type'),
				'lead_company' => $insert_csv['company'] ,
				'lead_prefix' => 1 ,
				'lead_name' => $insert_csv['username'],
				'lead_title' => '',
				'lead_industry' => '',
				'lead_emp' => '',
				'lead_email' => $insert_csv['email'], 
				'lead_mobile' => $insert_csv['phone'],
				'lead_source' => '',
				'lead_current_status' => 5,
				'lead_description' => $insert_csv['description'] ,
				'lead_address' => $insert_csv['address'],
				'lead_city' => '',
				'lead_state' => '',
				'lead_zipcode' => '',
				'lead_country' => 1,
				'lead_status' => 5,
				'lead_logintype' => 4,
				'lead_regdate' => $date->format( 'Y-m-d H-i-s' )
				);
				$query = " CALL sp_lead(?" . str_repeat(",?", count($data)-1) . ",@a) ";
				$data['rec']=$this->db->query($query, $data);
			}
		}
	}
?>