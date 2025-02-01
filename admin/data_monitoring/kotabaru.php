<?php
session_start();

$judul = "Kota Baru";
include('../layout/header.php');
?>

<!-- Tambahkan CSS untuk peta -->
<style>
  #map {
    height: 400px;
    width: 100%;
    margin-bottom: 20px;
    border-radius: 10px;
    position: relative;
    /* Tambahkan ini */
  }
</style>

<!-- Page body -->
<div class="page-body">
  <div class="container-xl">
    <div class="row row-deck row-cards">

      <!-- Peta Google Maps -->
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Lokasi Kota Baru</h3>
          </div>
          <div class="card-body">
            <div id="map"></div> <!-- Ganti iframe dengan div untuk peta -->
          </div>
        </div>
      </div>

      <!-- Informasi Card -->
      <div class="col-sm-6 col-lg-3">
        <div class="card card-sm">
          <div class="card-body">
            <div class="row align-items-center">
              <div class="col-auto">
                <span class="bg-primary text-white avatar">
                  <img src="<?= base_url('assets/img/kotabaru.JPG ') ?>" alt="Kota Baru">
                </span>
              </div>
              <div class="col">
                <div class="font-weight-medium">
                  KOTA BARU
                </div>
                <div class="text-secondary">
                  12 ULD
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Statistik Card -->
      <div class="col-sm-6 col-lg-3">
        <div class="card">
          <div class="card-body">
            <div class="d-flex align-items-center">
              <div class="subheader">Total ULD</div>
            </div>
            <div class="h1 mb-3">12</div>
          </div>
        </div>
      </div>

      <div class="col-sm-6 col-lg-3">
        <div class="card">
          <div class="card-body">
            <div class="d-flex align-items-center">
              <div class="subheader">Status Operasi</div>
            </div>
            <div class="d-flex align-items-baseline">
              <div class="h1 mb-0 me-2">75%</div>
              <div class="me-auto">
                <span class="text-green d-inline-flex align-items-center lh-1">
                  Aktif
                </span>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-sm-6 col-lg-3">
        <div class="card">
          <div class="card-body">
            <div class="d-flex align-items-center">
              <div class="subheader">Performa</div>
            </div>
            <div class="d-flex align-items-baseline">
              <div class="h1 mb-3 me-2">85%</div>
              <div class="me-auto">
                <span class="text-green d-inline-flex align-items-center lh-1">
                  Baik
                </span>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>


<!-- Script Google Maps -->
<script>
  document.addEventListener('DOMContentLoaded', function() {
    initMap();
  });

  function initMap() {
    const kotaBaru = {
      lat: -3.2384,
      lng: 116.1612
    };

    const map = new google.maps.Map(document.getElementById('map'), {
      zoom: 12,
      center: kotaBaru,
      mapTypeId: google.maps.MapTypeId.ROADMAP,
    });

    const marker = new google.maps.Marker({
      position: kotaBaru,
      map: map,
      title: 'Kota Baru',
      animation: google.maps.Animation.DROP
    });

    // Info window dengan styling
    const contentString = `
        <div style="padding: 15px; min-width: 200px;">
            <h5 style="margin: 0 0 10px 0; color: #333;">Kota Baru</h5>
            <p style="margin: 0; line-height: 1.5;">
                <strong>Unit Layanan:</strong> 12 ULD<br>
                <strong>Status:</strong> <span style="color: green;">Aktif</span><br>
                <strong>Performa:</strong> 85%
            </p>
        </div>
    `;

    const infowindow = new google.maps.InfoWindow({
      content: contentString,
      maxWidth: 300
    });

    // Event listener untuk marker
    marker.addListener('click', () => {
      infowindow.open(map, marker);
    });

    // Buka info window secara default
    infowindow.open(map, marker);

    // Garis batasan untuk daerah Kota Baru
    const kotaBaruBounds = [{
        lat: -3.2384,
        lng: 116.1612
      }, // Titik 1
      {
        lat: -3.2390,
        lng: 116.1620
      }, // Titik 2
      {
        lat: -3.2395,
        lng: 116.1600
      }, // Titik 3
      {
        lat: -3.2380,
        lng: 116.1590
      }, // Titik 4
      {
        lat: -3.2384,
        lng: 116.1612
      } // Kembali ke Titik 1
    ];

    const cityPolygon = new google.maps.Polygon({
      paths: kotaBaruBounds,
      strokeColor: '#FF0000',
      strokeOpacity: 0.8,
      strokeWeight: 2,
      fillColor: '#FF0000',
      fillOpacity: 0.35
    });

    cityPolygon.setMap(map); // Menampilkan polygon di peta
  }
</script>

<!-- Pastikan untuk menyertakan API Google Maps -->
<script async defer src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&callback=initMap"></script>

<?php include('../layout/footer.php'); ?>