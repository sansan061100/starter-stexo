<!DOCTYPE html>
<html lang="en">

<head>
    @include('layouts.admin.partials._head')
    <style>
        body {
            background-image: url("{{ asset('assets/images/bg.jpg') }}");
            background-repeat: no-repeat;
            background-size: 100% 100%;
        }

        .wrapper_page {
            margin: 7.5% auto;
            position: relative;
        }

    </style>
</head>

<body>
    <div class="">
        <div class="col-md-6 wrapper_page md-auto">
            <div class="card card-pages shadow-none">

                <div class="card-body">
                    <div class="text-center m-t-0 m-b-15">
                        <a href="index.html" class="logo logo-admin"><img src="assets/images/logo-dark.png" alt=""
                                height="24"></a>
                    </div>
                    <h5 class="font-18 text-center">Setup Aplikasi</h5>

                    <form class="form-horizontal m-t-30" action="index.html">

                        <div class="form-group row">
                            <div class="col-md-6 mb-3" id="logo">
                                <label>Logo</label>
                                <input type="file" class="dropify" name="logo">
                            </div>
                            <div class="col-md-6 mb-3" id="favicon">
                                <label>Favicon</label>
                                <input type="file" class="dropify" name="favicon">
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6 mb-3" id="nama_aplikasi">
                                <label>Nama Aplikasi</label>
                                <input class="form-control" type="text" name="nama_aplikasi" autocomplete="off">
                            </div>
                            <div class="col-md-6 mb-3" id="no_hp">
                                <label>No Hp</label>
                                <input class="form-control" type="text" name="no_hp" autocomplete="off">
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-12 mb-3" id="nama_aplikasi">
                                <label>Alamat</label>
                                <textarea name="alamat" class="form-control" rows="5"></textarea>
                            </div>
                        </div>

                        <div class="form-group text-center m-t-20">
                            <div class="col-12">
                                <button class="btn btn-primary btn-block btn-lg waves-effect waves-light"
                                    type="submit">Simpan</button>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <!-- jQuery  -->
    <script src="{{ asset('') }}assets/js/jquery.min.js"></script>
    <script src="{{ asset('') }}assets/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('') }}assets/js/jquery.slimscroll.js"></script>
    <script src="{{ asset('') }}assets/js/waves.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js"></script>
    <script>
        $('.dropify').dropify();
    </script>

</body>

</html>
