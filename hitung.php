<div class="page-header">
    <h1>Perhitungan</h1>
</div>

<div class="panel panel-primary">
    <div style="background-color: #981A40;" class="panel-heading">
        <h3 class="panel-title">Mengukur Konsistensi Kriteria</h3>
    </div>
    <div class="panel-body">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Matriks Perbandingan Kriteria</h3>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Kode</th>
                            <th>Nama</th>
                            <?php
                            $matriks = get_relkriteria();
                            $total = get_baris_total($matriks);
                            foreach ($matriks as $key => $val) : ?>
                                <th><?= $key ?></th>
                            <?php endforeach ?>
                        </tr>
                    </thead>
                    <?php foreach ($matriks as $key => $val) : ?>
                        <tr>
                            <td><?= $key ?></td>
                            <td><?= $KRITERIA[$key] ?></td>
                            <?php foreach ($val as $k => $v) : ?>
                                <td><?= round($v, 3) ?></td>
                            <?php endforeach ?>
                        </tr>
                    <?php endforeach ?>
                    <tfoot>
                        <td>&nbsp;</td>
                        <td>Total</td>
                        <?php foreach ($total as $k => $v) : ?>
                            <td><?= round($v, 3) ?></td>
                        <?php endforeach ?>
                    </tfoot>
                </table>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Normalisasi</h3>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Kode</th>
                            <?php
                            $normal = normalize($matriks, $total);
                            $rata = get_rata($normal);
                            // $mmult = mmult($matriks, $rata);
                            $cm = consistency_measure($matriks, $rata);
                            foreach ($matriks as $key => $val) : ?>
                                <th><?= $key ?></th>
                            <?php endforeach ?>
                            <th>Jumlah</th>
                            <th>Prioritas</th>
                            <th>Eigen</th>

                        </tr>
                    </thead>
                    <?php foreach ($normal as $key => $val) : ?>
                        <tr>
                            <td><?= $key ?></td>
                            <?php foreach ($val as $k => $v) : ?>
                                <td><?= round($v, 3) ?></td>
                            <?php endforeach ?>
                            <td><?= round(array_sum($val), 3) ?></td>
                            <td><?= round($rata[$key], 3) ?></td>
                            <td><?= round($cm[$key], 3) ?></td>
                        </tr>
                    <?php endforeach ?>
                </table>
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Perkalian Matriks dengan Prioritas</h3>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Kode</th>
                            <?php
                            $normal = normalize($matriks, $total);
                            $rata = get_rata($normal);
                            $cm = consistency_measure($matriks, $rata);
                            foreach ($matriks as $key => $val) : ?>
                                <th><?= $key ?></th>
                            <?php endforeach ?>
                            <th>Jumlah perkalian</th>
                        </tr>
                    </thead>
                    <?php
                    // Perhitungan baris prioritas dikali dengan kolom alternatif
                    $prioritas_matrix = array();
                    foreach ($rata as $k => $prioritas) {
                        foreach ($matriks as $key => $val) {
                            if (!isset($prioritas_matrix[$key])) {
                                $prioritas_matrix[$key] = array();
                            }
                            $prioritas_matrix[$key][$k] = round($prioritas * $val[$k], 3); // Sesuaikan dengan jumlah desimal yang diinginkan
                        }
                    }

                    foreach ($prioritas_matrix as $key => $val) : ?>
                        <tr>
                            <td><?= $key ?></td>
                            <?php foreach ($val as $k => $v) : ?>
                                <td><?= $v ?></td>
                            <?php endforeach ?>
                            <td><?= round(array_sum($val), 3) ?></td> <!-- Sesuaikan dengan jumlah desimal yang diinginkan -->
                        </tr>
                    <?php endforeach ?>

                </table>
            </div>
        </div>


        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Mencari Jumlah Dari Nilai-Nilai Hasil</h3>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Kode</th>
                            <th>Hasil Perkalian</th>
                            <th>Prioritas</th>
                            <th>Hasil</th>
                        </tr>
                    </thead>
                    <?php
                    // Fungsi untuk mendapatkan hasil perkalian
                    function get_hasil_perkalian($prioritas_matrix)
                    {
                        $hasil_perkalian = array();

                        foreach ($prioritas_matrix as $key => $val) {
                            $hasil_perkalian[$key] = array_sum($val);
                        }

                        return $hasil_perkalian;
                    }

                    $hasil_perkalian = get_hasil_perkalian($prioritas_matrix);
                    $prioritas_kriteria = array_values($rata); // Ambil nilai prioritas dari $rata

                    foreach ($hasil_perkalian as $key => $val) : ?>
                        <tr>
                            <td><?= $key ?></td>
                            <td><?= round($val, 3) ?></td>
                            <td><?= round($rata[$key], 3) ?></td>
                            <td><?= round($val / $rata[$key], 3) ?></td>

                            <?php
                            $hasil_pembagian = round($val / $rata[$key], 3);
                            $hasil_pembagian_array[] = $hasil_pembagian; // Menambahkan hasil pembagian ke dalam array
                            ?>
                        </tr>

                    <?php endforeach ?>
                    <tr>
                        <td>Jumlah</td>
                        <td></td>
                        <td></td>
                        <td><?= round(array_sum($hasil_pembagian_array), 3) ?></td> <!-- Menampilkan total hasil pembagian -->
                        <?php
                        $hasil_penjumlahan = round(array_sum($hasil_pembagian_array), 3);
                        $hasil_penjumlahan_array[] = $hasil_penjumlahan; // Menambahkan hasil pembagian ke dalam array
                        ?>
                    </tr>

                    <tr>
                        <td>Kriteria</td>
                        <td></td>
                        <td></td>
                        <td><?= count($cm) ?></td>
                    </tr>
                    <tr>
                        <td>λmax</td>
                        <td></td>
                        <td></td>
                        <td><?= $JML = array_sum($hasil_penjumlahan_array) / count($cm);
                            "&lambda;max: "  . round($JML, 3) . "<br />"; ?></td>

                    </tr>
                </table>
            </div>
        </div>




        <div class="panel panel-default">
            <div class="panel-body">
                Berikut tabel ratio index berdasarkan ordo matriks.
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <tr>
                        <th>Ordo matriks</th>
                        <?php
                        foreach ($nRI as $key => $value) {
                            if (count($matriks) == $key)
                                echo "<td class='text-primary'>$key</td>";
                            else
                                echo "<td>$key</td>";
                        }
                        ?>
                    </tr>
                    <tr>
                        <th>Ratio index</th>
                        <?php
                        foreach ($nRI as $key => $value) {
                            if (count($matriks) == $key)
                                echo "<td class='text-primary'>$value</td>";
                            else
                                echo "<td>$value</td>";
                        }
                        ?>
                    </tr>
                </table>
            </div>
            <div class="panel-body">
                <?php
                //if (count($cm) > 1) {
                $LMD = ((array_sum($cm) / count($cm)) - count($cm));
                $CI = ($LMD / count($cm)) - (count($cm) - 1);
                $RI = $nRI[count($matriks)];
                $CR = $CI / $RI;

                echo "Consistency Index: " . round($CI, 3) . "<br />";
                echo "Ratio Index: " . round($RI, 3) . "<br />";
                echo "Consistency Ratio: " . round($CR, 3);
                if ($CR > 0.10) {
                    echo " (Tidak konsisten)<br />";
                } else {
                    echo " (Konsisten)<br />";
                }
                // } else {
                //     // Handle the case where count($cm) is not greater than 1
                //     echo "Error: Tidak dapat melakukan pembagian, karena jumlah elemen array kurang dari 2.";
                // }
                ?>
            </div>
        </div>
    </div>
