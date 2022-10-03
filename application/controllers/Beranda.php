<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Beranda extends CI_Controller {

	function __construct() {
	    parent::__construct();
	    $this->dbrs = $this->load->database('dbrs', TRUE);
	    $this->load->library('pdf');
	    $this->load->helper('tgl_indo_helper');
	}

	public function index()
	{
		$this->load->view('dashboard');
	}

	public function cek_data(){
		$query = $this->db->query("select * from sequences");
		$antrian = $query->result_array();

		echo json_encode($antrian); 
	}

	public function add_antrian(){
		$timezone = new DateTimeZone('Asia/Jakarta');
		$date = new DateTime();
		$date->setTimeZone($timezone);
		$post    = $this->input->post('post');
		$source  = $this->input->post('source');
		$tanggal = date('Y-m-d');

		$query   = $this->db->query("SELECT max(number) + 1 as number from sequences where post = '$post' and date = '$tanggal'");
		$number  = $query->row_array();

		if (is_null($number['number'])) {
			$nomor = 1;
		} else {
			$nomor = $number['number'];
		}
		

		$data = [
				    'number'    => $nomor,
				    'status'    => 'WAITING',
				    'station'   => null,
				    'post'      => $post,
				    'source'    => $source,
				    'date'      => $tanggal,
				    'starttime' => $date->format('Y-m-d H:i:s'),
				    'calltime'  => null,
				    'endtime'   => null,
				    'call2time' => null
				];

		//echo json_encode($data); die();
		$this->db->insert('sequences', $data);
		$this->db->insert('jobs', $data);
		
		redirect(site_url('beranda/ctk_antrian/'.$post.''));
	}

	public function ctk_antrian($post){
		$tanggal = date('Y-m-d');
		$query   = $this->db->query("SELECT * from sequences a join posts b on a.post=b.name where a.post = '$post' and a.date = '$tanggal' order by a.number DESC limit 1");
		$tiket   = $query->row_array();

		$data['tiket'] = $tiket;
		$this->load->view('ctk_tiket', $data);

	}

	public function ctk_antrian_PBJKN($post, $no_boking, $no_antri, $no_rkm_medis){
		$tanggal = date('Y-m-d');
		$query   = $this->db->query("SELECT * from sequences a join posts b on a.post=b.name where a.post = '$post' and a.date = '$tanggal' order by a.number DESC limit 1");
		$tiket   = $query->row_array();

		$data['PB']    = [
							'no_boking'     => $no_boking,
							'no_antri_poli' => $no_antri,
							'no_rkm_medis'  => $no_rkm_medis
						];
		$data['tiket'] = $tiket;
		$this->load->view('ctk_tiketPB', $data);
	}

	public function updater(){
		$this->load->view('taks_id');
	}
}
