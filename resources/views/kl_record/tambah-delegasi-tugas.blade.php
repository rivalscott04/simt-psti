@extends('layout')

@section('side-menu')
<li class="active">
    <a href="/kl/delegasi-tugas"><i class="fa fa-list-alt"></i>
        <span class="nav-label">Delegasi Tugas</span></a>
</li>
<li>
    <a href="/kl/tugas-masuk"><i class="fa fa-envelope"></i>
        <span class="nav-label">Tugas Masuk</span>
        @if ($jumlahTugasMasuk > 0)
        <span class="label label-warning float-right">{{ $jumlahTugasMasuk }}</span>
        @endif
    </a>
</li>
<li>
    <a href="/kl/tugas"><i class="fa fa-file-o"></i>
        <span class="nav-label">Tugas</span></a>
</li>
@endsection

@section('page-wrapper')
<div id="page-wrapper" class="gray-bg">
    @if(session()->has('success'))
    <div class="alert alert-danger" role="alert">
        {{ session('success') }}
    </div>
    @endif
    <div class="row border-bottom">
        <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <a class="navbar-minimalize minimalize-styl-2 btn btn-primary" href="#"><i class="fa fa-bars"></i>
                </a>
            </div>
            <ul class="nav navbar-top-links navbar-right">
                <li>
                    <a href="/logout" style="padding-right: 20px;">
                        <i class="fa fa-sign-out" aria-hidden="true"></i>
                        Keluar
                    </a>
                </li>
            </ul>
        </nav>
    </div>
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
            <h2>Tambah Delegasi Tugas</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="/">Beranda</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="/kl/delegasi-tugas">Delegasi Tugas</a>
                </li>
                <li class="breadcrumb-item active">
                    <strong>Tambah</strong>
                </li>
            </ol>
        </div>
    </div>

    @if ($errors->any())
    <br>
    <div class="alert alert-danger">
        @foreach ($errors->all() as $error)
        <div>
            <i class="icon fa fa-times"></i>
            &nbsp;
            {{ $error }}
        </div>
        @endforeach
    </div>
    @endif

    <!-- @if(session()->has('success'))
    <br>
    <div class="alert alert-success alert-dismissable">
        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
        <i class="icon fa fa-times"></i>
        {{ session('success') }}
    </div>
    @endif -->

    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-md-12">
                <div class="ibox ">
                    <div class="ibox-title back-change">
                        <h5>Tambah Delegasi Tugas</h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                        </div>
                    </div>

                    <div class="ibox-content">
                        <form action="/kl/delegasi-tugas" enctype="multipart/form-data" method="post"
                            class="form-horizontal">
                            @csrf
                            <div class="row">
                                <div class="col-lg-6">
                                    <!-- Input tersembunyi untuk menyimpan ID pengguna -->
                                    <div class="form-group row">
                                        <input type="hidden" name="user_id" value="id_pengguna_disini">
                                    </div>

                                    <!-- Input tersembunyi untuk menyimpan nama pengguna si pengirim -->
                                    <div class="form-group row">
                                        <input type="hidden" name="nama_pengirim" value="nama_pengirim">
                                    </div>

                                    <!-- Input tersembunyi untuk menyimpan nama pengguna si pengirim -->
                                    <div class="form-group row">
                                        <input type="hidden" name="role_pengirim" value="role_pengirim">
                                    </div>

                                    <!-- Input tujuan -->
                                    <div class="form-group row">
                                        <label class="col-sm-4 label1" for="tujuan">
                                            Tujuan *
                                        </label>
                                        <div class="col-sm-8">
                                            <!-- <label>
                                                <input type="radio" class="radio-inline icheck" name="role_tujuan"
                                                    value="AdHoc">
                                                <b>AdHoc</b>
                                            </label>
                                            &nbsp; -->
                                            <label>
                                                <input type="radio" class="radio-inline icheck" name="role_tujuan"
                                                    value="Dosen">
                                                <b>Dosen</b>
                                            </label>
                                            &nbsp;
                                            <label>
                                                <input type="radio" class="radio-inline icheck" name="role_tujuan"
                                                    value="Staf">
                                                <b>Staf</b>
                                            </label>
                                            <br><br>
                                            <select id="select2" name="tujuan" class="select2_demo_3 form-control"
                                                required>
                                            </select>
                                            <br>
                                        </div>
                                    </div>
                                    <div class="form-group row"> <label class="col-sm-4 label1" for="perihal">
                                            Perihal * </label>
                                        <div class="col-sm-8">
                                            <textarea class="form-control" id="perihal" rows="5" name="perihal"
                                                required></textarea>
                                            <small class="text-muted"> <b>Keterangan tugas</b> </small>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-4 label1" for="tenggat_waktu_jam"> Waktu * </label>
                                        <div class="col-sm-8 col-md-5">
                                            <div class="input-group clockpicker" data-autoclose="true">
                                                <span class="input-group-addon">
                                                    <span class="fa fa-clock-o"></span>
                                                </span>
                                                <input type="text" name="tenggat_waktu_jam" class="form-control"
                                                    readonly>
                                                <span class="input-group-addon">
                                                    <span>WITA</span>
                                                </span>
                                            </div>
                                            <small class="text-muted"> <b>Tenggat waktu pengerjaan (jam)</b> </small>
                                        </div>
                                    </div>
                                    <div class="form-group row"> <label class="col-sm-4 label1"
                                            for="tenggat_waktu_tanggal">
                                            Tanggal *</label>
                                        <div class="col-sm-8 col-md-5">
                                            <div class="form-group" id="data_1">
                                                <div class="input-group date">
                                                    <span class="input-group-addon"><i
                                                            class="fa fa-calendar"></i></span>

                                                    <input type="text" id="data_1" name="tenggat_waktu_tanggal"
                                                        class="form-control" readonly>
                                                </div>
                                                <small class="text-muted"> <b>Tenggat waktu pengerjaan (tanggal)</b>
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row"> <label class="col-sm-4 label1" for="url"> URL
                                        </label>
                                        <div class="col-sm-8">
                                            <input type="text" id="url" name="url" class="form-control">
                                            <small class="text-muted"><b>Jika ada link tambahan terkait tugas
                                                </b>
                                                <span class="text-info"
                                                    style="font-style: italic;"><b>(opsional)</b></span>
                                            </small>
                                        </div>
                                    </div>
                                    <div class="form-group row"> <label class="col-sm-4 label1">
                                            Lampiran </label>
                                        <div class="col-sm-8">
                                            <div class="custom-file">
                                                <!-- <input id="inputGroupFile01" name="lampiran" type="file"
                                                    accept=".pdf,.doc,.docx,.zip" class="custom-file-input"
                                                    value="{{ old('lampiran') }}"> -->

                                                <input id="lampiran" name="lampiran" type="file"
                                                    accept=".pdf,.docx,.zip,.rar,.png,.jpg,.jpeg" class="custom-file-input"
                                                    value="{{ old('lampiran') }}">
                                                <label class="custom-file-label" for="inputGroupFile01">Choose
                                                    file</label>
                                                <small class="text-muted">
                                                    <b>Berkas pendukung (
                                                        <code>pdf</code>,
                                                        <code>docx</code>,
                                                        <code>zip</code>,
                                                        <code>rar</code>,
                                                        <code>png</code>,
                                                        <code>jpg</code>,
                                                        <code>jpeg</code>)
                                                    </b>
                                                    <span class="text-info"
                                                        style="font-style: italic;"><b>(opsional)</b></span>
                                                </small>
                                            </div>


                                            <!-- <input type="file" id="lampiran" name="lampiran"
                                                accept=".pdf,.doc,.docx,.zip" class="form-control">
                                            <small class="text-muted"> <b>Opsional</b> </small> -->
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="text-center">
                                <button class="btn btn-success btn-outline" type="submit">
                                    <i class="fa fa-send-o"></i> &nbsp;Simpan dan Ajukan
                                </button>
                                <br>
                                <br>
                            </div>

                            <div>
                                <span style="text-align: left;">(<b>*</b>) Wajib diisi.</span>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer">
        <div>
            <strong>Copyright</strong> Program Studi Teknik Informatika -- Universitas Mataram &copy; 2023
        </div>
    </div>
