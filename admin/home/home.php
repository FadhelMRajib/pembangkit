<?php
session_start();
require_once '../../config.php';

// Buat koneksi
$connection = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

// Cek koneksi
if (!$connection) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Ambil daftar UP3 yang diinginkan untuk dropdown filter
$query_up3_list = "SELECT id_up3, nama_up3 FROM up3 WHERE nama_up3 IN ('Kota Baru', 'Kuala Kapuas', 'Palangka Raya', 'Pangkalanbuun') ORDER BY nama_up3";
$result_up3_list = mysqli_query($connection, $query_up3_list);
$up3_list = [];
while ($row = mysqli_fetch_assoc($result_up3_list)) {
    $up3_list[] = $row;
}

// Ambil UP3 yang dipilih dari parameter GET, default ke semua
$selected_up3 = isset($_GET['up3']) ? $_GET['up3'] : 'semua';

// Modifikasi WHERE clause berdasarkan pilihan
$up3_filter = $selected_up3 != 'semua' ? "WHERE up3.id_up3 = '$selected_up3'" : "WHERE up3.nama_up3 IN ('Kota Baru', 'Kuala Kapuas', 'Palangka Raya', 'Pangkalanbuun')";

// Query yang sudah dimodifikasi dengan filter UP3
$query_system_comparison = "
    SELECT mesin.sistem, COUNT(mesin.id_mesin) AS total
    FROM mesin
    JOIN uld ON mesin.id_uld = uld.id_uld
    JOIN up3 ON uld.id_up3 = up3.id_up3
    $up3_filter
    GROUP BY mesin.sistem
";

$query_uld_system_comparison = "
    SELECT uld.sistem, COUNT(DISTINCT uld.id_uld) AS total
    FROM uld
    JOIN up3 ON uld.id_up3 = up3.id_up3
    $up3_filter
    GROUP BY uld.sistem
";

$query_up3_specific = "
    SELECT up3.nama_up3, COUNT(uld.id_uld) AS jumlah_uld
    FROM uld
    JOIN up3 ON uld.id_up3 = up3.id_up3
    $up3_filter
    GROUP BY up3.nama_up3
";

$query_isolated = "
    SELECT uld.nama_uld, COUNT(mesin.id_mesin) AS total_isolated
    FROM mesin
    JOIN uld ON mesin.id_uld = uld.id_uld
    JOIN up3 ON uld.id_up3 = up3.id_up3
    WHERE mesin.sistem = 'Isolated'
    " . ($up3_filter ? "AND " . substr($up3_filter, 6) : "") . "
    GROUP BY uld.nama_uld
";

$query_interkoneksi = "
    SELECT uld.nama_uld, COUNT(mesin.id_mesin) AS total_interkoneksi
    FROM mesin
    JOIN uld ON mesin.id_uld = uld.id_uld
    JOIN up3 ON uld.id_up3 = up3.id_up3
    WHERE mesin.sistem = 'Interkoneksi'
    " . ($up3_filter ? "AND " . substr($up3_filter, 6) : "") . "
    GROUP BY uld.nama_uld
";

$query_total_mesin = "
    SELECT uld.nama_uld, COUNT(mesin.id_mesin) AS total_mesin
    FROM mesin
    JOIN uld ON mesin.id_uld = uld.id_uld
    JOIN up3 ON uld.id_up3 = up3.id_up3
    $up3_filter
    GROUP BY uld.nama_uld
";

// Eksekusi query
$result_system_comparison = mysqli_query($connection, $query_system_comparison);
$result_uld_system_comparison = mysqli_query($connection, $query_uld_system_comparison);
$result_up3_specific = mysqli_query($connection, $query_up3_specific);
$result_isolated = mysqli_query($connection, $query_isolated);
$result_interkoneksi = mysqli_query($connection, $query_interkoneksi);
$result_total_mesin = mysqli_query($connection, $query_total_mesin);


// Array untuk menyimpan data perbandingan sistem mesin
$systemData = [];
while ($row = mysqli_fetch_assoc($result_system_comparison)) {
    $systemData[] = [
        'sistem' => $row['sistem'],
        'total' => $row['total']
    ];
}

// Array untuk menyimpan data perbandingan sistem ULD
$uldSystemData = [];
while ($row = mysqli_fetch_assoc($result_uld_system_comparison)) {
    $uldSystemData[] = [
        'sistem' => $row['sistem'],
        'total' => $row['total']
    ];
}

