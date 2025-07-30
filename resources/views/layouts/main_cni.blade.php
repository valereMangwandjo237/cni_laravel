<!doctype html>
<html lang="en">
  <!--begin::Head-->
  <head>
    @include("partials.head")
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  </head>
  <!--end::Head-->
  <!--begin::Body-->
  <body class="layout-fixed sidebar-expand-lg sidebar-open bg-body-tertiary">
    <!--begin::App Wrapper-->
    <div class="app-wrapper">

      <!--begin::Header-->
      @include("partials.navbar")
      <!--end::Header-->

      <!--begin::Sidebar-->
      @include("partials.sidebar")
      <!--end::Sidebar-->

      <!--begin::App Main-->
    <main class="app-main">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
            </div>
        @endif

        <!--begin::App Content Header-->
        <div class="app-content-header">
            <!--begin::Container-->
            <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">
                <div class="col-sm-4">
                <h3 class="mb-0">Dashboard</h3>
                </div>
                <div class="col-sm-4">
                    <img
                    src="{{ asset('assets/img/logo_dgi.png') }}" alt="AdminLTE Logo" class="brand-image"
                    width="50%" height="70%"
                />
                </div>

                <div class="col-sm-4">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                </ol>
                </div>
            </div>
            <!--end::Row-->
            </div>
            <!--end::Container-->
        </div>
        <!--end::App Content Header-->
        <!--begin::App Content-->
        <div class="app-content">
            <!--begin::Container-->
            <div class="container-fluid">
                <div class="row">
                    @yield("content_main")
                </div>
            </div>
        </div>
    </main>
      <!--end::App Main-->
      <!--begin::Footer-->
      @include("partials.footer")
      <!--end::Footer-->
    </div>

    @include("partials.scripts")


  </body>
  <!--end::Body-->
</html>