</div>

<div class="panel panel-primary">
    <div style="background-color: #981A40;" class="panel-heading">
        <h3 class="panel-title">Hasil Analisa</h3>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered table-hover table-striped">
            <thead>
                <tr>
                    <th>Kode</th>
                    <th>Nama Alternatif</th>
                    <?php foreach ($KRITERIA as $key => $val) : ?>
                        <th><?= $val ?></th>
                    <?php endforeach ?>
                </tr>
            </thead>
            <?php
            $data = get_rel_alternatif();
            foreach ($data as $key => $val) : ?>
                <tr>
                    <td><?= $key ?></td>
                    <td><?= $ALTERNATIF[$key] ?></td>
                    <?php foreach ($val as $k => $v) : ?>
                        <td><?= $SUB[$v]['nama'] ?></td>
                    <?php endforeach ?>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</div>
<?php

function get_hasil_bobot($data)
{
    $matriks_kriteria = get_relkriteria();
    $total_kriteria = get_baris_total($matriks_kriteria);
    $normal_kriteria = normalize($matriks_kriteria, $total_kriteria);
    $rata_kriteria = get_rata($normal_kriteria);
    global $SUB;
    $arr = array();
    foreach ($data as $key => $val) {
        foreach ($val as $k => $v) {
            $arr[$key][$k] = round($SUB[$v]['nilai_sub']* $rata_kriteria[$k],4);
        }
    }
    return $arr;
}
 function prettyPrint($array) {
	    echo '<pre>'.print_r($array, true).'</pre>';
	}
