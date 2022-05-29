<?php
defined('BASEPATH') or exit('No direct script access allowed');

class DataPembelian extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Models');
    }
    public function index()
    {
        // $data['pembelian'] = $this->db->query("SELECT * FROM pembelian")->result_array();
        // $data['pembelian'] = $this->db->query("SELECT pembelian.*, supplier.nama_supplier as namasupplier FROM pembelian, supplier WHERE pembelian.id_supplier = supplier.id_supplier AND pembelian.status != 0 ORDER BY pembelian.created_at ASC")->result_array();
        $data['pembelian'] = $this->db->query("SELECT DISTINCT(pembelian.id_supplier), supplier.nama_supplier, supplier.id_supplier FROM pembelian, supplier WHERE pembelian.id_supplier = supplier.id_supplier AND pembelian.status != 0 ORDER BY pembelian.created_at ASC")->result_array();
        $data['keranjang'] = $this->db->query("SELECT COUNT(detail_pembelian.id_pembelian) as total FROM detail_pembelian, pembelian WHERE pembelian.id_pembelian = detail_pembelian.id_pembelian AND pembelian.id_admin = 1 AND pembelian.status = 0")->result_array();

        $data['totalhutang'] = $this->db->query("SELECT SUM(total_hutang) as total_hutang FROM hutang_admin")->row_array();
        // var_dump($data['totalhutang']);die;
        $this->load->view('DataPembelian/index', $data);
    }

    public function detail($id)
    {
        $data['pembelian'] = $this->db->query("SELECT pembelian.*, otlet.*, supplier.nama_supplier as nama_supplier FROM pembelian, otlet, supplier WHERE pembelian.id_otlet = otlet.id_otlet AND pembelian.id_supplier = supplier.id_supplier AND pembelian.id_supplier = '$id' AND pembelian.status != 0 ORDER BY pembelian.created_at DESC")->result_array();
        $this->load->view('DataPembelian/detail', $data);
    }

    public function ambildata()
    {
        $id = $this->input->post('id');
        $datasupplier = $this->db->query("SELECT pembelian.*, supplier.nama_supplier as namasupplier FROM pembelian, supplier WHERE pembelian.id_supplier = supplier.id_supplier AND  supplier.id_supplier = '$id' ORDER BY pembelian.created_at ASC")->result();
        echo json_encode($datasupplier);
    }

    public function databayar()
    {
        $id_pembelian = $this->input->post('id');
        $datahutang = $this->db->query("SELECT * FROM bayar_hutang_admin WHERE id_admin = '1' AND id_pembelian = '$id_pembelian'")->result();
        echo json_encode($datahutang);
    }
    public function getBarang()
    {
        $id_otlet = $this->input->post('id_otlet');
        $data = $this->db->query("SELECT * FROM barang WHERE id_otlet = '$id_otlet'")->result();
        echo json_encode($data);
    }

    public function keranjang()
    {
        $data['keranjang'] = $this->db->query("SELECT * FROM pembelian, detail_pembelian, supplier, barang WHERE pembelian.id_pembelian = detail_pembelian.id_pembelian AND pembelian.id_supplier = supplier.id_supplier AND detail_pembelian.id_barang = barang.id_barang AND pembelian.status = 0")->result_array();
        $this->load->view('DataPembelian/keranjang', $data);
    }

    public function tambah()
    {
        $adakeranjang = $this->db->query("SELECT * FROM pembelian, detail_pembelian WHERE pembelian.id_pembelian = detail_pembelian.id_pembelian AND pembelian.id_admin = '1' AND pembelian.status = 0")->result_array();
        if ($adakeranjang) {
            $this->form_validation->set_rules('barang', 'Barang', 'required');
            $this->form_validation->set_rules('qty', 'QTY', 'required|numeric');
            $this->form_validation->set_rules('hargasatuan', 'Harga Satuan', 'required|numeric');
            $this->form_validation->set_rules('totalharga', 'Total Harga', 'required|numeric');
            if ($this->form_validation->run() == false) {
                $data['barang'] = $this->db->query("SELECT * FROM barang")->result_array();
                $data['otlet'] = $this->db->query("SELECT * FROM otlet")->result_array();
                $data['supplier'] = $this->db->query("SELECT * FROM supplier")->result_array();
                $data['keranjang'] = $this->db->query("SELECT * FROM pembelian, detail_pembelian, supplier, barang WHERE pembelian.id_pembelian = detail_pembelian.id_pembelian AND pembelian.id_supplier = supplier.id_supplier AND detail_pembelian.id_barang = barang.id_barang AND pembelian.status = 0")->result_array();
                $this->load->view('DataPembelian/tambah', $data);
            } else {
                foreach ($adakeranjang as $ad) {
                    $id_barang = $this->input->post('barang');
                    $qty = $this->input->post('qty');
                    $hargasatuan = $this->input->post('hargasatuan');
                    $totalharga = $this->input->post('totalharga');
                    $now = date('Y-m-d H:i:s');
                    $id_pembelianada = $ad['id_pembelian'];
                    $adabarang = $this->db->query("SELECT * FROM detail_pembelian WHERE id_pembelian = '$id_pembelianada' AND id_barang = '$id_barang'")->result_array();
                    if ($adabarang) {
                        $this->session->set_flashdata('pesan', '<div class="alert alert-danger" role="alert">
                Gagal tambah ke keranjang barang sudah ada di keranjang!
                </div>');
                        redirect('DataPembelian');
                    } else {
                        $datadetail = [
                            'id_pembelian' => $id_pembelianada,
                            'id_barang' => $id_barang,
                            'qty' => $qty,
                            'total_harga' => $totalharga,
                            'harga_satuan' => $hargasatuan,
                            'created_at' => $now,
                        ];
                        $querydetail = $this->Models->insert('detail_pembelian', $datadetail);
                        if ($querydetail) {
                            $this->session->set_flashdata('pesan', '<div class="alert alert-success" role="alert">
                    Berhasil tambah ke keranjang!
                    </div>');
                            redirect('DataPembelian/tambah');
                        } else {
                            $this->session->set_flashdata('pesan', '<div class="alert alert-danger" role="alert">
                    Gagal tambah ke keranjang!
                    </div>');
                            redirect('DataPembelian/tambah');
                        }
                    }
                }
            }
        } else {
            $this->form_validation->set_rules('invoice', 'No invoice', 'required|is_unique[pembelian.id_pembelian]');
            $this->form_validation->set_rules('barang', 'Barang', 'required');
            $this->form_validation->set_rules('qty', 'QTY', 'required|numeric');
            $this->form_validation->set_rules('hargasatuan', 'Harga Satuan', 'required');
            $this->form_validation->set_rules('supplier', 'Supplier', 'required');
            $this->form_validation->set_rules('totalharga', 'Total Harga', 'required');
            $this->form_validation->set_rules('otlet', 'Otlet', 'required');
            if ($this->form_validation->run() == false) {
                $data['barang'] = $this->db->query("SELECT * FROM barang")->result_array();
                $data['otlet'] = $this->db->query("SELECT * FROM otlet")->result_array();
                $data['supplier'] = $this->db->query("SELECT * FROM supplier")->result_array();
                $data['keranjang'] = $this->db->query("SELECT * FROM pembelian, detail_pembelian, supplier, barang WHERE pembelian.id_pembelian = detail_pembelian.id_pembelian AND pembelian.id_supplier = supplier.id_supplier AND detail_pembelian.id_barang = barang.id_barang AND pembelian.status = 0")->result_array();
                $this->load->view('DataPembelian/tambah', $data);
            } else {
                $id_barang = $this->input->post('barang');
                $qty = $this->input->post('qty');
                $hargasatuan = $this->input->post('hargasatuan');
                $id_otlet = $this->input->post('otlet');
                $id_supplier = $this->input->post('supplier');
                $totalharga = $this->input->post('totalharga');
                $id_pembelian = $this->input->post('invoice');
                $now = date('Y-m-d H:i:s');
                $data = [
                    'id_pembelian' => $id_pembelian,
                    'id_admin' => 1,
                    'id_supplier' => $id_supplier,
                    'id_otlet' => $id_otlet,
                    'subtotal' => 0,
                    'status' => 0,
                    'created_at' => $now,
                ];
                $datadetail = [
                    'id_pembelian' => $id_pembelian,
                    'id_barang' => $id_barang,
                    'qty' => $qty,
                    'total_harga' => $totalharga,
                    'harga_satuan' => $hargasatuan,
                    'created_at' => $now,
                ];
                $query = $this->Models->insert('pembelian', $data);
                $querydetail = $this->Models->insert('detail_pembelian', $datadetail);
                if ($query && $querydetail) {
                    $this->session->set_flashdata('pesan', '<div class="alert alert-success" role="alert">
                        Berhasil tambah ke keranjang!
                        </div>');
                    redirect('DataPembelian/tambah');
                } else {
                    $this->session->set_flashdata('pesan', '<div class="alert alert-danger" role="alert">
                        Gagal tambah ke keranjang!
                        </div>');
                    redirect('DataPembelian/tambah');
                }
            }
        }
        // $this->form_validation->set_rules('invoice', 'No invoice', 'required|is_unique[pembelian.id_pembelian]');
        // $this->form_validation->set_rules('barang', 'Barang', 'required');
        // $this->form_validation->set_rules('qty', 'QTY', 'required|numeric');
        // $this->form_validation->set_rules('hargasatuan', 'Harga Satuan', 'required');
        // $this->form_validation->set_rules('supplier', 'Supplier', 'required');
        // $this->form_validation->set_rules('totalharga', 'Total Harga', 'required');
        // $this->form_validation->set_rules('otlet', 'Otlet', 'required');
        // if ($this->form_validation->run() == false) {
        //     $data['barang'] = $this->db->query("SELECT * FROM barang")->result_array();
        //     $data['otlet'] = $this->db->query("SELECT * FROM otlet")->result_array();
        //     $data['supplier'] = $this->db->query("SELECT * FROM supplier")->result_array();
        //     $data['keranjang'] = $this->db->query("SELECT * FROM pembelian, detail_pembelian, supplier, barang WHERE pembelian.id_pembelian = detail_pembelian.id_pembelian AND pembelian.id_supplier = supplier.id_supplier AND detail_pembelian.id_barang = barang.id_barang AND pembelian.status = 0")->result_array();
        //     $this->load->view('DataPembelian/tambah', $data);
        // } else {
        //     // $id_otlet = $this->input->post('id_otlet');
        //     $id_barang = $this->input->post('barang');
        //     $qty = $this->input->post('qty');
        //     $hargasatuan = $this->input->post('hargasatuan');
        //     $id_otlet = $this->input->post('otlet');
        //     $id_supplier = $this->input->post('supplier');
        //     $totalharga = $this->input->post('totalharga');
        //     $id_pembelian = $this->input->post('invoice');
        //     $now = date('Y-m-d H:i:s');
        //     $data['keranjang'] = $this->db->query("SELECT * FROM pembelian, detail_pembelian, supplier, barang WHERE pembelian.id_pembelian = detail_pembelian.id_pembelian AND pembelian.id_supplier = supplier.id_supplier AND detail_pembelian.id_barang = barang.id_barang AND pembelian.status = 0")->result_array();
        //     $adakeranjang = $this->db->query("SELECT * FROM pembelian, detail_pembelian WHERE pembelian.id_pembelian = detail_pembelian.id_pembelian AND pembelian.id_admin = '1' AND pembelian.status = 0")->result_array();
        //     if ($adakeranjang) {
        //         foreach ($adakeranjang as $ad) {
        //             $id_pembelianada = $ad['id_pembelian'];
        //             $adabarang = $this->db->query("SELECT * FROM detail_pembelian WHERE id_pembelian = '$id_pembelianada' AND id_barang = '$id_barang'")->result_array();
        //             if ($adabarang) {
        //                 $this->session->set_flashdata('pesan', '<div class="alert alert-danger" role="alert">
        //             Gagal tambah ke keranjang barang sudah ada di keranjang!
        //             </div>');
        //                 redirect('DataPembelian');
        //             } else {
        //                 $datadetail = [
        //                     'id_pembelian' => $id_pembelianada,
        //                     'id_barang' => $id_barang,
        //                     'qty' => $qty,
        //                     'total_harga' => $totalharga,
        //                     'harga_satuan' => $hargasatuan,
        //                     'created_at' => $now,
        //                 ];
        //                 $querydetail = $this->Models->insert('detail_pembelian', $datadetail);
        //                 if ($querydetail) {
        //                     $this->session->set_flashdata('pesan', '<div class="alert alert-success" role="alert">
        //                 Berhasil tambah ke keranjang!
        //                 </div>');
        //                     redirect('DataPembelian/tambah');
        //                 } else {
        //                     $this->session->set_flashdata('pesan', '<div class="alert alert-danger" role="alert">
        //                 Gagal tambah ke keranjang!
        //                 </div>');
        //                     redirect('DataPembelian/tambah');
        //                 }
        //             }
        //         }
        //     } else {
        //         $data = [
        //             'id_pembelian' => $id_pembelian,
        //             'id_admin' => 1,
        //             'id_supplier' => $id_supplier,
        //             'id_otlet' => $id_otlet,
        //             'subtotal' => 0,
        //             'status' => 0,
        //             'created_at' => $now,
        //         ];
        //         $datadetail = [
        //             'id_pembelian' => $id_pembelian,
        //             'id_barang' => $id_barang,
        //             'qty' => $qty,
        //             'total_harga' => $totalharga,
        //             'harga_satuan' => $hargasatuan,
        //             'created_at' => $now,
        //         ];
        //         $query = $this->Models->insert('pembelian', $data);
        //         $querydetail = $this->Models->insert('detail_pembelian', $datadetail);
        //         if ($query && $querydetail) {
        //             $this->session->set_flashdata('pesan', '<div class="alert alert-success" role="alert">
        //                 Berhasil tambah ke keranjang!
        //                 </div>');
        //             redirect('DataPembelian/tambah');
        //         } else {
        //             $this->session->set_flashdata('pesan', '<div class="alert alert-danger" role="alert">
        //                 Gagal tambah ke keranjang!
        //                 </div>');
        //             redirect('DataPembelian/tambah');
        //         }
        //     }
        // }
    }

    public function hapuskeranjang($id)
    {
        $id_pem = $this->db->query("SELECT Distinct(id_pembelian) as idnya FROM detail_pembelian WHERE id_detail_pembelian = '$id'")->row_array();
        $id_pembelian = $id_pem['idnya'];
        $banyakbarang = $this->db->query("SELECT COUNT(id_pembelian) as banyak FROM detail_pembelian WHERE id_pembelian = '$id_pembelian'")->row_array();
        if ($banyakbarang['banyak'] > 1) {
            $query = $this->Models->hapus($id, 'id_detail_pembelian', 'detail_pembelian');
            if ($query) {
                $this->session->set_flashdata('pesan', '<div class="alert alert-success" role="alert">
                            Berhasil hapus dari keranjang!
                            </div>');
                redirect('DataPembelian/tambah');
            } else {
                $this->session->set_flashdata('pesan', '<div class="alert alert-danger" role="alert">
                            Gagal hapus dari keranjang!
                            </div>');
                redirect('DataPembelian/tambah');
            }
        } else {
            $query = $this->Models->hapus($id, 'id_detail_pembelian', 'detail_pembelian');
            $querypembelian = $this->Models->hapus($id_pembelian, 'id_pembelian', 'pembelian');
            if ($query && $querypembelian) {
                $this->session->set_flashdata('pesan', '<div class="alert alert-success" role="alert">
                            Berhasil hapus dari keranjang!
                            </div>');
                redirect('DataPembelian/tambah');
            } else {
                $this->session->set_flashdata('pesan', '<div class="alert alert-danger" role="alert">
                            Gagal hapus dari keranjang!
                            </div>');
                redirect('DataPembelian/tambah');
            }
        }
    }

    public function checkout()
    {
        $id_pembelian = $this->input->post('id_pembeliannya');
        $metode = $this->input->post('metode');
        $now = date('Y-m-d H:i:s');
        $limittanggal = date('Y-m-d', strtotime('+1 month', strtotime($now)));
        if ($metode == '1') {
            $datadetail = $this->db->query("SELECT * FROM detail_pembelian WHERE id_pembelian = '$id_pembelian'")->result_array();
            $totalharga = $this->db->query("SELECT SUM(total_harga) as total FROM detail_pembelian WHERE id_pembelian = '$id_pembelian'")->row_array();
            foreach ($datadetail as $dd) {
                $id_barang = $dd['id_barang'];
                $databarang = [
                    'harga_beli' => $dd['harga_satuan'],
                ];
                $this->Models->update($databarang, "id_barang", "barang", $id_barang);
            }
            $datapembelian = [
                'status' => $metode,
                'subtotal' => $totalharga['total'],
            ];
            $updatepembelian = $this->Models->update($datapembelian, "id_pembelian", "pembelian", $id_pembelian);
            if ($updatepembelian) {
                $this->session->set_flashdata('pesan', '<div class="alert alert-success" role="alert">
                Checkout Data Berhasil!
                </div>');
                redirect('DataPembelian');
            } else {
                $this->session->set_flashdata('pesan', '<div class="alert alert-danger" role="alert">
                Checkout Data Gagal!
                </div>');
                redirect('DataPembelian');
            }
        } else {
            $datadetail = $this->db->query("SELECT * FROM detail_pembelian WHERE id_pembelian = '$id_pembelian'")->result_array();
            $totalharga = $this->db->query("SELECT SUM(total_harga) as total FROM detail_pembelian WHERE id_pembelian = '$id_pembelian'")->row_array();
            $dataadmin = $this->db->query("SELECT * FROM pembelian WHERE id_pembelian = '$id_pembelian'")->row_array();
            $id_admin = $dataadmin['id_admin'];
            $id_supplier = $dataadmin['id_supplier'];
            $hutangada = $this->db->query("SELECT * FROM hutang_admin WHERE id_admin = '$id_admin' AND id_supplier = '$id_supplier'")->row_array();
            if ($hutangada) {
                $hutanglama = $hutangada['total_hutang'];
                $idhutangadmin = $hutangada['id_hutang_admin'];
                foreach ($datadetail as $dd) {
                    $id_barang = $dd['id_barang'];
                    $databarang = [
                        'harga_beli' => $dd['harga_satuan'],
                    ];
                    $this->Models->update($databarang, "id_barang", "barang", $id_barang);
                }
                $datapembelian = [
                    'status' => $metode,
                    'subtotal' => $totalharga['total'],
                ];
                $datahutang = [
                    'total_hutang' => $hutanglama + $totalharga['total'],
                    'updated_at' => $now,
                    'limit_tanggal' => $limittanggal,
                ];
                $updatepembelian = $this->Models->update($datapembelian, "id_pembelian", "pembelian", $id_pembelian);
                $queryhutang = $this->Models->update($datahutang, "id_hutang_admin", "hutang_admin", $idhutangadmin);
                if ($updatepembelian && $queryhutang) {
                    $this->session->set_flashdata('pesan', '<div class="alert alert-success" role="alert">
                Checkout Data Berhasil!
                </div>');
                    redirect('DataPembelian');
                } else {
                    $this->session->set_flashdata('pesan', '<div class="alert alert-danger" role="alert">
                Checkout Data Gagal!
                </div>');
                    redirect('DataPembelian');
                }
            } else {
                foreach ($datadetail as $dd) {
                    $id_barang = $dd['id_barang'];
                    $databarang = [
                        'harga_beli' => $dd['harga_satuan'],
                    ];
                    $this->Models->update($databarang, "id_barang", "barang", $id_barang);
                }
                $datapembelian = [
                    'status' => $metode,
                    'subtotal' => $totalharga['total'],
                ];
                $datahutang = [
                    'id_admin' => $id_admin,
                    'id_supplier' => $id_supplier,
                    'total_hutang' => $totalharga['total'],
                    'created_at' => $now,
                    'limit_tanggal' => $limittanggal,
                ];
                $updatepembelian = $this->Models->update($datapembelian, "id_pembelian", "pembelian", $id_pembelian);
                $queryhutang = $this->Models->insert('hutang_admin', $datahutang);
                if ($updatepembelian && $queryhutang) {
                    $this->session->set_flashdata('pesan', '<div class="alert alert-success" role="alert">
                Checkout Data Berhasil!
                </div>');
                    redirect('DataPembelian');
                } else {
                    $this->session->set_flashdata('pesan', '<div class="alert alert-danger" role="alert">
                Checkout Data Gagal!
                </div>');
                    redirect('DataPembelian');
                }
            }
        }
    }

    public function bayar()
    {
        $bayar = $this->input->post('bayar');
        $supplier = $this->input->post('supplier');
        $id_pembelian = $this->input->post('pembelian');
        $total = $this->input->post('total');
        $now = date('Y-m-d H:i:s');
        var_dump($bayar);
        var_dump($supplier);
        var_dump($id_pembelian);
        var_dump($total);
        $datakurang = $this->db->query("SELECT SUM(bayar) as bayar FROM bayar_hutang_admin WHERE id_admin = '1' AND id_pembelian = '$id_pembelian'")->row_array();
        $totalbayar = $datakurang['bayar'];
        if (($total - $totalbayar) == $bayar) {
            var_dump('status jadi 1 langsung');
            $data = $this->db->query("SELECT * FROM hutang_admin WHERE id_admin = '1' AND id_supplier = '$supplier'")->row_array();
            $id_hutang_admin = $data['id_hutang_admin'];
            $datahutang = [
                'total_hutang' => $data['total_hutang'] - $bayar,
                'updated_at' => $now,
            ];
            $datapembelian = [
                'status' => '1',
            ];
            $bayarnya = [
                'id_admin' => '1',
                'id_pembelian' => $id_pembelian,
                'bayar' => $bayar,
                'created_at' => $now
            ];
            $updatepembelian = $this->Models->update($datapembelian, "id_pembelian", "pembelian", $id_pembelian);
            $updatedatahutang = $this->Models->update($datahutang, "id_hutang_admin", "hutang_admin", $id_hutang_admin);
            $querybayar = $this->Models->insert('bayar_hutang_admin', $bayarnya);
            if ($updatepembelian && $updatedatahutang && $querybayar) {
                $this->session->set_flashdata('pesan', '<div class="alert alert-success" role="alert">
            Bayar Piutang Berhasil!
            </div>');
                redirect('DataPembelian/detail/' . $supplier);
            } else {
                $this->session->set_flashdata('pesan', '<div class="alert alert-danger" role="alert">
            Bayar Piutang Gagal!
            </div>');
                redirect('DataPembelian/detail/' . $supplier);
            }
        } else {
            if ($bayar > ($total - $totalbayar)) {
                $this->session->set_flashdata('pesan', '<div class="alert alert-danger" role="alert">
                Jumlah pembayaran melebihi total atau kekurangan piutang!
                </div>');
                redirect('DataPembelian/detail/' . $supplier);
            } else {
                $data = $this->db->query("SELECT * FROM hutang_admin WHERE id_admin = '1' AND id_supplier = '$supplier'")->row_array();
                $id_hutang_admin = $data['id_hutang_admin'];
                $datahutang = [
                    'total_hutang' => $data['total_hutang'] - $bayar,
                    'updated_at' => $now,
                ];
                $bayarnya = [
                    'id_admin' => '1',
                    'id_pembelian' => $id_pembelian,
                    'bayar' => $bayar,
                    'created_at' => $now
                ];
                $updatedatahutang = $this->Models->update($datahutang, "id_hutang_admin", "hutang_admin", $id_hutang_admin);
                $querybayar = $this->Models->insert('bayar_hutang_admin', $bayarnya);
                if ($updatedatahutang && $querybayar) {
                    $this->session->set_flashdata('pesan', '<div class="alert alert-success" role="alert">
                Bayar Piutang Berhasil!
                </div>');
                    redirect('DataPembelian/detail/' . $supplier);
                } else {
                    $this->session->set_flashdata('pesan', '<div class="alert alert-danger" role="alert">
                Bayar Piutang Gagal!
                </div>');
                    redirect('DataPembelian/detail/' . $supplier);
                }
            }
        }
    }
}

/* End of file DataPembelian.php and path /application/controllers/DataPembelian.php */
