<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Transaction extends CI_Controller
{
    public function index()
    {
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['transaksi'] = $this->db->get('transaksi')->result_array();

        $data['title'] = 'Dashboard';
        $this->load->view('templates/dashboard_header', $data);
        $this->load->view('templates/dashboard_sidebar', $data);
        $this->load->view('booking/index', $data);
        $this->load->view('templates/dashboard_footer');
    }
    public function booking()
    {
        $this->form_validation->set_rules('dateOfEntry', 'Date Of Entry', 'required|trim');
        // $this->form_validation->set_rules('proof', 'Payment Image', 'required|trim');

        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $isLogin = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $kost_id = $this->uri->segment(3);
        $data['detail'] = $this->kost_model->detail_kost($kost_id);
        $data['title'] = 'Form booking';

        if ($isLogin) {
            if ($this->form_validation->run() == false) {
                $this->load->view('detail/booking_kost', $data);
            } else {
                $uploadImage = $_FILES['proof']['name'];

                if ($uploadImage) {
                    $config['upload_path'] = './assets/images/proof/';
                    $config['allowed_types'] = 'jpg|jpeg|png';
                    $config['max_size']     = '2048';

                    $this->load->library('upload', $config);

                    if ($this->upload->do_upload('proof')) {
                        $new_image = $this->upload->data('file_name');
                        $this->db->set('payment_image', $new_image);
                    } else {
                        echo $this->upload->display_errors();
                    }
                }

                $data = [
                    'name'          => htmlspecialchars($this->input->post('name', true)),
                    'telp'          => htmlspecialchars($this->input->post('phone', true)),
                    'email'         => htmlspecialchars($this->input->post('email', true)),
                    'address'       => htmlspecialchars($this->input->post('address', true)),
                    'kost'          => htmlspecialchars($this->input->post('kost', true)),
                    'kost_location' => htmlspecialchars($this->input->post('full_address', true)),
                    'price'         => htmlspecialchars($this->input->post('price', true)),
                    'start_date'          => $this->input->post('dateOfEntry', true),
                    'payment_image'         => $uploadImage,
                    'status'        => 'process',
                    'date_created'  => time()
                ];

                $updateDataUser = [
                    'kost'          => htmlspecialchars($this->input->post('kost', true)),
                    'kost_location' => htmlspecialchars($this->input->post('full_address', true)),
                    'price'         => htmlspecialchars($this->input->post('price', true)),
                    'startDate'          => $this->input->post('dateOfEntry', true),
                    'status_booking'         => 'process',
                ];


                $this->db->insert('transaksi', $data);
                // update kost user in table user
                $this->db->set($updateDataUser);
                $this->db->where('email', $this->session->userdata('email'));
                $this->db->update('user');
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
                Booking Success!</div>');
                redirect('transaction/successBooking');
            }
        } else {
            redirect('auth');
        }
    }

    public function successBooking()
    {
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $kost_id = $this->uri->segment(3);
        $this->db->select('*');
        $this->db->from('transaksi');
        $this->db->order_by('id', 'DESC');
        $this->db->limit(1);
        $data['transaksi'] = $this->db->get()->row_array();

        $data['title'] = 'Success Booking';

        $this->load->view('detail/success_booking', $data);
        // update kost user 
    }

    public function confirm()
    {

        $this->db->set('status', 'Confirm');
        $this->db->where('id', $this->uri->segment(3));
        $this->db->update('transaksi');

        $this->db->set('status_booking', 'Confirmed');
        $this->db->where('email', $this->session->userdata('email'));
        $this->db->update('user');

        redirect('transaction/index');
    }

    public function reject()
    {
        $this->db->set('status', 'Reject');
        $this->db->where('id', $this->uri->segment(3));
        $this->db->update('transaksi');

        $this->db->set('status_booking', 'Rejected');
        $this->db->where('email', $this->session->userdata('email'));
        $this->db->update('user');

        redirect('transaction/index');
    }
}