// Array untuk menyimpan jumlah ULD per UP3 spesifik
$up3SpecificData = [];
while ($row = mysqli_fetch_assoc($result_up3_specific)) {
    // Normalisasi nama Pangkalan Bun
    if ($row['nama_up3'] == 'PANGKALANBUUN') {
        $row['nama_up3'] = 'PANGKALAN BUN';
    }
    $up3SpecificData[] = [
        'nama_up3' => $row['nama_up3'],
        'jumlah_uld' => $row['jumlah_uld']
    ];
}

// Arrays untuk menyimpan data
$isolatedData = [];
while ($row = mysqli_fetch_assoc($result_isolated)) {
    $isolatedData[] = [
        'nama_uld' => $row['nama_uld'],
        'total_isolated' => $row['total_isolated']
    ];
}

$interkoneksiData = [];
while ($row = mysqli_fetch_assoc($result_interkoneksi)) {
    $interkoneksiData[] = [
        'nama_uld' => $row['nama_uld'],
        'total_interkoneksi' => $row['total_interkoneksi']
    ];
}

$totalMesinData = [];
while ($row = mysqli_fetch_assoc($result_total_mesin)) {
    $totalMesinData[] = [
        'nama_uld' => $row['nama_uld'],
        'total_mesin' => $row['total_mesin']
    ];
}

// Cek login dan role
if (!isset($_SESSION["login"])) {
    header("Location: ../../auth/login.php?pesan=belum_login");
} else if ($_SESSION["role"] != 'admin') {
    header("Location: ../../auth/login.php?pesan=tolak_akses");
}

$judul = "Home";
include('../layout/header.php');
?>

<style>
    .card-img-top {
        height: 200px;
        overflow: hidden;
    }

    .card-img-top img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .card-title {
        font-size: 1rem;
        font-weight: bold;
        margin: 0;
    }

    .card .text-secondary {
        font-size: 0.9rem;
    }
</style>