</div>
@endsection

@section('isi-js')
<script>
    $(document).ready(function () {
        //COBA
        // Fungsi truncateFileName
        function truncateFileName() {
            const input = document.getElementById('lampiran');
            const maxLength = 30; // Atur panjang maksimal yang diinginkan

            if (input.files.length > 0) {
                const fileName = input.files[0].name;
                if (fileName.length > maxLength) {
                    const truncatedName = `[${input.files.length}] ${fileName.slice(0, maxLength - 4)}...${fileName.slice(-4)}`;
                    input.nextElementSibling.innerHTML = truncatedName;
                } else {
                    input.nextElementSibling.innerHTML = `[${input.files.length}] ${fileName}`;
                }
            }
        }

        // Panggil fungsi truncateFileName saat file dipilih
        $('#lampiran').change(function () {
            truncateFileName();
        });
        // ENDCOBA


        // bsCustomFileInput.init()

        // $('.tagsinput').tagsinput({
        //     tagClass: 'label label-primary'
        // });

        // var $image = $(".image-crop > img")
        // var $cropped = $($image).cropper({
        //     aspectRatio: 1.618,
        //     preview: ".img-preview",
        //     done: function (data) {
        //         // Output the result data for cropping image.
        //     }
        // });

        // var $inputImage = $("#inputImage");
        // if (window.FileReader) {
        //     $inputImage.change(function () {
        //         var fileReader = new FileReader(),
        //             files = this.files,
        //             file;

        //         if (!files.length) {
        //             return;
        //         }

        //         file = files[0];

        //         if (/^image\/\w+$/.test(file.type)) {
        //             fileReader.readAsDataURL(file);
        //             fileReader.onload = function () {
        //                 $inputImage.val("");
        //                 $image.cropper("reset", true).cropper("replace", this.result);
        //             };
        //         } else {
        //             showMessage("Please choose an image file.");
        //         }
        //     });
        // } else {
        //     $inputImage.addClass("hide");
        // }

        // $("#download").click(function (link) {
        //     link.target.href = $cropped.cropper('getCroppedCanvas', { width: 620, height: 520 }).toDataURL("image/png").replace("image/png", "application/octet-stream");
        //     link.target.download = 'cropped.png';
        // });


        $("#zoomIn").click(function () {
            $image.cropper("zoom", 0.1);
        });

        $("#zoomOut").click(function () {
            $image.cropper("zoom", -0.1);
        });

        $("#rotateLeft").click(function () {
            $image.cropper("rotate", 45);
        });

        $("#rotateRight").click(function () {
            $image.cropper("rotate", -45);
        });

        $("#setDrag").click(function () {
            $image.cropper("setDragMode", "crop");
        });

        // var mem = $('#data_1 .input-group.date').datepicker({
        //     todayBtn: "linked",
        //     keyboardNavigation: false,
        //     forceParse: false,
        //     calendarWeeks: true,
        //     autoclose: true,
        //     onClose: function (selectedDate) {
        //         // Ambil nilai tanggal yang dipilih dan simpan dalam variabel
        //         var tanggalDipilih = selectedDate;
        //     }
        // });

        // $('#data_1').datepicker({
        //     dateFormat: 'dd-mm-yy',
        //     minDate: new Date(),
        //     maxDate: '+1y',
        //     changeMonth: true,
        //     changeYear: true,
        //     showButtonPanel: true,
        //     onClose: function (selectedDate) {
        //         // Ambil nilai tanggal yang dipilih dan simpan dalam variabel
        //         var tanggalDipilih = selectedDate;

        //         // Lakukan apa pun yang Anda butuhkan dengan nilai tanggalDipilih
        //         console.log('Nilai tanggal yang dipilih: ' + tanggalDipilih);

        //         // Misalnya, Anda dapat menetapkan nilai tanggalDipilih ke input lain
        //         // $('#inputLain').val(tanggalDipilih);
        //     }
        // });



        var yearsAgo = new Date();
        yearsAgo.setFullYear(yearsAgo.getFullYear() - 20);

        $('#selector').datepicker('setDate', yearsAgo);


        $('#data_2 .input-group.date').datepicker({
            startView: 1,
            todayBtn: "linked",
            keyboardNavigation: false,
            forceParse: false,
            autoclose: true,
            format: "dd/mm/yyyy"
        });

        $('#data_3 .input-group.date').datepicker({
            startView: 2,
            todayBtn: "linked",
            keyboardNavigation: false,
            forceParse: false,
            autoclose: true
        });

        $('#data_4 .input-group.date').datepicker({
            minViewMode: 1,
            keyboardNavigation: false,
            forceParse: false,
            forceParse: false,
            autoclose: true,
            todayHighlight: true
        });

        $('#data_5 .input-daterange').datepicker({
            keyboardNavigation: false,
            forceParse: false,
            autoclose: true
        });

        // var elem = document.querySelector('.js-switch');
        // var switchery = new Switchery(elem, { color: '#1AB394' });

        // var elem_2 = document.querySelector('.js-switch_2');
        // var switchery_2 = new Switchery(elem_2, { color: '#ED5565' });

        // var elem_3 = document.querySelector('.js-switch_3');
        // var switchery_3 = new Switchery(elem_3, { color: '#1AB394' });

        // var elem_4 = document.querySelector('.js-switch_4');
        // var switchery_4 = new Switchery(elem_4, { color: '#f8ac59' });
        // switchery_4.disable();

        // $('.i-checks').iCheck({
        //     checkboxClass: 'icheckbox_square-green',
        //     radioClass: 'iradio_square-green'
        // });

        $('.demo1').colorpicker();

        var divStyle = $('.back-change')[0].style;
        $('#demo_apidemo').colorpicker({
            color: divStyle.backgroundColor
        }).on('changeColor', function (ev) {
            divStyle.backgroundColor = ev.color.toHex();
        });

        $('.clockpicker').clockpicker();

        $('.clockpicker').clockpicker({
            placement: 'bottom',
            align: 'left',
            autoclose: true,
            afterDone: function () {
                var tenggat_waktu_jam = this.value;

                // var selectedTime = $('.clockpicker').val();
                // console.log('Waktu yang dipilih: ' + selectedTime);
                // Lakukan operasi lainnya dengan nilai waktu yang dipilih
            }
        });

        var mem = $('#data_1 .input-group.date').datepicker({
            todayBtn: "linked",
            keyboardNavigation: false,
            forceParse: false,
            calendarWeeks: true,
            autoclose: true,
            // onClose: function (selectedDate) {
            //     // Ambil nilai tanggal yang dipilih dan simpan dalam variabel
            //     var tanggalDipilih = selectedDate;
            // }
            afterDone: function () {
                var tenggat_waktu_tanggal = this.value;

                // var selectedTime = $('.clockpicker').val();
                // console.log('Waktu yang dipilih: ' + selectedTime);
                // Lakukan operasi lainnya dengan nilai waktu yang dipilih
            }
        });


        $('input[name="daterange"]').daterangepicker();

        $('#reportrange span').html(moment().subtract(29, 'days').format('MMMM D, YYYY') + ' - ' + moment().format('MMMM D, YYYY'));

        $('#reportrange').daterangepicker({
            format: 'MM/DD/YYYY',
            startDate: moment().subtract(29, 'days'),
            endDate: moment(),
            minDate: '01/01/2012',
            maxDate: '12/31/2015',
            dateLimit: { days: 60 },
            showDropdowns: true,
            showWeekNumbers: true,
            timePicker: false,
            timePickerIncrement: 1,
            timePicker12Hour: true,
            ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            },
            opens: 'right',
            drops: 'down',
            buttonClasses: ['btn', 'btn-sm'],
            applyClass: 'btn-primary',
            cancelClass: 'btn-default',
            separator: ' to ',
            locale: {
                applyLabel: 'Submit',
                cancelLabel: 'Cancel',
                fromLabel: 'From',
                toLabel: 'To',
                customRangeLabel: 'Custom',
                daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
                monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                firstDay: 1
            }
        }, function (start, end, label) {
            console.log(start.toISOString(), end.toISOString(), label);
            $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        });

        //FINAL
        $(".select2_demo_1").select2({
            theme: 'bootstrap4',
        });
        $(".select2_demo_2").select2({
            theme: 'bootstrap4',
        });
        $(".select2_demo_3").select2({
            theme: 'bootstrap4',
            placeholder: "Pilih",
            allowClear: true
        });
        $('.icheck').iCheck({
            checkboxClass: 'icheckbox_square-green',
            radioClass: 'iradio_square-green'
        });

        // Mendengarkan perubahan pada radio button
        $('.icheck').on('ifChecked', function (event) {
            // Menghapus opsi sebelumnya dari Select2
            $('#select2').empty();

            // Mengambil peran yang dipilih
            var role_tujuan = $('input[name="role_tujuan"]:checked').val();

            $("#select2").select2({
                placeholder: 'Pilih',
                ajax: {
                    url: "{{url('getUser')}}/" + role_tujuan,
                    processResults: function ({ data }) {
                        return {
                            results: $.map(data, function (item) {
                                return {
                                    id: item.nama_pengguna,
                                    text: item.nama_pengguna,
                                }
                            })
                        }
                    }
                },
            });

            // Tangkap peristiwa "change" pada elemen Select2
            // $("#select2").on("change", function () {
            //     // Dapatkan data dari elemen yang dipilih dalam bentuk objek
            //     var selectedData = $("#select2").select2('data');

            //     // Cek apakah ada elemen yang dipilih
            //     if (selectedData && selectedData.length > 0) {
            //         // Dapatkan nilai teks dari elemen yang dipilih (nama_pengguna)
            //         var selectedNama = selectedData[0].text;

            //         // Cek apakah nilai selectedNama tidak null
            //         if (selectedNama) {
            //             // Gunakan nilai nama_pengguna sesuai kebutuhan Anda
            //             console.log("Nama Pengguna: " + selectedNama);
            //         } else {
            //             console.log("Tidak ada data yang dipilih atau data tidak valid.");
            //         }
            //     }
            // });

            // Dapatkan data dari elemen yang dipilih dalam bentuk objek
            // var selectedTujuan = $("#select2").select2('data');

            // dd($se)

            // // Cek apakah ada elemen yang dipilih
            // if (selectedTujuan && selectedTujuan.length > 0) {
            //     // Dapatkan nilai teks dari elemen yang dipilih (nama_pengguna)
            //     var selectedTujuan = selectedTujuan[0].text;
            // }
        });
        //END FINAL

        $(".touchspin1").TouchSpin({
            buttondown_class: 'btn btn-white',
            buttonup_class: 'btn btn-white'
        });

        $(".touchspin2").TouchSpin({
            min: 0,
            max: 100,
            step: 0.1,
            decimals: 2,
            boostat: 5,
            maxboostedstep: 10,
            postfix: '%',
            buttondown_class: 'btn btn-white',
            buttonup_class: 'btn btn-white'
        });

        $(".touchspin3").TouchSpin({
            verticalbuttons: true,
            buttondown_class: 'btn btn-white',
            buttonup_class: 'btn btn-white'
        });

        $('.dual_select').bootstrapDualListbox({
            selectorMinimalHeight: 160
        });


    });

    $("#ionrange_1").ionRangeSlider({
        skin: "flat",
        min: 0,
        max: 5000,
        type: 'double',
        prefix: "$",
        maxPostfix: "+",
        grid: true
    });

    $("#ionrange_2").ionRangeSlider({
        skin: "flat",
        min: 0,
        max: 10,
        type: 'single',
        step: 0.1,
        postfix: " carats",
        grid: true
    });

    $("#ionrange_3").ionRangeSlider({
        skin: "flat",
        min: -50,
        max: 50,
        from: 0,
        postfix: "°",
        grid: true
    });

    $(".dial").knob();

    var basic_slider = document.getElementById('basic_slider');

    noUiSlider.create(basic_slider, {
        start: 40,
        behaviour: 'tap',
        connect: 'upper',
        range: {
            'min': 20,
            'max': 80
        }
    });

    var range_slider = document.getElementById('range_slider');

    noUiSlider.create(range_slider, {
        start: [40, 60],
        behaviour: 'drag',
        connect: true,
        range: {
            'min': 20,
            'max': 80
        }
    });

    var drag_fixed = document.getElementById('drag-fixed');

    noUiSlider.create(drag_fixed, {
        start: [40, 60],
        behaviour: 'drag-fixed',
        connect: true,
        range: {
            'min': 20,
            'max': 80
        }
    });

    // Validasi form sebelum dikirimkan
    $('form').submit(function () {
        // var waktuInput = $('#waktu').val();
        if (!tenggat_waktu_jam) {
            alert('Jam harus diisi.');
            return false; // Jika waktu tidak diisi, form tidak akan dikirimkan
        }

        if (!tenggat_waktu_tanggal) {
            alert('Tanggal harus diisi.');
            return false; // Jika waktu tidak diisi, form tidak akan dikirimkan
        }
    });
</script>

@endsection