$hasil_bobot = get_hasil_bobot($data);
?>
<?php

    

    // $matriks_kriteria = get_relkriteria();
    // $total_kriteria = get_baris_total($matriks_kriteria);
    // $normal_kriteria = normalize($matriks_kriteria, $total_kriteria);
    // $rata_kriteria = get_rata($normal_kriteria);

   

    // $rows = $db->get_results("SELECT kode_kriteria
    //         FROM tb_sub
    //         GROUP BY kode_kriteria");
    // $matriks_all = array();
    // foreach ($rows as $row) {

    //     $rows_sub = $db->get_results("SELECT r.ID1, r.ID2, nilai 
    //         FROM tb_rel_sub r 
    //         INNER JOIN tb_sub s1 ON s1.kode_sub=r.ID1
    //         INNER JOIN tb_sub s2 ON s2.kode_sub=r.ID2
    //         WHERE s1.kode_kriteria='" . esc_field($row->kode_kriteria) . "' AND s2.kode_kriteria='" . esc_field($row->kode_kriteria) . "'
    //         ORDER BY ID1, ID2");
    //     $matriks_sub = array();
    //     foreach ($rows_sub as $row_sub) {
    //         $matriks_sub[$row_sub->ID1][$row_sub->ID2] = $row_sub->nilai;
    //     }

    //     $total_sub = get_baris_total($matriks_sub);
    //     $normal = normalize($matriks_sub, $total_sub);
    //     $matriks_all[$row->kode_kriteria] = get_rata($normal);
    // }
    // foreach ($matriks_all as $key1 => $value1) {
    //     foreach ($value1 as $key2 => $value2) {
    //         $matriks_all[$key1][$key2] = round($value2 * $rata_kriteria[$key1],3);
    //     }
    // }
?>
<div class="panel panel-primary">
    <div style="background-color: #981A40;" class="panel-heading">
        <h3 class="panel-title">Hasil Pembobotan</h3>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered table-hover table-striped">
            <thead>
                <tr>
                    <th>Kode</th>
                    <th>Nama Alternatif</th>
                    <?php foreach ($KRITERIA as $key => $val) : ?>
                        <th><?= $val ?></th>
                    <?php endforeach ?>
                </tr>
            </thead>
            <?php
            foreach ($hasil_bobot as $key => $val) :
            $total_nilai = 0; ?>
                <tr>
                    <td><?= $key ?></td>
                    <td><?= $ALTERNATIF[$key] ?></td>
                    <?php foreach ($val as $k => $v) : ?>
                        <td><?= round($v, 4) ?></td>
                    <?php 
                    $total_nilai+=round($v, 4);
                    endforeach ?>
                </tr>
            <?php 
            $db->query("UPDATE tb_alternatif SET total=$total_nilai WHERE kode_alternatif='$key'");
            endforeach; 
            ?>
        </table>
    </div>
</div>

<div class="panel panel-primary">
    <div style="background-color: #981A40;" class="panel-heading">
        <h3 class="panel-title">Perangkingan</h3>
    </div>
    <div class="table-responsive">
        <table class="table table-hover table-bordered table-striped">
            <thead>
                <tr>
                    <th>Kode</th>
                    <th>Nama</th>
                    <th>Ranking</th>
                    <th>Total</th>
                </tr>
            </thead>
            <?php
            $rank = 1;
            $rows = $db->get_results("SELECT * FROM tb_alternatif  ORDER BY total DESC");
            foreach ($rows as $row) : ?>
                <tr>
                    <td><?= $row->kode_alternatif ?></td>
                    <td><?= $row->nama_alternatif ?></td>
                    <td><?= $rank++ ?></td>
                    <td><?= round($row->total, 4) ?></td>
                </tr>
            <?php endforeach ?>
        </table>
    </div>
    <div class="panel-body">
        <?php
        // Ambil data dari baris pertama (rank 1)
        $best_alternatif = $rows[0]->nama_alternatif;
        $best_total = round($rows[0]->total, 3);
        ?>
        <p>Jadi pilihan terbaik adalah <strong><?= $best_alternatif ?></strong> dengan nilai <strong><?= $best_total ?></strong></p>
        <p><a class="btn btn-default" target="_blank" href="cetak.php?m=hitung"><span class="glyphicon glyphicon-print"></span> Cetak</a></p>
    </div>
</div>