<div class="page-body">
    <div class="container-xl">

        <!-- Bagian Filter -->
        <div class="row mb-3 align-items-stretch">
            <div class="col-md-4">
                <div class="card h-100">
                    <div class="card-body">
                        <form id="up3FilterForm" method="GET" class="d-flex align-items-center">
                            <div class="input-group">
                                <label class="input-group-text" for="up3Filter"> Pilih UP3: </label>
                                <select name="up3" id="up3Filter" class="form-select" onchange="this.form.submit()">
                                    <option value="semua"> Semua UP3 </option>
                                    <?php foreach ($up3_list as $up3): ?>
                                        <option value="<?= htmlspecialchars($up3['id_up3']) ?>" <?= $selected_up3 == $up3['id_up3'] ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($up3['nama_up3']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Informasi UP3 yang Dipilih -->
            <div class="col-md-8">
                <div class="card h-100 d-flex align-items-center">
                    <div class="card-body d-flex flex-column justify-content-center align-items-center" style="height: 100%;">
                        <h3 class="text-center">
                            <?php
                            if ($selected_up3 == 'semua') {
                                echo 'Menampilkan Semua UP3';
                            } else {
                                // Mencari nama UP3 berdasarkan selected_up3
                                $selected_up3_name = '';
                                foreach ($up3_list as $up3) {
                                    if ($up3['id_up3'] == $selected_up3) {
                                        $selected_up3_name = htmlspecialchars($up3['nama_up3']);
                                        break;
                                    }
                                }
                                // Jika nama UP3 ditemukan, tampilkan, jika tidak tampilkan pesan default
                                echo $selected_up3_name ? 'Menampilkan UP3 ' . $selected_up3_name : 'UP3 tidak ditemukan';
                            }
                            ?>
                        </h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="row row-cards mb-3">
            <!-- Isolated Machines di sebelah kiri -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="subheader">Isolated Machines by ULD</h4>
                        <canvas id="isolatedBarChart" width="100%" height="70"></canvas>
                    </div>
                </div>

                <div class="card mt-3">
                    <div class="card-body">
                        <h4 class="subheader">Jumlah Mesin by ULD</h4>
                        <canvas id="totalMesinChart" width="100%" height="70"></canvas>
                    </div>
                </div>

                <div class="card mt-3">
                    <div class="card-body">
                        <h4 class="subheader">Perbandingan Sistem Mesin Isolated dengan Interkoneksi</h4>
                        <canvas id="systemComparisonPieChart" width="200" height="200"></canvas>
                    </div>
                </div>
            </div>

            <!-- Interkoneksi Machines di sebelah kanan -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="subheader">Interkoneksi Machines by ULD</h4>
                        <canvas id="interkoneksiBarChart" width="100%" height="70"></canvas>
                    </div>
                </div>

                <div class="card mt-3">
                    <div class="card-body">
                        <h4 class="subheader">Jumlah ULD by UP3</h4>
                        <canvas id="up3BarChart" width="100%" height="70"></canvas>
                    </div>
                </div>

                <div class="card mt-3">
                    <div class="card-body">
                        <h4 class="subheader">Perbandingan Sistem ULD Isolated dengan Interkoneksi</h4>
                        <canvas id="uldSystemComparisonPieChart" width="200px" height=200px"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bagian untuk tampilan lokasi UP3 dengan gambar -->
        <div class="row row-cards">
            <?php foreach ($up3SpecificData as $up3) : ?>
                <?php
                $nama_up3 = $up3['nama_up3'];
                $jumlah_uld = $up3['jumlah_uld'];

                // Menentukan gambar berdasarkan nama UP3
                $gambar = '';
                switch (strtoupper($nama_up3)) {
                    case 'KOTA BARU':
                        $gambar = 'kotabaru.JPG';
                        break;
                    case 'KUALA KAPUAS':
                        $gambar = 'kuala_kapuas.jpg';
                        break;
                    case 'PALANGKA RAYA':
                        $gambar = 'palangkaraya2.jpg';
                        break;
                    case 'PANGKALAN BUN':
                    case 'PANGKALANBUUN':
                        $gambar = 'pangkalanbun.jpg';
                        break;
                    default:
                        $gambar = 'default.jpg';
                        break;
                }
                ?>
                <div class="col-sm-6 col-lg-3">
                    <div class="card">
                        <img src="<?= base_url('assets/img/' . $gambar) ?>"
                            alt="<?= htmlspecialchars($nama_up3) ?>"
                            style="width: 100%; height: 250px; object-fit: cover;">
                        <div class="card-body text-center p-2">
                            <h4><?= strtoupper(htmlspecialchars($nama_up3)) ?></h4>
                            <div class="text-secondary"><?= htmlspecialchars($jumlah_uld) ?> ULD</div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Tampilkan alert ketika filter berubah
        document.getElementById('up3Filter').addEventListener('change', function() {
            const selectedText = this.options[this.selectedIndex].text;
            document.getElementById('selectedUp3Info').textContent = selectedText; // Update the displayed city name
            if (this.value !== 'semua') {
                // Menampilkan pesan loading
                Swal.fire({
                    title: 'Memuat Data...',
                    text: `Sedang mengambil data untuk UP3 ${selectedText}`,
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
            }
            document.getElementById('up3FilterForm').submit();
        });

        var isolatedData = <?= json_encode($isolatedData) ?>;
        var interkoneksiData = <?= json_encode($interkoneksiData) ?>;
        var totalMesinData = <?= json_encode($totalMesinData) ?>;
        var up3Data = <?= json_encode($up3SpecificData) ?>;
        var systemData = <?= json_encode($systemData) ?>;
        var uldSystemData = <?= json_encode($uldSystemData) ?>;

        // Chart untuk Isolated Machines
        var ctxIsolated = document.getElementById('isolatedBarChart').getContext('2d');
        new Chart(ctxIsolated, {
            type: 'bar',
            data: {
                labels: isolatedData.map(data => data.nama_uld),
                datasets: [{
                    label: 'Jumlah Mesin Isolated',
                    data: isolatedData.map(data => data.total_isolated),
                    backgroundColor: '#3479f4',
                    borderColor: '#3479f4',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Jumlah Mesin',
                            font: {
                                size: 12
                            }
                        },
                        ticks: {
                            font: {
                                size: 7
                            }
                        }
                    },
                    x: {
                        ticks: {
                            font: {
                                size: 0
                            }
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                        labels: {
                            font: {
                                size: 10
                            }
                        }
                    },
                    title: {
                        display: true,
                        text: 'Jumlah Mesin dengan Sistem Isolated per ULD',
                        font: {
                            size: 12
                        }
                    }
                }
            }
        });

        // Chart untuk Interkoneksi Machines
        var ctxInterkoneksi = document.getElementById('interkoneksiBarChart').getContext('2d');
        new Chart(ctxInterkoneksi, {
            type: 'bar',
            data: {
                labels: interkoneksiData.map(data => data.nama_uld),
                datasets: [{
                    label: 'Jumlah Mesin Interkoneksi',
                    data: interkoneksiData.map(data => data.total_interkoneksi),
                    backgroundColor: '#f4a341',
                    borderColor: '#f4a341',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Jumlah Mesin',
                            font: {
                                size: 12
                            }
                        },
                        ticks: {
                            font: {
                                size: 6
                            }
                        }
                    },
                    x: {
                        ticks: {
                            font: {
                                size: 0
                            }
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                        labels: {
                            font: {
                                size: 10
                            }
                        }
                    },
                    title: {
                        display: true,
                        text: 'Jumlah Mesin dengan Sistem Interkoneksi per ULD',
                        font: {
                            size: 12
                        }
                    }
                }
            }
        });

        // Chart untuk Total Mesin
        var ctxTotalMesin = document.getElementById('totalMesinChart').getContext('2d');
        new Chart(ctxTotalMesin, {
            type: 'bar',
            data: {
                labels: totalMesinData.map(data => data.nama_uld),
                datasets: [{
                    label: 'Total Mesin',
                    data: totalMesinData.map(data => data.total_mesin),
                    backgroundColor: '#4BC0C0',
                    borderColor: '#4BC0C0',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Jumlah Mesin',
                            font: {
                                size: 12
                            }
                        },
                        ticks: {
                            font: {
                                size: 6
                            }
                        }
                    },
                    x: {
                        ticks: {
                            font: {
                                size: 0
                            }
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                        labels: {
                            font: {
                                size: 10
                            }
                        }
                    },
                    title: {
                        display: true,
                        text: 'Total Mesin per ULD',
                        font: {
                            size: 12
                        }
                    }
                }
            }
        });

        // Chart untuk Perbandingan Sistem Mesin
        var ctxSystemComparison = document.getElementById('systemComparisonPieChart').getContext('2d');
        new Chart(ctxSystemComparison, {
            type: 'pie',
            data: {
                labels: systemData.map(data => `Sistem ${data.sistem}`),
                datasets: [{
                    data: systemData.map(data => data.total),
                    backgroundColor: ['#0000FF', '#008000'], // Tambahkan warna sesuai kebutuhan
                    borderColor: '#000000',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            font: {
                                size: 12
                            }
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                var total = context.dataset.data.reduce((a, b) => a + b, 0);
                                var percentage = Math.round((context.raw / total) * 100);
                                return `${context.label}: ${context.raw} unit (${percentage}%)`;
                            }
                        }
                    }
                }
            }
        });

        // Chart untuk Perbandingan Sistem ULD
        var ctxUldSystemComparison = document.getElementById('uldSystemComparisonPieChart').getContext('2d');
        new Chart(ctxUldSystemComparison, {
            type: 'pie',
            data: {
                labels: uldSystemData.map(data => `ULD ${data.sistem}`),
                datasets: [{
                    data: uldSystemData.map(data => data.total),
                    backgroundColor: ['#0000FF', '#008000', '#008'], // Warna berbeda untuk membedakan dari chart sebelumnya
                    borderColor: '#000000', // Mengubah warna garis menjadi hitam
                    borderWidth: 2 // Ketebalan garis
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            font: {
                                size: 12
                            }
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                var total = context.dataset.data.reduce((a, b) => a + b, 0);
                                var percentage = Math.round((context.raw / total) * 100);
                                return `${context.label}: ${context.raw} unit (${percentage}%)`;
                            }
                        }
                    }
                }
            }
        });

        // Chart untuk ULD by UP3
        var ctxUP3 = document.getElementById('up3BarChart').getContext('2d');
        new Chart(ctxUP3, {
            type: 'bar',
            data: {
                labels: up3Data.map(data => data.nama_up3),
                datasets: [{
                    label: 'Jumlah ULD',
                    data: up3Data.map(data => data.jumlah_uld),
                    backgroundColor: '#FFA07A',
                    borderColor: '#FFA07A',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Jumlah ULD',
                            font: {
                                size: 12
                            }
                        },
                        ticks: {
                            font: {
                                size: 6
                            }
                        }
                    },
                    x: {
                        ticks: {
                            font: {
                                size: 8
                            }
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                        labels: {
                            font: {
                                size: 10
                            }
                        }
                    },
                    title: {
                        display: true,
                        text: 'Jumlah ULD by UP3',
                        font: {
                            size: 12
                        }
                    }
                }
            }
        })
    });
</script>

<!-- Tambahkan SweetAlert2 untuk notifikasi yang lebih baik -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?= include('../layout/footer.php') ?>