<?php
session_start();

require_once('../config.php');

if (isset($_POST["login"])) {
  $username = $_POST["username"];
  $password = $_POST["password"];

  $result = mysqli_query($connection, "SELECT * FROM users JOIN pegawai ON users.id_pegawai = pegawai.id 
  WHERE username = '$username'");

  if (mysqli_num_rows($result) === 1) {
    $row = mysqli_fetch_assoc($result);

    if (password_verify($password, $row["password"])) {
      if ($row['status'] == 'Aktif') {

        $_SESSION["login"] = true;
        $_SESSION['id'] = $row['id'];
        $_SESSION['role'] = $row['role'];
        $_SESSION['nama'] = $row['nama'];
        $_SESSION['nip'] = $row['nip'];
        $_SESSION['jabatan'] = $row['jabatan'];
        $_SESSION['foto'] = $row['foto'];

        if ($row['role'] === 'admin') {
          header("Location: ../admin/home/home.php");
          exit();
        } else {
          header("Location: ../pegawai/home/home.php");
          exit();
        }
      } else {
        $_SESSION["gagal"] = "Akun anda belum aktif";
      }
    } else {
      $_SESSION["gagal"] = "Password salah, silahkan coba lagi";
    }
  } else {
    $_SESSION["gagal"] = "Username salah, silahkan coba lagi";
  }
}

// Fungsi untuk mengonfigurasi pesan alert berdasarkan parameter URL
function getAlertConfig($pesan)
{
  switch ($pesan) {
    case 'belum_login':
      return [
        'message' => 'Anda harus login terlebih dahulu!',
        'icon' => 'warning',
        'title' => 'Peringatan'
      ];
    case 'tolak_akses':
      return [
        'message' => 'Anda tidak memiliki akses ke halaman tersebut!',
        'icon' => 'error',
        'title' => 'Akses Ditolak'
      ];
    default:
      return false;
  }
}
?>



<!doctype html>
<!--
* Tabler - Premium and Open Source dashboard template with responsive and high quality UI.
* @version 1.0.0-beta19
* @link https://tabler.io
* Copyright 2018-2023 The Tabler Authors
* Copyright 2018-2023 codecalm.net Paweł Kuna
* Licensed under MIT (https://github.com/tabler/tabler/blob/master/LICENSE)
-->
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />
  <title>Sign in with illustration - Tabler - Premium and Open Source dashboard template with responsive and high quality UI.</title>
  <!-- CSS files -->
  <link href="<?= base_url('/assets/css/tabler.min.css?168410606') ?>" rel="stylesheet" />
  <link href="<?= base_url('/assets/css/tabler-vendors.min.css?1684106062') ?>" rel="stylesheet" />
  <link href="<?= base_url('/assets/css/demo.min.css?1684106062') ?>" rel="stylesheet" />
  <style>
    @import url('https://rsms.me/inter/inter.css');

    :root {
      --tblr-font-sans-serif: 'Inter Var', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
    }

    body {
      font-feature-settings: "cv03", "cv04", "cv11";
    }
  </style>
</head>

<body class=" d-flex flex-column">
  <script src="./dist/js/demo-theme.min.js?1684106062"></script>
  <div class="page page-center">
    <div class="container container-normal py-4">
      <div class="row align-items-center g-4">
        <div class="col-lg">
          <div class="container-tight">
            <div class="text-center mb-4">
              <a href="." class="navbar-brand navbar-brand-autodark"><img src="<?= base_url('assets/img/Logo_PLN.png') ?>" height="40" alt=""></a>
            </div>

            <?php
            if (isset($_GET['pesan'])) {
              if ($_GET['pesan'] == "belum_login") {
                $_SESSION['gagal'] = 'Anda Belum Login';
              } else if ($_GET['pesan'] == "tolak_akses") {
                $_SESSION['gagal'] = 'Akses ke Halaman ini diTolak';
              }
            }
            ?>

            <div class="card card-md">
              <div class="card-body">
                <h2 class="h2 text-center mb-4">Login to your account</h2>
                <form action="" method="POST" autocomplete="off" novalidate>
                  <div class="mb-3">
                    <label class="form-label">Username</label>
                    <input type="text" class="form-control" autofocus name="username" placeholder="username" autocomplete="off">
                  </div>

                  <div class="mb-2">
                    <label class="form-label">Password</label>
                    <div class="input-group input-group-flat">
                      <input type="password" class="form-control" id="passwordInput" name="password" placeholder="Password" autocomplete="off">
                      <span class="input-group-text">
                        <a href="#" class="link-secondary" id="togglePassword" title="Show password" data-bs-toggle="tooltip">
                          <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <!-- Icon untuk mata tertutup -->
                            <g id="eyeClosed">
                              <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                              <path d="M3 3l18 18" />
                              <path d="M10.584 10.587a2 2 0 0 0 2.828 2.83" />
                              <path d="M9.363 5.365a9.466 9.466 0 0 1 2.637 -.365c3.6 0 6.6 2 9 6c-.63 1.05 -1.4 2.02 -2.37 2.91" />
                              <path d="M17.341 17.341c-.778 .49 -1.701 .931 -2.341 1.341c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c.059 0 .116 0 .173 .002" />
                            </g>
                            <!-- Icon untuk mata terbuka -->
                            <g id="eyeOpen">
                              <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                              <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                              <path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" />
                            </g>
                          </svg>
                        </a>
                      </span>
                    </div>
                  </div>


                  <div class="form-footer">
                    <button type="submit" name="login" class="btn btn-primary w-100">Sign in</button>
                  </div>
                </form>
              </div>

            </div>

          </div>
        </div>
        <div class="col-lg d-none d-lg-block">
          <style>
            svg#freepik_stories-electrician:not(.animated) .animable {
              opacity: 0;
            }

            svg#freepik_stories-electrician.animated #freepik--Plants--inject-103 {
              animation: 1s 1 forwards cubic-bezier(.36, -0.01, .5, 1.38) fadeIn;
              animation-delay: 0s;
            }

            svg#freepik_stories-electrician.animated #freepik--Floor--inject-103 {
              animation: 1s 1 forwards cubic-bezier(.36, -0.01, .5, 1.38) lightSpeedLeft;
              animation-delay: 0s;
            }

            svg#freepik_stories-electrician.animated #freepik--Shadows--inject-103 {
              animation: 1s 1 forwards cubic-bezier(.36, -0.01, .5, 1.38) zoomIn;
              animation-delay: 0s;
            }

            svg#freepik_stories-electrician.animated #freepik--tool-box--inject-103 {
              animation: 1s 1 forwards cubic-bezier(.36, -0.01, .5, 1.38) lightSpeedRight;
              animation-delay: 0s;
            }

            svg#freepik_stories-electrician.animated #freepik--Tools--inject-103 {
              animation: 1s 1 forwards cubic-bezier(.36, -0.01, .5, 1.38) zoomOut;
              animation-delay: 0s;
            }

            svg#freepik_stories-electrician.animated #freepik--Character--inject-103 {
              animation: 1s 1 forwards cubic-bezier(.36, -0.01, .5, 1.38) slideUp;
              animation-delay: 0s;
            }

            svg#freepik_stories-electrician.animated #freepik--fuse-box--inject-103 {
              animation: 1s 1 forwards cubic-bezier(.36, -0.01, .5, 1.38) slideUp;
              animation-delay: 0s;
            }

            @keyframes fadeIn {
              0% {
                opacity: 0;
              }

              100% {
                opacity: 1;
              }
            }

            @keyframes lightSpeedLeft {
              from {
                transform: translate3d(-50%, 0, 0) skewX(20deg);
                opacity: 0;
              }

              60% {
                transform: skewX(-10deg);
                opacity: 1;
              }

              80% {
                transform: skewX(2deg);
              }

              to {
                opacity: 1;
                transform: translate3d(0, 0, 0);
              }
            }

            @keyframes zoomIn {
              0% {
                opacity: 0;
                transform: scale(0.5);
              }

              100% {
                opacity: 1;
                transform: scale(1);
              }
            }

            @keyframes lightSpeedRight {
              from {
                transform: translate3d(50%, 0, 0) skewX(-20deg);
                opacity: 0;
              }

              60% {
                transform: skewX(10deg);
                opacity: 1;
              }

              80% {
                transform: skewX(-2deg);
              }

              to {
                opacity: 1;
                transform: translate3d(0, 0, 0);
              }
            }

            @keyframes zoomOut {
              0% {
                opacity: 0;
                transform: scale(1.5);
              }

              100% {
                opacity: 1;
                transform: scale(1);
              }
            }

            @keyframes slideUp {
              0% {
                opacity: 0;
                transform: translateY(30px);
              }

              100% {
                opacity: 1;
                transform: inherit;
              }
            }

            .animator-hidden {
              display: none;
            }
          </style>
          <svg class="animated" id="freepik_stories-electrician" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 500 500" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.com/svgjs">
            <g id="freepik--Plants--inject-103" class="animable animator-hidden" style="transform-origin: 251.382px 285.72px;">
              <g id="freepik--plants--inject-103" class="animable" style="transform-origin: 48.4416px 283.375px;">
                <path d="M75.49,311.74s1.32-17.42-2.27-34.12-12.31-29.56-23-34.58-23.5,1.82-14.27,13.25,28.37,31.81,28.26,61.6Z" style="fill: rgb(224, 224, 224); transform-origin: 54.2529px 279.63px;" id="elnstmsugolkg" class="animable"></path>
                <path d="M70,311.13h.13a.64.64,0,0,0,.62-.65c-1-36.48-13.16-54.75-27.2-64a.63.63,0,0,0-.87.18.62.62,0,0,0,.17.87c13.85,9.17,25.64,27.06,26.63,63A.63.63,0,0,0,70,311.13Z" style="fill: rgb(255, 255, 255); transform-origin: 56.6603px 278.754px;" id="el9ehftt6bnsv" class="animable"></path>
                <path d="M21.16,279c.2,2,1.83,3.56,3.39,4.87s3.25,2.71,3.67,4.69c.86,4-3.89,7.7-2.86,11.66a6.32,6.32,0,0,0,3.34,3.73,40,40,0,0,0,3.93,1.68,18.2,18.2,0,0,0,2,.48A9.17,9.17,0,0,1,40,308.48c2.18,2.37,1.91,6,2.68,9.16.94,3.75,3.17,6,8.28,7.74l17.5-9.92c4.36-4.44,5.9-12,1.88-17.21-2.41-3.1-6.92-3.49-9.2-6.6-2-2.78-.86-6.8-2.11-10s-4.58-4.32-7.72-4.87-6.48.75-9.54-.37-5.91-2.93-9.09-3.72a10.56,10.56,0,0,0-9.16,1.54A5.59,5.59,0,0,0,21.16,279Z" style="fill: rgb(235, 235, 235); transform-origin: 46.9134px 298.816px;" id="elm1uoottjwj" class="animable"></path>
                <path d="M53.78,294.75a.49.49,0,0,0-.14-.18c-8.22-11.66-21.12-17.2-25.47-18.17a.46.46,0,1,0-.2.89c4.13.92,16.1,6,24.16,16.74a25.16,25.16,0,0,0-20.07,1.74.46.46,0,0,0-.14.63.49.49,0,0,0,.37.21.42.42,0,0,0,.26-.08,24.33,24.33,0,0,1,20.5-1.23,38.21,38.21,0,0,1,6.85,23.52.45.45,0,0,0,.4.47h0a.46.46,0,0,0,.47-.44A39.08,39.08,0,0,0,53.78,294.75Z" style="fill: rgb(255, 255, 255); transform-origin: 44.1802px 297.831px;" id="el0x5dmhk0ouyp" class="animable"></path>
              </g>
              <g id="freepik--plants--inject-103" class="animable" style="transform-origin: 458.083px 289.785px;">
                <path d="M434.59,323.47c-.17-13,.07-25,6.67-43.46,5.53-15.51,19.75-31.15,29.35-30.49,8.95.62,10.93,11.61,2.88,21.39s-25.58,28.49-26.66,42l-3.43,15.33Z" style="fill: rgb(224, 224, 224); transform-origin: 456.555px 288.87px;" id="elinmeycg4mn" class="animable"></path>
                <path d="M438.56,320.19a.59.59,0,0,0,.44-.54c1.4-30.24,18.29-55.44,32.38-63.19a.57.57,0,0,0-.56-1c-14.32,7.87-31.55,33.48-33,64.14a.57.57,0,0,0,.54.6Z" style="fill: rgb(255, 255, 255); transform-origin: 454.746px 287.793px;" id="elkcz0mdurg8" class="animable"></path>
                <path d="M446.7,330.07c.55-4.56,4.73-12.61,12.39-19.94,8.48-8.1,20.06-13.05,22-18.62,2.36-6.68-3.55-10.25-13.32-8.16-11.75,2.51-24.77,15.95-27,43.41Z" style="fill: rgb(235, 235, 235); transform-origin: 461.189px 306.412px;" id="elm6ngx3zmh1n" class="animable"></path>
                <path d="M444.07,325.8a.57.57,0,0,0,.43-.45c4.49-24,20.53-34.73,28.39-37.06a.57.57,0,0,0,.38-.71.56.56,0,0,0-.71-.39c-8.68,2.57-24.6,13.45-29.19,37.94a.57.57,0,0,0,.46.67A.49.49,0,0,0,444.07,325.8Z" style="fill: rgb(255, 255, 255); transform-origin: 458.327px 306.489px;" id="elw8b18frsyq" class="animable"></path>
              </g>
            </g>
            <g id="freepik--Floor--inject-103" class="animable" style="transform-origin: 247.62px 367.92px;">
              <path id="freepik--floor--inject-103" d="M93.71,456.78c-85-49.07-85-128.64,0-177.72s222.82-49.07,307.82,0,85,128.65,0,177.72S178.71,505.86,93.71,456.78Z" style="fill: rgb(250, 250, 250); transform-origin: 247.62px 367.92px;" class="animable"></path>
            </g>
            <g id="freepik--Shadows--inject-103" class="animable" style="transform-origin: 254.76px 377.389px;">
              <path id="freepik--Shadow--inject-103" d="M261,420.58l23.27-13.44a.76.76,0,0,0,0-1.44l-5.7-3.29a2.75,2.75,0,0,0-2.5,0l-23.27,13.44a.76.76,0,0,0,0,1.44l2.85,1.64L226.43,435.8c-.69.4-.4.53-.08.72s.56.35,1.25,0l29.21-16.86,1.68,1A2.75,2.75,0,0,0,261,420.58Z" style="fill: rgb(224, 224, 224); transform-origin: 255.397px 419.418px;" class="animable"></path>
              <path id="freepik--shadow--inject-103" d="M252.21,394.79a10.51,10.51,0,0,1-5.21-1.26l-.47-.3-.86-.61,7.33-1.07.66-1.38-2-1.16-7,1,.23-.66a4.54,4.54,0,0,1,2.15-2.3,10.48,10.48,0,0,1,5.12-1.22,12.16,12.16,0,0,1,2.35.22l23.88-13.78a2.87,2.87,0,0,1-.2-1.93,4.29,4.29,0,0,1,2.22-2.56,10.6,10.6,0,0,1,5.13-1.22,10.41,10.41,0,0,1,5.21,1.27,5.4,5.4,0,0,1,.47.3l.86.6-7.33,1.07-.66,1.39,2,1.16,7-1-.23.65a4.56,4.56,0,0,1-2.15,2.31,10.59,10.59,0,0,1-5.12,1.22,12.16,12.16,0,0,1-2.35-.23l-23.88,13.79a2.85,2.85,0,0,1,.2,1.92,4.27,4.27,0,0,1-2.22,2.56A10.49,10.49,0,0,1,252.21,394.79Z" style="fill: rgb(224, 224, 224); transform-origin: 268.875px 380.675px;" class="animable"></path>
              <ellipse id="freepik--shadow--inject-103" cx="151.58" cy="402.77" rx="76.29" ry="44.05" style="fill: rgb(224, 224, 224); transform-origin: 151.58px 402.77px;" class="animable"></ellipse>
              <polygon id="freepik--shadow--inject-103" points="276.43 405.3 377.67 346.85 434.23 379.5 332.99 437.95 276.43 405.3" style="fill: rgb(224, 224, 224); transform-origin: 355.33px 392.4px;" class="animable"></polygon>
              <path id="freepik--shadow--inject-103" d="M250.31,371.24l-39.49-22.8c-1.43-.82-1.43-2.17,0-3l63.86-36.86a5.74,5.74,0,0,1,5.2,0l39.49,22.79c1.43.83,1.43,2.18,0,3l-63.86,36.87A5.74,5.74,0,0,1,250.31,371.24Z" style="fill: rgb(224, 224, 224); transform-origin: 265.095px 339.91px;" class="animable"></path>
            </g>
            <g id="freepik--tool-box--inject-103" class="animable" style="transform-origin: 265.095px 316.284px;">
              <g id="freepik--tool-box--inject-103" class="animable" style="transform-origin: 265.095px 316.284px;">
                <polygon points="252.91 367.44 252.91 334.61 212.29 311.15 216.35 346.33 252.91 367.44" style="fill: rgb(38, 50, 56); transform-origin: 232.6px 339.295px;" id="elw0lviqufnf" class="animable"></polygon>
                <polygon points="252.91 367.44 313.84 332.26 317.9 297.08 252.91 334.61 252.91 367.44" style="fill: rgb(55, 71, 79); transform-origin: 285.405px 332.26px;" id="el5x29h3du2ir" class="animable"></polygon>
                <path d="M209.75,304.12a1.83,1.83,0,0,1,1.07-1.5l63.86-36.87a5.74,5.74,0,0,1,5.2,0l39.49,22.8a1.82,1.82,0,0,1,1.07,1.5v9.38a1.82,1.82,0,0,1-1.07,1.51L255.51,337.8a5.74,5.74,0,0,1-5.2,0L210.82,315a1.84,1.84,0,0,1-1.07-1.5Z" style="fill: #064FF9; transform-origin: 265.095px 301.775px;" id="eldm89wy82ft7" class="animable"></path>
                <g id="elyo9t6kj19sb">
                  <path d="M210.82,302.62l42.09-24.3v60.11a5.27,5.27,0,0,1-2.6-.63L210.82,315a1.84,1.84,0,0,1-1.07-1.5v-9.39A1.83,1.83,0,0,1,210.82,302.62Z" style="opacity: 0.2; transform-origin: 231.33px 308.375px;" class="animable" id="el89nw2dkmlq7"></path>
                </g>
                <g id="el4teyfdb4ve">
                  <path d="M252.91,278.32l21.77-12.57a5.74,5.74,0,0,1,5.2,0l39.49,22.8a1.82,1.82,0,0,1,1.07,1.5v9.38a1.82,1.82,0,0,1-1.07,1.51L255.51,337.8a5.27,5.27,0,0,1-2.6.63Z" style="opacity: 0.1; transform-origin: 286.675px 301.779px;" class="animable" id="elxapt4y9h1p"></path>
                </g>
                <path d="M250.31,328.42l-39.49-22.8c-1.43-.83-1.43-2.17,0-3l63.86-36.87a5.74,5.74,0,0,1,5.2,0l39.49,22.8c1.43.83,1.43,2.17,0,3l-63.86,36.87A5.74,5.74,0,0,1,250.31,328.42Z" style="fill: #064FF9; transform-origin: 265.095px 297.085px;" id="elfbrp2wqtu6" class="animable"></path>
                <g id="elzwcc6yapxdi">
                  <path d="M307.75,291.22c1.12.65,1.06,1.73-.14,2.42L263.2,319.29a4.64,4.64,0,0,1-4.2.07c-1.12-.64-1.06-1.73.14-2.42l44.41-25.64A4.64,4.64,0,0,1,307.75,291.22Z" style="opacity: 0.2; transform-origin: 283.375px 305.292px;" class="animable" id="el8r49srxxysg"></path>
                </g>
                <g id="el553wpz5fcns">
                  <path d="M263.2,319.29a4.64,4.64,0,0,1-4.2.07l-.22-.15a2.53,2.53,0,0,1,.36-.25l44.41-25.64a4.64,4.64,0,0,1,4.2-.08l.22.16a2.5,2.5,0,0,1-.36.24Z" style="opacity: 0.2; transform-origin: 283.375px 306.302px;" class="animable" id="el5xs1vqhatk9"></path>
                </g>
                <g id="el9lr1bh4rhhb">
                  <path d="M275.25,272.46c1.13.64,1.07,1.73-.13,2.42L230.7,300.52a4.62,4.62,0,0,1-4.19.08c-1.12-.65-1.06-1.73.13-2.42l44.42-25.65A4.62,4.62,0,0,1,275.25,272.46Z" style="opacity: 0.2; transform-origin: 250.884px 286.528px;" class="animable" id="eltw5ag0iqs2d"></path>
                </g>
                <g id="ellefgjwsu3sp">
                  <path d="M230.7,300.52a4.62,4.62,0,0,1-4.19.08,1.25,1.25,0,0,1-.22-.16,3.07,3.07,0,0,1,.35-.24l44.42-25.64a4.59,4.59,0,0,1,4.19-.08,2.1,2.1,0,0,1,.22.15,2.41,2.41,0,0,1-.35.25Z" style="opacity: 0.2; transform-origin: 250.88px 287.538px;" class="animable" id="elk6d1wo7w9wp"></path>
                </g>
                <g id="elikb9ym3yh1q">
                  <path d="M234.62,303c-1.12.65-1.06,1.73.14,2.42l16,9.22a4.62,4.62,0,0,0,4.19.08c1.12-.65,1.06-1.73-.13-2.42l-16-9.22A4.64,4.64,0,0,0,234.62,303Z" style="opacity: 0.2; transform-origin: 244.786px 308.86px;" class="animable" id="elc0egny5ocuf"></path>
                </g>
                <g id="elk8ckriteijk">
                  <path d="M250.75,314.59a4.62,4.62,0,0,0,4.19.08,2.1,2.1,0,0,0,.22-.15,2.41,2.41,0,0,0-.35-.25l-16-9.22a4.64,4.64,0,0,0-4.2-.08,1.66,1.66,0,0,0-.21.16,2,2,0,0,0,.35.24Z" style="opacity: 0.2; transform-origin: 244.78px 309.82px;" class="animable" id="elgp6swrdnk04"></path>
                </g>
                <g id="elxs5hhbpns8a">
                  <path d="M226.51,307.64c-1.12.64-1.06,1.73.13,2.42l16,9.22a4.64,4.64,0,0,0,4.2.08c1.12-.65,1.06-1.74-.14-2.43l-16-9.22A4.62,4.62,0,0,0,226.51,307.64Z" style="opacity: 0.2; transform-origin: 236.674px 313.498px;" class="animable" id="elr3gq1hvtjnk"></path>
                </g>
                <g id="elifgst055cos">
                  <path d="M242.63,319.28a4.64,4.64,0,0,0,4.2.08c.08-.05.14-.11.21-.16a2.41,2.41,0,0,0-.35-.25l-16-9.22a4.62,4.62,0,0,0-4.19-.07,1.21,1.21,0,0,0-.22.15,2.41,2.41,0,0,0,.35.25Z" style="opacity: 0.2; transform-origin: 236.66px 314.508px;" class="animable" id="el7g8u051iybj"></path>
                </g>
                <g id="elb30pwnqouy8">
                  <path d="M283.37,274.81c-1.12.65-1.07,1.73.13,2.42l16,9.22a4.62,4.62,0,0,0,4.19.08c1.13-.65,1.07-1.73-.13-2.42l-16-9.22A4.62,4.62,0,0,0,283.37,274.81Z" style="opacity: 0.2; transform-origin: 293.532px 280.67px;" class="animable" id="el4xu3psn42nc"></path>
                </g>
                <g id="eljfzgue3mewe">
                  <path d="M299.49,286.45a4.64,4.64,0,0,0,4.2.08,1.66,1.66,0,0,0,.21-.16,2.38,2.38,0,0,0-.35-.24l-16-9.22a4.62,4.62,0,0,0-4.19-.08,2.1,2.1,0,0,0-.22.15,2.41,2.41,0,0,0,.35.25Z" style="opacity: 0.2; transform-origin: 293.52px 281.68px;" class="animable" id="el58ttgdwc7na"></path>
                </g>
                <g id="eliidsxdo2ar">
                  <path d="M275.25,279.49c-1.12.65-1.06,1.74.13,2.43l16,9.22a4.68,4.68,0,0,0,4.2.08c1.12-.65,1.06-1.74-.14-2.43l-16-9.22A4.68,4.68,0,0,0,275.25,279.49Z" style="opacity: 0.2; transform-origin: 285.414px 285.356px;" class="animable" id="elquoyl580nkl"></path>
                </g>
                <g id="el88l5rr6nfvg">
                  <path d="M291.37,291.14a4.68,4.68,0,0,0,4.2.08l.22-.16a2.53,2.53,0,0,0-.36-.25l-16-9.22a4.68,4.68,0,0,0-4.2-.08l-.22.16a3.12,3.12,0,0,0,.35.25Z" style="opacity: 0.2; transform-origin: 285.4px 286.365px;" class="animable" id="ela9hwo48lchv"></path>
                </g>
                <path d="M248.85,295.05v9.07l4.06,2.35,4.06-2.35v-6.88a4.8,4.8,0,0,1,2.16-3.75l10-5.79,1.9-1.09c1.19-.69,2.16-.13,2.16,1.25v6.88l4.06-2.35v-9.07a4.63,4.63,0,0,0,0-.54,2.52,2.52,0,0,0-.06-.41,3.09,3.09,0,0,0-.12-.46,3.65,3.65,0,0,0-.14-.35,2.59,2.59,0,0,0-.19-.33,2.21,2.21,0,0,0-.22-.29,1.88,1.88,0,0,0-.25-.24h0a1.67,1.67,0,0,0-.28-.18l-.13-.07-3.91-2.26a3,3,0,0,0-3.05.3l-15.71,9.07A9.55,9.55,0,0,0,248.85,295.05Z" style="fill: rgb(69, 90, 100); transform-origin: 263.054px 292.188px;" id="elgnt4x4qitxu" class="animable"></path>
                <path d="M269.15,287.7h0v4.68l4.06,2.35v-6.88c0-1.38-1-1.94-2.16-1.25Z" style="fill: rgb(38, 50, 56); transform-origin: 271.18px 290.517px;" id="elw7klpne8ug" class="animable"></path>
                <path d="M252.91,297.39v9.08l4.06-2.35v-6.88a4.8,4.8,0,0,1,2.16-3.75l10-5.78h0l1.9-1.09c1.19-.69,2.16-.13,2.16,1.25v6.88l4.06-2.34v-9.08a4.63,4.63,0,0,0,0-.54,2.52,2.52,0,0,0-.06-.41,3.09,3.09,0,0,0-.12-.46,3.65,3.65,0,0,0-.14-.35,2.59,2.59,0,0,0-.19-.33,2.21,2.21,0,0,0-.22-.29,1.88,1.88,0,0,0-.25-.24h0a1.67,1.67,0,0,0-.28-.18l-.13-.07a3.12,3.12,0,0,0-2.9.38l-15.71,9.07A9.59,9.59,0,0,0,252.91,297.39Z" style="fill: rgb(55, 71, 79); transform-origin: 265.084px 293.366px;" id="elgck63g8ykim" class="animable"></path>
                <polygon points="273.22 336.95 271.72 336.09 267.65 338.43 269.16 339.3 273.22 336.95" style="fill: rgb(69, 90, 100); transform-origin: 270.435px 337.695px;" id="elcv6ilp8tyt5" class="animable"></polygon>
                <polygon points="269.16 339.3 267.66 358.93 267.65 338.43 269.16 339.3" style="fill: rgb(38, 50, 56); transform-origin: 268.405px 348.68px;" id="elgyyqqei4asg" class="animable"></polygon>
                <polygon points="273.22 336.95 271.72 356.58 272.21 356.35 273.22 336.95" style="fill: rgb(55, 71, 79); transform-origin: 272.47px 346.765px;" id="el369xa4z80t2" class="animable"></polygon>
                <polygon points="239.22 340.78 240.72 339.91 244.78 342.25 243.28 343.12 239.22 340.78" style="fill: rgb(69, 90, 100); transform-origin: 242px 341.515px;" id="elb9mjkasn4tq" class="animable"></polygon>
                <polygon points="239.22 340.78 240.72 360.4 240.23 360.17 239.22 340.78" id="elam6p29ozq9d" class="animable" style="transform-origin: 239.97px 350.59px;"></polygon>
                <polygon points="222.97 331.39 224.48 330.53 228.54 332.87 227.03 333.74 222.97 331.39" style="fill: rgb(69, 90, 100); transform-origin: 225.755px 332.135px;" id="elppr5c4ibyk" class="animable"></polygon>
                <polygon points="244.78 362.75 243.28 343.12 244.78 342.25 244.78 362.75" style="fill: rgb(55, 71, 79); transform-origin: 244.03px 352.5px;" id="el9xgugtoemya" class="animable"></polygon>
                <polygon points="228.54 332.87 228.54 353.37 227.03 333.74 228.54 332.87" style="fill: rgb(55, 71, 79); transform-origin: 227.785px 343.12px;" id="el4qx5eiykj8q" class="animable"></polygon>
                <polygon points="222.97 331.39 224.47 351.02 223.98 350.79 222.97 331.39" id="eljlwmtt7tpx" class="animable" style="transform-origin: 223.72px 341.205px;"></polygon>
                <polygon points="301.65 320.54 300.15 319.67 296.09 322.01 297.59 322.88 301.65 320.54" style="fill: rgb(69, 90, 100); transform-origin: 298.87px 321.275px;" id="elz8z4rdu83c" class="animable"></polygon>
                <polygon points="297.59 322.88 296.09 342.51 296.09 322.01 297.59 322.88" style="fill: rgb(38, 50, 56); transform-origin: 296.84px 332.26px;" id="el9ml11xrhl2" class="animable"></polygon>
                <polygon points="301.65 320.54 300.15 340.17 300.65 339.93 301.65 320.54" style="fill: rgb(55, 71, 79); transform-origin: 300.9px 330.355px;" id="elfkl4zlr93" class="animable"></polygon>
                <polygon points="265.47 333.62 265.48 328.93 273.6 324.24 274.96 325.02 274.95 329.71 266.82 334.4 265.47 333.62" style="fill: rgb(55, 71, 79); transform-origin: 270.215px 329.32px;" id="el8gz70g2ev7a" class="animable"></polygon>
                <polygon points="274.96 325.02 274.95 329.71 266.82 334.4 266.84 329.71 274.96 325.02" style="fill: rgb(69, 90, 100); transform-origin: 270.89px 329.71px;" id="el654i4auhgll" class="animable"></polygon>
                <polygon points="266.84 329.71 265.48 328.93 265.47 333.62 266.82 334.4 266.84 329.71" style="fill: rgb(38, 50, 56); transform-origin: 266.155px 331.665px;" id="el2yohc7m5acy" class="animable"></polygon>
                <polygon points="294.12 317.09 294.14 312.4 302.26 307.71 303.62 308.49 303.6 313.18 295.48 317.87 294.12 317.09" style="fill: rgb(55, 71, 79); transform-origin: 298.87px 312.79px;" id="elo0b0wa0yndb" class="animable"></polygon>
                <polygon points="303.62 308.49 303.6 313.18 295.48 317.87 295.49 313.18 303.62 308.49" style="fill: rgb(69, 90, 100); transform-origin: 299.55px 313.18px;" id="el2ds9j4w7fxj" class="animable"></polygon>
                <polygon points="295.49 313.18 294.14 312.4 294.12 317.09 295.48 317.87 295.49 313.18" style="fill: rgb(38, 50, 56); transform-origin: 294.805px 315.135px;" id="elwqipjg2f0f" class="animable"></polygon>
              </g>
            </g>
            <g id="freepik--Tools--inject-103" class="animable" style="transform-origin: 259.22px 399.628px;">
              <g id="freepik--Wrench--inject-103" class="animable" style="transform-origin: 268.46px 379.485px;">
                <path d="M247.39,386.76c-.55.31-1.58.3-1.91.67v1.35l6.28-.91,2.37,1.39-.9,1.89-6.34-.43v1.35a4.38,4.38,0,0,0,.42.28,10.72,10.72,0,0,0,9.68,0,3.41,3.41,0,0,0,2-2.81h0v-1.35l-.37.06a.25.25,0,0,1,0-.07l23.76-13.72a10.7,10.7,0,0,0,7.15-.9,4,4,0,0,0,1.91-2v-1.36l-6.28,2.27-2.37-1.39.9-1.89,6.34-.92v-1.36s-7.41-.49-10.11,1a4.36,4.36,0,0,0-1.67,1.55l-.36-.13v1.34h0a2.56,2.56,0,0,0,.41,1.41l-23.76,13.72A10.7,10.7,0,0,0,247.39,386.76Z" style="fill: rgb(55, 71, 79); transform-origin: 268.46px 380.169px;" id="elzymdshfzasl" class="animable"></path>
                <polygon points="282.38 374.5 282.38 373.15 258.62 386.87 258.62 388.22 282.38 374.5" style="fill: rgb(55, 71, 79); transform-origin: 270.5px 380.685px;" id="eluyu0cc6t2n" class="animable"></polygon>
                <path d="M278.3,370.79l-23.76,13.72a10.75,10.75,0,0,0-7.15.89,4,4,0,0,0-1.91,2l6.28-.91,2.37,1.39-.9,1.88-6.34.93a4.38,4.38,0,0,0,.42.28,10.72,10.72,0,0,0,9.68,0c2-1.12,2.52-2.76,1.63-4.17l23.76-13.72a10.76,10.76,0,0,0,7.15-.9,4,4,0,0,0,1.91-2l-6.28.92-2.37-1.39.9-1.89,6.34-.93-.42-.27a10.72,10.72,0,0,0-9.68,0C278,367.74,277.41,369.38,278.3,370.79Z" style="fill: rgb(69, 90, 100); transform-origin: 268.46px 378.795px;" id="el0idrw8n4xefd" class="animable"></path>
                <polygon points="283.29 370.04 282.79 369.75 283.69 367.86 290.03 366.93 290.03 368.29 283.69 369.21 283.29 370.04" style="fill: rgb(38, 50, 56); transform-origin: 286.41px 368.485px;" id="el159ga6zpmgi" class="animable"></polygon>
                <polygon points="253.63 388.96 254.13 387.91 251.76 386.51 245.48 387.43 245.48 388.79 251.76 387.87 253.63 388.96" style="fill: rgb(38, 50, 56); transform-origin: 249.805px 387.735px;" id="elziv4cftzbfj" class="animable"></polygon>
              </g>
              <g id="freepik--Screwdriver--inject-103" class="animable" style="transform-origin: 255.913px 415.28px;">
                <path d="M261.93,406.72l5,8.6,16.76-9.67a2.4,2.4,0,0,0,1.12-2.32,7.76,7.76,0,0,0-3.52-6.09,2.45,2.45,0,0,0-2.48-.24h0Z" style="fill: #064FF9; transform-origin: 273.378px 406.045px;" id="elgceseaqbluf" class="animable"></path>
                <path d="M260.93,408.5h0c-.07,1.31-1.92,1.59-1.92,1.59l3.51,6.09s1.17-1.44,2.34-.87h0c1.73.75,3.08-.18,3.08-2.25a7.76,7.76,0,0,0-3.52-6.08C262.62,405.93,261.14,406.63,260.93,408.5Z" style="fill: #064FF9; transform-origin: 263.475px 411.335px;" id="elnheme1yxhna" class="animable"></path>
                <g id="elcj4gj2n9a7h">
                  <path d="M260.93,408.5h0c-.07,1.31-1.92,1.59-1.92,1.59l3.51,6.09s1.17-1.44,2.34-.87h0c1.73.75,3.08-.18,3.08-2.25a7.76,7.76,0,0,0-3.52-6.08C262.62,405.93,261.14,406.63,260.93,408.5Z" style="opacity: 0.05; transform-origin: 263.475px 411.335px;" class="animable" id="elep4nyu1sv7h"></path>
                </g>
                <g id="elwso18e97dp">
                  <path d="M259.84,409.83a3.54,3.54,0,0,1-.84.26l3.51,6.09a3.92,3.92,0,0,1,.65-.59A7.88,7.88,0,0,0,259.84,409.83Z" style="opacity: 0.05; transform-origin: 261.08px 413.005px;" class="animable" id="eli1bw2icsm6l"></path>
                </g>
                <path d="M255.34,410.52l.29.51a4,4,0,0,0-.15,1.09,7.78,7.78,0,0,0,3.52,6.09,3.57,3.57,0,0,0,1,.41l.29.51,1.17-.67h0a2.47,2.47,0,0,0,1-2.28,7.77,7.77,0,0,0-3.51-6.09,2.47,2.47,0,0,0-2.49-.24h0Z" style="fill: #064FF9; transform-origin: 258.908px 414.375px;" id="elfnepxb6ihth" class="animable"></path>
                <path d="M261.34,416.86a7.77,7.77,0,0,0-3.51-6.09c-1.94-1.12-3.52-.21-3.52,2a7.8,7.8,0,0,0,3.52,6.09C259.77,420,261.34,419.1,261.34,416.86Z" style="fill: #064FF9; transform-origin: 257.825px 414.822px;" id="elgzsivfmwud" class="animable"></path>
                <g id="elgb4lhzl5hb8">
                  <path d="M261.34,416.86a7.77,7.77,0,0,0-3.51-6.09c-1.94-1.12-3.52-.21-3.52,2a7.8,7.8,0,0,0,3.52,6.09C259.77,420,261.34,419.1,261.34,416.86Z" style="opacity: 0.15; transform-origin: 257.825px 414.822px;" class="animable" id="elxsq7y1gpoy"></path>
                </g>
                <g id="elfwhvxhsbix7">
                  <path d="M256.46,417.77a5.29,5.29,0,0,0,.87.78l.82-2.34-1-.73Z" style="opacity: 0.15; transform-origin: 257.305px 417.015px;" class="animable" id="elmk604olr1xn"></path>
                </g>
                <g id="elkpel3dl40zs">
                  <path d="M281.91,400.92h0a1,1,0,0,1-.36,1.32l-12,6.91a1,1,0,0,1-1.33-.35h0a1,1,0,0,1,.36-1.32l12-6.91A1,1,0,0,1,281.91,400.92Z" style="opacity: 0.2; transform-origin: 275.065px 404.86px;" class="animable" id="elgz8n3js2a88"></path>
                </g>
                <g id="eld80ocuxv8m">
                  <path d="M279.75,398.35h0a.56.56,0,0,1,0,1l-12.2,7a1.33,1.33,0,0,1-1.41-.16h0a.56.56,0,0,1,0-1l12.19-7A1.33,1.33,0,0,1,279.75,398.35Z" style="opacity: 0.2; transform-origin: 272.945px 402.268px;" class="animable" id="eldln49n9j41e"></path>
                </g>
                <g id="el50nd1nqxky">
                  <path d="M283.06,404.08h0a.57.57,0,0,0-.88-.46l-12.2,7a1.34,1.34,0,0,0-.57,1.3h0a.57.57,0,0,0,.88.46l12.2-7A1.35,1.35,0,0,0,283.06,404.08Z" style="opacity: 0.2; transform-origin: 276.235px 408px;" class="animable" id="elqoofzbqop3"></path>
                </g>
                <path d="M227,431.05v2.34l5.86-1.9a9.05,9.05,0,0,1,2.34-2.83l22.26-12.85.68-1.95-.68-.39-22.26,12.85a2.34,2.34,0,0,1-2.34-.13Z" style="fill: rgb(69, 90, 100); transform-origin: 242.57px 423.43px;" id="elmrjfbe1xkjb" class="animable"></path>
                <path d="M227.69,431.45v2.34l5.86-1.9a8.94,8.94,0,0,1,2.34-2.83l22.26-12.85v-2.35l-22.26,12.85a2.33,2.33,0,0,1-2.34-.12Z" style="fill: rgb(55, 71, 79); transform-origin: 242.92px 423.825px;" id="elyogshumziws" class="animable"></path>
                <polygon points="227.69 433.79 227.01 433.39 227.01 431.05 227.69 431.45 227.69 433.79" style="fill: rgb(38, 50, 56); transform-origin: 227.35px 432.42px;" id="elejoyuefzsi" class="animable"></polygon>
                <polygon points="227.01 431.05 227.69 431.45 233.55 426.59 232.87 426.19 227.01 431.05" style="fill: rgb(69, 90, 100); transform-origin: 230.28px 428.82px;" id="el00uzrsy70akrp" class="animable"></polygon>
              </g>
            </g>
            <g id="freepik--Character--inject-103" class="animable" style="transform-origin: 174.394px 233.553px;">
              <g id="freepik--character--inject-103" class="animable" style="transform-origin: 174.394px 233.553px;">
                <g id="freepik--Top--inject-103" class="animable" style="transform-origin: 213.37px 121.009px;">
                  <path d="M310.43,129.94H258.89a.75.75,0,0,1,0-1.5h51.54a.75.75,0,0,1,0,1.5Z" style="fill: rgb(55, 71, 79); transform-origin: 284.66px 129.19px;" id="el8znld5rld28" class="animable"></path>
                  <g id="freepik--Arm--inject-103" class="animable" style="transform-origin: 222.781px 144.615px;">
                    <path d="M192,163.27c-4.95-9.45-12.94-29.87-12.94-29.87l.17-27.41c-.2,0,3.7,1.18,4.89,1.46,7.72,2.85,9.85,4.21,13.16,11,2.63,5.41,11.49,30.08,14.64,38.43l18.85-13.41c4.75-4,5.86-9.7,8.76-13.25s6.19-4.53,9.47-7.54,4.52-5.25,5.78-2.84-2.32,6.84-2.94,7.91c-.43.76-1.52,1.32-1.77,2.17-.41,1.46,1.76,1.23,2.69,1,4.6-1,8.78-4.88,11.62-8.43,1.11-1.39,5.16-6.79,6.19-2.43.84,3.55-2.08,5.82-2.29,9.09a13.11,13.11,0,0,1-1.4,5.2c-.69,1.48-.37,3.2-.86,4.75-1.51,4.82-5.34,6.47-9.79,8s-9.26,2.58-12.95,5.42c-4.48,3.46-15.31,15.12-21.9,22.13-8.37,8.91-13.89,11-18.79,5.75S193.87,166.77,192,163.27Z" style="fill: rgb(255, 168, 167); transform-origin: 224.891px 144.615px;" id="elrilvlh7z03" class="animable"></path>
                    <path d="M270.6,120.11c-1-4.36-5.08,1-6.19,2.43-2.84,3.55-7,7.43-11.62,8.43-.93.2-3.1.43-2.69-1,.25-.85,1.34-1.41,1.77-2.17.62-1.07,4.2-5.51,2.94-7.91s-2.49-.18-5.78,2.84-6.57,4-9.47,7.54-4,9.26-8.76,13.25l-1.29.92c.78,5.27,4,10.43,8.67,12.8,2.06-2,3.86-3.67,5.13-4.66,3.69-2.84,8.62-4,12.95-5.42s8.28-3.16,9.79-8c.49-1.55.17-3.27.86-4.75a13.11,13.11,0,0,0,1.4-5.2C268.52,125.93,271.44,123.66,270.6,120.11Z" style="fill: rgb(69, 90, 100); transform-origin: 250.131px 137.837px;" id="el0iltead9wepm" class="animable"></path>
                    <path d="M231.77,142.6c-.09,1.74.88,6.38,3.09,8.85a16,16,0,0,0,5.33,3.72l.8-.62s.76.08-1.28,2.13-2.52,2.81-3.66,2.64-4.36-2-6.54-5.39a16.58,16.58,0,0,1-2.73-8c.06-1,1.46-1.72,2.73-2.64s2.59-2.45,3.3-1.84Z" style="fill: #064FF9; transform-origin: 233.954px 150.327px;" id="elgc91lr72pb9" class="animable"></path>
                    <g id="elkz3uxsmxs">
                      <path d="M231.77,142.6c-.09,1.74.88,6.38,3.09,8.85a16,16,0,0,0,5.33,3.72l.8-.62s.76.08-1.28,2.13-2.52,2.81-3.66,2.64-4.36-2-6.54-5.39a16.58,16.58,0,0,1-2.73-8c.06-1,1.46-1.72,2.73-2.64s2.59-2.45,3.3-1.84Z" style="opacity: 0.2; transform-origin: 233.954px 150.327px;" class="animable" id="elnhl7bez9ch8"></path>
                    </g>
                    <path d="M181.66,106.44c5.05,1.17,9,3.08,11.4,5.12,3.7,3.2,5.39,8.19,7.91,15s9,23.4,9,23.4a32.75,32.75,0,0,0-18,14.11l-17.16-35.71Z" style="fill: rgb(224, 224, 224); transform-origin: 192.39px 135.255px;" id="elb8xuul40x8d" class="animable"></path>
                    <path d="M212,156.9a17.29,17.29,0,0,0-7.69,7.72s0-5.51,7-9.63Z" style="fill: rgb(242, 143, 143); transform-origin: 208.155px 159.805px;" id="el790cb29b3yu" class="animable"></path>
                  </g>
                  <g id="freepik--Chest--inject-103" class="animable" style="transform-origin: 152.924px 153.631px;">
                    <path d="M123.62,109.32s-5.87,5.16-7.37,10.74c-.73,2.74-1.41,5,.91,20.24,2.21,14.53,3.78,14.53,4.91,25.61l-1.62,27.73c8.69,10.18,49.27,15.36,69.57,1.65,0,0,.88-42.1-.55-59.44-1-11.79-5.95-23.88-7.81-29.41-5.52-1-10.83-1.6-10.83-1.6l-20.3-1.18Z" style="fill: rgb(250, 250, 250); transform-origin: 152.924px 153.631px;" id="elzp2bx0bwkg" class="animable"></path>
                  </g>
                  <g id="freepik--Head--inject-103" class="animable" style="transform-origin: 156.447px 78.7048px;">
                    <path d="M180.39,67.76c2.66-6.12.05-14.24-3.14-18.05-4.61-5.51-11.78-7.89-22.6-7.22-8.22.51-16.31,3.93-17.85,12.37-6.6,2-5.85,12.82-4.21,17.61,3.34,9.72,9.9,18.17,10,23.14Z" style="fill: rgb(55, 71, 79); transform-origin: 156.475px 68.9949px;" id="elu46b6su655" class="animable"></path>
                    <path d="M180.38,90.61c-1.3,4.69-4,8.13-8.35,8.81a36.51,36.51,0,0,1-6.85,0l.17,6c9,11.39-12.06,13.7-22.46,1.22l-.62-20.17s-2.65,3-7,.16a9.55,9.55,0,0,1-3-11.69c2.17-4.57,6.51-2.68,7.85-1.29s2.89,4,4,3.64a4.05,4.05,0,0,0,2.69-2.75,24.63,24.63,0,0,0,1.41-8.87,11.72,11.72,0,0,0,3.4-2.62,11,11,0,0,0,3-6.79c9.37-2.93,20.15-1.55,24,1.47,2.24,3.95,2.33,13.13,2.7,18.42C181.73,81.9,181.47,86.69,180.38,90.61Z" style="fill: rgb(255, 168, 167); transform-origin: 156.447px 84.835px;" id="elrgva8mmp84q" class="animable"></path>
                    <path d="M165.18,99.45c-4.8-.27-14.45-2.51-17-5.18s-3.66-8.16-3.66-8.16.38,6.92,2.37,10,7,4.39,10,5.15a76.62,76.62,0,0,0,8.35,1.26Z" style="fill: rgb(242, 143, 143); transform-origin: 154.88px 94.315px;" id="elacxnlo8jmbl" class="animable"></path>
                    <path d="M162.14,73.09a2,2,0,0,1-1.93,2,2,2,0,1,1,1.93-2Z" style="fill: rgb(38, 50, 56); transform-origin: 160.14px 73.0912px;" id="eltjju3bfo3yo" class="animable"></path>
                    <path d="M159.43,66.89l-3.93,2.65a2.49,2.49,0,0,1,.67-3.38A2.31,2.31,0,0,1,159.43,66.89Z" style="fill: rgb(38, 50, 56); transform-origin: 157.269px 67.656px;" id="el3ufk91g7prk" class="animable"></path>
                    <path d="M178.5,68.13l-4.31-2.06a2.29,2.29,0,0,1,3.11-1.18A2.52,2.52,0,0,1,178.5,68.13Z" style="fill: rgb(38, 50, 56); transform-origin: 176.445px 66.3959px;" id="elvahkfrqlpn" class="animable"></path>
                    <path d="M177,72.4a1.94,1.94,0,1,1-1.94-2A2,2,0,0,1,177,72.4Z" style="fill: rgb(38, 50, 56); transform-origin: 175.06px 72.34px;" id="el1gpytr66i6o" class="animable"></path>
                    <polygon points="166.6 68.92 168 82.86 175.49 80.6 166.6 68.92" style="fill: rgb(242, 143, 143); transform-origin: 171.045px 75.89px;" id="el67addpuozbu" class="animable"></polygon>
                    <path d="M162.13,86.11l8,1.78a4,4,0,0,1-4.82,3.26A4.32,4.32,0,0,1,162.13,86.11Z" style="fill: rgb(177, 102, 104); transform-origin: 166.088px 88.6781px;" id="elcvdz1no07nw" class="animable"></path>
                    <path d="M165.34,91.15a4.53,4.53,0,0,0,.5.06,3.72,3.72,0,0,0-3.73-3.64A4.25,4.25,0,0,0,165.34,91.15Z" style="fill: rgb(242, 143, 143); transform-origin: 163.975px 89.39px;" id="elhkz31mkid9" class="animable"></path>
                  </g>
                  <g id="freepik--Helmet--inject-103" class="animable" style="transform-origin: 160.175px 56.2081px;">
                    <path d="M131,66.89A25.5,25.5,0,0,0,132.78,74c.53-.67,1.14-1.33,1.76-2A43,43,0,0,1,147,63.49h0c10.69-5,23.78-6.68,34.26-3.77a24.1,24.1,0,0,0-1.95-6A25.38,25.38,0,0,0,131,66.89Z" style="fill: #064FF9; transform-origin: 156.065px 56.47px;" id="elcbaza2o9tif" class="animable"></path>
                    <path d="M142,41.63c1.27-.62,7.66-2.53,8.18-2.69,3.31-1,8.64-.94,14.11,3.56a25.77,25.77,0,0,1,8.56,13.83l-6.8,2.13-2.17.21c-.8-5-7.39-15.77-16.65-16.17a9.43,9.43,0,0,0-1.3,0,12.21,12.21,0,0,0-3.59.73,35,35,0,0,0-3.59,2.88A5.67,5.67,0,0,1,142,41.63Z" style="fill: #064FF9; transform-origin: 155.8px 48.5431px;" id="elyldtdv759d8" class="animable"></path>
                    <g id="el268lwfo7yq8">
                      <path d="M142,41.63c1.27-.62,7.66-2.53,8.18-2.69,3.31-1,8.64-.94,14.11,3.56a25.77,25.77,0,0,1,8.56,13.83l-6.8,2.13-2.17.21c-.8-5-7.39-15.77-16.65-16.17a9.43,9.43,0,0,0-1.3,0,12.21,12.21,0,0,0-3.59.73,35,35,0,0,0-3.59,2.88A5.67,5.67,0,0,1,142,41.63Z" style="fill: rgb(255, 255, 255); opacity: 0.45; transform-origin: 155.8px 48.5431px;" class="animable" id="elffdehvt61nh"></path>
                    </g>
                    <path d="M163.9,58.68c-1-5.82-9.82-19.59-21.54-15.44a35.08,35.08,0,0,0-3.6,2.88A5.7,5.7,0,0,1,142,41.63c3.05-1.47,9.17-2.19,15.5,3a25.74,25.74,0,0,1,8.55,13.82Z" style="fill: #064FF9; transform-origin: 152.405px 49.6179px;" id="el7228btps1k7" class="animable"></path>
                    <g id="elrak3fkrfj2">
                      <path d="M163.9,58.68c-1-5.82-9.82-19.59-21.54-15.44a35.08,35.08,0,0,0-3.6,2.88A5.7,5.7,0,0,1,142,41.63c3.05-1.47,9.17-2.19,15.5,3a25.74,25.74,0,0,1,8.55,13.82Z" style="opacity: 0.3; transform-origin: 152.405px 49.6179px;" class="animable" id="elh57yqzxqzf"></path>
                    </g>
                    <path d="M146.81,61.49c.49-.43,2.86-5.53,11.3-10,5.21-2.78,15.89-2.92,20.68-2.84,8.39.14,10.39,1.92,10.5,3.16,0,.29.14,1.65.18,1.95a1.17,1.17,0,0,1-.18.8c-1.25,1.9-8,5.2-8,5.2-10.48-2.91-23.57-1.23-34.26,3.77Z" style="fill: #064FF9; transform-origin: 168.145px 56.0824px;" id="el7yxszesp47n" class="animable"></path>
                    <g id="eljd1ul87e82s">
                      <path d="M146.81,61.49c.49-.43,2.86-5.53,11.3-10,5.21-2.78,15.89-2.92,20.68-2.84,8.39.14,10.39,1.92,10.5,3.16,0,.29.14,1.65.18,1.95a1.17,1.17,0,0,1-.18.8c-1.25,1.9-8,5.2-8,5.2-10.48-2.91-23.57-1.23-34.26,3.77Z" style="opacity: 0.15; transform-origin: 168.145px 56.0824px;" class="animable" id="elot5egyikyok"></path>
                    </g>
                    <path d="M147,63.49c10.69-5,23.78-6.68,34.26-3.77,0,0,6.78-3.3,8-5.2.68-1.05.07-3.74-10.3-3.91-4.8-.08-15.48.06-20.69,2.84C149.86,58,147.49,63.06,147,63.49Z" style="fill: #064FF9; transform-origin: 168.227px 57.0424px;" id="elvuiqd6z6qof" class="animable"></path>
                    <g id="ele1cbh9961yk">
                      <path d="M147,63.49c10.69-5,23.78-6.68,34.26-3.77,0,0,6.78-3.3,8-5.2.68-1.05.07-3.74-10.3-3.91-4.8-.08-15.48.06-20.69,2.84C149.86,58,147.49,63.06,147,63.49Z" style="opacity: 0.3; transform-origin: 168.227px 57.0424px;" class="animable" id="elgs38rj3fc4o"></path>
                    </g>
                  </g>
                </g>
                <g id="freepik--Bottom--inject-103" class="animable" style="transform-origin: 158.801px 266.515px;">
                  <path d="M179.29,369.94c.32-5.31,3.17-58.8,3.17-58.8l-26,18.33c4.53,30.58,5.53,39.8,5.72,44.9h0a4.28,4.28,0,0,0-.12,1.31c.14,6.06,7.4,9.22,13.09,13.18a105.67,105.67,0,0,0,15.36,9.2c4.11,1.89,12.39,1.95,13.37-.56-6.92-4.86-14.93-10.16-20.47-15.74C180.8,379.09,178.9,376.3,179.29,369.94Z" style="fill: rgb(255, 168, 167); transform-origin: 180.17px 355.288px;" id="el7832ihxlrpe" class="animable"></path>
                  <path d="M215.68,403.86c.35,0,.95,3.65-.93,5.24-2.16,1.83-8.55,4.88-17.08,3.95s-13.19-3.36-16.65-6-8.31-6.42-12.18-7.17c-3.59-.7-7.5-2.19-8.67-3.22s-1.09-5.72-1.09-5.72Z" style="fill: rgb(38, 50, 56); transform-origin: 187.567px 402.081px;" id="el1uaxshkgh2s" class="animable"></path>
                  <path d="M189.08,383.77c-.56-.52-1.1-1-1.63-1.58a20,20,0,0,1-4.07-6.71,19.07,19.07,0,0,1-1.28-3.7c-.27-1.47-.44-3-.69-4.43-.09-.55,0-1.76-.68-2a4,4,0,0,0-2.3.43c-1.73.74-3.54,1.31-5.32,1.94-1,.35-3.05.89-3.35,2s.2,2.49,0,3.69c-.09.47-.29,1-.84.94-1,0-1.25-1.44-1.51-2.14-.56-1.47-1-2.16-2.59-2.59-.83-.23-2.45-.34-3-1.08l-.21-2a3,3,0,0,0-2.11,1.64c-.69,1.43-.23,3.42,0,4.94a22.61,22.61,0,0,1,.38,4.58,28.79,28.79,0,0,1-.63,3.9,36.08,36.08,0,0,0-.63,6.8,16.7,16.7,0,0,0,.24,3.16,3.47,3.47,0,0,0,1.34,2.16,11.62,11.62,0,0,0,3.65,2.18c1.83.73,3.72,1.29,5.58,1.94,3.83,1.32,8.29,4.1,12.21,7.07S194.15,411,199.7,411c8.48,0,14.4-2.8,16-5.72.15-2,.27-4-.64-5.42-3-4.58-9.57-6.06-14.86-8.58a59.91,59.91,0,0,1-6.66-3.92A34.24,34.24,0,0,1,189.08,383.77Z" style="fill: rgb(55, 71, 79); transform-origin: 187.21px 388.162px;" id="el9kr61749nls" class="animable"></path>
                  <path d="M203.48,392.66c-10.39,2.94-14,9.95-15.53,15.62A34.44,34.44,0,0,0,199.7,411c8.48,0,14.4-2.8,16-5.72.15-2,.27-4-.64-5.42C212.71,396.16,208,394.48,203.48,392.66Z" style="fill: rgb(69, 90, 100); transform-origin: 201.877px 401.83px;" id="elf5n0eiwtik" class="animable"></path>
                  <path d="M169.4,397.8l.44.17c-.41-8-3.71-13.3-10.94-14.37a35.9,35.9,0,0,0-.31,4.76,16.7,16.7,0,0,0,.24,3.16,3.47,3.47,0,0,0,1.34,2.16,11.62,11.62,0,0,0,3.65,2.18C165.65,396.59,167.54,397.15,169.4,397.8Z" style="fill: rgb(69, 90, 100); transform-origin: 164.213px 390.785px;" id="el43zkrauoova" class="animable"></path>
                  <path d="M136.45,326.89,109.35,321c-.71,16.77-.28,39.46-.85,55.2-.11,3-1.64,23-.79,29.14,1.28,9.25,13.67,8.65,14.69,3.21s1.92-28.7,2.13-31.11c.57-10.08,6.33-27,10.36-45C135.09,331.61,136.26,327.75,136.45,326.89Z" style="fill: rgb(255, 168, 167); transform-origin: 121.952px 366.749px;" id="elevobfpn2wca" class="animable"></path>
                  <path d="M126.78,412.63c-.1,5.39-.89,9-2.91,12.22s-6.05,4.38-10.22,3.61-9.58-3-11-7.64-1.3-7.78-.59-12.8Z" style="fill: rgb(38, 50, 56); transform-origin: 114.163px 418.355px;" id="elz15hrudk4tl" class="animable"></path>
                  <path d="M108.72,366.93c-1.69.18-2,14.81-2.68,22.07-.7,7.78-3.17,11.08-3.82,17.47-.74,7.3-.16,10.52,2.92,14.8s13.49,8.21,18.23,1.74c3.86-5.28,3.77-11,3.07-18.2-.73-7.47-.76-19.45-.67-25.15.08-5.44,1.73-11.19.22-11.74-.32,1.46-.52,2.71-.69,3.49-.37,1.72-.78,3.8-1.3,3.41,0,0,.15-1.53.17-2.23s.17-1.16-.3-1.61-2.51-.73-3.21-.82c-1.69-.24-3.38-.43-5.09-.51-.85,0-1.71,0-2.56,0a8.05,8.05,0,0,0-2.14.35,1.45,1.45,0,0,0-.89.78,2.1,2.1,0,0,0,0,.83,5.35,5.35,0,0,1-.14,1.49c-.06.22-.21.49-.46.45s-.4-.18-.47-.67a23.05,23.05,0,0,1-.16-3c0-.47,0-1.12,0-1.59S108.71,367.39,108.72,366.93Z" style="fill: rgb(55, 71, 79); transform-origin: 114.373px 396.681px;" id="el51us5ux0pei" class="animable"></path>
                  <path d="M101.94,410.69c-.09,4.52.35,7.59,2.76,10.94,3.08,4.28,14.31,8.19,19,1.72,2.36-3.22,2.86-6.94,3-10.72C123.54,407.9,106.51,406.39,101.94,410.69Z" style="fill: rgb(69, 90, 100); transform-origin: 114.315px 417.465px;" id="el06rtve2d5irn" class="animable"></path>
                  <path d="M191.12,147.78s-20.57,4.63-51.41,2.51c0,20.38,2.15,43.76-7.61,43.63l-11.65-.28c-.65,30.52-5.81,94.15-5.81,94.15-.46,3.75-5.89,19.69-6.09,33.25-.31,21.27-.76,37.39-.76,37.39s11.88,4.7,20.61,1.44c0,0,11.35-45.21,14.54-59.32,3.79-16.81,11.62-47.87,11.62-47.87l.95,44.23a121.71,121.71,0,0,0-.36,26.86c1,9,4.65,33.91,4.65,33.91s10.93,2.2,20.41-.61c0,0,5.71-53.57,6.18-61.82.51-9,3.35-91.67,3.61-99.38h0C192.6,157,191.12,147.78,191.12,147.78Z" style="fill: rgb(69, 90, 100); transform-origin: 149.665px 254.401px;" id="elrd4t682faf" class="animable"></path>
                  <path d="M139.71,150.29c-1.44-18.46-1.4-33.63-8.32-42.6l8.84-1.86s7.65,16.94,7.65,45.09Z" style="fill: rgb(69, 90, 100); transform-origin: 139.635px 128.375px;" id="el9cqd41gqhqw" class="animable"></path>
                  <path d="M183,149.81c0-20.11-4.43-37.35-11.45-44.88l10.11,1.51s9.46,15.22,9.46,43.37Z" style="fill: rgb(69, 90, 100); transform-origin: 181.335px 127.37px;" id="elzj06ge53xn" class="animable"></path>
                  <path d="M150.82,154.51s16.25,1,29.9-1.59l.62,13.83-13.62,8.54-16.9-5.52Z" style="fill: rgb(55, 71, 79); transform-origin: 166.08px 164.105px;" id="elxrdvmhhwxmi" class="animable"></path>
                  <path d="M124.65,194.65c7.83,3.25,26.84,5.2,42.1,5S190,195.86,190,195.86l-.25,9.3s-27.08,11.36-66.26-2Z" style="fill: #064FF9; transform-origin: 156.745px 202.157px;" id="elk2dd7n1z8jc" class="animable"></path>
                  <g id="el8iuv6zc49y4">
                    <path d="M124.65,194.65c7.83,3.25,26.84,5.2,42.1,5S190,195.86,190,195.86l-.25,9.3s-27.08,11.36-66.26-2Z" style="opacity: 0.3; transform-origin: 156.745px 202.157px;" class="animable" id="elcoyho6fufo5"></path>
                  </g>
                  <path d="M154.56,252.68l7.26-29.34s10.88.14,18-6.51c0,0-1,7.49-13.93,11.49l-6.72,23.31-3.81,44.45Z" style="fill: rgb(55, 71, 79); transform-origin: 167.19px 256.455px;" id="elbo97vjid9j7" class="animable"></path>
                  <path d="M143,104.58l.06,2a73.48,73.48,0,0,1,3.39,13.67c2.1,12.67,2.46,29.28,2.46,48v51.58s-23.45,1.5-30.9-16.4l3-37.52s-4.3-19.4-5.47-30.49-3.26-18.86,7.11-27.34Z" style="fill: #064FF9; transform-origin: 131.726px 162.22px;" id="elho6zyh4obg" class="animable"></path>
                  <path d="M118.85,155.42c1.17,5.94,2.18,10.49,2.18,10.49l-.11,1.47c7.25,4.74,18,7.78,28,7.32V164.22C138,164.72,126,161,118.85,155.42Z" style="fill: rgb(240, 240, 240); transform-origin: 133.885px 165.083px;" id="elefco0a3wi55" class="animable"></path>
                  <path d="M148.9,195.52V185c-10.28.47-21.49-2.8-28.74-7.83l-.76,9.93C126.6,192.47,138.25,196,148.9,195.52Z" style="fill: rgb(240, 240, 240); transform-origin: 134.15px 186.367px;" id="el5kbxh6tp2qo" class="animable"></path>
                  <path d="M165.72,104.34a29.18,29.18,0,0,1,13.21,17.74c3.16,12.42,3.63,22.22,4.07,38.17s-.21,60.45-.21,60.45,7-3.07,8.54-6.4c0,0,2-56.51-.21-76.54s-9.46-31.32-9.46-31.32S176.48,104.32,165.72,104.34Z" style="fill: #064FF9; transform-origin: 178.94px 162.52px;" id="elzcr15tni83k" class="animable"></path>
                  <path d="M183.17,172.69a50.15,50.15,0,0,0,9-1.08c0-3.5,0-7,0-10.47A50.21,50.21,0,0,1,183,162.2C183.11,165.22,183.15,168.81,183.17,172.69Z" style="fill: rgb(240, 240, 240); transform-origin: 187.585px 166.915px;" id="elxpzprlp53mm" class="animable"></path>
                  <path d="M192,192.48c.06-3.22.13-6.78.17-10.52a50,50,0,0,1-8.94,1c0,3.55,0,7.1,0,10.49A51.38,51.38,0,0,0,192,192.48Z" style="fill: rgb(240, 240, 240); transform-origin: 187.7px 187.705px;" id="elaxtc4bwvnt" class="animable"></path>
                </g>
                <g id="freepik--hand-with-bulb--inject-103" class="animable" style="transform-origin: 147.939px 126.471px;">
                  <path d="M127.89,108.29c-6,0-13-.26-16.93,8.4-1.28,2.82-5.23,19.4-9.62,34.69-7.86-10-14.57-20.25-15.44-22.07-2.33-4.87-2.36-8.16-4.74-13.19A41.45,41.45,0,0,1,78,107.48c-.57-2-2.35-.53-3,.37A9.43,9.43,0,0,0,73.35,113c0,1.3,0,2.63-.1,3.91s-.53,1.23-1.57.65c-2.14-1.2-4-3.27-5.74-4.93s-4.12-3.22-6-5-2.83-3.59-4.36-5.39c-1.15-1.35-3.11-3.1-4.62-1.17-.9,1.17-.07,2.53.33,3.7.46,1.33,0,2.31-.25,3.62a6.74,6.74,0,0,0,.12,4.35c.72,1.41,1.36,2.28,1.17,3.94-.15,1.37-.64,2.68-.44,4.09.16,1.16,1,2,1.58,3a21.83,21.83,0,0,0,3.77,4.82,44.93,44.93,0,0,0,5.63,4.83c4.81,3.74,6.6,4.91,8.21,6.16,2.41,1.86,4.9,6.63,6.3,9.26C80.11,154,86,168.38,93.86,178.67c4.55,5.93,10.74,7.82,16.2,1.12,2.86-3.52,5.29-9.1,6.87-13.32C123,150.3,127.39,137,127.39,137S132.29,121.89,127.89,108.29Z" style="fill: rgb(255, 168, 167); transform-origin: 90.1402px 142.123px;" id="elxr39lhc0ta" class="animable"></path>
                  <path d="M88.81,134c-1.56-2.36-2.6-4.07-2.91-4.71-2.33-4.87-2.36-8.16-4.74-13.19A41.45,41.45,0,0,1,78,107.48c-.57-2-2.35-.53-3,.37A9.43,9.43,0,0,0,73.35,113c0,1.3,0,2.63-.1,3.91s-.53,1.23-1.57.65c-2.14-1.2-4-3.27-5.74-4.93s-4.12-3.22-6-5-2.83-3.59-4.36-5.39c-1.15-1.35-3.11-3.1-4.62-1.17-.9,1.17-.07,2.53.33,3.7.46,1.33,0,2.31-.25,3.62a6.74,6.74,0,0,0,.12,4.35c.72,1.41,1.36,2.28,1.17,3.94-.15,1.37-.64,2.68-.44,4.09.16,1.16,1,2,1.58,3a21.83,21.83,0,0,0,3.77,4.82,44.93,44.93,0,0,0,5.63,4.83c4.81,3.74,6.6,4.91,8.21,6.16,2.29,1.77,4.65,6.16,6.08,8.84C81.94,145.36,86.27,139.48,88.81,134Z" style="fill: rgb(69, 90, 100); transform-origin: 69.6833px 124.317px;" id="elbu971w0psdj" class="animable"></path>
                  <path d="M87.29,131.67l-.75-1.12s.3-1.31,1.52.56a30.25,30.25,0,0,1,2.83,4.95c.15.71-1.06,6.83-4.86,9.87s-7.14,3.95-8.2,3.82-1.36-1.09-2-2.36-2.12-2.83-1.67-4l.86,1.21a17.12,17.12,0,0,0,8.76-5.46C87.15,134.85,87.29,131.67,87.29,131.67Z" style="fill: #064FF9; transform-origin: 82.4892px 139.933px;" id="eleaxq8ytr0f4" class="animable"></path>
                  <g id="elktxibon8h3n">
                    <path d="M87.29,131.67l-.75-1.12s.3-1.31,1.52.56a30.25,30.25,0,0,1,2.83,4.95c.15.71-1.06,6.83-4.86,9.87s-7.14,3.95-8.2,3.82-1.36-1.09-2-2.36-2.12-2.83-1.67-4l.86,1.21a17.12,17.12,0,0,0,8.76-5.46C87.15,134.85,87.29,131.67,87.29,131.67Z" style="opacity: 0.2; transform-origin: 82.4892px 139.933px;" class="animable" id="elhhy29uzwz8o"></path>
                  </g>
                  <path d="M101.34,151.38a45.36,45.36,0,0,1,5.11,17.55c1-9.11-1.77-17.44-4.33-20.25Z" style="fill: rgb(242, 143, 143); transform-origin: 104px 158.805px;" id="elc4htyvcxo1v" class="animable"></path>
                  <path d="M128.88,107c-5.72.9-6.94,1-10.59,2.26s-6.27,2.51-9.64,13.5c-3.24,10.6-6.26,22.66-6.26,22.66s3.2,8.38,19,10l8.37-23.34S132.34,118,128.88,107Z" style="fill: rgb(235, 235, 235); transform-origin: 116.537px 131.21px;" id="elyh7r5v5ygbr" class="animable"></path>
                  <g id="freepik--Light--inject-103" class="animable" style="transform-origin: 154.629px 133.134px;">
                    <path d="M72.67,119.87a3.2,3.2,0,1,1-3.57-2.79A3.19,3.19,0,0,1,72.67,119.87Z" style="fill: rgb(38, 50, 56); transform-origin: 69.4933px 120.255px;" id="elq3x2q5zost" class="animable"></path>
                    <path d="M255.72,129.94h-3.54a3.44,3.44,0,0,0-3.44,3.44V170.8a17,17,0,0,1-17,17H85.71a17,17,0,0,1-17-17V122.08a.75.75,0,0,1,1.5,0v48.37a15.81,15.81,0,0,0,15.82,15.81H231.42a15.81,15.81,0,0,0,15.82-15.81V133.38a4.94,4.94,0,0,1,4.94-4.94h6.09A18.13,18.13,0,0,1,255.72,129.94Z" style="fill: rgb(55, 71, 79); transform-origin: 163.49px 154.565px;" id="elta0yf86zsm" class="animable"></path>
                    <path d="M65.7,120.93c-2.25-1-2.49-2.93-.53-4.4a8.47,8.47,0,0,1,7.63-.93c2.25,1,2.49,2.93.53,4.4A8.47,8.47,0,0,1,65.7,120.93Z" style="fill: rgb(55, 71, 79); transform-origin: 69.25px 118.265px;" id="elg7ku969j6ok" class="animable"></path>
                    <path d="M65.44,119.8c-2.32-1-2.57-3-.55-4.54a8.76,8.76,0,0,1,7.87-1c2.32,1,2.57,3,.55,4.54A8.76,8.76,0,0,1,65.44,119.8Z" style="fill: rgb(38, 50, 56); transform-origin: 69.1px 117.03px;" id="el1rs0ri9gzef" class="animable"></path>
                    <path d="M65.18,118.63c-2.4-1-2.65-3.12-.57-4.68a9,9,0,0,1,8.11-1c2.39,1,2.65,3.12.57,4.68A9,9,0,0,1,65.18,118.63Z" style="fill: rgb(55, 71, 79); transform-origin: 68.9483px 115.79px;" id="elt66d0efx2rj" class="animable"></path>
                    <path d="M64.91,117.42c-2.47-1-2.74-3.21-.59-4.82a9.3,9.3,0,0,1,8.35-1c2.47,1,2.74,3.21.59,4.83A9.3,9.3,0,0,1,64.91,117.42Z" style="fill: rgb(38, 50, 56); transform-origin: 68.79px 114.512px;" id="eloaht5sbryac" class="animable"></path>
                    <path d="M64.67,116.15c-2.52-1.07-2.79-3.27-.6-4.92a9.47,9.47,0,0,1,8.52-1c2.52,1.07,2.79,3.28.6,4.92A9.45,9.45,0,0,1,64.67,116.15Z" style="fill: rgb(55, 71, 79); transform-origin: 68.63px 113.191px;" id="elo916jkvz0x" class="animable"></path>
                    <path d="M64.41,78.58a15.27,15.27,0,0,0-13.31,17c1.47,12,11.64,12.82,12.23,17.67a2.65,2.65,0,0,0,1.79,2,8.27,8.27,0,0,0,7.4-.9A2.63,2.63,0,0,0,73.79,112h0c-.59-4.85,9.09-8.06,7.63-20.09A15.27,15.27,0,0,0,64.41,78.58Z" style="fill: #064FF9; transform-origin: 66.2793px 97.1046px;" id="el5pzbc25v7fe" class="animable"></path>
                    <g id="el8cg2iqudhjw">
                      <g style="opacity: 0.6; transform-origin: 66.2793px 97.1046px;" class="animable" id="eluueniexbo9">
                        <path d="M64.41,78.58a15.27,15.27,0,0,0-13.31,17c1.47,12,11.64,12.82,12.23,17.67a2.65,2.65,0,0,0,1.79,2,8.27,8.27,0,0,0,7.4-.9A2.63,2.63,0,0,0,73.79,112h0c-.59-4.85,9.09-8.06,7.63-20.09A15.27,15.27,0,0,0,64.41,78.58Z" style="fill: rgb(255, 255, 255); transform-origin: 66.2793px 97.1046px;" id="eltvdzvrco0zh" class="animable"></path>
                      </g>
                    </g>
                    <path d="M66,114.43c-1.64-.7-1.82-2.14-.39-3.21a6.2,6.2,0,0,1,5.56-.68c1.64.7,1.82,2.14.39,3.21A6.17,6.17,0,0,1,66,114.43Z" style="fill: #064FF9; transform-origin: 68.585px 112.487px;" id="eltf80y0e0l6n" class="animable"></path>
                    <path d="M70.52,111.86a.51.51,0,0,1-.57-.44,36.52,36.52,0,0,1,0-8.79,19.34,19.34,0,0,1,.46-2.5A7.43,7.43,0,0,1,69,99.65a8.82,8.82,0,0,1-2.21-1.45A9.07,9.07,0,0,1,65,100.14a7,7,0,0,1-1.24.8,18.81,18.81,0,0,1,1.05,2.32,36.93,36.93,0,0,1,2.12,8.53.53.53,0,0,1-.46.57.53.53,0,0,1-.57-.47,36.27,36.27,0,0,0-2.06-8.27,17,17,0,0,0-1.05-2.3,3.26,3.26,0,0,1-3-.49,1.66,1.66,0,0,1-.48-2.1A1.37,1.37,0,0,1,60.66,98c.83.07,1.73.8,2.57,2.08a5.53,5.53,0,0,0,1.12-.72,7.79,7.79,0,0,0,1.72-1.88,3.87,3.87,0,0,1-1.1-2.8,1.45,1.45,0,0,1,2.76-.34,3.78,3.78,0,0,1-.39,3,7.68,7.68,0,0,0,2.12,1.42,6.07,6.07,0,0,0,1.26.43c.51-1.44,1.2-2.37,2-2.63a1.39,1.39,0,0,1,1.47.41,1.66,1.66,0,0,1,0,2.15,3.24,3.24,0,0,1-2.76,1.19,16.13,16.13,0,0,0-.48,2.5,37.27,37.27,0,0,0,0,8.51.52.52,0,0,1-.44.59ZM60.51,99c-.08,0-.18.06-.27.23-.21.37.13.7.24.8a2.12,2.12,0,0,0,1.72.34c-.67-.94-1.26-1.35-1.61-1.37Zm11.29.2a2,2,0,0,0,1.58-.75c.08-.11.34-.52.05-.83a.36.36,0,0,0-.4-.14C72.7,97.6,72.23,98.14,71.8,99.21Zm-5.45-4.72c-.26,0-.33.15-.36.32a2.54,2.54,0,0,0,.6,1.64,2.57,2.57,0,0,0,.19-1.74A.34.34,0,0,0,66.35,94.49Z" style="fill: rgb(255, 255, 255); transform-origin: 66.8532px 102.915px;" id="elyxp97rtg4g" class="animable"></path>
                  </g>
                  <path d="M74.19,73.74a1,1,0,0,1-.56-1.32l2-4.88A1,1,0,0,1,76.93,67h0a1,1,0,0,1,.56,1.31l-2,4.89a1,1,0,0,1-1.32.56Z" style="fill: rgb(224, 224, 224); transform-origin: 75.5582px 70.3821px;" id="el2z8ee5nl2uv" class="animable"></path>
                  <path d="M62.63,72.3a1,1,0,0,1-.62-.79l-.73-5.22a1,1,0,0,1,2-.28L64,71.23a1,1,0,0,1-.86,1.14A1,1,0,0,1,62.63,72.3Z" style="fill: rgb(224, 224, 224); transform-origin: 62.6407px 68.7594px;" id="eleb9hvrkk3ak" class="animable"></path>
                  <path d="M51.9,76.84a1,1,0,0,1-.41-.31l-3.24-4.16a1,1,0,0,1,1.6-1.24l3.24,4.15a1,1,0,0,1-.18,1.42A1,1,0,0,1,51.9,76.84Z" style="fill: rgb(224, 224, 224); transform-origin: 50.6727px 73.8281px;" id="el60z78e34wub" class="animable"></path>
                  <path d="M40,84.15a1,1,0,0,1,.77-1.87l4.88,2h0a1,1,0,1,1-.76,1.87l-4.88-2Z" style="fill: rgb(224, 224, 224); transform-origin: 42.8266px 84.2141px;" id="el2ohs4bb945n" class="animable"></path>
                  <path d="M38.23,98.41a1,1,0,0,1-.61-.79,1,1,0,0,1,.86-1.14l5.22-.73a1,1,0,0,1,.28,2l-5.22.73A.94.94,0,0,1,38.23,98.41Z" style="fill: rgb(224, 224, 224); transform-origin: 41.2289px 97.116px;" id="el29b3oltc40o" class="animable"></path>
                  <path d="M88,91.48a1,1,0,0,1,.25-1.94l5.22-.73a1,1,0,0,1,1.14.87,1,1,0,0,1-.86,1.14l-5.22.72A.94.94,0,0,1,88,91.48Z" style="fill: rgb(224, 224, 224); transform-origin: 90.9764px 90.1767px;" id="elulkqkq7w5cj" class="animable"></path>
                  <path d="M83.48,80.76a1,1,0,0,1-.42-.32A1,1,0,0,1,83.24,79l4.16-3.24a1,1,0,1,1,1.24,1.6l-4.16,3.24A1,1,0,0,1,83.48,80.76Z" style="fill: rgb(224, 224, 224); transform-origin: 85.9325px 78.1882px;" id="el6nmruw1wc5s" class="animable"></path>
                </g>
                <path d="M118,196.08,112.7,199a2.56,2.56,0,0,0-1.2,2c-.13,4.73-.57,23.33.19,32.22a2.8,2.8,0,0,0,1.28,2c3,1.69,11.14,6.15,14.87,7.18a4.68,4.68,0,0,0,2.53-.27l3.76-1.51a2.14,2.14,0,0,0,1.23-1.82c0-9.44,1.72-22.19,3.28-32.47a1.9,1.9,0,0,0-1-1.89L120.33,196A2.87,2.87,0,0,0,118,196.08Z" style="fill: rgb(69, 90, 100); transform-origin: 124.953px 219.129px;" id="elor2mk8bb53" class="animable"></path>
                <path d="M111.69,233.18c-.76-8.89-.32-27.49-.19-32.22a.78.78,0,0,1,1.23-.73l16.12,8a2.1,2.1,0,0,1,1.07,1.91c-.34,4.19-1.37,19.95-.85,31.08a1,1,0,0,1-1.23,1.1c-3.73-1-11.86-5.49-14.87-7.18A2.8,2.8,0,0,1,111.69,233.18Z" style="fill: rgb(55, 71, 79); transform-origin: 120.588px 221.216px;" id="elpf9bhs5qdl" class="animable"></path>
                <path d="M128,242.37a4.82,4.82,0,0,0,2.33-.32l3.77-1.51a2.18,2.18,0,0,0,1.21-1.82c.74-9.69,1.72-22.18,3.29-32.46a1.63,1.63,0,0,0-.19-1l-8.72,4a1.83,1.83,0,0,1,.19.93c-.35,4.21-1.37,20-.85,31.09A1,1,0,0,1,128,242.37Z" style="fill: rgb(38, 50, 56); transform-origin: 133.307px 223.83px;" id="el6iukpw5ira6" class="animable"></path>
                <path d="M113.75,204l14.12,6.59-.68,12-13.82-5.93S113.5,208.08,113.75,204Z" style="fill: rgb(38, 50, 56); transform-origin: 120.62px 213.295px;" id="elu7hhva1xhrq" class="animable"></path>
                <path d="M127.24,221.86,114,216.19s.12-7.84.34-11.89l13.5,6.29Z" style="fill: #064FF9; transform-origin: 120.92px 213.08px;" id="elrv1w1eshx5e" class="animable"></path>
                <g id="elqijqtpkarmf">
                  <path d="M127.24,221.86,114,216.19s.12-7.84.34-11.89l13.5,6.29Z" style="opacity: 0.4; transform-origin: 120.92px 213.08px;" class="animable" id="el5qwp5mduoq"></path>
                </g>
                <polygon points="121.33 208.61 118.37 212.89 120.23 213.53 118.78 217.31 122.09 212.85 120.23 212.15 121.33 208.61" style="fill: rgb(250, 250, 250); transform-origin: 120.23px 212.96px;" id="elbz7syisdrsu" class="animable"></polygon>
                <path d="M126.3,225.34l-.09,1.19a.45.45,0,0,1-.66.41l-2.14-.88a1,1,0,0,1-.57-.92l.07-1.21a.44.44,0,0,1,.65-.41l2.17.9A1,1,0,0,1,126.3,225.34Z" style="fill: rgb(38, 50, 56); transform-origin: 124.57px 225.229px;" id="el0kgeopnpnxuq" class="animable"></path>
                <path d="M126.31,229.21l-.06,1.19a.45.45,0,0,1-.65.42l-2.16-.85a1,1,0,0,1-.58-.9l0-1.22a.44.44,0,0,1,.64-.42l2.18.87A1,1,0,0,1,126.31,229.21Z" style="fill: rgb(38, 50, 56); transform-origin: 124.585px 229.124px;" id="elhvn8vd2ify" class="animable"></path>
                <path d="M126.33,233.08l0,1.19a.45.45,0,0,1-.65.43l-2.16-.81a1,1,0,0,1-.61-.9l0-1.22a.44.44,0,0,1,.64-.42l2.19.83A1,1,0,0,1,126.33,233.08Z" style="fill: rgb(38, 50, 56); transform-origin: 124.62px 233.024px;" id="elcubnf0czth8" class="animable"></path>
                <path d="M126.35,237l0,1.19a.45.45,0,0,1-.64.44l-2.18-.78a1,1,0,0,1-.62-.88l0-1.22a.44.44,0,0,1,.63-.44l2.21.8A1,1,0,0,1,126.35,237Z" style="fill: rgb(38, 50, 56); transform-origin: 124.629px 236.969px;" id="el5p50guidenw" class="animable"></path>
                <path d="M121.5,223.15l-.06,1.24a.44.44,0,0,1-.65.41l-2.12-.88a1,1,0,0,1-.59-.92l0-1.26a.43.43,0,0,1,.64-.41l2.16.9A1,1,0,0,1,121.5,223.15Z" style="fill: rgb(38, 50, 56); transform-origin: 119.789px 223.064px;" id="elw7sq86uskhn" class="animable"></path>
                <path d="M121.49,227l-.06,1.24a.44.44,0,0,1-.65.41l-2.12-.87a1,1,0,0,1-.6-.92l0-1.26a.43.43,0,0,1,.64-.41l2.16.89A1,1,0,0,1,121.49,227Z" style="fill: rgb(38, 50, 56); transform-origin: 119.774px 226.919px;" id="elva0lcg71ry" class="animable"></path>
                <path d="M121.47,230.84l0,1.24a.44.44,0,0,1-.64.42l-2.14-.86a1,1,0,0,1-.59-.92l0-1.26a.43.43,0,0,1,.63-.42l2.16.89A1,1,0,0,1,121.47,230.84Z" style="fill: rgb(38, 50, 56); transform-origin: 119.785px 230.769px;" id="elkogm4ra9ttk" class="animable"></path>
                <path d="M121.45,234.69l0,1.24a.44.44,0,0,1-.64.41l-2.14-.85a1,1,0,0,1-.6-.9l0-1.27a.44.44,0,0,1,.64-.42l2.16.88A1,1,0,0,1,121.45,234.69Z" style="fill: rgb(38, 50, 56); transform-origin: 119.76px 234.62px;" id="elfyjc2b4b7rl" class="animable"></path>
                <path d="M116.71,221l0,1.29a.43.43,0,0,1-.64.4l-2.11-.88a1,1,0,0,1-.59-.92l0-1.32a.42.42,0,0,1,.62-.4l2.14.91A1,1,0,0,1,116.71,221Z" style="fill: rgb(38, 50, 56); transform-origin: 115.04px 220.932px;" id="elhyhiwt5pj2l" class="animable"></path>
                <path d="M116.73,224.71l0,1.29a.42.42,0,0,1-.63.4l-2.11-.88a1,1,0,0,1-.6-.92l0-1.32a.42.42,0,0,1,.63-.4l2.14.91A1,1,0,0,1,116.73,224.71Z" style="fill: rgb(38, 50, 56); transform-origin: 115.06px 224.64px;" id="ellkcqxqptzl" class="animable"></path>
                <path d="M116.74,228.45l0,1.29a.43.43,0,0,1-.64.4l-2.11-.88a1.06,1.06,0,0,1-.6-.92l0-1.32a.42.42,0,0,1,.63-.4l2.14.91A1,1,0,0,1,116.74,228.45Z" style="fill: rgb(38, 50, 56); transform-origin: 115.065px 228.379px;" id="el02twx1ucif6l" class="animable"></path>
                <path d="M116.75,232.19l0,1.29a.42.42,0,0,1-.63.4L114,233a1,1,0,0,1-.59-.92l0-1.32a.42.42,0,0,1,.62-.4l2.14.9A1.06,1.06,0,0,1,116.75,232.19Z" style="fill: rgb(38, 50, 56); transform-origin: 115.08px 232.123px;" id="el1a0q6k1i4zi" class="animable"></path>
              </g>
            </g>
            <g id="freepik--fuse-box--inject-103" class="animable" style="transform-origin: 373.61px 204.741px;">
              <g id="freepik--fuse-box--inject-103" class="animable" style="transform-origin: 373.61px 204.741px;">
                <g id="freepik--plants--inject-103" class="animable" style="transform-origin: 368.184px 363.13px;">
                  <path d="M358.23,389.5,349,386.36c-.79-8.84.35-30.26,14.72-42.83,14.59-12.76,24.11-4.58,23.83,1-.3,6.09-13.39,11.8-20,20C360.33,373.45,358.08,379.55,358.23,389.5Z" style="fill: #064FF9; transform-origin: 368.184px 363.13px;" id="elza75vjhhpb" class="animable"></path>
                  <g id="eliewvvyjkh0a">
                    <path d="M358.23,389.5,349,386.36c-.79-8.84.35-30.26,14.72-42.83,14.59-12.76,24.11-4.58,23.83,1-.3,6.09-13.39,11.8-20,20C360.33,373.45,358.08,379.55,358.23,389.5Z" style="fill: rgb(255, 255, 255); opacity: 0.5; transform-origin: 368.184px 363.13px;" class="animable" id="ely8id71w15x"></path>
                  </g>
                  <path d="M352,387.87h0a.5.5,0,0,1-.49-.5c.13-23.78,17.79-44.59,26.59-45.94a.5.5,0,1,1,.15,1c-8.62,1.32-25.62,22.49-25.74,44.95A.5.5,0,0,1,352,387.87Z" style="fill: rgb(255, 255, 255); transform-origin: 365.095px 364.647px;" id="elfp3xgd67cva" class="animable"></path>
                  <path d="M380.16,368.18c-8-2.63-25.4,6.12-28.77,19l6.84,2.31a37.83,37.83,0,0,1,19.29-8.25C388.79,380.11,388.13,370.81,380.16,368.18Z" style="fill: #064FF9; transform-origin: 368.732px 378.601px;" id="elg3vwk74rh0p" class="animable"></path>
                  <g id="eltg3ebv9opw">
                    <path d="M380.16,368.18c-8-2.63-25.4,6.12-28.77,19l6.84,2.31a37.83,37.83,0,0,1,19.29-8.25C388.79,380.11,388.13,370.81,380.16,368.18Z" style="fill: rgb(255, 255, 255); opacity: 0.65; transform-origin: 368.732px 378.601px;" class="animable" id="eldqhdcefppwg"></path>
                  </g>
                  <path d="M354.51,388.92a.48.48,0,0,1-.23-.05.51.51,0,0,1-.21-.68c6.85-13.23,21.72-17.14,27.77-15.52a.49.49,0,0,1,.35.61.51.51,0,0,1-.61.36c-5.78-1.55-20,2.25-26.62,15A.49.49,0,0,1,354.51,388.92Z" style="fill: rgb(255, 255, 255); transform-origin: 368.112px 380.623px;" id="ely5kryylbmkk" class="animable"></path>
                </g>
                <g id="freepik--Box--inject-103" class="animable" style="transform-origin: 373.61px 204.741px;">
                  <path d="M346.79,241.28V389.16h0a2.76,2.76,0,0,0,1.64,2.28,8.69,8.69,0,0,0,7.91,0,2.78,2.78,0,0,0,1.64-2.28h0V241.28Z" style="fill: rgb(69, 90, 100); transform-origin: 352.385px 316.836px;" id="el7u7kbw5dwoj" class="animable"></path>
                  <polygon points="346.79 269 357.98 262.54 357.98 241.28 346.79 241.28 346.79 269" style="fill: rgb(55, 71, 79); transform-origin: 352.385px 255.14px;" id="el6h03dc0ps0i" class="animable"></polygon>
                  <polygon points="331.16 266.62 408.34 222.06 408.34 83.93 331.16 128.49 331.16 266.62" style="fill: #064FF9; transform-origin: 369.75px 175.275px;" id="el3pt673sde75" class="animable"></polygon>
                  <polygon points="408.34 83.93 373.61 63.88 296.43 108.44 331.16 128.49 408.34 83.93" style="fill: #064FF9; transform-origin: 352.385px 96.185px;" id="elyayw58mxcl" class="animable"></polygon>
                  <g id="elbksnsf50erc">
                    <polygon points="408.34 83.93 373.61 63.88 296.43 108.44 331.16 128.49 408.34 83.93" style="fill: rgb(255, 255, 255); opacity: 0.2; transform-origin: 352.385px 96.185px;" class="animable" id="elzuj63bvk6a"></polygon>
                  </g>
                  <polygon points="296.43 108.44 296.43 246.57 331.16 266.62 331.16 128.49 296.43 108.44" style="fill: #064FF9; transform-origin: 313.795px 187.53px;" id="elazb90yqg5y" class="animable"></polygon>
                  <g id="el47cufz8pb1e">
                    <polygon points="296.43 108.44 296.43 246.57 331.16 266.62 331.16 128.49 296.43 108.44" style="opacity: 0.2; transform-origin: 313.795px 187.53px;" class="animable" id="elfidadeih3cj"></polygon>
                  </g>
                  <polygon points="380.37 119.84 351.75 194.29 369.75 179.73 355.75 232.37 387.75 152.33 369.75 166.37 380.37 119.84" style="fill: rgb(250, 250, 250); transform-origin: 369.75px 176.105px;" id="elf3kz0iluk5o" class="animable"></polygon>
                  <path d="M337,129.6c1.06-.61,1.93-.11,1.93,1.12a4.27,4.27,0,0,1-1.93,3.34c-1.07.62-1.93.12-1.93-1.11A4.28,4.28,0,0,1,337,129.6Z" style="fill: rgb(55, 71, 79); transform-origin: 337px 131.833px;" id="elgbol8goyqm" class="animable"></path>
                  <path d="M337,254.38c1.06-.62,1.93-.12,1.93,1.11a4.27,4.27,0,0,1-1.93,3.34c-1.07.62-1.93.12-1.93-1.11A4.24,4.24,0,0,1,337,254.38Z" style="fill: rgb(55, 71, 79); transform-origin: 337px 256.605px;" id="elo2f5ta4c4s7" class="animable"></path>
                  <path d="M402.55,91.73c1.07-.62,1.93-.12,1.93,1.11a4.24,4.24,0,0,1-1.93,3.34c-1.06.62-1.92.12-1.92-1.11A4.26,4.26,0,0,1,402.55,91.73Z" style="fill: rgb(55, 71, 79); transform-origin: 402.555px 93.955px;" id="el1ovwrimu6kq" class="animable"></path>
                  <path d="M402.55,216.5c1.07-.62,1.93-.12,1.93,1.11a4.24,4.24,0,0,1-1.93,3.34c-1.06.62-1.92.12-1.92-1.11A4.26,4.26,0,0,1,402.55,216.5Z" style="fill: rgb(55, 71, 79); transform-origin: 402.555px 218.725px;" id="el6x573jug8vq" class="animable"></path>
                  <polygon points="408.34 83.93 408.34 181.96 450.79 157.45 450.79 19.32 373.61 63.88 408.34 83.93" style="fill: #064FF9; transform-origin: 412.2px 100.64px;" id="el4s0d1ymsdnr" class="animable"></polygon>
                  <polygon points="450.79 19.32 373.61 63.88 369.75 61.65 446.93 17.09 450.79 19.32" style="fill: #064FF9; transform-origin: 410.27px 40.485px;" id="elyjugqt3rl1j" class="animable"></polygon>
                  <g id="el7y4vmy3ilpv">
                    <polygon points="450.79 19.32 373.61 63.88 369.75 61.65 446.93 17.09 450.79 19.32" style="fill: rgb(255, 255, 255); opacity: 0.2; transform-origin: 410.27px 40.485px;" class="animable" id="elafp6ca55jaf"></polygon>
                  </g>
                  <polygon points="369.75 66.11 369.75 61.65 373.61 63.88 369.75 66.11" style="fill: #064FF9; transform-origin: 371.68px 63.88px;" id="el9glhyzk37s5" class="animable"></polygon>
                  <g id="el75mju4qanbm">
                    <polygon points="369.75 66.11 369.75 61.65 373.61 63.88 369.75 66.11" style="opacity: 0.2; transform-origin: 371.68px 63.88px;" class="animable" id="elraa6t74wte"></polygon>
                  </g>
                  <g id="elr3em47hk4no">
                    <polygon points="373.61 63.88 423.31 77.52 423.31 173.32 408.34 181.96 408.34 83.93 373.61 63.88" style="opacity: 0.2; transform-origin: 398.46px 122.92px;" class="animable" id="elxrlmrsualsq"></polygon>
                  </g>
                </g>
              </g>
            </g>
            <defs>
              <filter id="active" height="200%">
                <feMorphology in="SourceAlpha" result="DILATED" operator="dilate" radius="2"></feMorphology>
                <feFlood flood-color="#32DFEC" flood-opacity="1" result="PINK"></feFlood>
                <feComposite in="PINK" in2="DILATED" operator="in" result="OUTLINE"></feComposite>
                <feMerge>
                  <feMergeNode in="OUTLINE"></feMergeNode>
                  <feMergeNode in="SourceGraphic"></feMergeNode>
                </feMerge>
              </filter>
              <filter id="hover" height="200%">
                <feMorphology in="SourceAlpha" result="DILATED" operator="dilate" radius="2"></feMorphology>
                <feFlood flood-color="#ff0000" flood-opacity="0.5" result="PINK"></feFlood>
                <feComposite in="PINK" in2="DILATED" operator="in" result="OUTLINE"></feComposite>
                <feMerge>
                  <feMergeNode in="OUTLINE"></feMergeNode>
                  <feMergeNode in="SourceGraphic"></feMergeNode>
                </feMerge>
                <feColorMatrix type="matrix" values="0   0   0   0   0                0   1   0   0   0                0   0   0   0   0                0   0   0   1   0 "></feColorMatrix>
              </filter>
            </defs>
          </svg>
        </div>
      </div>
    </div>
  </div>

  <!-- Libs JS -->
  <script src="<?= base_url('assets/libs/apexcharts/dist/apexcharts.min.js?1684106062') ?>" defer></script>
  <script src="<?= base_url('assets/libs/jsvectormap/dist/js/jsvectormap.min.js?1684106062') ?>" defer></script>
  <script src="<?= base_url('assets/libs/jsvectormap/dist/maps/world.js?1684106062') ?>" defer></script>
  <script src="<?= base_url('assets/libs/jsvectormap/dist/maps/world-merc.js?1684106062') ?>" defer></script>

  <!-- Tabler Core -->
  <script src="<?= base_url('assets/js/tabler.min.js?1684106062') ?>" defer></script>
  <script src="<?= base_url('assets/js/demo.min.js?1684106062') ?>" defer></script>

  <!-- SweetAlert2 -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <!-- Show Password -->
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const togglePassword = document.getElementById('togglePassword');
      const passwordInput = document.getElementById('passwordInput');
      const eyeOpen = document.getElementById('eyeOpen');
      const eyeClosed = document.getElementById('eyeClosed');

      // Set initial state 
      eyeOpen.style.display = 'none';
      eyeClosed.style.display = 'block';

      togglePassword.addEventListener('click', function(e) {
        // Prevent the default anchor behavior 
        e.preventDefault();

        // Toggle password visibility 
        if (passwordInput.type === 'password') {
          passwordInput.type = 'text';
          eyeOpen.style.display = 'block';
          eyeClosed.style.display = 'none';
        } else {
          passwordInput.type = 'password';
          eyeOpen.style.display = 'none';
          eyeClosed.style.display = 'block';
        }
      });
    });
  </script>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      <?php
      // Cek apakah ada parameter URL untuk pesan alert
      if (isset($_GET['pesan'])) {
        $alertConfig = getAlertConfig($_GET['pesan']);
        if ($alertConfig): ?>
          Swal.fire({
            icon: '<?= $alertConfig['icon']; ?>',
            title: '<?= htmlspecialchars($alertConfig['title']); ?>',
            text: '<?= htmlspecialchars($alertConfig['message']); ?>',
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'OK'
          });
        <?php endif;
      }
      // Cek apakah ada session gagal (misalnya, login gagal)
      if (isset($_SESSION['gagal'])): ?>
        Swal.fire({
          icon: 'error',
          title: 'Oops...',
          text: '<?= htmlspecialchars($_SESSION['gagal']); ?>',
          confirmButtonColor: '#3085d6',
          confirmButtonText: 'OK'
        });
        <?php unset($_SESSION['gagal']); ?>
      <?php endif; ?>
    });
  </script>



</body>

</html>