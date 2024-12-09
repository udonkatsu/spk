<div class="page-header">
    <h1>Nilai Bobot Alternatif</h1>
</div>
<div class="panel panel-default">
    <div class="panel-heading">
        <form class="form-inline">
            <input type="hidden" name="m" value="rel_alternatif" />
            <div class="form-group">
                <input class="form-control" type="text" placeholder="Pencarian. . ." name="q" value="<?= isset($_GET['q']) ? $_GET['q'] : '' ?>" />
            </div>
        </form>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered table-hover table-striped">
            <thead>
                <tr>
                    <th>Kode</th>
                    <th>Nama Alternatif</th>
                    <?php
                    if (!isset($KRITERIA) || !is_array($KRITERIA)) {
                        $KRITERIA = array(); // Inisialisasi sebagai array kosong jika belum terdefinisi
                    }

                    // Gunakan variabel $KRITERIA dalam pernyataan foreach
                    foreach ($KRITERIA as $key => $val) :
                    ?>
                        <th><?= $val ?></th>
                    <?php endforeach ?>
                    <th>Aksi</th>
                </tr>
            </thead>
            <?php
            $data = get_rel_alternatif();
            $no = 0;
            foreach ($data as $key => $val) :
            ?>
                <tr>
                    <td><?= $key ?></td>
                    <td><?= $ALTERNATIF[$key] ?></td>
                    <?php foreach ($val as $k => $v) : ?>
                        <td>
                            <?php
                            // Periksa apakah kunci sudah terdefinisi dan tidak kosong
                            if (isset($SUB[$v]['nama']) && !empty($SUB[$v]['nama'])) {
                                echo $SUB[$v]['nama'];
                            } else {
                                echo " ";
                            }
                            ?>
                        </td>
                    <?php endforeach ?>
                    <td>
                        <a class="btn btn-xs btn-warning" href="?m=rel_alternatif_ubah&ID=<?= $key ?>"><span class="glyphicon glyphicon-edit"></span> Ubah</a>
                    </td>
                </tr>

            <?php endforeach ?>
        </table>
    </div>
</div>