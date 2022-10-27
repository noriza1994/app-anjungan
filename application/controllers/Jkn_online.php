<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jkn_online extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('tgl_indo_helper');
        $this->load->helper('bpjs_helper');
        $this->load->library('javascript');
        $this->load->library('pdf');
        $this->load->model('Jkn_model', 'jm', true);
		$this->dbrs = $this->load->database('dbrs', TRUE);
	}

    //======================================== Form Antrian Add ==============================//

    public function pasien_baru($noka)
    {   
        $hasil           = $this->referensi_peserta_jkn($noka);
        // $prop            = $this->referensi_provinsi();
        $data['peserta'] = $hasil;
        // $data['prop']    = $prop;
        //print_r($data); die();
        $this->load->view('pasien_baru', $data);
    }

    //======================================== Form Antrian Add ==============================//

	public function antrian()
	{
		$this->load->view('jkn_online');
	}

    //========================================= Bukti Daftar ================================//

    public function bukti_daftar($no_boking)
    {   
        $data['tiket'] = $this->jm->referensi_jkn($no_boking);
        $this->load->view('bukti_daftar', $data);
    }

    //======================================= Cetak Bukti Daftar ===============================//

    public function ctk_bukti_daftar($no_boking){
        $data['tiket'] = $this->jm->referensi_jkn($no_boking);
        $this->load->view('ctk_bukti_daftar_jkn', $data);
    }

    //=============================== List JKN Online ===============================//

    public function list_jkn_online(){
        $tanggal         = date('Y-m-d');
        $data['periode'] = ['tanggal' => $tanggal];
        $data['jkn']     = $this->jm->referensi_jkn_online($tanggal);
        $this->load->view('list_jkn_online', $data);
    }

    public function filter_list_jkn_online(){
        $tanggal         = $this->input->post('tanggal');
        $data['periode'] = ['tanggal' => $tanggal];
        $data['jkn']     = $this->jm->referensi_jkn_online($tanggal);
        $this->load->view('list_jkn_online', $data);
    }

    //================================= Referensi Peserta ===========================//

    public function referensi_peserta(){
        $noka  = $_GET['noka'];

        $query = $this->dbrs->query("SELECT no_rkm_medis, no_peserta, no_ktp, nm_pasien, no_ktp, no_tlp, tgl_lahir, keluarga, namakeluarga, alamatpj, kelurahanpj, kecamatanpj, kabupatenpj, propinsipj from pasien where no_rkm_medis = '$noka' or no_peserta = '$noka'");
        $pasien= $query->row_array();

        echo json_encode($pasien);
        
       
    }	

    //========================================== Tambah Antrian Online JKN =============================//

	public function add_antrian_jkn(){
        $timezone = new DateTimeZone('Asia/Jakarta');
        $date     = new DateTime();
        $date->setTimeZone($timezone);
        $jam      = $date->format('H:i:s');

        $no_rkm_medis   = $this->input->post('no_rkm_medis');
        $birthday       = $this->input->post('tgl_lahir');
        $tgl_registrasi = date('Y-m-d');
        $kd_dokter      = $this->input->post('kd_dokter');
        $kd_poli        = $this->input->post('kd_poli');
        $kunjungan      = $this->input->post('jns_kunjungan');

        //===================================== Hitung Umur =====================================//
        $biday = new DateTime($birthday);
        $today = new DateTime();
        $diff = $today->diff($biday);
        if ($diff->y < 0) {
            $umur       = $diff->m;
            $stts_umur  = 'Bl';
        }elseif ($diff->m < 0) {
            $umur = $diff->d;
            $stts_umur  = 'Hr';
        }else{
            $umur = $diff->y;
            $stts_umur  = 'Th';
        }
        
        //========================================= No Registrasi ========================================//
        $cek_dokter   = $this->dbrs->query("SELECT b.kd_dokter, a.nm_dokter_bpjs from maping_dokter_dpjpvclaim a join dokter b on a.kd_dokter=b.kd_dokter where a.kd_dokter_bpjs = '$kd_dokter'");
        $dokter       = $cek_dokter->row_array();
        $kd_dokter_rs = $dokter['kd_dokter'];

        $no_reg_akhir = $this->dbrs->query("SELECT max(no_reg)+1 as regis FROM reg_periksa WHERE kd_dokter='$kd_dokter_rs' and tgl_registrasi='$tgl_registrasi'");

        $no_urut_reg = $no_reg_akhir->row();
        $no_urut_reg = sprintf('%03d', $no_urut_reg->regis);
        $null = 0;
        if ($no_urut_reg == $null ){
            $no_urut_reg = 1;
        } else {
            $no_urut_reg = sprintf("%03d", $no_urut_reg);
        } 

        $no_reg = sprintf("%03d", $no_urut_reg);

        //===================================== No Rawat =================================================//

        $no_rawat_akhir = $this->dbrs->query("SELECT max(no_rawat) as no_rawat FROM reg_periksa WHERE tgl_registrasi = '$tgl_registrasi'");
        $date           = date_create($tgl_registrasi);
        $tanggal        = date_format($date, 'Y/m/d');
        $no_urut_rawat  = $no_rawat_akhir->row();
        $no_rawat       = $tanggal.'/'.sprintf('%06d', substr($no_urut_rawat->no_rawat, 11) + 1);
        
        //======================================= Status Poli =============================================//
        $cek_poli    = $this->dbrs->query("SELECT b.kd_poli, a.nm_poli_bpjs from maping_poli_bpjs a join poliklinik b on a.kd_poli_rs=b.kd_poli where a.kd_poli_bpjs = '$kd_poli'");
        $poli        = $cek_poli->row_array();
        $kd_poli_rs  = $poli['kd_poli'];

        $status_poli = $this->dbrs->query("SELECT no_rawat from reg_periksa where kd_poli = '$kd_poli_rs' and no_rkm_medis = '$no_rkm_medis'")->num_rows();
        if ($status_poli > 0) {
            $status_poli = 'Lama';
        } else {
            $status_poli = 'Baru';
        }

        if ($kunjungan == '1') {
            $jns_kunjungan = '1 (Rujukan FKTP)';
        }else if($kunjungan == '2'){
            $jns_kunjungan = '2 (Rujukan Internal)';
        }else if ($kunjungan == '3') {
            $jns_kunjungan = '3 (Kontrol)';
        }else if ($kunjungan == '4') {
            $jns_kunjungan = '4 (Rujukan Antar RS)';
        }
          
        //======================================= Data Reg_pasien ==============================================//
        $reg = [   
                    'no_reg'            => $no_reg,
                    'no_rawat'          => $no_rawat,
                    'tgl_registrasi'    => $tgl_registrasi,
                    'jam_reg'           => $jam,
                    'kd_dokter'         => $kd_dokter_rs, 
                    'no_rkm_medis'      => $no_rkm_medis,
                    'kd_poli'           => $kd_poli_rs,
                    'p_jawab'           => $this->input->post('p_jawab'),
                    'almt_pj'           => $this->input->post('almt_pj').$this->input->post('kelurahanpj').$this->input->post('kecamatanpj').$this->input->post('kabupatenpj').$this->input->post('propinsipj'),
                    'hubunganpj'        => $this->input->post('hubungan_pj'),
                    'biaya_reg'         => '0',
                    'stts'              => 'Belum',
                    'stts_daftar'       => 'Lama',
                    'status_lanjut'     => 'Ralan',
                    'kd_pj'             => 'BPJ',
                    'umurdaftar'        => $umur,
                    'sttsumur'          => $stts_umur,
                    'status_bayar'      => 'Belum Bayar',
                    'status_poli'       => $status_poli
                ];
        //echo json_encode($reg); die();
        //================================= Data Reg_online ======================================//
        
        $dilayani  = $no_reg * 6;
        $no_boking = date('Ymd').sprintf('%06d', substr($no_urut_rawat->no_rawat, 11) + 1);
        //echo print_r($no_boking); die();
        $json = [
               'kodebooking'        => $no_boking,
               'jenispasien'        => 'JKN',
               'nomorkartu'         => $this->input->post('noka'),
               'nik'                => $this->input->post('nik'),
               'nohp'               => $this->input->post('no_hp'),
               'kodepoli'           => $this->input->post('kd_poli'),
               'namapoli'           => $poli['nm_poli_bpjs'],
               'pasienbaru'         => 0,
               'norm'               => $this->input->post('no_rkm_medis'),
               'tanggalperiksa'     => date('Y-m-d'),
               'kodedokter'         => $this->input->post('kd_dokter'),
               'namadokter'         => $dokter['nm_dokter_bpjs'],
               'jampraktek'         => '08:00-15:00',
               'jeniskunjungan'     => $this->input->post('jns_kunjungan'),
               'nomorreferensi'     => $this->input->post('no_referensi'),
               'nomorantrean'       => $kd_poli.'-'.$no_reg,
               'angkaantrean'       => $no_reg,
               'estimasidilayani'   => strtotime('08:15:00'.'+'.$dilayani.' minute') * 1000,
               'sisakuotajkn'       => 20 - $no_reg,   
               'kuotajkn'           => 20,
               'sisakuotanonjkn'    => 20 - $no_reg,
               'kuotanonjkn'        => 20,
               'keterangan'         => 'Peserta harap 30 menit lebih awal guna pencatatan administrasi.'
            ];
        //echo json_encode($json); die();
        $jkn_local = [
                        'nobooking'         => $no_boking,
                        'no_rawat'          => $no_rawat,
                        'nomorkartu'        => $this->input->post('noka'),
                        'nik'               => $this->input->post('nik'),
                        'nohp'              => $this->input->post('no_hp'),
                        'kodepoli'          => $this->input->post('kd_poli'),
                        'pasienbaru'        => 0,
                        'norm'              => $this->input->post('no_rkm_medis'),
                        'tanggalperiksa'    => date('Y-m-d'),
                        'kodedokter'        => $this->input->post('kd_dokter'),
                        'jampraktek'        => '08:00-15:00',
                        'jeniskunjungan'    => $jns_kunjungan,
                        'nomorreferensi'    => $this->input->post('no_referensi'),
                        'nomorantrean'      => $kd_poli.'-'.$no_reg,
                        'angkaantrean'      => $no_reg,
                        'estimasidilayani'  => strtotime('08:15:00'.'+'.$dilayani.' minute') * 1000,  
                        'sisakuotajkn'      => 20 - $no_reg,
                        'kuotajkn'          => 20,
                        'sisakuotanonjkn'   => 20 - $no_reg,
                        'kuotanonjkn'       => 20,
                        'status'            => 'Checkin',
                        'validasi'          => date('Y-m-d '.$jam.''),
                        'statuskirim'       => 'Sudah'
                    ];
       
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => ''.$this->config->item('antrol_url').'/'.$this->config->item('antrol_servisce').'/antrean/add',
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($json),
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_HTTPHEADER => [
                "Content-Type: Application/x-www-form-urlencoded",
                "X-cons-id: ".$this->config->item('antrol_cons_id'),
                "X-timestamp: ".$this->config->item('antrol_tStamp'),
                "X-signature: ".$this->config->item('antrol_encodedSignature'),
                "user_key: ".$this->config->item('antrol_user_key')
            ],
        ));

        $response = curl_exec($curl);
        $err      = curl_error($curl);
        curl_close($curl);

        if ($err) {   echo "Hubungi Administrator Jaringan Tony Stark 0852-7708-8878" . $err;
        } else {

            $query     = json_decode($response, true);
            //echo json_encode($query); die();
            if ($query['metadata']['code'] == 200) {
               $this->dbrs->insert('reg_periksa', $reg);
               $this->dbrs->insert('referensi_mobilejkn_bpjs', $jkn_local);
               redirect(site_url('jkn_online/cek_antri1/'.$no_boking.''));
            } else {
              redirect(site_url('jkn_online/antrian'));
            }
        }
    }

    //=============================================== Kirim Taks ID 1 ===========================================//

    public function cek_antri1($no_boking){
        $timezone = new DateTimeZone('UTC');
        $date     = new DateTime();
        $date->setTimeZone($timezone);
        $jam      = $date->format('H:i:s');
        $waktu    = strtotime(''.date('Y-m-d').' '.$jam.'') * 1000 + 7;

        $json = [
    
                    'kodebooking' => $no_boking,
                    'taskid'      => '3',
                    'waktu'       => $waktu
   
                ];

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => ''.$this->config->item('antrol_url').'/'.$this->config->item('antrol_servisce').'/antrean/updatewaktu',
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($json),
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_HTTPHEADER => [
               "Content-Type: Application/x-www-form-urlencoded",
                "X-cons-id: ".$this->config->item('antrol_cons_id'),
                "X-timestamp: ".$this->config->item('antrol_tStamp'),
                "X-signature: ".$this->config->item('antrol_encodedSignature'),
                "user_key: ".$this->config->item('antrol_user_key')
            ],
        ));

        $response = curl_exec($curl);
        $err      = curl_error($curl);
        curl_close($curl);
        //echo json_encode($response); die();
        if ($err) {   echo "Hubungi Administrator Jaringan Tony Stark 0852-7708-8878" . $err;
        } else {

            // $query   = json_decode($response, true);
            // redirect(site_url('jkn_online/cek_antri2/'.$no_boking.''));
            $query   = json_decode($response, true);
            redirect(site_url('jkn_online/bukti_daftar/'.$no_boking.''));
            
        }
    }

    //======================================================== Kirim Taks ID 2 ==========================================//

    public function cek_antri2($no_boking){
        $timezone = new DateTimeZone('UTC');
        $date     = new DateTime();
        $date->setTimeZone($timezone);
        $jam      = $date->format('H:i:s');
        $waktu    = strtotime(''.date('Y-m-d').' '.$jam.'') * 1000 + 7;

        $json = [
    
                    'kodebooking' => $no_boking,
                    'taskid'      => '2',
                    'waktu'       => $waktu
   
                ];

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => ''.$this->config->item('antrol_url').'/'.$this->config->item('antrol_servisce').'/antrean/updatewaktu',
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($json),
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_HTTPHEADER => [
               "Content-Type: Application/x-www-form-urlencoded",
                "X-cons-id: ".$this->config->item('antrol_cons_id'),
                "X-timestamp: ".$this->config->item('antrol_tStamp'),
                "X-signature: ".$this->config->item('antrol_encodedSignature'),
                "user_key: ".$this->config->item('antrol_user_key')
            ],
        ));

        $response = curl_exec($curl);
        $err      = curl_error($curl);
        curl_close($curl);
        //echo json_encode($response); die();
        if ($err) {   echo "Hubungi Administrator Jaringan Tony Stark 0852-7708-8878" . $err;
        } else {

            $query   = json_decode($response, true);
            redirect(site_url('jkn_online/bukti_daftar/'.$no_boking.''));
            
        }
    }

    //===================================================== Update Taks ID =================================================//

    public function taksid($no_boking, $taksid){
        $nobooking = str_replace('--', '/', $no_boking);
        $timezone = new DateTimeZone('UTC');
        $date     = new DateTime();
        $date->setTimeZone($timezone);
        $jam      = $date->format('H:i:s');
        $waktu    = strtotime(''.date('Y-m-d').' '.$jam.'') * 1000 + 7;

        $json = [
    
                    'kodebooking' => $nobooking,
                    'taskid'      => $taksid,
                    'waktu'       => $waktu
   
                ];

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => ''.$this->config->item('antrol_url').'/'.$this->config->item('antrol_servisce').'/antrean/updatewaktu',
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($json),
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_HTTPHEADER => [
               "Content-Type: Application/x-www-form-urlencoded",
                "X-cons-id: ".$this->config->item('antrol_cons_id'),
                "X-timestamp: ".$this->config->item('antrol_tStamp'),
                "X-signature: ".$this->config->item('antrol_encodedSignature'),
                "user_key: ".$this->config->item('antrol_user_key')
            ],
        ));

        $response = curl_exec($curl);
        $err      = curl_error($curl);
        curl_close($curl);
        
        if ($err) {   echo "Hubungi Administrator Jaringan Tony Stark 0852-7708-8878" . $err;
        } else {

            $query   = json_decode($response, true);
            $notif   = $query['metadata']['message'];
            $this->session->set_flashdata('notifikasi', ''.$notif.'');
            redirect(site_url('jkn_online/list_jkn_online'));
            
        }
    }

    //====================================================== Referensi Poliklinik ===========================================//

	public function referensi_poli(){
        $kd_poli  = $this->input->post('cek_poli');
		// $query = $this->dbrs->query("select * from maping_poli_bpjs where kd_poli_bpjs = '$kd_poli'");
		$query = $this->dbrs->query("select * from maping_poli_bpjs");
		$poli= $query->result_array();
		echo json_encode($poli);
	}

    //===================================================== Referensi Dokter ================================================//

	public function referensi_dokter(){
		$kd_poli  = $this->input->post('poli');
		$hari     = hari(date('Y-m-d'));

		// $query    = $this->dbrs->query("select b.kd_dokter_bpjs, b.nm_dokter_bpjs, a.jam_mulai, a.jam_selesai, a.kuota from jadwal a join maping_dokter_dpjpvclaim b on a.kd_dokter=b.kd_dokter join maping_poli_bpjs c on a.kd_poli=c.kd_poli_rs where a.hari_kerja = '$hari'");
		$query    = $this->dbrs->query("select b.kd_dokter_bpjs, b.nm_dokter_bpjs, a.jam_mulai, a.jam_selesai, a.kuota from jadwal a join maping_dokter_dpjpvclaim b on a.kd_dokter=b.kd_dokter join maping_poli_bpjs c on a.kd_poli=c.kd_poli_rs where c.kd_poli_bpjs = '$kd_poli' and a.hari_kerja = '$hari'");
		$dokter   = $query->result_array();
		echo json_encode($dokter);
	}

    //===================================================== Referensi Nomor Daftar ==========================================//

    public function referensi_nomor_daftar(){
       $noka           = $this->input->post('noka');
       $jns_kunjungan  = $this->input->post('jns_kunjungan');
        //======================================== JNS Kunjungan 1 Rujukan FKTP ======================================//
        if ($jns_kunjungan == '1') {

            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_URL => ''.$this->config->item('vclaim_url').'/'.$this->config->item('vclaim_servisce').'/Rujukan/List/Peserta/'.$noka.'',
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_HTTPHEADER => [
                    "Content-Type: Application/x-www-form-urlencoded",
                    "X-cons-id: ".$this->config->item('vclaim_cons_id'),
                    "X-timestamp: ".$this->config->item('vclaim_tStamp'),
                    "X-signature: ".$this->config->item('vclaim_encodedSignature'),
                    "user_key: ".$this->config->item('vclaim_user_key')
                ],
            ));

            $response = curl_exec($curl);
            $err = curl_error($curl);
            curl_close($curl);

            if ($err) {   echo "Hubungi Administrator Jaringan Tony Stark 0852-7708-8878" . $err;
            } else {
                $data    = json_decode($response, true);
                $string  = $data['response'];

                //Decript
                $output = decript($this->config->item('vclaim_key'), $string);
                //Compress
                $hasil  = compress($output);
                
                $ok     = json_decode($hasil);
                $tampil = json_encode($ok);
                $tampil1=json_decode($tampil, true);
                echo json_encode($tampil1['rujukan']);
            }
        //======================================== JNS Kunjungan 4 Rujukan FKTL ======================================//
        } elseif ($jns_kunjungan == '4') {
            $curl = curl_init();
            $tStamp = strval(time()-strtotime('1970-01-01 00:00:00'));
            curl_setopt_array($curl, array(
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_URL => ''.$this->config->item('vclaim_url').'/'.$this->config->item('vclaim_servisce').'/Rujukan/RS/List/Peserta/'.$noka.'',
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_HTTPHEADER => [
                    "Content-Type: Application/x-www-form-urlencoded",
                    "X-cons-id: ".$this->config->item('vclaim_cons_id'),
                    "X-timestamp: ".$this->config->item('vclaim_tStamp'),
                    "X-signature: ".$this->config->item('vclaim_encodedSignature'),
                    "user_key: ".$this->config->item('vclaim_user_key')
                ],
            ));

            $response = curl_exec($curl);
            $err = curl_error($curl);
            curl_close($curl);

            if ($err) {   echo "Hubungi Administrator Jaringan Tony Stark 0852-7708-8878" . $err;
            } else {

                $data    = json_decode($response, true);
                $string  = $data['response'];

                //Decript
                $output = decript($this->config->item('vclaim_key'), $string);
                //Compress
                $hasil  = compress($output);
                
                $ok     = json_decode($hasil);
                $tampil = json_encode($ok);
                $tampil1=json_decode($tampil, true);
                echo json_encode($tampil1['rujukan']);
            }
        //======================================== JNS Kunjungan 3 Rencana Kontrol ======================================//
        }elseif ($jns_kunjungan == '3') {
            $curl = curl_init();
            $tStamp = strval(time()-strtotime('1970-01-01 00:00:00'));
            curl_setopt_array($curl, array(
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_URL => ''.$this->config->item('vclaim_url').'/'.$this->config->item('vclaim_servisce').'/RencanaKontrol/ListRencanaKontrol/Bulan/06/Tahun/2022/Nokartu/'.$noka.'/filter/2022-06-07',
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_POSTFIELDS => json_encode($json),
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_HTTPHEADER => [
                    "Content-Type: Application/x-www-form-urlencoded",
                    "X-cons-id: ".$this->config->item('vclaim_cons_id'),
                    "X-timestamp: ".$this->config->item('vclaim_tStamp'),
                    "X-signature: ".$this->config->item('vclaim_encodedSignature'),
                    "user_key: ".$this->config->item('vclaim_user_key')
                ],
            ));

            $response = curl_exec($curl);
            $err = curl_error($curl);
            curl_close($curl);

            $key = $data.$secretKey.$tStamp;

            if ($err) {   echo "Hubungi Administrator Jaringan Tony Stark 0852-7708-8878" . $err;
            } else {

                $data    = json_decode($response, true);
                $string  = $data['response'];
                echo json_encode($string); die();
                //Decript
                $encrypt_method = 'AES-256-CBC';
                $key_hash       = hex2bin(hash('sha256', $key));
                $iv             = substr(hex2bin(hash('sha256', $key)), 0, 16);
                $output         = openssl_decrypt(base64_decode($string), $encrypt_method, $key_hash, OPENSSL_RAW_DATA, $iv);
                
                //Compress
                $hasil = \LZCompressor\LZString::decompressFromEncodedURIComponent($output);
                $ok    = json_decode($hasil);
                echo json_encode($ok);
            }
        } 
    }

    public function batal_antrian(){
        $timezone = new DateTimeZone('Asia/Jakarta');
        $date     = new DateTime();
        $date->setTimeZone($timezone);
        $jam      = $date->format('H:i:s');
        $waktu    = strtotime(''.date('Y-m-d').' '.$jam.'') * 1000;
        $waktu_server = date('Y-m-d').$jam;
        //echo json_encode($waktu_server); die();
        $json = [
    
                    'kodebooking' => '20200609000005',
                    'keterangan'  => 'Lama x Antri Akhirnya Saya Sembuh :D'
   
                ];

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => ''.$this->config->item('antrol_url').'/'.$this->config->item('antrol_servisce').'/dashboard/waktutunggu/tanggal/2022-06-09/waktu/rs',
            CURLOPT_CUSTOMREQUEST => "GET",
            //CURLOPT_CUSTOMREQUEST => "POST",
            //CURLOPT_POSTFIELDS => json_encode($json),
            //CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_HTTPHEADER => [
               "Content-Type: Application/x-www-form-urlencoded",
                "X-cons-id: ".$this->config->item('antrol_cons_id'),
                "X-timestamp: ".$this->config->item('antrol_tStamp'),
                "X-signature: ".$this->config->item('antrol_encodedSignature'),
                "user_key: ".$this->config->item('antrol_user_key')
            ],
        ));

        $response = curl_exec($curl);
        $err      = curl_error($curl);
        curl_close($curl);

        if ($err) {   echo "Hubungi Administrator Jaringan Tony Stark 0852-7708-8878" . $err;
        } else {

            $data    = json_decode($response, true);
            $string  = $data['response'];
            echo json_encode($string); die();
            
        }
    }

    //=============================================== List Taks ID Nomor Booking =========================================//

    public function getlisttask(){
        $timezone = new DateTimeZone('UTC');
        $date     = new DateTime();
        $date->setTimeZone($timezone);
        $jam      = $date->format('H:i:s');
        $waktu    = strtotime(''.date('Y-m-d').' '.$jam.'') * 1000 + 7;

        $json = [
    
                    'kodebooking' => '20220819PB004',
   
                ];

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => ''.$this->config->item('antrol_url').'/'.$this->config->item('antrol_servisce').'/antrean/getlisttask',
            //CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($json),
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_HTTPHEADER => [
               "Content-Type: Application/x-www-form-urlencoded",
                "X-cons-id: ".$this->config->item('antrol_cons_id'),
                "X-timestamp: ".$this->config->item('antrol_tStamp'),
                "X-signature: ".$this->config->item('antrol_encodedSignature'),
                "user_key: ".$this->config->item('antrol_user_key')
            ],
        ));

        $response = curl_exec($curl);
        $err      = curl_error($curl);
        curl_close($curl);

        if ($err) {   echo "Hubungi Administrator Jaringan Tony Stark 0852-7708-8878" . $err;
        } else {

            $data    = json_decode($response, true);
            $string  = $data['response'];
            
            //Decript
            $output = decript($this->config->item('antrol_key'), $string);
            //Compress
            $hasil  = compress($output);
            
            $ok     = json_decode($hasil);
            $tampil = json_encode($ok);
            $tampil1=json_decode($tampil, true);
            echo json_encode($tampil1);
            
        }
    }

    //=================================================== Dashboard Per Tanggal =======================================//

    public function dashboard_tanggal(){
        $tanggal = date('Y-m-d');
        $waktu = 'server';
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => ''.$this->config->item('antrol_url').'/'.$this->config->item('antrol_servisce').'/dashboard/waktutunggu/tanggal/'.$tanggal.'/waktu/'.$waktu.'',
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_HTTPHEADER => [
               "Content-Type: Application/x-www-form-urlencoded",
                "X-cons-id: ".$this->config->item('antrol_cons_id'),
                "X-timestamp: ".$this->config->item('antrol_tStamp'),
                "X-signature: ".$this->config->item('antrol_encodedSignature'),
                "user_key: ".$this->config->item('antrol_user_key')
            ],
        ));

        $response = curl_exec($curl);
        $err      = curl_error($curl);
        curl_close($curl);
        
        if ($err) {   echo "Hubungi Administrator Jaringan Tony Stark 0852-7708-8878" . $err;
        } else {

           $data = json_decode($response);
           $data1= $data->response->list;

           $data2['periode']   = [
                                    'tanggal' => $tanggal,
                                    'waktu'   => $waktu
                                ];
           $data2['dashboard'] = $data1;
           $this->load->view('dashboard_per_tanggal', $data2);
            
        }
    }

    public function filter_dashboard_tanggal(){
        $tanggal = $this->input->post('tanggal');
        $waktu   = $this->input->post('waktu');
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => ''.$this->config->item('antrol_url').'/'.$this->config->item('antrol_servisce').'/dashboard/waktutunggu/tanggal/'.$tanggal.'/waktu/'.$waktu.'',
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_HTTPHEADER => [
               "Content-Type: Application/x-www-form-urlencoded",
                "X-cons-id: ".$this->config->item('antrol_cons_id'),
                "X-timestamp: ".$this->config->item('antrol_tStamp'),
                "X-signature: ".$this->config->item('antrol_encodedSignature'),
                "user_key: ".$this->config->item('antrol_user_key')
            ],
        ));

        $response = curl_exec($curl);
        $err      = curl_error($curl);
        curl_close($curl);
        
        if ($err) {   echo "Hubungi Administrator Jaringan Tony Stark 0852-7708-8878" . $err;
        } else {

           $data = json_decode($response);
           $data1= $data->response->list;

           $data2['periode']   = [
                                    'tanggal' => $tanggal,
                                    'waktu'   => $waktu
                                ];
           $data2['dashboard'] = $data1;
           $this->load->view('dashboard_per_tanggal', $data2);
            
        }
    }

    //=================================================== Dashboard Per Bulan =========================================//

    public function dashboard_bulan(){
        $bulan = date('m');
        $tahun = date('Y');
        $waktu = 'server';
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => ''.$this->config->item('antrol_url').'/'.$this->config->item('antrol_servisce').'/dashboard/waktutunggu/bulan/'.$bulan.'/tahun/'.$tahun.'/waktu/'.$waktu.'',
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_HTTPHEADER => [
               "Content-Type: Application/x-www-form-urlencoded",
                "X-cons-id: ".$this->config->item('antrol_cons_id'),
                "X-timestamp: ".$this->config->item('antrol_tStamp'),
                "X-signature: ".$this->config->item('antrol_encodedSignature'),
                "user_key: ".$this->config->item('antrol_user_key')
            ],
        ));

        $response = curl_exec($curl);
        $err      = curl_error($curl);
        curl_close($curl);
        
        if ($err) {   echo "Hubungi Administrator Jaringan Tony Stark 0852-7708-8878" . $err;
        } else {

           $data = json_decode($response);
           $data1= $data->response->list;

           $data2['periode']   = [
                                    'bulan' => $bulan,
                                    'tahun' => $tahun,
                                    'waktu' => $waktu
                                ];
           $data2['dashboard'] = $data1;
           $this->load->view('dashboard_per_bulan', $data2);
            
        }
    }

    public function filter_dashboard_bulan(){
        $bulan = $this->input->post('bulan');
        $tahun = $this->input->post('tahun');
        $waktu = $this->input->post('waktu');
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => ''.$this->config->item('antrol_url').'/'.$this->config->item('antrol_servisce').'/dashboard/waktutunggu/bulan/'.$bulan.'/tahun/'.$tahun.'/waktu/'.$waktu.'',
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_HTTPHEADER => [
               "Content-Type: Application/x-www-form-urlencoded",
                "X-cons-id: ".$this->config->item('antrol_cons_id'),
                "X-timestamp: ".$this->config->item('antrol_tStamp'),
                "X-signature: ".$this->config->item('antrol_encodedSignature'),
                "user_key: ".$this->config->item('antrol_user_key')
            ],
        ));

        $response = curl_exec($curl);
        $err      = curl_error($curl);
        curl_close($curl);
        
        if ($err) {   echo "Hubungi Administrator Jaringan Tony Stark 0852-7708-8878" . $err;
        } else {

           $data = json_decode($response);
           $data1= $data->response->list;

           $data2['periode']   = [
                                    'bulan' => $bulan,
                                    'tahun' => $tahun,
                                    'waktu' => $waktu
                                ];
           $data2['dashboard'] = $data1;
           $this->load->view('dashboard_per_bulan', $data2);
            
        }
    }

    public function rujuk_internal(){
        
        $json = [
                    'request' => array(
                              't_suratkontrol' => array(
                                    'noSuratKontrol'     => '0017R0100422K000001',
                                    'user'               => 'Noriza'
                              )
                           )
                ];
       /* $json = [
                    'request' => array(
                              't_sep' => array(
                                    'noSep'              => '0017R0100422V000001',
                                    'noSurat'            => '0017R0100422K000001',
                                    'tglRujukanInternal' => '2022-04-12',
                                    'kdPoliTuj'          => 'BED',
                                    'user'               => 'Noriza'
                              )
                           )
                ];*/
        //echo json_encode($json); die();
        $curl = curl_init();
            $tStamp = strval(time()-strtotime('1970-01-01 00:00:00'));
            curl_setopt_array($curl, array(
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_URL => ''.$this->config->item('vclaim_url').'/'.$this->config->item('vclaim_servisce').'/RencanaKontrol/Delete',
                //CURLOPT_URL => ''.$this->config->item('vclaim_url').'/'.$this->config->item('vclaim_servisce').'/RencanaKontrol/ListRencanaKontrol/Bulan/04/Tahun/2022/Nokartu/0002078925197/filter/2',
                //CURLOPT_URL => ''.$this->config->item('vclaim_url').'/'.$this->config->item('vclaim_servisce').'/RencanaKontrol/nosep/0017R0100422V000001',
                //CURLOPT_URL => ''.$this->config->item('vclaim_url').'/'.$this->config->item('vclaim_servisce').'/SEP/Internal/0017R0100422V000001',
                //CURLOPT_URL => ''.$this->config->item('vclaim_url').'/'.$this->config->item('vclaim_servisce').'/monitoring/HistoriPelayanan/NoKartu/0002078925197}/tglMulai/2022-03-27/tglAkhir/2022-06-14',
                CURLOPT_CUSTOMREQUEST => "DELETE",
                CURLOPT_POSTFIELDS => json_encode($json),
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_HTTPHEADER => [
                    "Content-Type: Application/x-www-form-urlencoded",
                    "X-cons-id: ".$this->config->item('vclaim_cons_id'),
                    "X-timestamp: ".$this->config->item('vclaim_tStamp'),
                    "X-signature: ".$this->config->item('vclaim_encodedSignature'),
                    "user_key: ".$this->config->item('vclaim_user_key')
                ],
            ));

            $response = curl_exec($curl);
            $err = curl_error($curl);
            curl_close($curl);

            $key = $data.$secretKey.$tStamp;

            if ($err) {   echo "Hubungi Administrator Jaringan Tony Stark 0852-7708-8878" . $err;
            } else {

                $data    = json_decode($response, true);
                $string  = $data['response'];
                echo json_encode($data); die();
                //Decript
                $output = decript($this->config->item('vclaim_key'), $string);
                //Compress
                $hasil  = compress($output);
                
                $ok     = json_decode($hasil);
                $tampil = json_encode($ok);
                $tampil1=json_decode($tampil, true);
                echo json_encode($tampil1);
            }
    }

    public function referensi_peserta_jkn($noka){
        $tanggal= date('Y-m-d'); 
        $curl   = curl_init();
        $tStamp = strval(time()-strtotime('1970-01-01 00:00:00'));
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => ''.$this->config->item('vclaim_url').'/'.$this->config->item('vclaim_servisce').'/Peserta/nokartu/'.$noka.'/tglSEP/'.$tanggal.'',
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_HTTPHEADER => [
                "Content-Type: Application/x-www-form-urlencoded",
                "X-cons-id: ".$this->config->item('vclaim_cons_id'),
                "X-timestamp: ".$this->config->item('vclaim_tStamp'),
                "X-signature: ".$this->config->item('vclaim_encodedSignature'),
                "user_key: ".$this->config->item('vclaim_user_key')
            ],
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        if ($err) {   echo "Hubungi Administrator Jaringan Tony Stark 0852-7708-8878" . $err;
        } else {

            $data    = json_decode($response, true);
            $string  = $data['response'];

            //Decript
            $output = decript($this->config->item('vclaim_key'), $string);
            //Compress
            $hasil  = compress($output);
            
            $ok     = json_decode($hasil);
            $tampil = json_encode($ok);
            $tampil1= json_decode($tampil, true);
            return    $tampil1['peserta'];
        }
    }

    //========================================== Referensi Provinsi ===============================================//

    public function referensi_provinsi(){
        $curl   = curl_init();
        $tStamp = strval(time()-strtotime('1970-01-01 00:00:00'));
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => ''.$this->config->item('vclaim_url').'/'.$this->config->item('vclaim_servisce').'/referensi/propinsi',
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_HTTPHEADER => [
                "Content-Type: Application/x-www-form-urlencoded",
                "X-cons-id: ".$this->config->item('vclaim_cons_id'),
                "X-timestamp: ".$this->config->item('vclaim_tStamp'),
                "X-signature: ".$this->config->item('vclaim_encodedSignature'),
                "user_key: ".$this->config->item('vclaim_user_key')
            ],
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        if ($err) {   echo "Hubungi Administrator Jaringan Tony Stark 0852-7708-8878" . $err;
        } else {

            $data    = json_decode($response, true);
            $string  = $data['response'];

            //Decript
            $output = decript($this->config->item('vclaim_key'), $string);
            //Compress
            $hasil  = compress($output);
            
            $ok     = json_decode($hasil);
            $tampil = json_encode($ok);
            $tampil1= json_decode($tampil, true);
            return    $tampil1['list'];
        }
    }

    //========================================== Referensi Kabupaten ===============================================//

    public function referensi_kabupaten(){
        $provinsi = $this->input->post('provinsi');
        $curl     = curl_init();
        $tStamp   = strval(time()-strtotime('1970-01-01 00:00:00'));
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => ''.$this->config->item('vclaim_url').'/'.$this->config->item('vclaim_servisce').'/referensi/kabupaten/propinsi/'.$provinsi.'',
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_HTTPHEADER => [
                "Content-Type: Application/x-www-form-urlencoded",
                "X-cons-id: ".$this->config->item('vclaim_cons_id'),
                "X-timestamp: ".$this->config->item('vclaim_tStamp'),
                "X-signature: ".$this->config->item('vclaim_encodedSignature'),
                "user_key: ".$this->config->item('vclaim_user_key')
            ],
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        if ($err) {   echo "Hubungi Administrator Jaringan Tony Stark 0852-7708-8878" . $err;
        } else {

            $data    = json_decode($response, true);
            $string  = $data['response'];

            //Decript
            $output = decript($this->config->item('vclaim_key'), $string);
            //Compress
            $hasil  = compress($output);
            
            $ok     = json_decode($hasil);
            $tampil = json_encode($ok);
            $tampil1= json_decode($tampil, true);
            echo json_encode($tampil1['list']);
        }
    }

    //========================================== Referensi Kecamatan ===============================================//

    public function referensi_kecamatan(){
        $kabupaten= $this->input->post('kabupaten');
        $curl     = curl_init();
        $tStamp   = strval(time()-strtotime('1970-01-01 00:00:00'));
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => ''.$this->config->item('vclaim_url').'/'.$this->config->item('vclaim_servisce').'/referensi/kecamatan/kabupaten/'.$kabupaten.'',
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_HTTPHEADER => [
                "Content-Type: Application/x-www-form-urlencoded",
                "X-cons-id: ".$this->config->item('vclaim_cons_id'),
                "X-timestamp: ".$this->config->item('vclaim_tStamp'),
                "X-signature: ".$this->config->item('vclaim_encodedSignature'),
                "user_key: ".$this->config->item('vclaim_user_key')
            ],
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        if ($err) {   echo "Hubungi Administrator Jaringan Tony Stark 0852-7708-8878" . $err;
        } else {

            $data    = json_decode($response, true);
            $string  = $data['response'];

            //Decript
            $output = decript($this->config->item('vclaim_key'), $string);
            //Compress
            $hasil  = compress($output);
            
            $ok     = json_decode($hasil);
            $tampil = json_encode($ok);
            $tampil1= json_decode($tampil, true);
            echo json_encode($tampil1['list']);
        }
    }

    public function save_pasien_baru(){
        //================== Set Time Zone =================//
        $tanggal  = date('Y-m-d');
        $timezone = new DateTimeZone('UTC');
        $date     = new DateTime();
        $date->setTimeZone($timezone);
        $jam      = $date->format('H:i:s');
        //==================  Variable Pendukung ===========//
        $birthday       = $this->input->post('tgl_lahir');
        $kd_dokter      = $this->input->post('kd_dokter');
        $kd_poli        = $this->input->post('kd_poli');
        $kunjungan      = $this->input->post('jns_kunjungan');

        //======================================= Cek Dokter  =============================================//
        $cek_dokter   = $this->dbrs->query("SELECT b.kd_dokter, a.nm_dokter_bpjs from maping_dokter_dpjpvclaim a join dokter b on a.kd_dokter=b.kd_dokter where a.kd_dokter_bpjs = '$kd_dokter'");
        $dokter       = $cek_dokter->row_array();
        $kd_dokter_rs = $dokter['kd_dokter'];

        //======================================= Status Poli =============================================//
        $cek_poli    = $this->dbrs->query("SELECT b.kd_poli, a.nm_poli_bpjs from maping_poli_bpjs a join poliklinik b on a.kd_poli_rs=b.kd_poli where a.kd_poli_bpjs = '$kd_poli'");
        $poli        = $cek_poli->row_array();
        $kd_poli_rs  = $poli['kd_poli'];

        //======================================== Cek Jadwal & Kuota ===============================//
        $hari        = hari(date('Y-m-d')); 
        $cek_kuota  = $this->dbrs->query("SELECT * from jadwal where kd_dokter = '$kd_dokter_rs' and kd_poli = '$kd_poli_rs' and hari_kerja = '$hari'")->row_array();

        //=============== Menghitung Umur ==========================//
        $tanggal_lahir = $this->input->post('tgl_lahir');
        $tgl   = date('d');
        $bulan = date('m');
        $tahun = date('Y');
            
        $tgl_l   = substr($tanggal_lahir, 8, 2);
        $bulan_l = substr($tanggal_lahir, 5, 2);
        $tahun_l = substr($tanggal_lahir, 0, 4);
        
        $hitung_tahun = $tahun - $tahun_l;
        $hitung_bulan = $bulan - $bulan_l;
        $hitung_hari  = $tgl   - $tgl_l;

        $umur = $hitung_tahun." Th ".$hitung_bulan." Bl ".$hitung_hari." Hr ";
        
        $cek_rm   = $this->dbrs->query("SELECT no_rkm_medis from set_no_rkm_medis");
        $cek_rmok = $cek_rm->row_array();
        $no_rkm_medis = $cek_rmok['no_rkm_medis'] + 1;

        $data = [
                    'no_rkm_medis'      => $no_rkm_medis,
                    'nm_pasien'         => $this->input->post('nm_pasien'),
                    'jk'                => $this->input->post('jk'),
                    'tmp_lahir'         => '-',
                    'tgl_lahir'         => $this->input->post('tgl_lahir'),
                    'umur'              => $umur,
                    'nm_ibu'            => '-',
                    'agama'             => '-',
                    'gol_darah'         => '-',
                    'stts_nikah'        => '-',
                    'pnd'               => '-',
                    'pekerjaan'         => '-',
                    'no_tlp'            => $this->input->post('no_tlp'),
                    'no_ktp'            => $this->input->post('no_ktp'),
                    'alamat'            => '-',
                    'kd_kel'            => '62735',
                    'kd_kec'            => '7171',
                    'kd_kab'            => '514',
                    'kd_prop'           => '9001',
                    'keluarga'          => '-',
                    'alamatpj'          => '-',
                    'pekerjaanpj'       => '-',
                    'namakeluarga'      => '-',
                    'kelurahanpj'       => '-',
                    'kecamatanpj'       => '-',
                    'kabupatenpj'       => '-',
                    'propinsipj'        => '-',
                    'no_peserta'        => $this->input->post('no_peserta'),
                    'kd_pj'             => 'BPJ',
                    'cacat_fisik'       => '1',
                    'suku_bangsa'       => '189',
                    'bahasa_pasien'     => '113',
                    'perusahaan_pasien' => '-',
                    'email'             => '-',
                    'tgl_daftar'        => date('Y-m-d'),
                    'nip'               => '-'
                ];

        $cek_boking= $this->dbrs->query("select max(no_rawat) as nomor from reg_periksa where tgl_registrasi = '$tanggal'")->row_array();
        $cek_antri = $this->dbrs->query("select max(no_reg) as nomor from reg_periksa where tgl_registrasi = '$tanggal' and kd_poli = '$kd_poli_rs'")->row_array();
        
        $no_boking = date('Ymd').'PB'.sprintf('%03d', substr($cek_boking['nomor'], 11) + 1);
        $no_antri  = sprintf('%03d', $cek_antri['nomor'] + 1);

        //print_r($no_antri); die();

        $dilayani  = $cek_boking['nomor'] * 6;

        $json = [
               'kodebooking'        => $no_boking,
               'jenispasien'        => 'JKN',
               'nomorkartu'         => $this->input->post('no_peserta'),
               'nik'                => $this->input->post('no_ktp'),
               'nohp'               => $this->input->post('no_tlp'),
               'kodepoli'           => $this->input->post('kd_poli'),
               'namapoli'           => $poli['nm_poli_bpjs'],
               'pasienbaru'         => 1,
               'norm'               => $no_rkm_medis,
               'tanggalperiksa'     => $tanggal,
               'kodedokter'         => $this->input->post('kd_dokter'),
               'namadokter'         => $dokter['nm_dokter_bpjs'],
               'jampraktek'         => substr($cek_kuota['jam_mulai'], 0, -3).'-'.substr($cek_kuota['jam_selesai'], 0, -3),
               'jeniskunjungan'     => $this->input->post('jns_kunjungan'),
               'nomorreferensi'     => $this->input->post('no_referensi'),
               'nomorantrean'       => $kd_poli.'-'.$no_antri,
               'angkaantrean'       => $no_antri,
               'estimasidilayani'   => strtotime('08:15:00'.'+'.$dilayani.' minute') * 1000 + 7,
               'sisakuotajkn'       => $cek_kuota['kuota'] - $no_antri,   
               'kuotajkn'           => $cek_kuota['kuota'] + 0,
               'sisakuotanonjkn'    => $cek_kuota['kuota'] - $no_antri,
               'kuotanonjkn'        => $cek_kuota['kuota'] + 0,
               'keterangan'         => 'Peserta harap 30 menit lebih awal guna pencatatan administrasi.'
            ];
        
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => ''.$this->config->item('antrol_url').'/'.$this->config->item('antrol_servisce').'/antrean/add',
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($json),
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_HTTPHEADER => [
                "Content-Type: Application/x-www-form-urlencoded",
                "X-cons-id: ".$this->config->item('antrol_cons_id'),
                "X-timestamp: ".$this->config->item('antrol_tStamp'),
                "X-signature: ".$this->config->item('antrol_encodedSignature'),
                "user_key: ".$this->config->item('antrol_user_key')
            ],
        ));

        $response = curl_exec($curl);
        $err      = curl_error($curl);
        curl_close($curl);

        if ($err) {   echo "Hubungi Administrator Jaringan Tony Stark 0852-7708-8878" . $err;
        } else {

            $query     = json_decode($response, true);
            if ($query['metadata']['code'] == 200) {
                //===== SImpan Data Ke Table Pasien =====//
                $this->dbrs->insert('pasien', $data);
                //===== Set RM Terakhir =================//
                $this->dbrs->set('no_rkm_medis', $no_rkm_medis);
                $this->dbrs->update('set_no_rkm_medis');
                //===== Set PB Onsite ===================//
                $this->dbrs->set('no_rkm_medis', $no_rkm_medis);
                $this->dbrs->set('no_boking', $no_boking);
                $this->dbrs->set('tanggal', $tanggal);
                $this->dbrs->set('no_referensi', $this->input->post('no_referensi'));
                $this->dbrs->set('jns_kunjungan', $this->input->post('jns_kunjungan'));
                $this->dbrs->insert('uxui_pasien_baru_onsite');

                $jam      = $date->format('H:i:s');
                $waktu    = strtotime(''.date('Y-m-d').' '.$jam.'') * 1000 + 7;

                $json = [
            
                            'kodebooking' => $no_boking,
                            'taskid'      => '1',
                            'waktu'       => $waktu
           
                        ];

                $curl = curl_init();
                curl_setopt_array($curl, array(
                    CURLOPT_RETURNTRANSFER => 1,
                    CURLOPT_URL => ''.$this->config->item('antrol_url').'/'.$this->config->item('antrol_servisce').'/antrean/updatewaktu',
                    CURLOPT_CUSTOMREQUEST => "POST",
                    CURLOPT_POSTFIELDS => json_encode($json),
                    CURLOPT_SSL_VERIFYPEER => false,
                    CURLOPT_HTTPHEADER => [
                       "Content-Type: Application/x-www-form-urlencoded",
                        "X-cons-id: ".$this->config->item('antrol_cons_id'),
                        "X-timestamp: ".$this->config->item('antrol_tStamp'),
                        "X-signature: ".$this->config->item('antrol_encodedSignature'),
                        "user_key: ".$this->config->item('antrol_user_key')
                    ],
                ));

                $response = curl_exec($curl);
                $err      = curl_error($curl);
                curl_close($curl);
                
                redirect(site_url('jkn_online/bukti_daftarPB/'.$no_boking.'/'.$no_antri.'/'.$no_rkm_medis.''));

            } else {
              redirect(site_url('beranda/index'));
            }
        }
    }

    public function bukti_daftarPB($no_boking, $no_antri, $no_rkm_medis){   
        $timezone = new DateTimeZone('Asia/Jakarta');
        $date = new DateTime();
        $date->setTimeZone($timezone);
        $tanggal = date('Y-m-d');
        $query   = $this->db->query("SELECT max(number) + 1 as number from sequences where post = 'POST1' and date = '$tanggal'");
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
                    'post'      => 'POST1',
                    'source'    => 'TICKET#1',
                    'date'      => $tanggal,
                    'starttime' => $date->format('Y-m-d H:i:s'),
                    'calltime'  => null,
                    'endtime'   => null,
                    'call2time' => null
                ];

        $this->db->insert('sequences', $data);
        $this->db->insert('jobs', $data);

        $data['tiket'] = [
                            'no_boking'    => $no_boking,
                            'no_antri'     => $no_antri,
                            'no_rkm_medis' => $no_rkm_medis,
                            'nomor'        => $nomor
                        ];
        $this->load->view('bukti_daftarPB', $data);
    }

}
