<div class="page-header">
    <h1>Kriteria</h1>
</div>
<div class="panel panel-default">
    <div class="panel-heading">
        <form class="form-inline">
            <input type="hidden" name="m" value="kriteria" />
            <div class="form-group">
                <input class="form-control" type="text" placeholder="Pencarian. . ." name="q" value="<?= isset($_GET['q']) ? $_GET['q'] : '' ?>" />
            </div>
            <div class="form-group">
                <a style="background-color: #981A40;" class="btn btn-default" href="?m=kriteria_tambah"><span class="glyphicon glyphicon-plus"></span> Tambah</a>
            </div>
        </form>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered table-hover table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode</th>
                    <th>Nama Kriteria</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <?php
            //$q = esc_field($_GET['q']);
            $q = isset($_GET['q']) ? esc_field($_GET['q']) : '';
            $rows = $db->get_results("SELECT * FROM tb_kriteria WHERE nama_kriteria LIKE '%$q%' ORDER BY kode_kriteria");
            $no = 0;
            foreach ($rows as $row) : ?>
                <tr>
                    <td><?= ++$no ?></td>
                    <td><?= $row->kode_kriteria ?></td>
                    <td><?= $row->nama_kriteria ?></td>
                    <td>
                        <a class="btn btn-xs btn-warning" href="?m=kriteria_ubah&ID=<?= $row->kode_kriteria ?>"><span class="glyphicon glyphicon-edit"></span></a>
                        <a class="btn btn-xs btn-danger" href="aksi.php?act=kriteria_hapus&ID=<?= $row->kode_kriteria ?>" onclick="return confirm('Hapus data?')"><span class="glyphicon glyphicon-trash"></span></a>
                    </td>
                </tr>
            <?php endforeach ?>
        </table>
    </div>
</div>