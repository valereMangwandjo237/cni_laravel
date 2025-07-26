<!doctype html>
<html lang="en">
  <!--begin::Head-->
  <head>
    @include("partials.head")
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>
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
      @yield("content_main")
      <!--end::App Main-->
      <!--begin::Footer-->
      @include("partials.footer")
      <!--end::Footer-->
    </div>

    @include("partials.scripts")


  </body>
  <!--end::Body-->
</html>
