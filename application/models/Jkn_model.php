<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jkn_model extends CI_Model {

	function __construct() {
	    parent::__construct();
	    $this->dbrs = $this->load->database('dbrs', TRUE);
	}

	//============================================== Data Referensi JKN Online ==================================//

	public function referensi_jkn($no_boking){
		$this->dbrs->select('a.nobooking, a.no_rawat, b.nm_pasien, a.nomorkartu, a.nik, a.nohp, a.tanggalperiksa, a.nomorantrean, a.norm, a.nomorreferensi, a.estimasidilayani, d.nm_poli_bpjs, c.nm_dokter_bpjs');
		$this->dbrs->from('referensi_mobilejkn_bpjs a');
		$this->dbrs->join('pasien b',  'a.norm=b.no_rkm_medis');
		$this->dbrs->join('maping_dokter_dpjpvclaim c', 'a.kodedokter=c.kd_dokter_bpjs');
		$this->dbrs->join('maping_poli_bpjs d', 'a.kodepoli=d.kd_poli_bpjs');
		$this->dbrs->where('a.nobooking', $no_boking);
		return $this->dbrs->get()->row_array();
	}

	public function referensi_jkn_online($tanggal){
		$this->dbrs->select('a.nobooking, b.nm_pasien, c.nm_poli_bpjs, a.jeniskunjungan');
		$this->dbrs->from('referensi_mobilejkn_bpjs a');
		$this->dbrs->join('pasien b', 'a.norm=b.no_rkm_medis');
		$this->dbrs->join('maping_poli_bpjs c', 'a.kodepoli=c.kd_poli_bpjs');
		$this->dbrs->where('a.tanggalperiksa', $tanggal);
		return $this->dbrs->get()->result_array();
	}
}
