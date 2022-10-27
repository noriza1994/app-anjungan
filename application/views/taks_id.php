<?php 
    
    $page = site_url('beranda/updater');
    $sec = "25";
    header("Refresh: $sec; url=$page");

    $tanggal  = date('Y-m-d');
    $timezone = new DateTimeZone('UTC');
    $date     = new DateTime();
    $date->setTimeZone($timezone);
    $jam      = $date->format('H:i:s');
    $waktu    = strtotime(''.date('Y-m-d').' '.$jam.'') * 1000 + 7;
    //================================================ Update Taks ID 2 JKN ==================================================//

    $cek_reg = $this->dbrs->query("SELECT 
                                          a.no_reg, 
                                          a.no_rawat,
                                          a.kd_poli,
                                          a.kd_dokter, 
                                          b.no_rkm_medis, 
                                          b.no_boking, 
                                          b.tanggal, 
                                          b.no_referensi,  
                                          b.jns_kunjungan, 
                                          b.posisi,
                                          c.no_peserta,
                                          c.no_ktp,
                                          c.no_tlp 
                                  from reg_periksa a 
                                  join uxui_pasien_baru_onsite b on a.no_rkm_medis=b.no_rkm_medis 
                                  join pasien c on b.no_rkm_medis=c.no_rkm_medis 
                                  where b.posisi = 'Belum' and b.tanggal = '$tanggal'")->result_array();

   if (!empty($cek_reg)) {
     foreach ($cek_reg as $data) {
      //============================================ Update Taks ID 2  Setelah Reg_periksa ==================================//

          $json = [
      
                      'kodebooking' => $data['no_boking'],
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

        //======================================================= Insert Referensi JKN  ==============================================//

          $dilayani  = $data['no_reg'] * 6;
          $kunjungan = $data['jns_kunjungan'];

         if ($kunjungan == '1') {
              $jns_kunjungan = '1 (Rujukan FKTP)';
          }else if($kunjungan == '2'){
              $jns_kunjungan = '2 (Rujukan Internal)';
          }else if ($kunjungan == '3') {
              $jns_kunjungan = '3 (Kontrol)';
          }else if ($kunjungan == '4') {
              $jns_kunjungan = '4 (Rujukan Antar RS)';
          }

         $onsite_jkn[] = [
                        'nobooking'         => $data['no_boking'], 
                        'no_rawat'          => $data['no_rawat'],
                        'nomorkartu'        => $data['no_peserta'],
                        'nik'               => $data['no_ktp'],
                        'nohp'              => $data['no_tlp'],
                        'kodepoli'          => $data['kd_poli'],  
                        'pasienbaru'        => 1,
                        'norm'              => $data['no_rkm_medis'],  
                        'tanggalperiksa'    => $tanggal,
                        'kodedokter'        => $data['kd_dokter'],
                        'jampraktek'        => '08:30-23:00',
                        'jeniskunjungan'    => $kunjungan,
                        'nomorreferensi'    => $data['no_referensi'],
                        'nomorantrean'      => $data['kd_poli'].'-'.$data['no_reg'],
                        'angkaantrean'      => $data['no_reg'],
                        'estimasidilayani'  => strtotime('08:15:00'.'+'.$dilayani.' minute') * 1000,
                        'sisakuotajkn'      => 50 - $data['no_reg'],
                        'kuotajkn'          => 50,
                        'sisakuotanonjkn'   => 50 - $data['no_reg'],
                        'kuotanonjkn'       => 50,
                        'status'            => 'Checkin',
                        'statuskirim'       => 'Sudah',
                    ];

          //=============================================== Update Tbl_onsite ===========================================//

          $this->dbrs->set('posisi', 'Sudah');
          $this->dbrs->where('no_rkm_medis', $data['no_rkm_medis']);
          $this->dbrs->where('no_boking', $data['no_boking']);
          $this->dbrs->update('uxui_pasien_baru_onsite');
      }

      $this->dbrs->insert_batch('referensi_mobilejkn_bpjs', $onsite_jkn);
      //echo json_encode($onsite_jkn);
   }

  //============================================= Update Taks ID 3 PL =============================================//

//   $cek_sep_pl = $this->dbrs->query("SELECT a.no_rawat, a.nomr, a.no_rujukan, c.no_reg, c.kd_dokter as dokter_rs, c.kd_poli as poli_rs, a.kdpolitujuan as poli_bpjs, a.nmpolitujuan, a.kddpjp as dokter_bpjs, a.nmdpdjp, d.no_ktp, d.no_peserta, a.notelep, a.asal_rujukan
//   from bridging_sep a 
//   left join referensi_mobilejkn_bpjs b on a.no_rawat=b.no_rawat 
//   join reg_periksa c on a.no_rawat=c.no_rawat
//   join pasien d on a.nomr=d.no_rkm_medis
//   where a.tglsep = '$tanggal' and c.stts = 'Belum' and b.no_rawat is null")->result_array();
  $cek_sep_pl = $this->dbrs->query("SELECT reg_periksa.no_reg,reg_periksa.no_rawat,reg_periksa.tgl_registrasi,reg_periksa.kd_dokter,dokter.nm_dokter,reg_periksa.kd_poli,poliklinik.nm_poli,reg_periksa.stts_daftar,reg_periksa.no_rkm_medis
  from reg_periksa 
  inner join dokter on reg_periksa.kd_dokter=dokter.kd_dokter 
  inner join poliklinik on reg_periksa.kd_poli=poliklinik.kd_poli 
  where reg_periksa.tgl_registrasi=current_date()
  and reg_periksa.no_rawat 
  not in (select referensi_mobilejkn_bpjs.no_rawat from referensi_mobilejkn_bpjs 
  where referensi_mobilejkn_bpjs.tanggalperiksa=current_date())
  order by concat(reg_periksa.tgl_registrasi,' ',reg_periksa.jam_reg)")->result_array();

 if (!empty($cek_sep_pl)) {

   foreach ($cek_sep_pl as $datapl) {
        $dilayanipl  = $datapl['no_reg'] * 6;
        $kunjunganpl = $datapl['asal_rujukan'];

        // if ($kunjunganpl == '1. Faskes 1') {
        //     $jns_kunjunganpl = '1 (Rujukan FKTP)';
        // }else if ($kunjunganpl == '2. Faskes 2(RS)') {
        //     $jns_kunjunganpl = '4 (Rujukan Antar RS)';
        // }

      $jsonpl = [
             'kodebooking'        => $datapl['no_rawat'],
             'jenispasien'        => 'JKN',
             'nomorkartu'         => $datapl['no_peserta'],
             'nik'                => $datapl['no_ktp'],
             'nohp'               => $datapl['notelep'],
             'kodepoli'           => $datapl['poli_bpjs'],
             'namapoli'           => $datapl['nmpolitujuan'],
             'pasienbaru'         => 0,
             'norm'               => $datapl['nomr'],
             'tanggalperiksa'     => $tanggal,
             'kodedokter'         => $datapl['dokter_bpjs'],
             'namadokter'         => $datapl['nmdpdjp'],
             'jampraktek'         => '08:00-15:00',
             'jeniskunjungan'     => 3,
             'nomorreferensi'     => $datapl['no_rujukan'],
             'nomorantrean'       => $datapl['poli_bpjs'].'-'.$datapl['no_reg'],
             'angkaantrean'       => $datapl['no_reg'],
             'estimasidilayani'   => strtotime('08:15:00'.'+'.$dilayanipl.' minute') * 1000,
             'sisakuotajkn'       => 20 - $datapl['no_reg'],   
             'kuotajkn'           => 20,
             'sisakuotanonjkn'    => 20 - $datapl['no_reg'],
             'kuotanonjkn'        => 20,
             'keterangan'         => 'Peserta harap 30 menit lebih awal guna pencatatan administrasi.'
          ];
      //echo json_encode($jsonpl); die();

      $curl = curl_init();
      curl_setopt_array($curl, array(
          CURLOPT_RETURNTRANSFER => 1,
          CURLOPT_URL => ''.$this->config->item('antrol_url').'/'.$this->config->item('antrol_servisce').'/antrean/add',
          CURLOPT_CUSTOMREQUEST => "POST",
          CURLOPT_POSTFIELDS => json_encode($jsonpl),
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
      
      $jkn_localpl[] = [
                      'nobooking'         => $datapl['no_rawat'],
                      'no_rawat'          => $datapl['no_rawat'],
                      'nomorkartu'        => $datapl['no_peserta'],
                      'nik'               => $datapl['no_ktp'],
                      'nohp'              => $datapl['notelep'],
                      'kodepoli'          => $datapl['poli_rs'],
                      'pasienbaru'        => 0,
                      'norm'              => $datapl['nomr'],
                      'tanggalperiksa'    => $tanggal,
                      'kodedokter'        => $datapl['dokter_rs'],
                      'jampraktek'        => '08:00-15:00',
                      'jeniskunjungan'    => 3,
                      'nomorreferensi'    => $datapl['no_rujukan'],
                      'nomorantrean'      => $datapl['poli_bpjs'].'-'.$datapl['no_reg'],
                      'angkaantrean'      => $datapl['no_reg'],
                      'estimasidilayani'  => strtotime('08:15:00'.'+'.$dilayanipl.' minute') * 1000,  
                      'sisakuotajkn'      => 20 - $datapl['no_reg'],
                      'kuotajkn'          => 20,
                      'sisakuotanonjkn'   => 20 - $datapl['no_reg'],
                      'kuotanonjkn'       => 20,
                      'status'            => 'Checkin',
                      'validasi'          => date('Y-m-d '.$jam.''),
                      'statuskirim'       => 'Sudah'
                  ];
   }
   $this->dbrs->insert_batch('referensi_mobilejkn_bpjs', $jkn_localpl);
 }

 


    //========================================= Task Id 3 =================================================================//
   $cek_sep = $this->dbrs->query("SELECT a.no_rawat, b.nobooking as no_boking 
                                    from bridging_sep a 
                                    join referensi_mobilejkn_bpjs b on a.no_rawat=b.no_rawat
                                    join reg_periksa c on a.no_rawat=c.no_rawat
                                    where c.stts = 'Belum' and b.tanggalperiksa = '$tanggal'")->result_array();
    if (!empty($cek_sep)) {
      foreach ($cek_sep as $data3) {
              $json3 = [
            
                            'kodebooking' => $data3['no_boking'],
                            'taskid'      => '3',
                            'waktu'       => $waktu
           
                        ];

                $curl = curl_init();
                curl_setopt_array($curl, array(
                    CURLOPT_RETURNTRANSFER => 1,
                    CURLOPT_URL => ''.$this->config->item('antrol_url').'/'.$this->config->item('antrol_servisce').'/antrean/updatewaktu',
                    CURLOPT_CUSTOMREQUEST => "POST",
                    CURLOPT_POSTFIELDS => json_encode($json3),
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
      }
    }
    // Test-test
    //=============================================== Update Taks ID 4 ==============================================//

    // $cek_status = $this->dbrs->query("SELECT mutasi_berkas.dikirim, a.no_rawat, b.nobooking as no_boking from mutasi_berkas, reg_periksa a 
    //                                     join referensi_mobilejkn_bpjs b on a.no_rawat=b.no_rawat
    //                                     where mutasi_berkas.no_rawat=b.no_rawat
    //                                     and mutasi_berkas.dikirim<>'0000-00-00 00:00:00'")->result_array();

    // if (!empty($cek_status)) 
    // {
    //   foreach ($cek_status as $data1) 
    //   {
    //     $json1 = [
      
    //         'kodebooking' => $data1['no_boking'],
    //         'taskid'      => '3',
    //         'waktu'       => $waktu

    //     ];

    //     $curl = curl_init();
    //     curl_setopt_array($curl, array(
    //         CURLOPT_RETURNTRANSFER => 1,
    //         CURLOPT_URL => ''.$this->config->item('antrol_url').'/'.$this->config->item('antrol_servisce').'/antrean/updatewaktu',
    //         CURLOPT_CUSTOMREQUEST => "POST",
    //         CURLOPT_POSTFIELDS => json_encode($json1),
    //         CURLOPT_SSL_VERIFYPEER => false,
    //         CURLOPT_HTTPHEADER => [
    //         "Content-Type: Application/x-www-form-urlencoded",
    //             "X-cons-id: ".$this->config->item('antrol_cons_id'),
    //             "X-timestamp: ".$this->config->item('antrol_tStamp'),
    //             "X-signature: ".$this->config->item('antrol_encodedSignature'),
    //             "user_key: ".$this->config->item('antrol_user_key')
    //         ],
    //     ));

    //     $response = curl_exec($curl);
    //     $err      = curl_error($curl);
    //     curl_close($curl);
    //   }
    // }

    //=============================================== Update Taks ID  4 ==============================================//

    $cek_status = $this->dbrs->query("SELECT a.no_rawat, b.nobooking as no_boking 
                                      from reg_periksa a 
                                      join referensi_mobilejkn_bpjs b on a.no_rawat=b.no_rawat
                                      where a.stts = 'Berkas Diterima' and b.tanggalperiksa = '$tanggal'")->result_array();

    if (!empty($cek_status)) {
      foreach ($cek_status as $data1) {
        
          $json1 = [
      
                      'kodebooking' => $data1['no_boking'],
                      'taskid'      => '4',
                      'waktu'       => $waktu
     
                  ];

          $curl = curl_init();
          curl_setopt_array($curl, array(
              CURLOPT_RETURNTRANSFER => 1,
              CURLOPT_URL => ''.$this->config->item('antrol_url').'/'.$this->config->item('antrol_servisce').'/antrean/updatewaktu',
              CURLOPT_CUSTOMREQUEST => "POST",
              CURLOPT_POSTFIELDS => json_encode($json1),
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
        }
          
    }


//=============================================== Update Taks ID  4 ==============================================//

    // $cek_status = $this->dbrs->query("SELECT a.no_rawat, b.nobooking as no_boking 
    //                                   from reg_periksa a 
    //                                   join referensi_mobilejkn_bpjs b on a.no_rawat=b.no_rawat
    //                                   where a.stts = 'Berkas Diterima' and b.tanggalperiksa = '$tanggal'")->result_array();

    // if (!empty($cek_status)) {
    //   foreach ($cek_status as $data1) {
        
    //       $json1 = [
      
    //                   'kodebooking' => $data1['no_boking'],
    //                   'taskid'      => '4',
    //                   'waktu'       => $waktu
     
    //               ];

    //       $curl = curl_init();
    //       curl_setopt_array($curl, array(
    //           CURLOPT_RETURNTRANSFER => 1,
    //           CURLOPT_URL => ''.$this->config->item('antrol_url').'/'.$this->config->item('antrol_servisce').'/antrean/updatewaktu',
    //           CURLOPT_CUSTOMREQUEST => "POST",
    //           CURLOPT_POSTFIELDS => json_encode($json1),
    //           CURLOPT_SSL_VERIFYPEER => false,
    //           CURLOPT_HTTPHEADER => [
    //              "Content-Type: Application/x-www-form-urlencoded",
    //               "X-cons-id: ".$this->config->item('antrol_cons_id'),
    //               "X-timestamp: ".$this->config->item('antrol_tStamp'),
    //               "X-signature: ".$this->config->item('antrol_encodedSignature'),
    //               "user_key: ".$this->config->item('antrol_user_key')
    //           ],
    //       ));

    //       $response = curl_exec($curl);
    //       $err      = curl_error($curl);
    //       curl_close($curl);
    //     }
          
    // }


    //================================================= Taks ID 5 =============================================//

    $cek_periksa = $this->dbrs->query("SELECT a.no_rawat, b.nobooking as no_boking 
                                      from reg_periksa a 
                                      join referensi_mobilejkn_bpjs b on a.no_rawat=b.no_rawat
                                      where a.stts = 'Sudah' and b.tanggalperiksa = '$tanggal'")->result_array();
    if (!empty($cek_periksa)) {
        foreach ($cek_periksa as $data2) {
          $json3 = [
      
                      'kodebooking' => $data2['no_boking'],
                      'taskid'      => '5',
                      'waktu'       => $waktu
     
                  ];

          $curl = curl_init();
          curl_setopt_array($curl, array(
              CURLOPT_RETURNTRANSFER => 1,
              CURLOPT_URL => ''.$this->config->item('antrol_url').'/'.$this->config->item('antrol_servisce').'/antrean/updatewaktu',
              CURLOPT_CUSTOMREQUEST => "POST",
              CURLOPT_POSTFIELDS => json_encode($json3),
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
        }
    }

    //================================================= Taks ID 6 =============================================//

    $cek_resep = $this->dbrs->query("SELECT a.no_rawat, b.nobooking 
                                    from resep_obat a join referensi_mobilejkn_bpjs b on a.no_rawat=b.no_rawat
                                    where b.tanggalperiksa = '$tanggal' and a.tgl_perawatan = '0000-00-00'")->result_array();

    if (!empty($cek_resep)){
        foreach ($cek_resep as $data6) {
            $json6 = [
      
                'kodebooking' => $data6['nobooking'],
                'taskid'      => '6',
                'waktu'       => $waktu

            ];

            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_URL => ''.$this->config->item('antrol_url').'/'.$this->config->item('antrol_servisce').'/antrean/updatewaktu',
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => json_encode($json6),
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
            //echo json_encode($response);
        }
    }

    //================================================= Taks ID 7 =============================================//

    $cek_resep7 = $this->dbrs->query("SELECT a.no_rawat, b.nobooking 
                                    from resep_obat a join referensi_mobilejkn_bpjs b on a.no_rawat=b.no_rawat
                                    where b.tanggalperiksa = '$tanggal' and a.tgl_perawatan = '$tanggal'")->result_array();

    if (!empty($cek_resep7)){
        foreach ($cek_resep7 as $data7) {
            $json7 = [
      
                'kodebooking' => $data7['nobooking'],
                'taskid'      => '7',
                'waktu'       => $waktu

            ];

            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_URL => ''.$this->config->item('antrol_url').'/'.$this->config->item('antrol_servisce').'/antrean/updatewaktu',
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => json_encode($json7),
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

            //echo json_encode($response);
        }
    }

    //================================================= Taks ID 99 =============================================//

    $cek_batal = $this->dbrs->query("SELECT a.no_rawat, b.nobooking as no_boking 
                                      from reg_periksa a 
                                      join referensi_mobilejkn_bpjs b on a.no_rawat=b.no_rawat
                                      where a.stts = 'Batal' and b.tanggalperiksa = '$tanggal'")->result_array();
    if (!empty($cek_batal)) {
        foreach ($cek_batal as $data99) {
          $json99 = [
      
                      'kodebooking' => $data99['no_boking'],
                      'taskid'      => '99',
                      'waktu'       => $waktu
     
                  ];

          $curl = curl_init();
          curl_setopt_array($curl, array(
              CURLOPT_RETURNTRANSFER => 1,
              CURLOPT_URL => ''.$this->config->item('antrol_url').'/'.$this->config->item('antrol_servisce').'/antrean/updatewaktu',
              CURLOPT_CUSTOMREQUEST => "POST",
              CURLOPT_POSTFIELDS => json_encode($json99),
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
        }
    }
?>




  
