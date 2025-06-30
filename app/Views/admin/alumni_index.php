<?= $this->extend('layouts/admin_main') ?>
<?= $this->section('content') ?>

<div class="container mt-4">
    <h3>Data Alumni</h3>

    <div class="table-responsive">
        <table class="table table-bordered" id="tabelAlumni">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>NIM</th>
                    <th>Nama</th>
                    <th>Prodi</th>
                    <th>Tahun Lulus</th>
                    <th>Email</th>
                    <th>No HP</th>
                    <th>Options</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($list as $i => $row): ?>
                    <tr>
                        <td><?= $i + 1 ?></td>
                        <td><?= esc($row['nim']) ?></td>
                        <td><?= esc($row['nama']) ?></td>
                        <td><?= esc($row['nama_prodi']) ?></td>
                        <td><?= esc($row['tahun_lulus']) ?></td>
                        <td><?= esc($row['email']) ?></td>
                        <td><?= esc($row['no_hp']) ?></td>
                        <td>
                            <a href="<?= base_url('admin/alumni/edit/' . $row['id']) ?>" class="btn btn-warning btn-sm">Edit</a>
                            <a href="<?= base_url('admin/alumni/detail/' . $row['id']) ?>" class="btn btn-info btn-sm">Detail</a>
                            <a href="<?= base_url('admin/alumni/delete/' . $row['id']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus?')">Hapus</a>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
</div>

<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script>
    $(function() {
        $('#tabelAlumni').DataTable();
    });
</script>

<?= $this->endSection() ?>