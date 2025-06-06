<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>{{!empty($title) ? $title : trans('admin.adminPanel')}}</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset('/design/adminlte/plugins/fontawesome-free/css/all.min.css')}}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bbootstrap 4 -->
  <link rel="stylesheet" href="{{asset('/design/adminlte/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')}}">
  <!-- iCheck -->
  <link rel="stylesheet" href="{{asset('/design/adminlte/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
  <!--DataTable-->
  <link rel="stylesheet" href="{{asset('/design/adminLte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
  <!-- JQVMap -->
  <link rel="stylesheet" href="{{asset('/design/adminlte/plugins/jqvmap/jqvmap.min.css')}}">
  <!-- Theme style -->
  @if (direction() == 'ltr')
    <link rel="stylesheet" href="{{asset('/design/adminlte/dist/css/adminlte.min.css')}}">
  @else
    <link rel="stylesheet" href="{{asset('/design/adminlte/dist/css/rtl/AdminLTE.min.css')}}">
    <!-- Bootstrap 4 RTL -->
    <link rel="stylesheet" href="https://cdn.rtlcss.com/bootstrap/v4.2.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{asset('/design/adminlte/dist/css/rtl/rtl.css')}}">
  @endif
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{asset('/design/adminlte/plugins/overlayScrollbars/css/OverlayScrollbars.min.css')}}">
  <!-- Daterange picker -->
{{--  <link rel="stylesheet" href="{{asset('/design/adminlte/plugins/daterangepicker/daterangepicker.css')}}">--}}
  <!-- summernote -->
  <link rel="stylesheet" href="{{asset('/design/adminlte/plugins/summernote/summernote-bs4.css')}}">
  <link rel="stylesheet" href="{{asset('/design/adminlte/jstree/themes/default/style.css')}}">
  <link rel="stylesheet" href="  https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css"/>
  <link rel="stylesheet" href="{{asset('/design/adminlte/style.css')}}">


  <!-- Google Font: Source Sans Pro -->
  {{-- <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet"> --}}
  <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200&display=swap" rel="stylesheet">
    <style>
      html, body {font-family: 'Cairo', sans-serif;}
  </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
