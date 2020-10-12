<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();

        $this->_init();
        $this->load->helper('security');
        
	}

	public function _init()
	{
		$this->output->set_template('backend');
	}

	public function index()
	{
		$this->load->view('backend/user/v_index');
    }
    
    public function index_json()
    {
        $this->output->unset_template();
        $this->load->library('datatables');
        $this->datatables->select('id, name, email, password, image, status')
            ->from('user')
            ->add_column('password', '******', '')
            ->add_column('status', '$1', 'status(status)')
            ->add_column('id', '$1', 'encrypt_url(id)')
            ->add_column('image', 'Coming Soon', '')
            ->add_column('action', '<a class="confirm-update bs-tooltip" id="$1" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 p-1 br-6 mb-1"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path></svg></a>
                                    <a class="confirm-delete bs-tooltip" id="$1" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash p-1 br-6 mb-1"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg></a>',
                                    'id');

        return $this->output->set_output($this->datatables->generate());
    }

    public function get_action()
    {
        $this->output->unset_template();

        $id = decrypt_url($this->input->get('id'));
        $result = $this->db->get_where('user', ['id'=> $id])->row();

        if ($result) {
            $this->output->set_output(json_encode(['status'=>TRUE, 'msg'=> 'Success.', 'data'=> $result]));
        } else {
            $this->output->set_output(json_encode(['status'=>FALSE, 'msg'=> 'Failed.']));
        }
    }

    public function insert_edit_action()
    {
        $this->output->unset_template();
		$this->form_validation->set_rules('name', 'name', 'required');
		$this->form_validation->set_rules('email', 'email', 'required');
        $this->form_validation->set_rules('status', 'status', 'required');
        
        if ($this->input->post('mod') == "create") {
			$this->form_validation->set_rules('password', 'password', 'required');
        }
        
        $this->form_validation->set_error_delimiters('<div>', '</div>');

        if ($this->form_validation->run() == TRUE) {
            $mod = $this->input->post('mod');

            if ($mod == "create") {
                $check_email = $this->db->get_where('user',['email' => $this->input->post('email')])->row();

                if ($check_email) {
                    $_data = array(
                        'status' => FALSE,
                        'alert' => 'Email field must contain a unique value.'
                    ); 
                } else {
                    $data = array(
                        'name' => $this->input->post('name'),
                        'email' => $this->input->post('email'),
                        'password' => get_hash($this->input->post('password')),
                        'status' => $this->input->post('status')
                    );
                    $result = $this->db->insert('user', $data);

                    if ($result) {
                        $_data = array(
                            'status' => TRUE,
                            'alert' => 'Success'
                        );
                    } else {
                        $_data = array(
                            'status' => FALSE,
                            'alert' => 'Failed'
                        );
                    }
                }
            } else if ($mod == "edit") {
                $data = array(
                    'name' => $this->input->post('name'),
                    'email' => $this->input->post('email'),
                    'status' => $this->input->post('status')
                );

                $id = $this->input->post('id');
                $result = $this->db->update('user', $data, ['id' => $id]);

                if ($result) {
                    $_data = array(
                        'status' => TRUE,
                        'alert' => 'Success'
                    );
                } else {
                    $_data = array(
                        'status' => FALSE,
                        'alert' => 'Failed'
                    );
                }
            }
        } else {
            $validation = form_error('name').
                form_error('email').
                form_error('password').
                form_error('status');    

            $_data = array(
                'status' => FALSE,
                'alert' => $validation
            );
        }

        if ($_data) {
            $this->output->set_output(json_encode($_data));
        } else {
            $this->output->set_output(json_encode(['status' => FALSE, 'msg' => 'Failed to retrieve data']));
        }
    }

    public function delete_action()
    {
        $this->output->unset_template();

        $id = decrypt_url($this->input->get('id'));
        $result = $this->db->delete('user',['id' => $id]);

        if ($result) {
            $this->output->set_output(json_encode(['status'=>TRUE, 'msg'=> 'Success.']));
        } else {
            $this->output->set_output(json_encode(['status'=>FALSE, 'msg'=> 'Failed.']));
        }
    }
}